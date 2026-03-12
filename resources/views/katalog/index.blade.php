<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Katalog Buku - Perpustakaan Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #F4F1EA; margin: 0; color: #4A3F35; }
        .navbar { background-color: #6B8E23; padding: 15px 30px; display: flex; justify-content: space-between; color: white; }
        .navbar a { color: white; text-decoration: none; font-weight: 600; }
        .container { padding: 40px 30px; max-width: 1000px; margin: auto; }
        
        .grid-katalog { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 25px; }
        .buku-card { background-color: white; border-radius: 12px; padding: 20px; text-align: center; box-shadow: 0 4px 10px rgba(0,0,0,0.05); text-decoration: none; color: inherit; transition: 0.3s; display: block; border: 2px solid transparent;}
        .buku-card:hover { transform: translateY(-5px); border-color: #8B5E3C; }
        .buku-card h3 { color: #6B8E23; margin: 10px 0 5px 0; font-size: 18px; }
        .badge { background-color: #DCD7C9; color: #4A3F35; padding: 3px 8px; border-radius: 10px; font-size: 11px; margin: 2px; display: inline-block; }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="{{ url('/dashboard') }}">⬅ Kembali ke Dashboard</a>
        <span>Katalog Perpustakaan</span>
    </div>
    <div class="container">
        <h2 style="text-align: center; color: #8B5E3C; margin-bottom: 30px;">Jelajahi Koleksi Buku Kami 📚</h2>
        
        <div class="grid-katalog">
            @foreach($buku as $b)
                <a href="{{ url('/katalog/'.$b->BukuID) }}" class="buku-card">
                    <h3>{{ $b->Judul }}</h3>
                    <p style="font-size: 14px; color: #777; margin-bottom: 10px;">{{ $b->Penulis }}</p>
                    <div>
                        @foreach($b->kategori as $kat)
                            <span class="badge">{{ $kat->NamaKategori }}</span>
                        @endforeach
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</body>
</html>