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
    public function index(Request $request)
    {
        $query = PeminjamanFasilitas::with(['user', 'fasilitas', 'approvedBy']);

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal_mulai', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal_selesai', '<=', $request->tanggal_selesai);
        }

        // Gunakan paginate() untuk mendapatkan pagination
        $riwayat = $query->orderBy('created_at', 'desc')->paginate(10);

        // Statistics
        $stats = [
            'total' => PeminjamanFasilitas::count(),
            'menunggu' => PeminjamanFasilitas::where('status', 'Menunggu')->count(),
            'disetujui' => PeminjamanFasilitas::where('status', 'Disetujui')->count(),
            'ditolak' => PeminjamanFasilitas::where('status', 'Ditolak')->count(),
        ];

        $adaNonMahasiswa = PeminjamanFasilitas::whereHas('user', function ($q) {
            $q->where('role', '!=', 'mahasiswa');
        })->exists();

        $no = ($riwayat->currentPage() - 1) * $riwayat->perPage() + 1;

        return view('admin.Riwayat.index', compact('riwayat', 'stats', 'adaNonMahasiswa', 'no'));
    }

    public function detail($id)
    {
        $riwayat = PeminjamanFasilitas::with(['user', 'fasilitas', 'approvedBy'])->findOrFail($id);
        return view('admin.Riwayat.detail', compact('riwayat'));
    }

    public function print($id)
    {
        $riwayat = PeminjamanFasilitas::with(['user', 'fasilitas', 'approvedBy'])->findOrFail($id);
        $pdf = PDF::loadView('admin.Riwayat.print', compact('riwayat'));
        return $pdf->stream('riwayat_peminjaman_' . $riwayat->kode_peminjaman . '.pdf');
    }
}
