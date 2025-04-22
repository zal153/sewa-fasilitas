<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Fasilitas;
use App\Models\PeminjamanFasilitas;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = PeminjamanFasilitas::paginate(10);
        $user = User::all();
        $fasilitas = Fasilitas::all();
        $peminjaman = PeminjamanFasilitas::all();
        $no = 1;
        return view('admin.peminjaman.index', compact('user', 'fasilitas', 'peminjaman', 'no', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = User::all();
        $fasilitas = Fasilitas::all();
        return view('admin.peminjaman.create', compact('user', 'fasilitas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
