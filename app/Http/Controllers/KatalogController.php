<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    // Menampilkan semua buku dalam bentuk katalog (Grid)
    public function index()
    {
        $buku = Buku::with('kategori')->get();
        return view('katalog.index', compact('buku'));
    }

    // Menampilkan 1 halaman detail buku yang berisi tombol pinjam & ulasan
    public function show($id)
    {
        // Menarik data buku, kategori, dan semua ulasan beserta nama user yang mengulas
        $buku = Buku::with(['kategori', 'ulasan.user'])->findOrFail($id);
        return view('katalog.show', compact('buku'));
    }
}