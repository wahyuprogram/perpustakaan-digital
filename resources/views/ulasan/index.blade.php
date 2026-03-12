<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ulasan Saya - Perpustakaan Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #F4F1EA; margin: 0; color: #4A3F35; }
        .navbar { background-color: #6B8E23; padding: 15px 30px; display: flex; justify-content: space-between; color: white; }
        .navbar a { color: white; text-decoration: none; font-weight: 600; }
        .container { padding: 40px 30px; max-width: 900px; margin: auto; }
        .card { background-color: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .btn-tambah { background-color: #8B5E3C; color: white; padding: 10px 15px; border-radius: 8px; text-decoration: none; display: inline-block; margin-bottom: 20px; font-weight: 600;}
        
        /* Desain Kotak Ulasan */
        .ulasan-list { display: flex; flex-direction: column; gap: 15px; }
        .ulasan-card { border: 1px solid #DCD7C9; border-radius: 8px; padding: 20px; background-color: #FAFAFA; }
        .ulasan-card h4 { margin: 0 0 5px 0; color: #6B8E23; font-size: 18px; }
        .bintang { color: #FFD700; font-size: 18px; margin-bottom: 10px; }
        .teks-ulasan { font-style: italic; color: #555; margin: 0; }
        
        .alert-success { background-color: #A3B18A; color: white; padding: 10px; border-radius: 8px; margin-bottom: 20px; }
        .alert-error { background-color: #E8A09A; color: white; padding: 10px; border-radius: 8px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="{{ url('/dashboard') }}">⬅ Kembali ke Dashboard</a>
        <span>Ulasan Buku</span>
    </div>
    <div class="container">
        <div class="card">
            <h2 style="margin-top: 0;">Riwayat Ulasan Saya 📝</h2>
            
            @if(session('success')) <div class="alert-success">{{ session('success') }}</div> @endif
            @if(session('error')) <div class="alert-error">{{ session('error') }}</div> @endif
            
            <a href="{{ url('/ulasan/create') }}" class="btn-tambah">+ Tulis Ulasan Baru</a>
            
            <div class="ulasan-list">
                @forelse($ulasan as $u)
                    <div class="ulasan-card">
                        <h4>{{ $u->buku->Judul }}</h4>
                        <div class="bintang">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $u->Rating) ★ @else ☆ @endif
                            @endfor
                            <span style="color: #888; font-size: 14px; margin-left: 5px;">({{ $u->Rating }}/5)</span>
                        </div>
                        <p class="teks-ulasan">"{{ $u->Ulasan }}"</p>
                    </div>
                @empty
                    <p style="text-align: center; color: #888; padding: 20px;">Anda belum memberikan ulasan untuk buku apapun.</p>
                @endforelse
            </div>
        </div>
    </div>
</body>
</html>