<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Kategori - Perpustakaan Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #F4F1EA; margin: 0; color: #4A3F35; }
        .navbar { background-color: #6B8E23; padding: 15px 30px; display: flex; justify-content: space-between; color: white; }
        .navbar a { color: white; text-decoration: none; font-weight: 600; }
        .container { padding: 40px 30px; max-width: 500px; margin: auto; }
        .card { background-color: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; }
        .form-group input { width: 100%; padding: 12px; border: 1px solid #DCD7C9; border-radius: 8px; box-sizing: border-box; font-family: 'Poppins'; }
        .btn-simpan { width: 100%; padding: 12px; background-color: #A3B18A; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="{{ url('/kategori') }}">⬅ Kembali</a>
        <span>Edit Kategori</span>
    </div>
    <div class="container">
        <div class="card">
            <h2 style="margin-top: 0; color: #6B8E23;">Edit Kategori</h2>
            <form action="{{ url('/kategori/'.$kategori->KategoriID) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Nama Kategori</label>
                    <input type="text" name="NamaKategori" value="{{ $kategori->NamaKategori }}" required>
                </div>
                <button type="submit" class="btn-simpan">Update Kategori</button>
            </form>
        </div>
    </div>
</body>
</html>