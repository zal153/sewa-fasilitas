<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\NonMahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class NonMahasiswaController extends Controller
{
    public function index()
    {
        $data = NonMahasiswa::with('user')->paginate(10);
        $no = 1;
        return view('admin.non-mahasiswa.index', compact('data', 'no'));
    }

    public function create()
    {
        return view('admin.non-mahasiswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|min:8|confirmed',
            'institusi'    => 'required',
            'jabatan'      => 'required',
            'identitas_no' => 'required|unique:non_mahasiswa,identitas_no',
            'alamat'       => 'required',
            'kontak'       => 'required',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => bcrypt($request->password),
                'role'     => 'nonmahasiswa',
            ]);

            NonMahasiswa::create([
                'user_id'      => $user->id,
                'institusi'    => $request->institusi,
                'jabatan'      => $request->jabatan,
                'identitas_no' => $request->identitas_no,
                'alamat'       => $request->alamat,
                'kontak'       => $request->kontak,
            ]);

            DB::commit();
            return redirect()->route('eksternal')->with('success', 'Data non-mahasiswa berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan data non-mahasiswa: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function edit($id)
    {
        $data = NonMahasiswa::with('user')->findOrFail($id);
        return view('admin.non-mahasiswa.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'         => 'required',
            'email'        => 'required|email|unique:users,email,' . $request->user_id,
            'password'     => 'nullable|min:8|confirmed',
            'institusi'    => 'required',
            'jabatan'      => 'required',
            'identitas_no' => 'required|unique:non_mahasiswa,identitas_no,' . $id,
            'alamat'       => 'required',
            'kontak'       => 'required',
        ]);

        DB::beginTransaction();
        try {
            $non = NonMahasiswa::findOrFail($id);
            $user = User::findOrFail($non->user_id);

            $user->name  = $request->name;
            $user->email = $request->email;
            if ($request->filled('password')) {
                $user->password = bcrypt($request->password);
            }
            $user->save();

            $non->update([
                'institusi'    => $request->institusi,
                'jabatan'      => $request->jabatan,
                'identitas_no' => $request->identitas_no,
                'alamat'       => $request->alamat,
                'kontak'       => $request->kontak,
            ]);

            DB::commit();
            return redirect()->route('eksternal')->with('success', 'Data non-mahasiswa berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal memperbarui data non-mahasiswa: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }

    public function destroy($id)
    {
        try {
            $non = NonMahasiswa::findOrFail($id);
            $user = User::findOrFail($non->user_id);

            $non->delete();
            $user->delete();

            return redirect()->route('eksternal')->with('success', 'Data non-mahasiswa berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data non-mahasiswa: ' . $e->getMessage());
            return redirect()->route('eksternal')->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}
