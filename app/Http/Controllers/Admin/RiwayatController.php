<?php

namespace App\Http\Controllers\Admin;

use App\Models\PeminjamanFasilitas;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function riwayat()
    {
        $data = PeminjamanFasilitas::paginate(10);
        $user = User::all();
        $peminjaman = PeminjamanFasilitas::all();
        $no = 1;
        return view('admin.Riwayat.index', compact('data', 'user', 'peminjaman', 'no'));
    }
}
