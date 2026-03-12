@php
    // Memaksa browser untuk tidak menyimpan cache halaman ini
    header("Cache-Control: no-cache, no-store, must-revalidate");
    header("Pragma: no-cache");
    header("Expires: 0");
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Perpustakaan Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        /* TEMA EARTH TONE */
        body { font-family: 'Poppins', sans-serif; background-color: #F4F1EA; margin: 0; color: #4A3F35; }
        .navbar { background-color: #6B8E23; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; color: white; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .navbar h1 { margin: 0; font-size: 20px; }
        .nav-links { display: flex; align-items: center; gap: 20px; }
        .btn-logout { background-color: #E8A09A; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; font-family: 'Poppins', sans-serif; font-weight: 600; transition: 0.3s; }
        .btn-logout:hover { background-color: #D68A84; }
        .container { padding: 40px 30px; max-width: 1000px; margin: auto; }
        .header-section { background-color: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 30px; }
        .badge { background-color: #8B5E3C; color: white; padding: 5px 12px; border-radius: 20px; font-size: 14px; text-transform: uppercase; font-weight: 600; }
        
        /* GRID UNTUK MENU */
        .menu-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
        .menu-card { background-color: white; padding: 25px; border-radius: 12px; text-align: center; text-decoration: none; color: #4A3F35; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border: 2px solid transparent; transition: 0.3s; display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 120px; }
        .menu-card:hover { border-color: #8B5E3C; transform: translateY(-5px); }
        .menu-card h3 { margin: 0 0 10px 0; color: #6B8E23; }
        .menu-card p { margin: 0; font-size: 14px; color: #777; }
    </style>
</head>
<body>

    <div class="navbar">
        <h1>Perpus Digital</h1>
        <div class="nav-links">
            <span>Halo, {{ Auth::user()->NamaLengkap }}!</span>
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>
    </div>

    <div class="container">
        <div class="header-section">
            <h2 style="margin-top: 0;">Selamat Datang di Dashboard</h2>
            <p>Anda login sebagai: <span class="badge">{{ Auth::user()->role }}</span></p>
            <p style="margin-bottom: 0;">Silakan pilih menu di bawah ini sesuai dengan hak akses Anda.</p>
        </div>

        <div class="menu-grid">

            @if(Auth::user()->role == 'administrator')
                <a href="{{ url('/users') }}" class="menu-card">
                    <h3>👥 Kelola Pengguna</h3>
                    <p>Daftarkan Petugas atau Admin baru</p>
                </a>
            @endif

            @if(Auth::user()->role == 'administrator' || Auth::user()->role == 'petugas')
                <a href="{{ url('/buku') }}" class="menu-card">
                    <h3>📚 Pendataan Buku</h3>
                    <p>Tambah, edit, dan hapus data buku</p>
                </a>
                <a href="{{ url('/kategori') }}" class="menu-card">
                    <h3>🏷️ Kategori Buku</h3>
                    <p>Kelola daftar kategori buku</p>
                </a>
                
                <a href="{{ url('/konfirmasi') }}" class="menu-card">
                    <h3>✅ Konfirmasi Peminjaman</h3>
                    <p>Setujui antrean dan pengembalian buku</p>
                </a>
                <a href="{{ url('/admin/ulasan') }}" class="menu-card">
                    <h3>💬 Kelola Ulasan</h3>
                    <p>Pantau dan balas ulasan pembaca</p>
                </a>
                <a href="{{ url('/laporan') }}" class="menu-card">
                    <h3>📊 Generate Laporan</h3>
                    <p>Cetak laporan peminjaman buku</p>
                </a>
            @endif

            @if(Auth::user()->role == 'peminjam')
                <a href="{{ url('/katalog') }}" class="menu-card"> <h3>📖 Lihat Buku</h3>
                    <p>Cari, pinjam, dan ulas buku di sini</p>
                </a>
                <a href="{{ url('/koleksi') }}" class="menu-card">
                    <h3>⭐ Koleksi Pribadi</h3>
                    <p>Lihat buku yang Anda simpan</p>
                </a>
                <a href="{{ url('/peminjaman') }}" class="menu-card"> <h3>📋 Status Pinjaman</h3>
                    <p>Pantau status konfirmasi buku Anda</p>
                </a>
            @endif

        </div>
    </div>

</body>
</html>