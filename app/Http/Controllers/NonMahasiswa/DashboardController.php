<?php

namespace App\Http\Controllers\NonMahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use App\Models\PeminjamanFasilitas;
use App\Models\PembayaranFasilitas;
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

        $tagihanBelumBayar = PeminjamanFasilitas::where('user_id', $userId)
            ->where('is_bayar', false)
            ->whereIn('status', ['disetujui', 'selesai'])
            ->count();

        $riwayatPeminjaman = PeminjamanFasilitas::where('user_id', $userId)->count();

        return view('user.non-mahasiswa.dashboard', compact(
            'totalFasilitas',
            'peminjamanAktif',
            'tagihanBelumBayar',
            'riwayatPeminjaman'
        ));
    }
}
