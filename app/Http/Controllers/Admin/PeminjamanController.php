<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use App\Models\PeminjamanFasilitas;
use App\Models\User;
use App\Notifications\PengembalianBarangNotification;
use App\Notifications\StatusPeminjamanNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function index()
    {
        $data = PeminjamanFasilitas::paginate(10);
        $user = User::all();
        $fasilitas = Fasilitas::all();
        $peminjaman = PeminjamanFasilitas::all();
        $adaNonMahasiswa = $peminjaman->contains(fn($item) => $item->user->role === 'non-mahasiswa');
        $no = 1;
        return view('admin.Peminjaman.index', compact('user', 'fasilitas', 'peminjaman', 'no', 'data', 'adaNonMahasiswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'fasilitas_id' => 'required|exists:fasilitas,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keperluan' => 'required|string',
        ]);

        $peminjaman = PeminjamanFasilitas::create([
            'user_id' => $request->user_id,
            'fasilitas_id' => $request->fasilitas_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'keperluan' => $request->keperluan,
            'status' => 'diajukan',
            'status_pembayaran' => 0,
        ]);

        // Kirim notifikasi ke admin
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new StatusPeminjamanNotification($peminjaman, 'diajukan'));
        }

        return redirect()->route('peminjaman')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $peminjaman = PeminjamanFasilitas::findOrFail($id);
        $users = User::all();
        $fasilitas = Fasilitas::all();

        return view('admin.Peminjaman.edit', compact('peminjaman', 'users', 'fasilitas'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'nullable|in:diajukan,disetujui,ditolak,selesai',
            'catatan' => 'nullable|string',
        ]);

        $peminjaman = PeminjamanFasilitas::findOrFail($id);
        $oldStatus = $peminjaman->status;

        $peminjaman->status = $request->status ?? $peminjaman->status;
        $peminjaman->catatan = $request->catatan;

        if ($request->status === 'disetujui') {
            $peminjaman->approved_by = Auth::id();
            $this->setFasilitasAktif($peminjaman->fasilitas_id, true);
        }

        if ($request->status === 'selesai') {
            $this->setFasilitasAktif($peminjaman->fasilitas_id, false);

            // Kirim notifikasi pengembalian barang
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new PengembalianBarangNotification($peminjaman));
            }
        }

        $peminjaman->save();

        // Kirim notifikasi jika status berubah
        if ($oldStatus !== $request->status && $request->status) {
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new StatusPeminjamanNotification($peminjaman, $request->status));
            }
        }

        return redirect()->route('peminjaman')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $peminjaman = PeminjamanFasilitas::findOrFail($id);
        $peminjaman->delete();

        return redirect()->route('peminjaman')->with('success', 'Data berhasil dihapus.');
    }

    public function reject($id)
    {
        $peminjaman = PeminjamanFasilitas::findOrFail($id);
        $peminjaman->status = 'Ditolak';
        $peminjaman->save();

        // Kirim notifikasi
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new StatusPeminjamanNotification($peminjaman, 'ditolak'));
        }

        return redirect()->back()->with('success', 'Peminjaman telah ditolak.');
    }

    public function approve($id)
    {
        $peminjaman = PeminjamanFasilitas::findOrFail($id);
        $peminjaman->status = 'Disetujui';
        $peminjaman->disetujui_oleh = Auth::id();
        $peminjaman->save();

        $this->setFasilitasAktif($peminjaman->fasilitas_id, true);

        // Kirim notifikasi
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new StatusPeminjamanNotification($peminjaman, 'disetujui'));
        }

        return redirect()->back()->with('success', 'Peminjaman telah disetujui dan fasilitas ditandai sebagai digunakan.');
    }

    private function setFasilitasAktif($fasilitasId, $aktif = true)
    {
        $fasilitas = Fasilitas::find($fasilitasId);
        if ($fasilitas) {
            // Jika peminjaman selesai, cek apakah masih ada peminjaman aktif lainnya
            if (!$aktif) {
                $masihAdaPeminjamanAktif = PeminjamanFasilitas::where('fasilitas_id', $fasilitasId)
                    ->where('status', 'disetujui')
                    ->where('tanggal_mulai', '<=', Carbon::now())
                    ->where('tanggal_selesai', '>=', Carbon::now())
                    ->exists();

                // Hanya set tidak aktif jika tidak ada peminjaman aktif lainnya
                if (!$masihAdaPeminjamanAktif) {
                    $fasilitas->is_aktif = 0;
                }
            } else {
                $fasilitas->is_aktif = 1;
            }

            $fasilitas->save();
        }
    }
}
