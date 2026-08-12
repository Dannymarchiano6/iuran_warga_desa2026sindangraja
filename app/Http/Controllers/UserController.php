<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id_user', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username'     => 'required|string|max:255|unique:users,username',
            'password'     => 'required|string|min:6',
            'role'         => 'required|in:admin,bendahara,warga',
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'username'     => $request->username,
            'password'     => Hash::make($request->password),
            'role'         => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('notif', 'User berhasil ditambahkan!');
    }
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username'     => 'required|string|max:255|unique:users,username,' . $id . ',id_user',
            'role'         => 'required|in:admin,bendahara,warga',
            'password'     => 'nullable|string|min:6',
        ]);

        $data = [
            'nama_lengkap' => $request->nama_lengkap,
            'username'     => $request->username,
            'role'         => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('notif', 'User berhasil diperbarui!');
    }
    public function destroy($id)
    {
        if (Auth::user()->id_user == $id) {
            return redirect()->route('admin.users.index')->with('notif', 'Tidak bisa hapus akun sendiri!');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('notif', 'User berhasil dihapus!');
    }
}
