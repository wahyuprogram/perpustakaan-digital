<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Buku</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #F4F1EA; margin: 0; color: #4A3F35; }
        .navbar { background-color: #6B8E23; padding: 15px 30px; display: flex; justify-content: space-between; color: white; }
        .navbar a { color: white; text-decoration: none; font-weight: 600; }
        .container { padding: 40px 30px; max-width: 600px; margin: auto; }
        .card { background-color: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; }
        .form-group input[type="text"], .form-group input[type="number"] { width: 100%; padding: 12px; border: 1px solid #DCD7C9; border-radius: 8px; box-sizing: border-box; font-family: 'Poppins'; }
        .btn-simpan { width: 100%; padding: 12px; background-color: #8B5E3C; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; }
        .checkbox-group { display: flex; flex-wrap: wrap; gap: 15px; background: #FAFAFA; padding: 15px; border-radius: 8px; border: 1px solid #DCD7C9; }
        .checkbox-group label { display: flex; align-items: center; font-weight: 400; margin: 0; cursor: pointer; }
        .checkbox-group input { width: auto; margin-right: 8px; }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="{{ url('/buku') }}">⬅ Kembali</a>
        <span>Tambah Buku</span>
    </div>
    <div class="container">
        <div class="card">
            <h2 style="margin-top: 0; color: #6B8E23;">Tambah Buku Baru</h2>
            <form action="{{ url('/buku') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Judul Buku</label>
                    <input type="text" name="Judul" required>
                </div>
                <div class="form-group">
                    <label>Penulis</label>
                    <input type="text" name="Penulis" required>
                </div>
                <div class="form-group">
                    <label>Penerbit</label>
                    <input type="text" name="Penerbit" required>
                </div>
                <div class="form-group">
                    <label>Tahun Terbit</label>
                    <input type="number" name="TahunTerbit" required min="1000" max="2099">
                </div>
                
                <div class="form-group">
                    <label>Pilih Kategori (Bisa lebih dari satu)</label>
                    <div class="checkbox-group">
                        @foreach($kategori as $k)
                            <label>
                                <input type="checkbox" name="kategori[]" value="{{ $k->KategoriID }}"> {{ $k->NamaKategori }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <button type="submit" class="btn-simpan">Simpan Data Buku</button>
            </form>
        </div>
    </div>
</body>
</html>