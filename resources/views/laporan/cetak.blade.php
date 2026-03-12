<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan - Perpustakaan Digital</title>
    <style>
        body { font-family: Arial, sans-serif; color: #000; margin: 20px; }
        h2 { text-align: center; margin-bottom: 5px; }
        p { text-align: center; margin-top: 0; margin-bottom: 10px; font-size: 14px; color: #555; }
        .recap-print { text-align: center; margin-bottom: 20px; font-size: 14px; font-weight: bold; background-color: #f2f2f2; padding: 10px; border: 1px solid #000;}
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 8px 12px; text-align: left; font-size: 14px; }
        th { background-color: #f2f2f2; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>
    <div style="text-align: right; margin-bottom: 20px;" class="no-print">
        <button onclick="window.print()" style="padding: 10px 20px; background-color: #6B8E23; color: white; border: none; cursor: pointer; font-size: 16px;">🖨️ Cetak Sekarang</button>
    </div>
    
    <h2>LAPORAN PEMINJAMAN BUKU</h2>
    
    @if($tgl_mulai && $tgl_selesai)
        <p>Periode Laporan: <strong>{{ \Carbon\Carbon::parse($tgl_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($tgl_selesai)->format('d M Y') }}</strong></p>
    @else
        <p>Periode Laporan: <strong>Semua Waktu</strong></p>
    @endif
    <p style="margin-bottom: 20px;">Tanggal Cetak: {{ \Carbon\Carbon::now()->format('d M Y') }}</p>

    <div class="recap-print">
        Total Transaksi: {{ count($peminjaman) }} | 
        Total Denda Terkumpul: Rp {{ number_format($totalDenda, 0, ',', '.') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Peminjam</th>
                <th>Buku</th>
                <th>Tgl Pengajuan</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
                <th>Denda</th>
            </tr>
        </thead>
        <tbody>
            @forelse($peminjaman as $key => $p)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $p->user->NamaLengkap }}</td>
                    <td>{{ $p->buku->Judul }}</td>
                    <td>{{ $p->created_at->format('d M Y') }}</td>
                    <td>{{ in_array($p->StatusPeminjaman, ['Menunggu', 'Ditolak']) ? '-' : \Carbon\Carbon::parse($p->TanggalPengembalian)->format('d M Y') }}</td>
                    <td>{{ $p->StatusPeminjaman }}</td>
                    <td>{{ $p->Denda > 0 ? 'Rp ' . number_format($p->Denda, 0, ',', '.') : '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="7" style="text-align: center;">Tidak ada data pada periode ini.</td></tr>
            @endforelse
        </tbody>
    </table>
    <script> window.onload = function() { window.print(); } </script>
</body>
</html>