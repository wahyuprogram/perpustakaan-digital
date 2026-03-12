<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Pengguna - Perpustakaan Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #F4F1EA; margin: 0; color: #4A3F35; }
        .navbar { background-color: #6B8E23; padding: 15px 30px; display: flex; justify-content: space-between; color: white; }
        .navbar a { color: white; text-decoration: none; font-weight: 600; }
        .container { padding: 40px 30px; max-width: 1100px; margin: auto; } /* Sedikit dilebarkan untuk kolom alamat */
        .card { background-color: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .btn-tambah { background-color: #8B5E3C; color: white; padding: 10px 15px; border-radius: 8px; text-decoration: none; display: inline-block; margin-bottom: 20px; font-weight: 600;}
        table { width: 100%; border-collapse: collapse; }
        th { background-color: #DCD7C9; padding: 12px; text-align: left; }
        td { padding: 12px; border-bottom: 1px solid #EFEFEF; }
        .badge { padding: 4px 10px; border-radius: 20px; font-size: 12px; color: white; text-transform: uppercase;}
        .bg-admin { background-color: #8B5E3C; }
        .bg-petugas { background-color: #6B8E23; }
        .bg-peminjam { background-color: #A3B18A; }
        .btn-hapus { background-color: #E8A09A; color: white; padding: 6px 12px; border: none; border-radius: 5px; cursor: pointer; font-family: 'Poppins'; }
        .alert-success { background-color: #A3B18A; color: white; padding: 10px; border-radius: 8px; margin-bottom: 20px; }
        .alert-error { background-color: #E8A09A; color: white; padding: 10px; border-radius: 8px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="{{ url('/dashboard') }}">⬅ Kembali ke Dashboard</a>
        <span>Kelola Pengguna</span>
    </div>
    <div class="container">
        <div class="card">
            <h2 style="margin-top: 0;">Daftar Pengguna Sistem</h2>
            
            @if(session('success')) <div class="alert-success">{{ session('success') }}</div> @endif
            @if(session('error')) <div class="alert-error">{{ session('error') }}</div> @endif
            
            <a href="{{ url('/users/create') }}" class="btn-tambah">+ Daftarkan Petugas / Admin Baru</a>
            
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th width="25%">Alamat</th> <th>Role / Hak Akses</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $key => $u)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $u->NamaLengkap }}</td>
                            <td>{{ $u->Username }}</td>
                            <td>{{ $u->Email }}</td>
                            <td><small>{{ $u->Alamat }}</small></td> <td>
                                @if($u->role == 'administrator')
                                    <span class="badge bg-admin">Admin</span>
                                @elseif($u->role == 'petugas')
                                    <span class="badge bg-petugas">Petugas</span>
                                @else
                                    <span class="badge bg-peminjam">Peminjam</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ url('/users/'.$u->UserID) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun ini?');" style="margin: 0;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-hapus">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>