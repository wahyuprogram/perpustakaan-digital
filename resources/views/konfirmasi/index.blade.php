<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Peminjaman - Perpustakaan Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #F4F1EA; margin: 0; color: #4A3F35; }
        .navbar { background-color: #6B8E23; padding: 15px 30px; display: flex; justify-content: space-between; color: white; }
        .navbar a { color: white; text-decoration: none; font-weight: 600; }
        .container { padding: 40px 30px; max-width: 1000px; margin: auto; }
        .card { background-color: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background-color: #DCD7C9; padding: 12px; text-align: left; }
        td { padding: 12px; border-bottom: 1px solid #EFEFEF; }
        
        .badge-menunggu { background-color: #DCD7C9; color: #4A3F35; padding: 4px 8px; border-radius: 10px; font-size: 12px; font-weight: 600;}
        .badge-dipinjam { background-color: #E8A09A; color: white; padding: 4px 8px; border-radius: 10px; font-size: 12px; font-weight: 600;}
        
        .btn-setuju { background-color: #A3B18A; color: white; padding: 6px 10px; border: none; border-radius: 5px; cursor: pointer; font-family: 'Poppins'; font-size: 12px;}
        .btn-tolak { background-color: #E8A09A; color: white; padding: 6px 10px; border: none; border-radius: 5px; cursor: pointer; font-family: 'Poppins'; font-size: 12px;}
        .btn-kembali { background-color: #6B8E23; color: white; padding: 6px 10px; border: none; border-radius: 5px; cursor: pointer; font-family: 'Poppins'; font-size: 12px;}
        
        .aksi-flex { display: flex; gap: 5px; }
        .alert-success { background-color: #A3B18A; color: white; padding: 10px; border-radius: 8px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="{{ url('/dashboard') }}">⬅ Kembali ke Dashboard</a>
        <span>Konfirmasi Peminjaman</span>
    </div>
    <div class="container">
        <div class="card">
            <h2 style="margin-top: 0;">Kelola Peminjaman & Pengembalian</h2>
            @if(session('success')) <div class="alert-success">{{ session('success') }}</div> @endif
            
            <table>
                <thead>
                    <tr>
                        <th>Peminjam</th>
                        <th>Buku</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Status</th>
                        <th>Aksi Petugas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjaman as $p)
                        <tr>
                            <td><strong>{{ $p->user->NamaLengkap }}</strong><br><small>{{ $p->user->Username }}</small></td>
                            <td>{{ $p->buku->Judul }}</td>
                            <td>{{ $p->created_at->format('d M Y') }}</td>
                            <td>
                                @if($p->StatusPeminjaman == 'Menunggu')
                                    <span class="badge-menunggu">Menunggu Persetujuan</span>
                                @elseif($p->StatusPeminjaman == 'Dipinjam')
                                    <span class="badge-dipinjam">Sedang Dipinjam</span>
                                @endif
                            </td>
                            <td>
                                <div class="aksi-flex">
                                    @if($p->StatusPeminjaman == 'Menunggu')
                                        <form action="{{ url('/konfirmasi/'.$p->PeminjamanID.'/setujui') }}" method="POST" onsubmit="return confirm('Setujui peminjaman ini?');">
                                            @csrf
                                            <button type="submit" class="btn-setuju">✓ Setujui</button>
                                        </form>
                                        <form action="{{ url('/konfirmasi/'.$p->PeminjamanID.'/tolak') }}" method="POST" onsubmit="return confirm('Tolak peminjaman ini?');">
                                            @csrf
                                            <button type="submit" class="btn-tolak">✕ Tolak</button>
                                        </form>
                                    @elseif($p->StatusPeminjaman == 'Dipinjam')
                                        <form action="{{ url('/konfirmasi/'.$p->PeminjamanID.'/kembalikan') }}" method="POST" onsubmit="return confirm('Konfirmasi buku sudah dikembalikan secara fisik?');">
                                            @csrf
                                            <button type="submit" class="btn-kembali">📚 Terima Pengembalian</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" style="text-align: center; color: #888;">Tidak ada antrean peminjaman saat ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>