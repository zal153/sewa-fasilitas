<?php

namespace App\Http\Controllers\NonMahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use App\Models\PeminjamanFasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NonPeminjamanController extends Controller
{
    public function index()
    {
        $fasilitas = Fasilitas::all();

        foreach ($fasilitas as $fasilitasItem) {
            $peminjamanAktif = PeminjamanFasilitas::where('fasilitas_id', $fasilitasItem->id)
                ->where('status', 'disetujui')
                ->where(function ($query) {
                    $query->where('tanggal_selesai', '>=', Carbon::now())
                        ->where('tanggal_mulai', '<=', Carbon::now());
                })
                ->exists();

            $fasilitasItem->kondisi = $peminjamanAktif ? 'false' : 'true';
        }

        $peminjaman = PeminjamanFasilitas::all();
        return view('user.non-mahasiswa.peminjaman.index', compact('fasilitas', 'peminjaman'));
    }

    public function create()
    {
        $fasilitas = Fasilitas::all();
        $fasilitas_id = request()->input('fasilitas_id');
        $fasilitas_pilih = Fasilitas::find($fasilitas_id);
        return view('user.non-mahasiswa.peminjaman.create', compact('fasilitas', 'fasilitas_pilih'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fasilitas_id' => 'required|exists:fasilitas,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keperluan' => 'required|string',
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

        return redirect()->route('non_mahasiswa.peminjaman')->with('success', 'Peminjaman berhasil diajukan!')->with('kode_peminjaman', $kode);
    }

    public function edit($id)
    {
        $peminjaman = PeminjamanFasilitas::findOrFail($id);
        return view('user.non-mahasiswa.peminjaman.edit', compact('peminjaman'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fasilitas_id' => 'required|exists:fasilitas,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keperluan' => 'nullable|string',
        ]);

        $peminjaman = PeminjamanFasilitas::findOrFail($id);
        $peminjaman->update([
            'fasilitas_id' => $request->fasilitas_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'keperluan' => $request->keperluan,
        ]);

        return redirect()->route('non_mahasiswa.peminjaman')->with('success', 'Peminjaman berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $peminjaman = PeminjamanFasilitas::findOrFail($id);
        $peminjaman->delete();
        return redirect()->route('non_mahasiswa.peminjaman')->with('success', 'Peminjaman berhasil dihapus!');
    }
}
