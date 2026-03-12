<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Mulai query dasar
        $query = Peminjaman::with(['user', 'buku'])->orderBy('created_at', 'desc');

        // Tangkap request filter tanggal
        $tgl_mulai = $request->tgl_mulai;
        $tgl_selesai = $request->tgl_selesai;

        // Jika filter tanggal diisi
        if ($tgl_mulai && $tgl_selesai) {
            $query->whereDate('created_at', '>=', $tgl_mulai)
                  ->whereDate('created_at', '<=', $tgl_selesai);
        }

        // Hitung Data Rekapan (menggunakan clone agar tidak terpengaruh limit pagination)
        $totalTransaksi = (clone $query)->count();
        $totalSelesai = (clone $query)->where('StatusPeminjaman', 'Dikembalikan')->count();
        $totalDenda = (clone $query)->sum('Denda');

        // Ambil data dengan paginasi 10 per halaman & tetap bawa filter di URL
        $peminjaman = $query->paginate(10)->withQueryString();

        return view('laporan.index', compact(
            'peminjaman', 'tgl_mulai', 'tgl_selesai', 
            'totalTransaksi', 'totalSelesai', 'totalDenda'
        ));
    }

    public function cetak(Request $request)
    {
        $query = Peminjaman::with(['user', 'buku'])->orderBy('created_at', 'desc');

        $tgl_mulai = $request->tgl_mulai;
        $tgl_selesai = $request->tgl_selesai;

        if ($tgl_mulai && $tgl_selesai) {
            $query->whereDate('created_at', '>=', $tgl_mulai)
                  ->whereDate('created_at', '<=', $tgl_selesai);
        }

        // Untuk cetak kita ambil semua (get) tanpa paginasi agar semua data muncul di kertas
        $peminjaman = $query->get();
        $totalDenda = $peminjaman->sum('Denda');

        return view('laporan.cetak', compact('peminjaman', 'tgl_mulai', 'tgl_selesai', 'totalDenda'));
    }
}