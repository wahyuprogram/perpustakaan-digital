<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UlasanBuku extends Model
{
    use HasFactory;

    protected $table = 'ulasanbuku';
    protected $primaryKey = 'UlasanID'; 

    protected $fillable = [
        'UserID',
        'BukuID',
        'Ulasan',
        'Rating',
        'Balasan',
    ];

    // Relasi ke tabel User (Siapa yang mengulas)
    public function user()
    {
        return $this->belongsTo(User::class, 'UserID', 'UserID');
    }

    // Relasi ke tabel Buku (Buku apa yang diulas)
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'BukuID', 'BukuID');
    }
}