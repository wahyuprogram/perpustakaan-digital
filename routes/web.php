<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;

// Jika buka web pertama kali, arahkan ke login
Route::get('/', function () {
    return redirect('/login');
});

// Route untuk Guest (Belum Login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'postLogin']);
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'postRegister']);
});

// Route untuk yang sudah Login
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', function () {
        return view('dashboard'); 
    })->name('dashboard');

    // =======================================================
    // RUANGAN KHUSUS ADMINISTRATOR SAJA
    // =======================================================
    Route::middleware('role:administrator')->group(function () {
        
        // Rute Kelola Pengguna
        Route::get('/users', [App\Http\Controllers\UserController::class, 'index']);
        Route::get('/users/create', [App\Http\Controllers\UserController::class, 'create']);
        Route::post('/users', [App\Http\Controllers\UserController::class, 'store']);
        Route::delete('/users/{id}', [App\Http\Controllers\UserController::class, 'destroy']);
        
    });

    // =======================================================
    // RUANGAN KHUSUS ADMINISTRATOR & PETUGAS
    // =======================================================
    Route::middleware('role:administrator,petugas')->group(function () {
        
        // Rute untuk CRUD Buku
        Route::get('/buku', [App\Http\Controllers\BukuController::class, 'index']);
        Route::get('/buku/create', [App\Http\Controllers\BukuController::class, 'create']);
        Route::post('/buku', [App\Http\Controllers\BukuController::class, 'store']);
        Route::get('/buku/{id}/edit', [App\Http\Controllers\BukuController::class, 'edit']);
        Route::put('/buku/{id}', [App\Http\Controllers\BukuController::class, 'update']);
        Route::delete('/buku/{id}', [App\Http\Controllers\BukuController::class, 'destroy']);

        // Rute Kategori Buku (Gantikan yang lama dengan ini)
        Route::get('/kategori', [App\Http\Controllers\KategoriController::class, 'index']);
        Route::get('/kategori/create', [App\Http\Controllers\KategoriController::class, 'create']);
        Route::post('/kategori', [App\Http\Controllers\KategoriController::class, 'store']);
        Route::get('/kategori/{id}/edit', [App\Http\Controllers\KategoriController::class, 'edit']);
        Route::put('/kategori/{id}', [App\Http\Controllers\KategoriController::class, 'update']);
        Route::delete('/kategori/{id}', [App\Http\Controllers\KategoriController::class, 'destroy']);

        // Rute Laporan (Gantikan yang lama dengan dua baris ini)
        Route::get('/laporan', [App\Http\Controllers\LaporanController::class, 'index']);
        Route::get('/laporan/cetak', [App\Http\Controllers\LaporanController::class, 'cetak']);

        // RUTE KONFIRMASI PEMINJAMAN
        Route::get('/konfirmasi', [App\Http\Controllers\KonfirmasiController::class, 'index']);
        Route::get('/konfirmasi/{id}', [App\Http\Controllers\KonfirmasiController::class, 'show']); // <--- TAMBAHKAN INI
        Route::post('/konfirmasi/{id}/setujui', [App\Http\Controllers\KonfirmasiController::class, 'setujui']);
        Route::post('/konfirmasi/{id}/tolak', [App\Http\Controllers\KonfirmasiController::class, 'tolak']);
        Route::post('/konfirmasi/{id}/kembalikan', [App\Http\Controllers\KonfirmasiController::class, 'kembalikan']);
        
        // RUTE KELOLA ULASAN (UNTUK ADMIN/PETUGAS)
        Route::get('/admin/ulasan', [App\Http\Controllers\UlasanController::class, 'adminIndex']);
        Route::post('/admin/ulasan/{id}/balas', [App\Http\Controllers\UlasanController::class, 'balas']);
    });

    // =======================================================
    // RUANGAN KHUSUS PEMINJAM
    // =======================================================
    Route::middleware('role:peminjam')->group(function () {
        
        // Rute Katalog Baru (Pengganti form pinjam yang kaku)
        Route::get('/katalog', [App\Http\Controllers\KatalogController::class, 'index']);
        Route::get('/katalog/{id}', [App\Http\Controllers\KatalogController::class, 'show']);

        // Rute Peminjaman
        Route::get('/peminjaman', [App\Http\Controllers\PeminjamanController::class, 'index']);
        Route::post('/peminjaman', [App\Http\Controllers\PeminjamanController::class, 'store']);
        Route::delete('/peminjaman/{id}/batal', [App\Http\Controllers\PeminjamanController::class, 'batal']); // <-- TAMBAHKAN BARIS INI

        // Rute Koleksi Pribadi
        Route::get('/koleksi', [App\Http\Controllers\KoleksiController::class, 'index']);
        Route::post('/koleksi', [App\Http\Controllers\KoleksiController::class, 'store']);
        Route::delete('/koleksi/{id}', [App\Http\Controllers\KoleksiController::class, 'destroy']);

        // Rute Ulasan Buku
        Route::get('/ulasan', [App\Http\Controllers\UlasanController::class, 'index']);
        Route::post('/ulasan', [App\Http\Controllers\UlasanController::class, 'store']);
    });
});