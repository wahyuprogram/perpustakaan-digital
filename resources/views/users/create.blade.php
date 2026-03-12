<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Pengguna - Perpustakaan Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #F4F1EA; margin: 0; color: #4A3F35; }
        .navbar { background-color: #6B8E23; padding: 15px 30px; display: flex; justify-content: space-between; color: white; }
        .navbar a { color: white; text-decoration: none; font-weight: 600; }
        .container { padding: 40px 30px; max-width: 600px; margin: auto; }
        .card { background-color: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 12px; border: 1px solid #DCD7C9; border-radius: 8px; box-sizing: border-box; font-family: 'Poppins'; }
        .btn-simpan { width: 100%; padding: 12px; background-color: #8B5E3C; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 16px;}
        .alert-error { background-color: #E8A09A; color: white; padding: 10px; border-radius: 8px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="{{ url('/users') }}">⬅ Kembali</a>
        <span>Tambah Pengguna</span>
    </div>
    <div class="container">
        <div class="card">
            <h2 style="margin-top: 0; color: #6B8E23;">Daftarkan Pengguna Baru</h2>
            
            @if ($errors->any())
                <div class="alert-error">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ url('/users') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="NamaLengkap" value="{{ old('NamaLengkap') }}" required>
                </div>
                
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="Username" value="{{ old('Username') }}" required>
                </div>
                
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="Email" value="{{ old('Email') }}" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="Password" required placeholder="Minimal 6 karakter">
                </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="Alamat" rows="3" required>{{ old('Alamat') }}</textarea>
                </div>

                <div class="form-group">
                    <label>Pilih Role / Hak Akses</label>
                    <select name="role" required>
                        <option value="">-- Pilih Hak Akses --</option>
                        <option value="petugas">Petugas (Bisa kelola buku & laporan)</option>
                        <option value="administrator">Administrator (Bisa semua fitur)</option>
                        <option value="peminjam">Peminjam (Hanya bisa pinjam buku)</option>
                    </select>
                </div>
                
                <button type="submit" class="btn-simpan">Simpan Pengguna</button>
            </form>
        </div>
    </div>
</body>
</html>