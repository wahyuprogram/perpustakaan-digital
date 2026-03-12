<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // Untuk mengatur tanggal otomatis

class PeminjamanController extends Controller
{
    // Menampilkan riwayat peminjaman user yang sedang login
    public function index()
    {
        // Ambil data peminjaman khusus untuk UserID yang sedang login
        $peminjaman = Peminjaman::with('buku')
                        ->where('UserID', Auth::user()->UserID)
                        ->orderBy('TanggalPeminjaman', 'desc')
                        ->get();
                        
        return view('peminjaman.index', compact('peminjaman'));
    }

    // Halaman form untuk meminjam buku baru
    public function create()
    {
        $buku = Buku::all(); // Ambil semua daftar buku
        return view('peminjaman.create', compact('buku'));
    }

    // Proses menyimpan data pinjaman
    public function store(Request $request)
    {
        $request->validate([
            'BukuID' => 'required'
        ]);

        // Simpan ke database dengan tanggal otomatis
        Peminjaman::create([
            'UserID' => Auth::user()->UserID,
            'BukuID' => $request->BukuID,
            'TanggalPeminjaman' => Carbon::now()->toDateString(), // Hari ini
            'TanggalPengembalian' => Carbon::now()->addDays(7)->toDateString(), // Tenggat 7 hari
            'StatusPeminjaman' => 'Menunggu',
        ]);

        return redirect('/peminjaman')->with('success', 'Buku berhasil dipinjam! Harap kembalikan tepat waktu.');
    }

    // Proses mengembalikan buku
    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        // Pastikan yang menekan tombol adalah orang yang meminjam
        if ($peminjaman->UserID == Auth::user()->UserID) {
            $peminjaman->update([
                'StatusPeminjaman' => 'Dikembalikan'
            ]);
            return redirect('/peminjaman')->with('success', 'Terima kasih telah mengembalikan buku.');
        }

        return redirect('/peminjaman')->with('error', 'Akses ditolak.');
    }
}