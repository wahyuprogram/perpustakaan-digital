<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Koleksi - Perpustakaan Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #F4F1EA; margin: 0; color: #4A3F35; }
        .navbar { background-color: #6B8E23; padding: 15px 30px; display: flex; justify-content: space-between; color: white; }
        .navbar a { color: white; text-decoration: none; font-weight: 600; }
        .container { padding: 40px 30px; max-width: 500px; margin: auto; }
        .card { background-color: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; }
        .form-group select { width: 100%; padding: 12px; border: 1px solid #DCD7C9; border-radius: 8px; font-family: 'Poppins'; font-size: 14px;}
        .btn-simpan { width: 100%; padding: 12px; background-color: #8B5E3C; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 16px;}
    </style>
</head>
<body>
    <div class="navbar">
        <a href="{{ url('/koleksi') }}">⬅ Kembali</a>
        <span>Tambah Koleksi</span>
    </div>
    <div class="container">
        <div class="card">
            <h2 style="margin-top: 0; color: #6B8E23;">Pilih Buku Favorit</h2>
            
            <form action="{{ url('/koleksi') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Judul Buku</label>
                    <select name="BukuID" required>
                        <option value="">-- Pilih Buku --</option>
                        @foreach($buku as $b)
                            <option value="{{ $b->BukuID }}">{{ $b->Judul }} ({{ $b->Penulis }})</option>
                        @endforeach
                    </select>
                </div>
                
                <button type="submit" class="btn-simpan">Simpan ke Koleksi</button>
            </form>
        </div>
    </div>
</body>
</html>