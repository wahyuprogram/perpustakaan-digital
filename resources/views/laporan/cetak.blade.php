<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan - Perpustakaan Digital</title>
    <style>
        /* Tampilan khusus untuk kertas putih Print */
        body { font-family: Arial, sans-serif; color: #000; margin: 20px; }
        h2 { text-align: center; margin-bottom: 5px; }
        p { text-align: center; margin-top: 0; margin-bottom: 30px; font-size: 14px; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 8px 12px; text-align: left; font-size: 14px; }
        th { background-color: #f2f2f2; }
        
        /* Menyembunyikan elemen yang tidak perlu saat di-print beneran */
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div style="text-align: right; margin-bottom: 20px;" class="no-print">
        <button onclick="window.print()" style="padding: 10px 20px; background-color: #6B8E23; color: white; border: none; cursor: pointer; font-size: 16px;">🖨️ Cetak Sekarang</button>
    </div>

    <h2>LAPORAN PEMINJAMAN BUKU</h2>
    <p>Perpustakaan Digital | Tanggal Cetak: {{ \Carbon\Carbon::now()->format('d M Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Peminjam</th>
                <th>Buku</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
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
                    <td>{{ $p->StatusPeminjaman }}</td>
                </tr>
            @empty
                <tr><td colspan="6" style="text-align: center;">Tidak ada data.</td></tr>
            @endforelse
        </tbody>
    </table>

    <script>
        // Membuka dialog print otomatis saat halaman ini dibuka
        window.print();
    </script>
</body>
</html>