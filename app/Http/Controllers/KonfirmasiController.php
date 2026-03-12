<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KonfirmasiController extends Controller
{
    // Menampilkan daftar peminjaman yang perlu tindakan (Menunggu & Dipinjam)
    public function index()
    {
        // Menarik semua data peminjaman tanpa difilter statusnya
        $peminjaman = Peminjaman::with(['user', 'buku'])
                        ->orderBy('updated_at', 'desc')
                        ->get();
                        
        return view('konfirmasi.index', compact('peminjaman'));
    }
// Menampilkan halaman detail spesifik untuk 1 transaksi peminjaman
    public function show($id)
    {
        $peminjaman = Peminjaman::with(['user', 'buku'])->findOrFail($id);
        return view('konfirmasi.show', compact('peminjaman'));
    }
    
    // Mengubah status menjadi "Dipinjam" (Disetujui) & Mengurangi Stok
    public function setujui($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        // Cek apakah stok masih ada sebelum disetujui (keamanan ekstra)
        if ($peminjaman->buku->Stok > 0) {
            // Kurangi stok buku 1
            $peminjaman->buku->decrement('Stok');
            
            // Update status dan tanggal
            $peminjaman->update([
                'StatusPeminjaman' => 'Dipinjam',
                'TanggalPeminjaman' => Carbon::now()->toDateString(),
                'TanggalPengembalian' => Carbon::now()->addDays(7)->toDateString(),
            ]);

            return redirect('/konfirmasi')->with('success', 'Peminjaman disetujui dan stok buku telah dikurangi!');
        }

        return redirect('/konfirmasi')->with('error', 'Gagal menyetujui, stok buku sedang habis!');
    }

    // Mengubah status menjadi "Ditolak" (Stok tidak berubah karena buku belum dipinjam)
    public function tolak($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update([
            'StatusPeminjaman' => 'Ditolak'
        ]);

        return redirect('/konfirmasi')->with('success', 'Peminjaman telah ditolak.');
    }

    // Mengubah status menjadi "Dikembalikan" & Menghitung Denda via Modal (Anti Minus)
    public function kembalikan(Request $request, $id)
    {
        $request->validate([
            'TanggalDikembalikan' => 'required|date'
        ]);

        $peminjaman = Peminjaman::findOrFail($id);
        
        // Ambil tanggal tenggat dan tanggal pilihan admin
        $tenggat = \Carbon\Carbon::parse($peminjaman->TanggalPengembalian)->startOfDay();
        $tglKembaliAsli = \Carbon\Carbon::parse($request->TanggalDikembalikan)->startOfDay();
        
        $denda = 0;
        
        // Jika tanggal kembalinya melewati tenggat, hitung dendanya
        if ($tglKembaliAsli->greaterThan($tenggat)) {
            // PERBAIKAN: Gunakan fungsi abs() untuk memastikan selisih harinya selalu positif!
            $terlambat = abs($tglKembaliAsli->diffInDays($tenggat));
            $denda = $terlambat * 1000;
        }

        // Kembalikan stok buku +1
        $peminjaman->buku->increment('Stok');

        // Simpan status dan total denda ke Database
        $peminjaman->update([
            'StatusPeminjaman' => 'Dikembalikan',
            'Denda' => $denda
        ]);

        return redirect('/konfirmasi')->with('success', 'Buku dikembalikan. Denda tercatat: Rp ' . number_format($denda, 0, ',', '.'));
    }
}