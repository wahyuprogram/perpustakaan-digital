<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Koleksi Pribadi - Perpustakaan Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #F4F1EA; margin: 0; color: #4A3F35; }
        .navbar { background-color: #6B8E23; padding: 15px 30px; display: flex; justify-content: space-between; color: white; }
        .navbar a { color: white; text-decoration: none; font-weight: 600; }
        .container { padding: 40px 30px; max-width: 900px; margin: auto; }
        .card { background-color: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .btn-tambah { background-color: #8B5E3C; color: white; padding: 10px 15px; border-radius: 8px; text-decoration: none; display: inline-block; margin-bottom: 20px; }
        
        /* Grid Koleksi Buku */
        .grid-buku { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; }
        .buku-card { border: 1px solid #DCD7C9; border-radius: 10px; padding: 15px; text-align: center; background-color: #FAFAFA; transition: 0.3s;}
        .buku-card:hover { transform: translateY(-5px); border-color: #8B5E3C; }
        .buku-card h3 { font-size: 16px; margin: 0 0 5px 0; color: #6B8E23; }
        .buku-card p { font-size: 13px; color: #777; margin: 0 0 15px 0; }
        
        .btn-hapus { background-color: #E8A09A; color: white; padding: 5px 10px; border: none; border-radius: 5px; cursor: pointer; font-family: 'Poppins'; font-size: 12px; width: 100%;}
        
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
            <h2 style="margin-top: 0;">Buku Favorit Saya ⭐</h2>
            
            @if(session('success')) <div class="alert-success">{{ session('success') }}</div> @endif
            @if(session('error')) <div class="alert-error">{{ session('error') }}</div> @endif
            
            <a href="{{ url('/katalog') }}" class="btn-tambah">🔍 Cari Buku di Katalog</a>
            
            @if(count($koleksi) > 0)
                <div class="grid-buku">
                    @foreach($koleksi as $k)
                        <div class="buku-card">
                            <h3>{{ $k->buku->Judul }}</h3>
                            <p>{{ $k->buku->Penulis }} <br> ({{ $k->buku->TahunTerbit }})</p>
                            
                            <form action="{{ url('/koleksi/'.$k->KoleksiID) }}" method="POST" onsubmit="return confirm('Keluarkan buku ini dari koleksi?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-hapus">Hapus dari Koleksi</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @else
                <p style="text-align: center; color: #888; margin-top: 40px;">Belum ada buku di koleksi Anda.</p>
            @endif
        </div>
    </div>
</body>
</html>