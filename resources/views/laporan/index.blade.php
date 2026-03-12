<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman - Perpustakaan Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #F4F1EA; margin: 0; color: #4A3F35; }
        .navbar { background-color: #6B8E23; padding: 15px 30px; display: flex; justify-content: space-between; color: white; }
        .navbar a { color: white; text-decoration: none; font-weight: 600; }
        .container { padding: 40px 30px; max-width: 1000px; margin: auto; }
        .card { background-color: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .btn-cetak { background-color: #8B5E3C; color: white; padding: 10px 15px; border-radius: 8px; text-decoration: none; display: inline-block; margin-bottom: 20px; font-weight: 600; }
        table { width: 100%; border-collapse: collapse; }
        th { background-color: #DCD7C9; padding: 12px; text-align: left; }
        td { padding: 12px; border-bottom: 1px solid #EFEFEF; }
        .badge-pinjam { background-color: #E8A09A; color: white; padding: 4px 8px; border-radius: 10px; font-size: 12px; }
        .badge-kembali { background-color: #A3B18A; color: white; padding: 4px 8px; border-radius: 10px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="{{ url('/dashboard') }}">⬅ Kembali ke Dashboard</a>
        <span>Generate Laporan</span>
    </div>
    <div class="container">
        <div class="card">
            <h2 style="margin-top: 0;">Laporan Seluruh Peminjaman Buku</h2>
            
            <a href="{{ url('/laporan/cetak') }}" target="_blank" class="btn-cetak">🖨️ Cetak Laporan (PDF / Print)</a>
            
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Peminjam</th>
                        <th>Buku yang Dipinjam</th>
                        <th>Tanggal Pinjam</th>
                        <th>Dikembalikan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjaman as $key => $p)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $p->user->NamaLengkap }}</td>
                            <td>{{ $p->buku->Judul }}</td>
                            <td>{{ $p->TanggalPeminjaman }}</td>
                            <td>{{ $p->TanggalPengembalian }}</td>
                            <td>
                                @if($p->StatusPeminjaman == 'Dipinjam')
                                    <span class="badge-pinjam">Dipinjam</span>
                                @else
                                    <span class="badge-kembali">Dikembalikan</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="text-align: center; color: #888;">Belum ada data transaksi peminjaman.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>