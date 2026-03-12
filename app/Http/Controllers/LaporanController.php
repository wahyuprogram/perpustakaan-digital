<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    // Menampilkan halaman data laporan peminjaman
    public function index()
    {
        // Mengambil semua data peminjaman beserta nama user dan judul bukunya
        $peminjaman = Peminjaman::with(['user', 'buku'])
                        ->orderBy('TanggalPeminjaman', 'desc')
                        ->get();
                        
        return view('laporan.index', compact('peminjaman'));
    }

    // Membuka halaman khusus untuk dicetak
    public function cetak()
    {
        $peminjaman = Peminjaman::with(['user', 'buku'])
                        ->orderBy('TanggalPeminjaman', 'desc')
                        ->get();

        return view('laporan.cetak', compact('peminjaman'));
    }
}