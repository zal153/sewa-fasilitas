<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalFasilitas;
use App\Models\Fasilitas;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = JadwalFasilitas::paginate(10);
        $jadwal = JadwalFasilitas::all();
        $fasilitas = Fasilitas::all();
        $no = 1;
        return view('admin.jadwal.index', compact('jadwal', 'fasilitas', 'no', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fasilitas = Fasilitas::all();
        return view('admin.jadwal.create', compact('fasilitas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'fasilitas_id' => 'required|exists:fasilitas,id',
            'tanggal_mulai' => 'required|date',
            'jam_mulai' => 'required|date_format:H:i',
            'tanggal_selesai' => 'required|date',
            'jam_selesai' => 'required|date_format:H:i',
        ]);

        $waktu_mulai = Carbon::parse($request->tanggal_mulai . ' ' . $request->jam_mulai);
        $waktu_selesai = Carbon::parse($request->tanggal_selesai . ' ' . $request->jam_selesai);

        if ($waktu_selesai <= $waktu_mulai) {
            return back()->withErrors(['jam_selesai' => 'Waktu selesai harus setelah waktu mulai'])->withInput();
        }

        JadwalFasilitas::create([
            'fasilitas_id' => $request->fasilitas_id,
            'waktu_mulai' => $waktu_mulai,
            'waktu_selesai' => $waktu_selesai,
        ]);

        return redirect()->route('jadwal')->with('success', 'Jadwal created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jadwal = JadwalFasilitas::findOrFail($id);
        $fasilitas = Fasilitas::all();
        return view('admin.jadwal.edit', compact('jadwal', 'fasilitas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'fasilitas_id' => 'required|exists:fasilitas,id',
            'tanggal_mulai' => 'required|date',
            'jam_mulai' => 'required|date_format:H:i',
            'tanggal_selesai' => 'required|date',
            'jam_selesai' => 'required|date_format:H:i',
        ]);

        $waktu_mulai = Carbon::parse($request->tanggal_mulai . ' ' . $request->jam_mulai);
        $waktu_selesai = Carbon::parse($request->tanggal_selesai . ' ' . $request->jam_selesai);

        if ($waktu_selesai <= $waktu_mulai) {
            return back()->withErrors(['jam_selesai' => 'Waktu selesai harus setelah waktu mulai'])->withInput();
        }

        $jadwal = JadwalFasilitas::findOrFail($id);

        $jadwal->update([
            'fasilitas_id' => $request->fasilitas_id,
            'waktu_mulai' => $waktu_mulai,
            'waktu_selesai' => $waktu_selesai,
        ]);

        return redirect()->route('jadwal')->with('success', 'Jadwal updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jadwal = JadwalFasilitas::findOrFail($id);
        $jadwal->delete();
        return redirect()->route('jadwal')->with('success', 'Jadwal deleted successfully.');
    }
}
