<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Menampilkan daftar semua pengguna (admin, petugas, peminjam)
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    // Menampilkan form tambah pengguna baru (untuk bikin akun petugas/admin)
    public function create()
    {
        return view('users.create');
    }

    // Proses menyimpan pengguna baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'Username' => 'required|unique:users',
            'Email' => 'required|email|unique:users',
            'Password' => 'required|min:6',
            'NamaLengkap' => 'required',
            'Alamat' => 'required',
            'role' => 'required|in:administrator,petugas,peminjam',
        ]);

        User::create([
            'Username' => $request->Username,
            'Email' => $request->Email,
            'Password' => Hash::make($request->Password),
            'NamaLengkap' => $request->NamaLengkap,
            'Alamat' => $request->Alamat,
            'role' => $request->role, // Role ditentukan oleh Admin yang membuat
        ]);

        return redirect('/users')->with('success', 'Pengguna baru berhasil ditambahkan!');
    }

    // Proses menghapus pengguna
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Mencegah admin menghapus dirinya sendiri yang sedang login
        if ($user->UserID == auth()->user()->UserID) {
            return redirect('/users')->with('error', 'Anda tidak bisa menghapus akun Anda sendiri yang sedang digunakan!');
        }

        $user->delete();
        return redirect('/users')->with('success', 'Pengguna berhasil dihapus!');
    }
}