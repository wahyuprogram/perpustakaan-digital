<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Koleksi Pribadi - Perpustakaan Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #F4F1EA; margin: 0; color: #4A3F35; }
        .navbar { background-color: #6B8E23; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; color: white; }
        .navbar a { color: white; text-decoration: none; font-weight: 600; }
        .container { padding: 40px 30px; max-width: 1000px; margin: auto; }
        .card { background-color: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        
        .btn-tambah { background-color: #8B5E3C; color: white; padding: 10px 15px; border-radius: 8px; text-decoration: none; display: inline-block; margin-bottom: 20px; transition: 0.3s; font-weight: 600;}
        .btn-tambah:hover { background-color: #6C472B; }
        
        /* Desain Tabel */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #DCD7C9; color: #4A3F35; padding: 12px; text-align: left; }
        td { padding: 12px; border-bottom: 1px solid #EFEFEF; }
        tr:hover { background-color: #FAFAFA; }
        
        /* Tombol Aksi */
        .aksi-flex { display: flex; gap: 5px; align-items: center; }
        .btn-detail { background-color: #6B8E23; color: white; padding: 6px 12px; border-radius: 5px; text-decoration: none; font-size: 14px; transition: 0.3s; font-family: 'Poppins'; }
        .btn-detail:hover { background-color: #55721c; }
        .btn-hapus { background-color: #E8A09A; color: white; padding: 6px 12px; border: none; border-radius: 5px; cursor: pointer; font-family: 'Poppins'; font-size: 14px; transition: 0.3s;}
        .btn-hapus:hover { background-color: #D68A84; }
        
        .alert-success { background-color: #A3B18A; color: white; padding: 10px; border-radius: 8px; margin-bottom: 20px; }
        .alert-error { background-color: #E8A09A; color: white; padding: 10px; border-radius: 8px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="{{ url('/dashboard') }}">⬅ Kembali ke Dashboard</a>
        <span>Rak Koleksi Pribadi</span>
    </div>
    <div class="container">
        <div class="card">
            <h2 style="margin-top: 0; color: #8B5E3C;">Buku Favorit Saya ⭐</h2>
            
            @if(session('success')) <div class="alert-success">{{ session('success') }}</div> @endif
            @if(session('error')) <div class="alert-error">{{ session('error') }}</div> @endif
            
            <a href="{{ url('/katalog') }}" class="btn-tambah">🔍 Cari Buku di Katalog</a>
            
            <table>
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="35%">Judul Buku</th>
                        <th width="20%">Penulis</th>
                        <th width="15%">Tahun Terbit</th>
                        <th width="25%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($koleksi as $key => $k)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td><strong>{{ $k->buku->Judul }}</strong></td>
                            <td>{{ $k->buku->Penulis }}</td>
                            <td>{{ $k->buku->TahunTerbit }}</td>
                            <td>
                                <div class="aksi-flex">
                                    <a href="{{ url('/katalog/'.$k->buku->BukuID) }}" class="btn-detail">Lihat Detail</a>
                                    
                                    <form action="{{ url('/koleksi/'.$k->KoleksiID) }}" method="POST" onsubmit="return confirm('Keluarkan buku ini dari koleksi?');" style="margin: 0;">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="btn-hapus">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: #888; padding: 20px;">Belum ada buku di koleksi Anda.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>