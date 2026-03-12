<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Ulasan - Perpustakaan Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #F4F1EA; margin: 0; color: #4A3F35; }
        .navbar { background-color: #6B8E23; padding: 15px 30px; display: flex; justify-content: space-between; color: white; }
        .navbar a { color: white; text-decoration: none; font-weight: 600; }
        .container { padding: 40px 30px; max-width: 1000px; margin: auto; }
        .card { background-color: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 20px;}
        
        .ulasan-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; border-bottom: 1px solid #EFEFEF; padding-bottom: 10px;}
        .ulasan-header h4 { margin: 0; color: #6B8E23; }
        .bintang { color: #FFD700; font-size: 16px; }
        
        .balasan-box { background-color: #F4F1EA; padding: 15px; border-radius: 8px; margin-top: 15px; border-left: 4px solid #8B5E3C; }
        
        textarea { width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #DCD7C9; font-family: 'Poppins'; box-sizing: border-box; margin-top: 10px;}
        .btn-balas { background-color: #8B5E3C; color: white; padding: 8px 15px; border: none; border-radius: 5px; cursor: pointer; font-family: 'Poppins'; font-weight: 600; margin-top: 10px;}
        
        .alert-success { background-color: #A3B18A; color: white; padding: 10px; border-radius: 8px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="{{ url('/dashboard') }}">⬅ Kembali ke Dashboard</a>
        <span>Kelola Ulasan Pembaca</span>
    </div>
    <div class="container">
        <h2 style="color: #8B5E3C;">Daftar Ulasan Masuk</h2>
        
        @if(session('success')) <div class="alert-success">{{ session('success') }}</div> @endif

        @forelse($ulasan as $u)
            <div class="card">
                <div class="ulasan-header">
                    <div>
                        <h4>{{ $u->buku->Judul }}</h4>
                        <small style="color: #777;">Diulas oleh: <strong>{{ $u->user->NamaLengkap }}</strong> pada {{ $u->created_at->format('d M Y') }}</small>
                    </div>
                    <div class="bintang">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $u->Rating) ★ @else ☆ @endif
                        @endfor
                    </div>
                </div>
                
                <p style="font-style: italic;">"{{ $u->Ulasan }}"</p>

                @if($u->Balasan)
                    <div class="balasan-box">
                        <strong style="color: #8B5E3C;">Balasan Petugas:</strong>
                        <p style="margin: 5px 0 0 0;">{{ $u->Balasan }}</p>
                    </div>
                @else
                    <form action="{{ url('/admin/ulasan/'.$u->UlasanID.'/balas') }}" method="POST">
                        @csrf
                        <textarea name="Balasan" rows="2" placeholder="Tulis balasan untuk ulasan ini..." required></textarea>
                        <button type="submit" class="btn-balas">Kirim Balasan</button>
                    </form>
                @endif
            </div>
        @empty
            <div class="card" style="text-align: center; color: #888;">Belum ada ulasan dari pembaca.</div>
        @endforelse
    </div>
</body>
</html>