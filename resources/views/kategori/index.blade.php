<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kategori Buku - Perpustakaan Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #F4F1EA; margin: 0; color: #4A3F35; }
        .navbar { background-color: #6B8E23; padding: 15px 30px; display: flex; justify-content: space-between; color: white; }
        .navbar a { color: white; text-decoration: none; font-weight: 600; }
        .container { padding: 40px 30px; max-width: 800px; margin: auto; }
        .card { background-color: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .btn-tambah { background-color: #8B5E3C; color: white; padding: 10px 15px; border-radius: 8px; text-decoration: none; display: inline-block; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th { background-color: #DCD7C9; padding: 12px; text-align: left; }
        td { padding: 12px; border-bottom: 1px solid #EFEFEF; }
        .btn-edit { background-color: #A3B18A; color: white; padding: 6px 12px; border-radius: 5px; text-decoration: none; font-size: 14px; }
        .btn-hapus { background-color: #E8A09A; color: white; padding: 6px 12px; border: none; border-radius: 5px; cursor: pointer; font-family: 'Poppins'; }
        .alert-success { background-color: #A3B18A; color: white; padding: 10px; border-radius: 8px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="{{ url('/dashboard') }}">⬅ Kembali ke Dashboard</a>
        <span>Kategori Buku</span>
    </div>
    <div class="container">
        <div class="card">
            <h2 style="margin-top: 0;">Kelola Kategori Buku</h2>
            @if(session('success')) <div class="alert-success">{{ session('success') }}</div> @endif
            <a href="{{ url('/kategori/create') }}" class="btn-tambah">+ Tambah Kategori</a>
            <table>
                <thead>
                    <tr>
                        <th width="10%">No</th>
                        <th>Nama Kategori</th>
                        <th width="25%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategori as $key => $k)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $k->NamaKategori }}</td>
                            <td style="display: flex; gap: 5px;">
                                <a href="{{ url('/kategori/'.$k->KategoriID.'/edit') }}" class="btn-edit">Edit</a>
                                <form action="{{ url('/kategori/'.$k->KategoriID) }}" method="POST" onsubmit="return confirm('Yakin hapus kategori ini?');" style="margin: 0;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-hapus">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" style="text-align: center; color: #888;">Belum ada kategori.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>