<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Buku - Perpustakaan Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #F4F1EA; margin: 0; color: #4A3F35; }
        .navbar { background-color: #6B8E23; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; color: white; }
        .navbar a { color: white; text-decoration: none; font-weight: 600; }
        .container { padding: 40px 30px; max-width: 1000px; margin: auto; }
        
        /* Menggunakan desain Card putih sebagai alas tabel */
        .card { background-color: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        
        /* Desain Tabel */
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #DCD7C9; color: #4A3F35; padding: 12px; text-align: left; }
        td { padding: 12px; border-bottom: 1px solid #EFEFEF; }
        tr:hover { background-color: #FAFAFA; }
        
        .badge { background-color: #DCD7C9; color: #4A3F35; padding: 4px 8px; border-radius: 10px; font-size: 11px; margin: 2px; display: inline-block; font-weight: 600;}
        .btn-detail { background-color: #8B5E3C; color: white; padding: 6px 15px; border-radius: 5px; text-decoration: none; font-size: 14px; font-weight: 600; transition: 0.3s; display: inline-block; }
        .btn-detail:hover { background-color: #6C472B; }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="{{ url('/dashboard') }}">⬅ Kembali ke Dashboard</a>
        <span>Daftar Buku Perpustakaan</span>
    </div>
    <div class="container">
        <div class="card">
            <h2 style="margin-top: 0; color: #8B5E3C; text-align: center;">Jelajahi Koleksi Buku Kami 📚</h2>
            <p style="text-align: center; color: #777; font-size: 14px; margin-bottom: 30px;">Temukan buku favoritmu, lalu klik "Lihat Detail" untuk meminjam atau membaca ulasan.</p>
            
            <table>
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="30%">Judul Buku</th>
                        <th width="20%">Penulis</th>
                        <th width="15%">Tahun Terbit</th>
                        <th width="20%">Kategori</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($buku as $key => $b)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td><strong>{{ $b->Judul }}</strong><br><small style="color: #888;">Penerbit: {{ $b->Penerbit }}</small></td>
                            <td>{{ $b->Penulis }}</td>
                            <td>{{ $b->TahunTerbit }}</td>
                            <td>
                                @forelse($b->kategori as $kat)
                                    <span class="badge">{{ $kat->NamaKategori }}</span>
                                @empty
                                    <span style="color: #999; font-size: 12px;">Tanpa Kategori</span>
                                @endforelse
                            </td>
                            <td>
                                <a href="{{ url('/katalog/'.$b->BukuID) }}" class="btn-detail">Lihat Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; color: #888; padding: 20px;">Belum ada buku di perpustakaan ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>