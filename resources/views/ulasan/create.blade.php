<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tulis Ulasan - Perpustakaan Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #F4F1EA; margin: 0; color: #4A3F35; }
        .navbar { background-color: #6B8E23; padding: 15px 30px; display: flex; justify-content: space-between; color: white; }
        .navbar a { color: white; text-decoration: none; font-weight: 600; }
        .container { padding: 40px 30px; max-width: 600px; margin: auto; }
        .card { background-color: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; }
        .form-group select, .form-group textarea { width: 100%; padding: 12px; border: 1px solid #DCD7C9; border-radius: 8px; box-sizing: border-box; font-family: 'Poppins'; font-size: 14px;}
        .btn-simpan { width: 100%; padding: 12px; background-color: #8B5E3C; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 16px;}
        .alert-error { background-color: #E8A09A; color: white; padding: 10px; border-radius: 8px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="{{ url('/ulasan') }}">⬅ Kembali</a>
        <span>Tulis Ulasan</span>
    </div>
    <div class="container">
        <div class="card">
            <h2 style="margin-top: 0; color: #6B8E23;">Berikan Ulasan & Rating</h2>
            
            @if ($errors->any())
                <div class="alert-error">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ url('/ulasan') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Pilih Buku</label>
                    <select name="BukuID" required>
                        <option value="">-- Buku yang ingin diulas --</option>
                        @foreach($buku as $b)
                            <option value="{{ $b->BukuID }}">{{ $b->Judul }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Rating Bintang</label>
                    <select name="Rating" required>
                        <option value="5">⭐⭐⭐⭐⭐ (5/5) - Sangat Bagus</option>
                        <option value="4">⭐⭐⭐⭐ (4/5) - Bagus</option>
                        <option value="3">⭐⭐⭐ (3/5) - Lumayan</option>
                        <option value="2">⭐⭐ (2/5) - Kurang</option>
                        <option value="1">⭐ (1/5) - Sangat Kurang</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Tulis Ulasan Anda</label>
                    <textarea name="Ulasan" rows="4" required placeholder="Ceritakan pendapat Anda tentang buku ini..."></textarea>
                </div>
                
                <button type="submit" class="btn-simpan">Kirim Ulasan</button>
            </form>
        </div>
    </div>
</body>
</html>