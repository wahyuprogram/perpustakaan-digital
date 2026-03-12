<?php

namespace App\Http\Controllers;

use App\Models\UlasanBuku;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UlasanController extends Controller
{
    // Menampilkan daftar ulasan milik user yang sedang login
    public function index()
    {
        $ulasan = UlasanBuku::with('buku')
                    ->where('UserID', Auth::user()->UserID)
                    ->get();
                    
        return view('ulasan.index', compact('ulasan'));
    }

    // Halaman form untuk menulis ulasan baru
    public function create()
    {
        $buku = Buku::all(); // Menampilkan semua buku untuk dipilih
        return view('ulasan.create', compact('buku'));
    }

    // Proses menyimpan ulasan ke database
    public function store(Request $request)
    {
        $request->validate([
            'BukuID' => 'required',
            'Ulasan' => 'required',
            'Rating' => 'required|integer|min:1|max:5',
        ]);

        $userID = Auth::user()->UserID;
        $bukuID = $request->BukuID;

        // Cek apakah user sudah pernah mengulas buku ini (agar tidak dobel/spam)
        $cek_ulasan = UlasanBuku::where('UserID', $userID)->where('BukuID', $bukuID)->first();

        if ($cek_ulasan) {
            return redirect('/ulasan')->with('error', 'Anda sudah pernah memberikan ulasan untuk buku ini!');
        }

        UlasanBuku::create([
            'UserID' => $userID,
            'BukuID' => $bukuID,
            'Ulasan' => $request->Ulasan,
            'Rating' => $request->Rating,
        ]);

        return redirect('/ulasan')->with('success', 'Terima kasih! Ulasan Anda berhasil dikirim.');
    }
}