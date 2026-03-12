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

    // Halaman form untuk menulis ulasan baru (opsional jika lewat katalog)
    public function create()
    {
        $buku = Buku::all(); 
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

        // Cek apakah user sudah pernah mengulas buku ini
        $cek_ulasan = UlasanBuku::where('UserID', $userID)->where('BukuID', $bukuID)->first();

        if ($cek_ulasan) {
            // MENGGUNAKAN back() AGAR TETAP DI HALAMAN DETAIL BUKU
            return back()->with('error', 'Anda sudah pernah memberikan ulasan untuk buku ini!');
        }

        UlasanBuku::create([
            'UserID' => $userID,
            'BukuID' => $bukuID,
            'Ulasan' => $request->Ulasan,
            'Rating' => $request->Rating,
        ]);

        // MENGGUNAKAN back() AGAR TETAP DI HALAMAN DETAIL BUKU
        return back()->with('success', 'Terima kasih! Ulasan Anda berhasil dikirim.');
    }

    // ==========================================
    // BAGIAN KHUSUS ADMIN & PETUGAS
    // ==========================================

    // Menampilkan semua ulasan dari semua user untuk dibalas
    public function adminIndex()
    {
        $ulasan = UlasanBuku::with(['user', 'buku'])->orderBy('created_at', 'desc')->get();
        return view('ulasan.admin', compact('ulasan'));
    }

    // Menyimpan balasan dari admin
    public function balas(Request $request, $id)
    {
        $request->validate([
            'Balasan' => 'required'
        ]);

        $ulasan = UlasanBuku::findOrFail($id);
        $ulasan->update([
            'Balasan' => $request->Balasan
        ]);

        return back()->with('success', 'Balasan berhasil dikirim!');
    }
}