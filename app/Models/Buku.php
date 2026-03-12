<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';
    protected $primaryKey = 'BukuID'; 

    protected $fillable = [
        'Judul',
        'Penulis',
        'Penerbit',
        'TahunTerbit',
        'Stok',
    ];

    // Fungsi Relasi Many-to-Many ke Kategori
    public function kategori()
    {
        return $this->belongsToMany(KategoriBuku::class, 'kategoribuku_relasi', 'BukuID', 'KategoriID');
    }

    // TAMBAHAN BARU: Relasi One-to-Many ke Ulasan Buku
    public function ulasan()
    {
        return $this->hasMany(UlasanBuku::class, 'BukuID', 'BukuID');
    }
}