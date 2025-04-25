<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Fasilitas;
use App\Models\PeminjamanFasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function index()
    {
        $data = PeminjamanFasilitas::paginate(10);
        $user = User::all();
        $fasilitas = Fasilitas::all();
        $peminjaman = PeminjamanFasilitas::all();
        $adaNonMahasiswa = $peminjaman->contains(fn($item) => $item->user->role === 'non-mahasiswa');
        $no = 1;
        return view('admin.peminjaman.index', compact('user', 'fasilitas', 'peminjaman', 'no', 'data', 'adaNonMahasiswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'fasilitas_id' => 'required|exists:fasilitas,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keperluan' => 'required|string',
        ]);

        PeminjamanFasilitas::create([
            'user_id' => $request->user_id,
            'fasilitas_id' => $request->fasilitas_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'keperluan' => $request->keperluan,
            'status' => 'Menunggu',
            'status_pembayaran' => 0, // 0 = Belum Bayar
        ]);

        return redirect()->route('peminjaman')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $peminjaman = PeminjamanFasilitas::findOrFail($id);
        $users = User::all();
        $fasilitas = Fasilitas::all();

        return view('admin.peminjaman.edit', compact('peminjaman', 'users', 'fasilitas'));
    }


    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'nullable|in:diajukan,disetujui,ditolak,selesai',
            // 'status_pembayaran' => 'nullable|boolean',
            'catatan' => 'nullable|string',
        ]);

        $peminjaman = PeminjamanFasilitas::findOrFail($id);
        $peminjaman->status = $request->status ?? $peminjaman->status;
        $peminjaman->catatan = $request->catatan;

        if ($request->status === 'disetujui') {
            $peminjaman->approved_by = Auth::id();
        }

        $peminjaman->save();

        return redirect()->route('peminjaman')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $peminjaman = PeminjamanFasilitas::findOrFail($id);
        $peminjaman->delete();

        return redirect()->route('peminjaman')->with('success', 'Data berhasil dihapus.');
    }

    // Custom method buat menyetujui
    public function approve($id)
    {
        $peminjaman = PeminjamanFasilitas::findOrFail($id);
        $peminjaman->status = 'Disetujui';
        $peminjaman->approved_by = Auth::id();
        $peminjaman->save();

        return redirect()->back()->with('success', 'Peminjaman telah disetujui.');
    }
}
