<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FasilitasController extends Controller
{
    public function index()
    {
        $fasilitas = Fasilitas::orderBy('created_at', 'desc')->paginate(10);
        $allFasilitas = Fasilitas::all();

        $data = [
            'fasilitas' => $fasilitas,
            'allFasilitas' => $allFasilitas,
            'no' => ($fasilitas->currentPage() - 1) * $fasilitas->perPage() + 1
        ];

        return view('admin.fasilitas.index', $data);
    }

    public function create()
    {
        return view('admin.fasilitas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_fasilitas' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'lokasi' => 'required|string|max:255',
            'biaya' => 'required|string',
            'kapasitas' => 'required|integer|min:1',
            'status_penggunaan' => 'required|in:Digunakan,Tidak Digunakan',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $biaya = (float) str_replace('.', '', $request->biaya);

        $gambarPath = $request->hasFile('gambar')
            ? $request->file('gambar')->store('fasilitas', 'public')
            : null;

        Fasilitas::create([
            'nama_fasilitas' => $request->nama_fasilitas,
            'deskripsi' => $request->deskripsi,
            'lokasi' => $request->lokasi,
            'biaya' => $biaya,
            'kapasitas' => $request->kapasitas,
            'gambar' => $gambarPath,
            'status_penggunaan' => strtolower(str_replace(' ', '_', $request->status_penggunaan)),
        ]);

        return redirect()->route('fasilitas')->with('success', 'Data fasilitas berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        return view('admin.fasilitas.edit', compact('fasilitas'));
    }

    public function update(Request $request, $id)
    {
        $fasilitas = Fasilitas::findOrFail($id);

        $validated = $request->validate([
            'nama_fasilitas' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'lokasi' => 'required|string|max:255',
            'biaya' => 'required|string',
            'kapasitas' => 'required|integer|min:1',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status_penggunaan' => 'required|in:digunakan,tidak_digunakan',
        ]);

        $biaya = (float) str_replace('.', '', $request->biaya);

        if ($request->hasFile('gambar') && $fasilitas->gambar) {
            Storage::disk('public')->delete($fasilitas->gambar);
        }

        $gambarPath = $request->hasFile('gambar')
            ? $request->file('gambar')->store('fasilitas', 'public')
            : $fasilitas->gambar;

        $fasilitas->update([
            'nama_fasilitas' => $validated['nama_fasilitas'],
            'deskripsi' => $validated['deskripsi'],
            'lokasi' => $validated['lokasi'],
            'biaya' => $biaya,
            'kapasitas' => $validated['kapasitas'],
            'gambar' => $gambarPath,
            'status_penggunaan' => $validated['status_penggunaan'],
        ]);

        return redirect()->route('fasilitas')->with('success', 'Data fasilitas berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $fasilitas = Fasilitas::findOrFail($id);

        if ($fasilitas->gambar) {
            Storage::disk('public')->delete($fasilitas->gambar);
        }

        $fasilitas->delete();

        return redirect()->route('fasilitas')->with('success', 'Fasilitas deleted successfully.');
    }

    public function updateStatus($id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        $fasilitas->status_penggunaan = $fasilitas->status_penggunaan === 'digunakan'
            ? 'tidak_digunakan'
            : 'digunakan';
        $fasilitas->save();

        return redirect()->route('fasilitas')->with('success', 'Status fasilitas berhasil diperbarui.');
    }
}
