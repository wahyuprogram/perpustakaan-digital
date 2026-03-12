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
        .container { padding: 40px 30px; max-width: 1100px; margin: auto; }
        .card { background-color: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background-color: #DCD7C9; padding: 12px; text-align: left; }
        td { padding: 12px; border-bottom: 1px solid #EFEFEF; }
        
        .badge { padding: 4px 8px; border-radius: 10px; font-size: 12px; font-weight: 600; display: inline-block;}
        .bg-menunggu { background-color: #DCD7C9; color: #4A3F35; }
        .bg-dipinjam { background-color: #E8A09A; color: white; }
        .bg-kembali { background-color: #A3B18A; color: white; }
        .bg-ditolak { background-color: #4A3F35; color: white; }
        
        /* Tombol Detail */
        .btn-detail { background-color: #8B5E3C; color: white; padding: 6px 15px; border-radius: 5px; text-decoration: none; font-size: 12px; font-weight: 600; transition: 0.3s; display: inline-block;}
        .btn-detail:hover { background-color: #6C472B; }
        
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
                        <th>Tgl Tenggat</th>
                        <th>Status</th>
                        <th>Denda (Rp)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjaman as $p)
                        @php
                            $dendaTampil = 0;
                            if ($p->StatusPeminjaman == 'Dikembalikan') {
                                $dendaTampil = $p->Denda;
                            } elseif ($p->StatusPeminjaman == 'Dipinjam') {
                                $tenggat = \Carbon\Carbon::parse($p->TanggalPengembalian)->startOfDay();
                                $hariIni = \Carbon\Carbon::now()->startOfDay();
                                if ($hariIni->greaterThan($tenggat)) {
                                    $dendaTampil = $hariIni->diffInDays($tenggat) * 1000;
                                }
                            }
                        @endphp

                        <tr>
                            <td><strong>{{ $p->user->NamaLengkap }}</strong><br><small>{{ $p->user->Username }}</small></td>
                            <td>{{ $p->buku->Judul }}</td>
                            <td>{{ in_array($p->StatusPeminjaman, ['Menunggu', 'Ditolak']) ? '-' : \Carbon\Carbon::parse($p->TanggalPengembalian)->format('d M Y') }}</td>
                            <td>
                                @if($p->StatusPeminjaman == 'Menunggu') <span class="badge bg-menunggu">Menunggu</span>
                                @elseif($p->StatusPeminjaman == 'Dipinjam') <span class="badge bg-dipinjam">Dipinjam</span>
                                @elseif($p->StatusPeminjaman == 'Dikembalikan') <span class="badge bg-kembali">Dikembalikan</span>
                                @else <span class="badge bg-ditolak">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                @if($dendaTampil > 0)
                                    <strong style="color: #E8A09A;">Rp {{ number_format($dendaTampil, 0, ',', '.') }}</strong>
                                @else
                                    <span style="color: #A3B18A;">Rp 0</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ url('/konfirmasi/'.$p->PeminjamanID) }}" class="btn-detail">Lihat Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="text-align: center; color: #888;">Tidak ada data peminjaman saat ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>