<?php

namespace App\Http\Controllers;

use App\Models\KoleksiPribadi;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KoleksiController extends Controller
{
    // Menampilkan daftar koleksi pribadi user yang sedang login
    public function index()
    {
        $koleksi = KoleksiPribadi::with('buku')
                    ->where('UserID', Auth::user()->UserID)
                    ->get();
                    
        return view('koleksi.index', compact('koleksi'));
    }

    // Halaman untuk memilih buku yang mau ditambahkan ke koleksi
    public function create()
    {
        $buku = Buku::all();
        return view('koleksi.create', compact('buku'));
    }

    // Proses menyimpan ke koleksi
    public function store(Request $request)
    {
        $request->validate([
            'BukuID' => 'required'
        ]);

        $userID = Auth::user()->UserID;
        $bukuID = $request->BukuID;

        // Cek apakah buku sudah ada di koleksi agar tidak dobel
        $cek_koleksi = KoleksiPribadi::where('UserID', $userID)->where('BukuID', $bukuID)->first();

        if ($cek_koleksi) {
            return redirect('/koleksi')->with('error', 'Buku ini sudah ada di dalam koleksi Anda!');
        }

        // Jika belum ada, tambahkan ke koleksi
        KoleksiPribadi::create([
            'UserID' => $userID,
            'BukuID' => $bukuID,
        ]);

        return redirect('/koleksi')->with('success', 'Buku berhasil ditambahkan ke koleksi pribadi!');
    }

    // Menghapus buku dari koleksi
    public function destroy($id)
    {
        $koleksi = KoleksiPribadi::findOrFail($id);
        
        // Keamanan: Pastikan hanya pemilik koleksi yang bisa menghapus
        if ($koleksi->UserID == Auth::user()->UserID) {
            $koleksi->delete();
            return redirect('/koleksi')->with('success', 'Buku dihapus dari koleksi.');
        }

        return redirect('/koleksi')->with('error', 'Akses ditolak.');
    }
}