<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PeminjamanFasilitas;
use App\Models\User;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index()
    {
        $data = PeminjamanFasilitas::paginate(10);
        $user = User::all();
        $peminjaman = PeminjamanFasilitas::all();
        $no = 1;
        return view('user.peminjaman.index', compact('data', 'user', 'peminjaman', 'no'));
    }

    public function create()
    {
        $user = User::all();
        $peminjaman = PeminjamanFasilitas::all();
        return view('user.peminjaman.create', compact('user', 'peminjaman'));
    }
}
