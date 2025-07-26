<?php

namespace App\Http\Controllers\NonMahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PembayaranFasilitas;
use Illuminate\Support\Facades\Auth;

class NonPembayaranController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pembayaran = PembayaranFasilitas::with('peminjaman')
            ->whereHas('peminjaman', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->orderByDesc('created_at')
            ->get();

        return view('user.non-mahasiswa.pembayaran.index', compact('pembayaran'));
    }
}
