<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use App\Models\PeminjamanFasilitas;
use App\Services\NotificationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index()
    {
        $fasilitas = Fasilitas::all();

        foreach ($fasilitas as $fasilitasItem) {
            $fasilitasItem->kondisi = $fasilitasItem->tersedia() ? 'true' : 'false';
        }

        $peminjaman = PeminjamanFasilitas::all();
        $adaNonMahasiswa = $peminjaman->contains(fn($item) => $item->user->role === 'non_mahasiswa');

        return view('user.Peminjaman.index', compact('fasilitas', 'adaNonMahasiswa'));
    }

    public function create(Request $request)
    {
        $fasilitas = Fasilitas::all();
        $peminjaman = PeminjamanFasilitas::all();
        $fasilitas_id = $request->fasilitas_id;
        $fasilitas_pilih = Fasilitas::find($fasilitas_id);
        return view('user.Peminjaman.create', compact('fasilitas', 'peminjaman', 'fasilitas_pilih'));
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
            'user_id' => Auth::id(),
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
        return view('user.Peminjaman.edit', compact('peminjaman'));
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

    // Ketika peminjaman disetujui
    public function approve($id)
    {
        $peminjaman = PeminjamanFasilitas::findOrFail($id);
        $peminjaman->update(['status' => 'disetujui']);

        // Kirim notifikasi
        NotificationService::sendPeminjamanDisetujui($peminjaman);

        return redirect()->back()->with('success', 'Peminjaman berhasil disetujui!');
    }
}
