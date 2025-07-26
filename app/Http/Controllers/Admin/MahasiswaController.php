<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class MahasiswaController extends Controller
{
    public function index()
    {
        $data = Mahasiswa::with('user')->paginate(10);
        $no = 1;
        return view('admin.mahasiswa.index', compact('data', 'no'));
    }

    public function create()
    {
        return view('admin.mahasiswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'nim'      => 'required|unique:mahasiswa,nim',
            'fakultas' => 'required',
            'jurusan'  => 'required',
            'angkatan' => 'required|numeric',
            'kontak'   => 'required',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => bcrypt($request->password),
                'role'     => 'mahasiswa',
            ]);

            Mahasiswa::create([
                'user_id'  => $user->id,
                'nim'      => $request->nim,
                'fakultas' => $request->fakultas,
                'jurusan'  => $request->jurusan,
                'angkatan' => $request->angkatan,
                'kontak'   => $request->kontak,
            ]);

            DB::commit();
            return redirect()->route('mahasiswa')->with('success', 'Data mahasiswa berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan data mahasiswa: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function edit($id)
    {
        $data = Mahasiswa::with('user')->findOrFail($id);
        return view('admin.mahasiswa.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email,' . $request->user_id,
            'password' => 'nullable|min:8|confirmed',
            'nim'      => 'required|unique:mahasiswa,nim,' . $id,
            'fakultas' => 'required',
            'jurusan'  => 'required',
            'angkatan' => 'required|numeric',
            'kontak'   => 'required',
        ]);

        DB::beginTransaction();
        try {
            $mahasiswa = Mahasiswa::findOrFail($id);
            $user = User::findOrFail($mahasiswa->user_id);

            $user->name  = $request->name;
            $user->email = $request->email;
            if ($request->filled('password')) {
                $user->password = bcrypt($request->password);
            }
            $user->save();

            $mahasiswa->update([
                'nim'      => $request->nim,
                'fakultas' => $request->fakultas,
                'jurusan'  => $request->jurusan,
                'angkatan' => $request->angkatan,
                'kontak'   => $request->kontak,
            ]);

            DB::commit();
            return redirect()->route('mahasiswa')->with('success', 'Data mahasiswa berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal memperbarui data mahasiswa: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }

    public function destroy($id)
    {
        try {
            $mahasiswa = Mahasiswa::findOrFail($id);
            $user = User::findOrFail($mahasiswa->user_id);

            $mahasiswa->delete();
            $user->delete();

            return redirect()->route('mahasiswa')->with('success', 'Data mahasiswa berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data mahasiswa: ' . $e->getMessage());
            return redirect()->route('mahasiswa')->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}
