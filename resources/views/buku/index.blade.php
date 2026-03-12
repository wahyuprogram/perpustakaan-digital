<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Buku - Perpustakaan Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #F4F1EA; margin: 0; color: #4A3F35; }
        .navbar { background-color: #6B8E23; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; color: white; }
        .navbar a { color: white; text-decoration: none; font-weight: 600; }
        .container { padding: 40px 30px; max-width: 1000px; margin: auto; }
        .card { background-color: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .btn-tambah { background-color: #8B5E3C; color: white; padding: 10px 15px; border-radius: 8px; text-decoration: none; display: inline-block; margin-bottom: 20px; transition: 0.3s; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #DCD7C9; color: #4A3F35; padding: 12px; text-align: left; }
        td { padding: 12px; border-bottom: 1px solid #EFEFEF; }
        .btn-edit { background-color: #A3B18A; color: white; padding: 6px 12px; border-radius: 5px; text-decoration: none; font-size: 14px; }
        .btn-hapus { background-color: #E8A09A; color: white; padding: 6px 12px; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; font-family: 'Poppins'; }
        .alert-success { background-color: #A3B18A; color: white; padding: 10px; border-radius: 8px; margin-bottom: 20px; }
        .badge-kategori { background-color: #6B8E23; color: white; padding: 4px 8px; border-radius: 10px; font-size: 12px; display: inline-block; margin: 2px; }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="{{ url('/dashboard') }}">⬅ Kembali ke Dashboard</a>
        <span>Data Buku</span>
    </div>
    <div class="container">
        <div class="card">
            <h2 style="margin-top: 0;">Kelola Data Buku</h2>
            @if(session('success')) <div class="alert-success">{{ session('success') }}</div> @endif
            <a href="{{ url('/buku/create') }}" class="btn-tambah">+ Tambah Buku Baru</a>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Buku</th>
                        <th>Penulis</th>
                        <th>Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($buku as $key => $b)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $b->Judul }}<br><small style="color: #888;">{{ $b->TahunTerbit }} | {{ $b->Penerbit }}</small></td>
                            <td>{{ $b->Penulis }}</td>
                            <td>
                                @forelse($b->kategori as $kat)
                                    <span class="badge-kategori">{{ $kat->NamaKategori }}</span>
                                @empty
                                    <span style="color: #999; font-size: 12px;">Tanpa Kategori</span>
                                @endforelse
                            </td>
                            <td style="display: flex; gap: 5px;">
                                <a href="{{ url('/buku/'.$b->BukuID.'/edit') }}" class="btn-edit">Edit</a>
                                <form action="{{ url('/buku/'.$b->BukuID) }}" method="POST" onsubmit="return confirm('Yakin hapus?');" style="margin: 0;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-hapus">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" style="text-align: center; color: #888;">Belum ada data buku.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>