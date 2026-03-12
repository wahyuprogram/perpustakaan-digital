<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\KategoriBuku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        // Mengambil semua buku sekaligus menarik data kategorinya
        $buku = Buku::with('kategori')->get(); 
        return view('buku.index', compact('buku'));
    }

    public function create()
    {
        // Mengirim daftar kategori ke halaman form tambah buku
        $kategori = KategoriBuku::all();
        return view('buku.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Judul' => 'required',
            'Penulis' => 'required',
            'Penerbit' => 'required',
            'TahunTerbit' => 'required|numeric',
        ]);

        // Simpan data buku
        $buku = Buku::create($request->all());

        // Jika ada kategori yang dicentang, simpan relasinya
        if($request->has('kategori')) {
            $buku->kategori()->attach($request->kategori);
        }

        return redirect('/buku')->with('success', 'Data buku beserta kategori berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $buku = Buku::with('kategori')->findOrFail($id);
        $kategori = KategoriBuku::all();
        return view('buku.edit', compact('buku', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'Judul' => 'required',
            'Penulis' => 'required',
            'Penerbit' => 'required',
            'TahunTerbit' => 'required|numeric',
        ]);

        $buku = Buku::findOrFail($id);
        $buku->update($request->all());

        // Sinkronisasi kategori (Update relasinya)
        if($request->has('kategori')) {
            $buku->kategori()->sync($request->kategori);
        } else {
            // Jika centang dihapus semua, lepaskan semua relasi kategori
            $buku->kategori()->detach(); 
        }

        return redirect('/buku')->with('success', 'Data buku berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        // Kita tidak perlu menghapus relasinya manual karena di database migration sudah pakai onDelete('cascade')
        $buku->delete(); 
        return redirect('/buku')->with('success', 'Data buku berhasil dihapus!');
    }
}