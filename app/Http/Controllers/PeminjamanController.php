<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
        $buku = Buku::all(); 
        return view('peminjaman.create', compact('buku'));
    }

    // Proses menyimpan data pinjaman
    public function store(Request $request)
    {
        $request->validate([
            'BukuID' => 'required'
        ]);

        // Keamanan Ekstra: Pastikan stok buku benar-benar masih ada
        $buku = Buku::findOrFail($request->BukuID);
        if ($buku->Stok <= 0) {
            return back()->with('error', 'Maaf, stok buku ini sedang kosong dan tidak bisa dipinjam.');
        }

        // Simpan ke database dengan status Menunggu
        Peminjaman::create([
            'UserID' => Auth::user()->UserID,
            'BukuID' => $request->BukuID,
            'TanggalPeminjaman' => Carbon::now()->toDateString(), 
            'TanggalPengembalian' => Carbon::now()->addDays(7)->toDateString(),
            'StatusPeminjaman' => 'Menunggu',
        ]);

        return redirect('/peminjaman')->with('success', 'Permintaan peminjaman berhasil dikirim! Silakan tunggu konfirmasi Admin.');
    }

    // Proses mengembalikan buku (Jika peminjam masih punya akses tombol ini)
    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        // Pastikan yang menekan tombol adalah orang yang meminjam
        if ($peminjaman->UserID == Auth::user()->UserID) {
            
            // Tambah stok buku kembali karena dikembalikan
            $peminjaman->buku->increment('Stok');

            $peminjaman->update([
                'StatusPeminjaman' => 'Dikembalikan'
            ]);
            return redirect('/peminjaman')->with('success', 'Terima kasih telah mengembalikan buku.');
        }

        return redirect('/peminjaman')->with('error', 'Akses ditolak.');
    }

    // Proses membatalkan pengajuan pinjaman
    public function batal($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        // Pastikan hanya pemiliknya yang bisa membatalkan dan statusnya masih Menunggu
        if ($peminjaman->UserID == Auth::user()->UserID && $peminjaman->StatusPeminjaman == 'Menunggu') {
            
            // Hapus data pengajuan dari database (karena stok belum dikurangi, jadi aman dihapus)
            $peminjaman->delete();
            
            return redirect('/peminjaman')->with('success', 'Pengajuan peminjaman berhasil dibatalkan.');
        }

        return redirect('/peminjaman')->with('error', 'Peminjaman tidak dapat dibatalkan.');
    }
}