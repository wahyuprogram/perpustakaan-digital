<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KonfirmasiController extends Controller
{
    // Menampilkan daftar peminjaman yang perlu tindakan (Menunggu & Dipinjam)
    public function index()
    {
        // Menarik data peminjaman beserta info user dan buku
        $peminjaman = Peminjaman::with(['user', 'buku'])
                        ->whereIn('StatusPeminjaman', ['Menunggu', 'Dipinjam'])
                        ->orderBy('created_at', 'desc')
                        ->get();
                        
        return view('konfirmasi.index', compact('peminjaman'));
    }

    // Mengubah status menjadi "Dipinjam" (Disetujui)
    public function setujui($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        // Saat disetujui, tanggal pinjam dimulai HARI INI, dan tenggat waktu 7 hari ke depan
        $peminjaman->update([
            'StatusPeminjaman' => 'Dipinjam',
            'TanggalPeminjaman' => Carbon::now()->toDateString(),
            'TanggalPengembalian' => Carbon::now()->addDays(7)->toDateString(),
        ]);

        return redirect('/konfirmasi')->with('success', 'Peminjaman berhasil disetujui!');
    }

    // Mengubah status menjadi "Ditolak"
    public function tolak($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update([
            'StatusPeminjaman' => 'Ditolak'
        ]);

        return redirect('/konfirmasi')->with('success', 'Peminjaman telah ditolak.');
    }

    // Mengubah status menjadi "Dikembalikan" (Buku sudah diterima fisik oleh petugas)
    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        // Catat tanggal dikembalikan sesuai hari ini (opsional jika kamu punya kolom tanggal kembali aktual, tapi kita ikuti ERD saja dengan mengubah status)
        $peminjaman->update([
            'StatusPeminjaman' => 'Dikembalikan'
        ]);

        return redirect('/konfirmasi')->with('success', 'Buku berhasil dikonfirmasi kembali.');
    }
}