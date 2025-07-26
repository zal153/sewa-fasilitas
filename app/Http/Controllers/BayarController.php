<?php
// app/Http/Controllers/BayarController.php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PembayaranFasilitas;
use App\Models\PeminjamanFasilitas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BayarController extends Controller
{
    public function bayar($id)
    {
        $user = Auth::user();
        $peminjaman = PeminjamanFasilitas::findOrFail($id);

        // Cek apakah user berhak mengakses peminjaman ini
        if ($peminjaman->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        // Cek apakah sudah ada pembayaran yang berhasil
        $pembayaran = PembayaranFasilitas::where('peminjaman_id', $peminjaman->id)->first();

        if ($pembayaran && $pembayaran->status === 'berhasil') {
            return redirect()->route('non_mahasiswa.pembayaran')
                ->with('info', 'Pembayaran untuk peminjaman ini sudah berhasil');
        }

        // Buat record pembayaran jika belum ada
        if (!$pembayaran) {
            $pembayaran = PembayaranFasilitas::create([
                'peminjaman_id' => $peminjaman->id,
                'order_id' => $peminjaman->kode_peminjaman,
                'jumlah' => $peminjaman->biaya,
                'status' => 'menunggu'
            ]);
        }

        return view('user.non-mahasiswa.pembayaran.bayar', compact('peminjaman', 'pembayaran'));
    }

    public function uploadBukti(Request $request, $id)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'metode' => 'required|in:transfer_bank,gopay,qris,kartu_kredit'
        ]);

        $pembayaran = PembayaranFasilitas::findOrFail($id);

        // Cek apakah user berhak mengakses pembayaran ini
        if ($pembayaran->peminjaman->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Upload bukti pembayaran
        if ($request->hasFile('bukti_pembayaran')) {
            // Hapus file lama jika ada
            if ($pembayaran->bukti_pembayaran && Storage::exists('public/' . $pembayaran->bukti_pembayaran)) {
                Storage::delete('public/' . $pembayaran->bukti_pembayaran);
            }

            $file = $request->file('bukti_pembayaran');
            $filename = 'bukti_' . $pembayaran->order_id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('bukti_pembayaran', $filename, 'public');

            $pembayaran->update([
                'bukti_pembayaran' => $path,
                'metode' => $request->metode,
                'status' => 'menunggu_verifikasi'
            ]);
        }

        return redirect()->route('non_mahasiswa.pembayaran')
            ->with('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi admin.');
    }

    public function approvePembayaran(Request $request, $id)
    {
        $request->validate([
            'catatan_admin' => 'nullable|string|max:500'
        ]);

        $pembayaran = PembayaranFasilitas::findOrFail($id);

        // Generate QR Code
        $qrData = json_encode([
            'order_id' => $pembayaran->order_id,
            'peminjaman_id' => $pembayaran->peminjaman_id,
            'fasilitas' => $pembayaran->peminjaman->fasilitas->nama_fasilitas ?? 'N/A',
            'user' => $pembayaran->peminjaman->user->name ?? 'N/A',
            'tanggal_mulai' => $pembayaran->peminjaman->tanggal_mulai,
            'tanggal_selesai' => $pembayaran->peminjaman->tanggal_selesai,
            'status' => 'approved',
            'timestamp' => now()->toISOString()
        ]);

        $qrCode = QrCode::format('png')->size(300)->generate($qrData);
        $qrFilename = 'qr_' . $pembayaran->order_id . '.png';
        Storage::put('public/qr_codes/' . $qrFilename, $qrCode);

        $pembayaran->update([
            'status' => 'berhasil',
            'catatan_admin' => $request->catatan_admin,
            'qr_code' => 'qr_codes/' . $qrFilename,
            'tanggal_bayar' => now(),
            'tanggal_approved' => now()
        ]);

        // Update status peminjaman
        $pembayaran->peminjaman->update(['status' => 'disetujui']);

        return redirect()->back()->with('success', 'Pembayaran berhasil disetujui dan QR Code telah dibuat!');
    }

    public function rejectPembayaran(Request $request, $id)
    {
        $request->validate([
            'catatan_admin' => 'required|string|max:500'
        ]);

        $pembayaran = PembayaranFasilitas::findOrFail($id);

        $pembayaran->update([
            'status' => 'ditolak',
            'catatan_admin' => $request->catatan_admin
        ]);

        return redirect()->back()->with('success', 'Pembayaran telah ditolak.');
    }

    public function downloadQrCode($id)
    {
        $pembayaran = PembayaranFasilitas::findOrFail($id);

        if (!$pembayaran->qr_code || !Storage::exists('public/' . $pembayaran->qr_code)) {
            return redirect()->back()->with('error', 'QR Code tidak ditemukan.');
        }

        return Storage::download('public/' . $pembayaran->qr_code, 'QR_' . $pembayaran->order_id . '.png');
    }
}
