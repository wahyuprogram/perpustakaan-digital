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
        .container { padding: 40px 30px; max-width: 1100px; margin: auto; }
        .card { background-color: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px;}
        th { background-color: #DCD7C9; padding: 12px; text-align: left; }
        td { padding: 12px; border-bottom: 1px solid #EFEFEF; }
        .badge { padding: 4px 8px; border-radius: 10px; font-size: 12px; font-weight: 600; }
        .bg-menunggu { background-color: #DCD7C9; color: #4A3F35; }
        .bg-dipinjam { background-color: #E8A09A; color: white; }
        .bg-kembali { background-color: #A3B18A; color: white; }
        .bg-ditolak { background-color: #4A3F35; color: white; }

        .filter-box { background-color: #FAFAFA; border: 1px solid #EFEFEF; padding: 15px; border-radius: 8px; margin-bottom: 20px; display: flex; gap: 10px; align-items: center; justify-content: space-between;}
        .filter-form { display: flex; gap: 10px; align-items: center; }
        .filter-form input[type="date"] { padding: 8px; border-radius: 5px; border: 1px solid #DCD7C9; font-family: 'Poppins'; outline: none;}
        .btn-filter { background-color: #6B8E23; color: white; padding: 8px 15px; border: none; border-radius: 5px; cursor: pointer; font-family: 'Poppins'; font-weight: 600;}
        .btn-cetak { background-color: #8B5E3C; color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none; font-weight: 600; display: inline-block;}
        
        .recap-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px; }
        .recap-card { background-color: #F4F1EA; padding: 15px; border-radius: 8px; border-left: 4px solid #8B5E3C; }
        .recap-card h3 { margin: 0; font-size: 24px; color: #8B5E3C; }
        .recap-card p { margin: 0; font-size: 13px; color: #777; font-weight: 600; text-transform: uppercase;}

        /* Style Pagination */
        .pagination-container { margin-top: 20px; display: flex; justify-content: center; }
        .pagination { display: flex; list-style: none; gap: 5px; }
        .pagination li a, .pagination li span { padding: 8px 12px; border: 1px solid #DCD7C9; text-decoration: none; color: #4A3F35; border-radius: 4px; }
        .pagination li.active span { background-color: #6B8E23; color: white; border-color: #6B8E23; }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="{{ url('/dashboard') }}">⬅ Kembali ke Dashboard</a>
        <span>Generate Laporan</span>
    </div>
    <div class="container">
        <div class="card">
            <h2 style="margin-top: 0;">Laporan Peminjaman Buku</h2>
            
            <div class="filter-box">
                <form action="{{ url('/laporan') }}" method="GET" class="filter-form">
                    <label style="font-size: 14px; font-weight: 600;">Dari:</label>
                    <input type="date" name="tgl_mulai" value="{{ $tgl_mulai }}">
                    <label style="font-size: 14px; font-weight: 600;">Sampai:</label>
                    <input type="date" name="tgl_selesai" value="{{ $tgl_selesai }}">
                    
                    <button type="submit" class="btn-filter">Tampilkan</button>
                    @if($tgl_mulai || $tgl_selesai)
                        <a href="{{ url('/laporan') }}" style="color: #E8A09A; font-size: 14px; text-decoration: none;">Reset</a>
                    @endif
                </form>

                <a href="{{ url('/laporan/cetak?tgl_mulai='.$tgl_mulai.'&tgl_selesai='.$tgl_selesai) }}" target="_blank" class="btn-cetak">🖨️ Cetak PDF</a>
            </div>

            <div class="recap-grid">
                <div class="recap-card">
                    <p>Total Transaksi</p>
                    <h3>{{ $totalTransaksi }}</h3>
                </div>
                <div class="recap-card" style="border-color: #6B8E23;">
                    <p>Selesai (Dikembalikan)</p>
                    <h3 style="color: #6B8E23;">{{ $totalSelesai }}</h3>
                </div>
                <div class="recap-card" style="border-color: #E8A09A;">
                    <p>Total Denda Terkumpul</p>
                    <h3 style="color: #E8A09A;">Rp {{ number_format($totalDenda, 0, ',', '.') }}</h3>
                </div>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Peminjam</th>
                        <th>Buku</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Tenggat/Kembali</th>
                        <th>Status</th>
                        <th>Denda (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjaman as $key => $p)
                        <tr>
                            <td>{{ ($peminjaman->currentPage() - 1) * $peminjaman->perPage() + $loop->iteration }}</td>
                            <td>{{ $p->user->NamaLengkap }}</td>
                            <td>{{ $p->buku->Judul }}</td>
                            <td>{{ $p->created_at->format('d M Y') }}</td>
                            <td>{{ in_array($p->StatusPeminjaman, ['Menunggu', 'Ditolak']) ? '-' : \Carbon\Carbon::parse($p->TanggalPengembalian)->format('d M Y') }}</td>
                            <td>
                                @if($p->StatusPeminjaman == 'Menunggu') <span class="badge bg-menunggu">Menunggu</span>
                                @elseif($p->StatusPeminjaman == 'Dipinjam') <span class="badge bg-dipinjam">Dipinjam</span>
                                @elseif($p->StatusPeminjaman == 'Dikembalikan') <span class="badge bg-kembali">Dikembalikan</span>
                                @else <span class="badge bg-ditolak">Ditolak</span>
                                @endif
                            </td>
                            <td><strong>{{ $p->Denda > 0 ? number_format($p->Denda, 0, ',', '.') : '-' }}</strong></td>
                        </tr>
                    @empty
                        <tr><td colspan="7" style="text-align: center; color: #888;">Belum ada data pada periode ini.</td></tr>
                    @endforelse
                </tbody>
            </table>

            <div class="pagination-container">
                {{ $peminjaman->links() }}
            </div>
        </div>
    </div>
</body>
</html>