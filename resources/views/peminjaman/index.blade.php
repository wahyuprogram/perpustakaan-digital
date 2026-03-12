<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Status Pinjaman - Perpustakaan Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #F4F1EA; margin: 0; color: #4A3F35; }
        .navbar { background-color: #6B8E23; padding: 15px 30px; display: flex; justify-content: space-between; color: white; }
        .navbar a { color: white; text-decoration: none; font-weight: 600; }
        .container { padding: 40px 30px; max-width: 1000px; margin: auto; }
        .card { background-color: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; margin-top: 15px;}
        th { background-color: #DCD7C9; padding: 12px; text-align: left; }
        td { padding: 12px; border-bottom: 1px solid #EFEFEF; }
        
        .badge { padding: 5px 10px; border-radius: 20px; font-size: 12px; font-weight: 600;}
        .bg-menunggu { background-color: #DCD7C9; color: #4A3F35; }
        .bg-dipinjam { background-color: #E8A09A; color: white; }
        .bg-kembali { background-color: #A3B18A; color: white; }
        .bg-ditolak { background-color: #4A3F35; color: white; }
        
        /* Desain Tombol Aksi */
        .btn-batal { background-color: #E8A09A; color: white; padding: 6px 12px; border: none; border-radius: 5px; cursor: pointer; font-family: 'Poppins'; font-size: 12px; font-weight: 600; transition: 0.3s;}
        .btn-batal:hover { background-color: #D68A84; }
        .btn-ulas { background-color: #6B8E23; color: white; padding: 6px 12px; border-radius: 5px; text-decoration: none; font-size: 12px; font-weight: 600; transition: 0.3s;}
        .btn-ulas:hover { background-color: #55721c; }

        .alert-success { background-color: #A3B18A; color: white; padding: 10px; border-radius: 8px; margin-bottom: 20px; }
        .alert-error { background-color: #E8A09A; color: white; padding: 10px; border-radius: 8px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="{{ url('/dashboard') }}">⬅ Kembali ke Dashboard</a>
        <span>Status Pinjaman Saya</span>
    </div>
    <div class="container">
        <div class="card">
            <h2 style="margin-top: 0;">Pantau Peminjaman Buku Anda</h2>
            @if(session('success')) <div class="alert-success">{{ session('success') }}</div> @endif
            @if(session('error')) <div class="alert-error">{{ session('error') }}</div> @endif
            
            <p style="color: #666; font-size: 14px;">Jika buku masih "Sedang Dipinjam", serahkan buku fisik kepada Petugas untuk dikonfirmasi pengembaliannya.</p>

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tenggat Waktu</th>
                        <th>Status</th>
                        <th>Denda (Rp)</th> <th>Aksi</th> 
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjaman as $key => $p)
                        @php
                            $dendaTampil = 0;
                            if ($p->StatusPeminjaman == 'Dikembalikan') {
                                // Jika sudah dikembalikan, ambil data denda dari Database
                                $dendaTampil = $p->Denda;
                            } elseif ($p->StatusPeminjaman == 'Dipinjam') {
                                // Jika masih dipinjam, hitung estimasi denda hari ini
                                $tenggat = \Carbon\Carbon::parse($p->TanggalPengembalian)->timezone('Asia/Jakarta')->startOfDay();
                                $hariIni = \Carbon\Carbon::now()->timezone('Asia/Jakarta')->startOfDay();
                                if ($hariIni->greaterThan($tenggat)) {
                                    $dendaTampil = $hariIni->diffInDays($tenggat) * 1000;
                                }
                            }
                        @endphp

                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td><strong>{{ $p->buku->Judul }}</strong><br><small>{{ $p->buku->Penulis }}</small></td>
                            <td>{{ $p->StatusPeminjaman == 'Menunggu' ? '-' : $p->TanggalPeminjaman }}</td>
                            <td style="color: #E8A09A; font-weight: 600;">{{ $p->StatusPeminjaman == 'Menunggu' ? '-' : $p->TanggalPengembalian }}</td>
                            <td>
                                @if($p->StatusPeminjaman == 'Menunggu')
                                    <span class="badge bg-menunggu">Menunggu Konfirmasi</span>
                                @elseif($p->StatusPeminjaman == 'Dipinjam')
                                    <span class="badge bg-dipinjam">Sedang Dipinjam</span>
                                @elseif($p->StatusPeminjaman == 'Dikembalikan')
                                    <span class="badge bg-kembali">Sudah Dikembalikan</span>
                                @else
                                    <span class="badge bg-ditolak">Ditolak</span>
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
                                @if($p->StatusPeminjaman == 'Menunggu')
                                    <form action="{{ url('/peminjaman/'.$p->PeminjamanID.'/batal') }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pengajuan pinjam ini?');" style="margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-batal">Batal Pinjam</button>
                                    </form>
                                @elseif($p->StatusPeminjaman == 'Dikembalikan')
                                    <a href="{{ url('/katalog/'.$p->buku->BukuID) }}" class="btn-ulas">Beri Ulasan</a>
                                @else
                                    <span style="color: #ccc;">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" style="text-align: center; color: #888;">Anda belum meminjam buku apapun.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>