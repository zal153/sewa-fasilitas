<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OperatorController extends Controller
{
    public function index()
    {
        $data = User::where('role', 'admin')->paginate(10);
        $no = 1;
        return view('admin.Operator.index', compact('data', 'no'));
    }

    public function create()
    {
        return view('admin.Operator.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role'     => 'required|in:admin,mahasiswa,dosen',
        ]);

        try {
            User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => bcrypt($request->password),
                'role'     => $request->role,
            ]);

            return redirect()->route('operator')->with('success', 'Data operator berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan operator: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.Operator.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:8|confirmed',
            'role'     => 'required|in:admin,mahasiswa,dosen',
        ]);

        try {
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->email = $request->email;

            if ($request->filled('password')) {
                $user->password = bcrypt($request->password);
            }

            $user->role = $request->role;
            $user->save();

            return redirect()->route('operator')->with('success', 'Data operator berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui operator: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return redirect()->route('operator')->with('success', 'Data operator berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus operator: ' . $e->getMessage());
            return redirect()->route('operator')->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}
