<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'Username' => 'required',
            'Password' => 'required',
        ]);

        // Cari user berdasarkan Username
        $user = User::where('Username', $request->Username)->first();

        // Cek apakah user ada dan passwordnya cocok
        if ($user && Hash::check($request->Password, $user->Password)) {
            Auth::login($user);
            return redirect('/dashboard');
        }

        return back()->with('error', 'Username atau Password salah!');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function postRegister(Request $request)
    {
        $request->validate([
            'Username' => 'required|unique:users',
            'Email' => 'required|email|unique:users',
            'Password' => 'required|min:6',
            'NamaLengkap' => 'required',
            'Alamat' => 'required',
        ]);

        // Simpan data ke database, password di-hash agar aman
        User::create([
            'Username' => $request->Username,
            'Email' => $request->Email,
            'Password' => Hash::make($request->Password),
            'NamaLengkap' => $request->NamaLengkap,
            'Alamat' => $request->Alamat,
            'role' => 'peminjam', // Default saat register dari halaman depan
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}