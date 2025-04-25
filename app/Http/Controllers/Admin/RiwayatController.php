<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PeminjamanFasilitas;
use App\Models\User;
use App\Models\Fasilitas;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index()
    {
        $data = PeminjamanFasilitas::paginate(10);
        $user = User::all();
        $fasilitas = Fasilitas::all();
        $riwayat = PeminjamanFasilitas::all();
        $adaNonMahasiswa = $riwayat->contains(fn($item) => $item->user->role === 'non-mahasiswa');
        $no = 1;
        return view('admin.riwayat.index', compact('data', 'adaNonMahasiswa', 'no', 'riwayat', 'user', 'fasilitas'));
    }

    public function detail($id)
    {
        $riwayat = PeminjamanFasilitas::with(['user', 'fasilitas', 'approvedBy'])->findOrFail($id);
        return view('admin.riwayat.detail', compact('riwayat'));
    }

    public function print($id)
    {
        $riwayat = PeminjamanFasilitas::with(['user', 'fasilitas', 'approvedBy'])->findOrFail($id);
        $pdf = PDF::loadView('admin.riwayat.print', compact('riwayat'));
        return $pdf->download('riwayat-peminjaman-' . $riwayat->kode_peminjaman . '.pdf');
    }
}
