<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use Illuminate\Http\Request;

class FasilitasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Fasilitas::paginate(10);
        $fasilitas = Fasilitas::all();
        $no = 1;
        return view('admin.fasilitas.index', compact('fasilitas', 'no', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.fasilitas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_fasilitas' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lokasi' => 'required|string|max:255',
            'kapasitas' => 'required|integer',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $gambarPath = $request->hasFile('gambar')
            ? $request->file('gambar')->store('fasilitas', 'public')
            : null;
        
        Fasilitas::create([
            'nama_fasilitas' => $request->nama_fasilitas,
            'deskripsi' => $request->deskripsi,
            'lokasi' => $request->lokasi,
            'kapasitas' => $request->kapasitas,
            'gambar' => $gambarPath,
            'is_aktif' => $request->has('is_aktif') ? 1 : 0,
        ]);

        return redirect()->route('fasilitas')->with('success', 'Fasilitas created successfully.');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        return view('admin.fasilitas.edit', compact('fasilitas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_fasilitas' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lokasi' => 'required|string|max:255',
            'kapasitas' => 'required|integer',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $fasilitas = Fasilitas::findOrFail($id);

        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('fasilitas', 'public');
            $fasilitas->gambar = $gambarPath;
        }

        $fasilitas->update([
            'nama_fasilitas' => $request->nama_fasilitas,
            'deskripsi' => $request->deskripsi,
            'lokasi' => $request->lokasi,
            'kapasitas' => $request->kapasitas,
            'is_aktif' => $request->has('is_aktif') ? 1 : 0,
        ]);

        return redirect()->route('fasilitas')->with('success', 'Fasilitas updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        $fasilitas->delete();

        return redirect()->route('fasilitas')->with('success', 'Fasilitas deleted successfully.');
    }
}
