<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
Use App\Models\PeminjamanFasilitas;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index()
    {
        $fasilitas = Fasilitas::all();
        $no = 1;
        $data = Fasilitas::paginate(10);
        return view('user.peminjaman.index', compact('fasilitas', 'no', 'data'));
    }

    public function create()
    {
        $fasilitas = Fasilitas::all();
        return view('user.peminjaman.create', compact('fasilitas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fasilitas_id' => 'required|exists:fasilitas,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keperluan' => 'nullable|string',
        ]);

        $lastId = DB::table('peminjaman_fasilitas')->max('id') ?? 0;
        $nextId = $lastId + 1;

        $kode = 'PMJ-' . date('Ymd') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        PeminjamanFasilitas::create([
            'kode_peminjaman' => $kode,
            'user_id' => auth()->id(),
            'fasilitas_id' => $request->fasilitas_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'keperluan' => $request->keperluan,
            'status' => 'diajukan',
            'is_bayar' => false,
        ]);

        return redirect()->route('mahasiswa.peminjaman')->with('success', 'Peminjaman berhasil diajukan!');
    }

    public function edit($id)
    {
        $peminjaman = PeminjamanFasilitas::findOrFail($id);
        return view('user.peminjaman.edit', compact('peminjaman'));
    }
    public function update(Request $request, $id)
    {
        $peminjaman = PeminjamanFasilitas::findOrFail($id);

        $request->validate([
            'fasilitas_id' => 'required|exists:fasilitas,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keperluan' => 'nullable|string',
        ]);

        $peminjaman->update([
            'fasilitas_id' => $request->fasilitas_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'keperluan' => $request->keperluan,
        ]);

        return redirect()->route('mahasiswa.peminjaman')->with('success', 'Peminjaman berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $peminjaman = PeminjamanFasilitas::findOrFail($id);
        $peminjaman->delete();

        return redirect()->route('mahasiswa.peminjaman')->with('success', 'Peminjaman berhasil dihapus!');
    }
}
