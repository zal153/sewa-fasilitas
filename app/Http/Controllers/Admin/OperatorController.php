<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class OperatorController extends Controller
{
    public function index()
    {
        $data = User::paginate(10);
        $user = User::all();
        $no = 1;
        return view('admin.operator.index', compact('data', 'no', 'user'));
    }

    public function create()
    {
        $user = User::all();
        return view('admin.operator.create', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:admin,mahasiswa,dosen',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('operator')->with('success', 'Operator created successfully.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.operator.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:8|confirmed',
            'role' => 'required|in:admin,mahasiswa,dosen',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->role = $request->role;
        $user->save();

        return redirect()->route('operator')->with('success', 'Operator updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('operator')->with('success', 'Operator deleted successfully.');
    }

    public function detail($id)
    {
        $user = User::findOrFail($id);
        return view('admin.operator.detail', compact('user'));
    }
}
