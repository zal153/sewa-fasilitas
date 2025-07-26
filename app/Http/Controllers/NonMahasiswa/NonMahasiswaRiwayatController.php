<?php

namespace App\Http\Controllers\NonMahasiswa;

use App\Http\Controllers\Controller;
use App\Models\PeminjamanFasilitas;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NonMahasiswaRiwayatController extends Controller
{
    public function riwayat(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $peminjaman = PeminjamanFasilitas::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
        $no = 1;
        $start = $peminjaman->firstItem();
        $end = $peminjaman->lastItem();
        $adaNonMahasiswa = $peminjaman->contains(fn($item) => $item->user->role === 'non_mahasiswa');

        return view('user.non-mahasiswa.riwayat.index', compact('peminjaman', 'no', 'perPage', 'start', 'end', 'adaNonMahasiswa'));
    }

    public function print($id)
    {
        $peminjaman = PeminjamanFasilitas::with(['user', 'fasilitas', 'approvedBy'])->findOrFail($id);

        if ($peminjaman->status !== 'Disetujui') {
            return redirect()->back()->with('error', 'Surat hanya dapat dicetak untuk peminjaman yang sudah disetujui.');
        }

        $pdf = PDF::loadView('user.non-mahasiswa.riwayat.print', compact('peminjaman'));
        return $pdf->stream('riwayat_peminjaman_' . $peminjaman->kode_peminjaman . '.pdf');
    }

    public function destroy($id)
    {
        $peminjaman = PeminjamanFasilitas::findOrFail($id);
        $peminjaman->delete();
        return redirect()->route('non_mahasiswa.riwayat')->with('success', 'Peminjaman telah dihapus.');
    }
}
