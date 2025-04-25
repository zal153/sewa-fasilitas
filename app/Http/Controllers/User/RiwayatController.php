<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PeminjamanFasilitas;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function riwayat(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $peminjaman = PeminjamanFasilitas::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        $no = 1;
        $start = $peminjaman->firstItem();
        $end = $peminjaman->lastItem();
        return view('user.riwayat.index', compact('peminjaman', 'no', 'perPage', 'start', 'end'));
    }
}
