<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use App\Models\PeminjamanFasilitas;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\NonMahasiswa;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalFasilitas = Fasilitas::count();

        $totalPeminjaman = PeminjamanFasilitas::count();

        $pengajuanPeminjaman = PeminjamanFasilitas::where('status', 'pending')
            ->orWhere('status', 'menunggu')
            ->count();

        // Hitung total pengguna dari data master saja
        $totalMahasiswa = Mahasiswa::count();
        $totalNonMahasiswa = NonMahasiswa::count();
        $totalUser = $totalMahasiswa + $totalNonMahasiswa;

        $peminjamanDisetujui = PeminjamanFasilitas::where('status', 'disetujui')
            ->orWhere('status', 'aktif')
            ->count();

        $persentasePeminjaman = $totalPeminjaman > 0 ?
            round(($peminjamanDisetujui / $totalPeminjaman) * 100) : 0;

        return view('admin.dashboard.dashboard', compact(
            'totalFasilitas',
            'totalPeminjaman',
            'pengajuanPeminjaman',
            'totalUser',
            'persentasePeminjaman'
        ));
    }

    public function pending()
    {
        $peminjamanPending = PeminjamanFasilitas::where('status', 'pending')
            ->orWhere('status', 'menunggu')
            ->with(['user', 'fasilitas'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.peminjaman.pending', compact('peminjamanPending'));
    }

    public function getData()
    {
        $totalFasilitas = Fasilitas::count();
        $totalPeminjaman = PeminjamanFasilitas::count();
        $pengajuanPeminjaman = PeminjamanFasilitas::where('status', 'pending')
            ->orWhere('status', 'menunggu')
            ->count();

        $totalMahasiswa = Mahasiswa::count();
        $totalNonMahasiswa = NonMahasiswa::count();
        $totalUser = $totalMahasiswa + $totalNonMahasiswa;

        $peminjamanDisetujui = PeminjamanFasilitas::where('status', 'disetujui')
            ->orWhere('status', 'aktif')
            ->count();

        $persentasePeminjaman = $totalPeminjaman > 0 ?
            round(($peminjamanDisetujui / $totalPeminjaman) * 100) : 0;

        return response()->json([
            'totalFasilitas' => $totalFasilitas,
            'totalPeminjaman' => $totalPeminjaman,
            'pengajuanPeminjaman' => $pengajuanPeminjaman,
            'totalUser' => $totalUser,
            'persentasePeminjaman' => $persentasePeminjaman
        ]);
    }
}
