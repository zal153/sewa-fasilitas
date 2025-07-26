<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use App\Models\PeminjamanFasilitas;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');
        $userId = Auth::id();

        $totalFasilitas = Fasilitas::count();

        $peminjamanAktif = PeminjamanFasilitas::where('user_id', $userId)
            ->where('status', 'disetujui')
            ->where('tanggal_mulai', '<=', Carbon::now())
            ->where('tanggal_selesai', '>=', Carbon::now())
            ->count();

        $menungguPersetujuan = PeminjamanFasilitas::where('user_id', $userId)
            ->where('status', 'diajukan')
            ->count();

        $riwayatPeminjaman = PeminjamanFasilitas::where('user_id', $userId)->count();

        return view('user.mahasiswa.dashboard', compact(
            'totalFasilitas',
            'peminjamanAktif',
            'menungguPersetujuan',
            'riwayatPeminjaman'
        ));
    }
}
