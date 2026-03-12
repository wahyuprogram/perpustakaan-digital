<?php

namespace App\Http\Controllers;

use App\Models\KategoriBuku;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = KategoriBuku::all();
        return view('kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'NamaKategori' => 'required'
        ]);

        KategoriBuku::create($request->all());
        return redirect('/kategori')->with('success', 'Kategori Buku berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kategori = KategoriBuku::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'NamaKategori' => 'required'
        ]);

        $kategori = KategoriBuku::findOrFail($id);
        $kategori->update($request->all());
        return redirect('/kategori')->with('success', 'Kategori Buku berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kategori = KategoriBuku::findOrFail($id);
        $kategori->delete();
        return redirect('/kategori')->with('success', 'Kategori Buku berhasil dihapus!');
    }
}