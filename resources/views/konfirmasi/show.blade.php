<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Transaksi - Perpustakaan Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #F4F1EA; margin: 0; color: #4A3F35; }
        .navbar { background-color: #6B8E23; padding: 15px 30px; display: flex; justify-content: space-between; color: white; }
        .navbar a { color: white; text-decoration: none; font-weight: 600; }
        .container { padding: 40px 30px; max-width: 800px; margin: auto; }
        .card { background-color: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); position: relative;}
        
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        .info-box { background-color: #FAFAFA; border: 1px solid #EFEFEF; padding: 15px; border-radius: 8px; }
        .info-box p { margin: 5px 0; font-size: 14px; }
        .info-box strong { color: #8B5E3C; }

        .badge { padding: 4px 10px; border-radius: 10px; font-size: 14px; font-weight: 600; }
        .bg-menunggu { background-color: #DCD7C9; color: #4A3F35; }
        .bg-dipinjam { background-color: #E8A09A; color: white; }
        .bg-kembali { background-color: #A3B18A; color: white; }
        .bg-ditolak { background-color: #4A3F35; color: white; }

        /* Tombol Aksi */
        .btn-setuju { width: 100%; background-color: #A3B18A; color: white; padding: 12px; border: none; border-radius: 8px; cursor: pointer; font-family: 'Poppins'; font-size: 16px; font-weight: 600; margin-bottom: 10px;}
        .btn-tolak { width: 100%; background-color: #E8A09A; color: white; padding: 12px; border: none; border-radius: 8px; cursor: pointer; font-family: 'Poppins'; font-size: 16px; font-weight: 600;}
        .btn-kembali { width: 100%; background-color: #6B8E23; color: white; padding: 12px; border: none; border-radius: 8px; cursor: pointer; font-family: 'Poppins'; font-size: 16px; font-weight: 600;}

        /* CSS UNTUK MODAL POP-UP */
        .modal-overlay { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); align-items: center; justify-content: center; backdrop-filter: blur(3px);}
        .modal-content { background-color: white; padding: 30px; border-radius: 12px; width: 100%; max-width: 400px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
        .modal-content h3 { margin-top: 0; color: #8B5E3C; border-bottom: 1px solid #EFEFEF; padding-bottom: 10px;}
        .modal-content label { font-size: 14px; font-weight: 600; color: #4A3F35; display: block; margin-top: 15px; margin-bottom: 5px;}
        .modal-content input[type="date"] { width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #DCD7C9; font-family: 'Poppins'; box-sizing: border-box; }
        .denda-preview { background-color: #F4F1EA; padding: 15px; border-radius: 8px; text-align: center; margin-top: 20px; border: 1px solid #DCD7C9;}
        .denda-preview h2 { margin: 0; color: #E8A09A; font-size: 24px;}
        .btn-simpan-modal { width: 100%; background-color: #6B8E23; color: white; padding: 12px; border: none; border-radius: 8px; cursor: pointer; font-family: 'Poppins'; font-weight: 600; margin-top: 20px;}
        .btn-tutup-modal { width: 100%; background-color: transparent; color: #888; padding: 10px; border: none; cursor: pointer; font-family: 'Poppins'; margin-top: 5px; text-decoration: underline;}
    </style>
</head>
<body>
    <div class="navbar">
        <a href="{{ url('/konfirmasi') }}">⬅ Kembali ke Daftar</a>
        <span>Detail Transaksi Peminjaman</span>
    </div>
    
    <div class="container">
        <div class="card">
            <h2 style="margin-top: 0; text-align: center; color: #6B8E23;">Detail Transaksi</h2>
            <hr style="border: 0; border-top: 1px solid #EFEFEF; margin-bottom: 20px;">

            @php
                $dendaTampil = 0;
                if ($peminjaman->StatusPeminjaman == 'Dikembalikan') {
                    $dendaTampil = $peminjaman->Denda;
                } elseif ($peminjaman->StatusPeminjaman == 'Dipinjam') {
                    $tenggat = \Carbon\Carbon::parse($peminjaman->TanggalPengembalian)->startOfDay();
                    $hariIni = \Carbon\Carbon::now()->startOfDay();
                    if ($hariIni->greaterThan($tenggat)) {
                        $dendaTampil = $hariIni->diffInDays($tenggat) * 1000;
                    }
                }
            @endphp

            <div class="info-grid">
                <div class="info-box">
                    <h4 style="margin-top: 0; color: #6B8E23;">Informasi Peminjam</h4>
                    <p><strong>Nama:</strong> {{ $peminjaman->user->NamaLengkap }}</p>
                    <p><strong>Username:</strong> {{ $peminjaman->user->Username }}</p>
                    <p><strong>Email:</strong> {{ $peminjaman->user->Email }}</p>
                </div>
                <div class="info-box">
                    <h4 style="margin-top: 0; color: #6B8E23;">Informasi Buku</h4>
                    <p><strong>Judul:</strong> {{ $peminjaman->buku->Judul }}</p>
                    <p><strong>Penulis:</strong> {{ $peminjaman->buku->Penulis }}</p>
                    <p><strong>Sisa Stok Sistem:</strong> {{ $peminjaman->buku->Stok }} Buku</p>
                </div>
            </div>

            <div class="info-box" style="margin-bottom: 20px; text-align: center;">
                <p><strong>Status Saat Ini:</strong> 
                    @if($peminjaman->StatusPeminjaman == 'Menunggu') <span class="badge bg-menunggu">Menunggu Konfirmasi</span>
                    @elseif($peminjaman->StatusPeminjaman == 'Dipinjam') <span class="badge bg-dipinjam">Sedang Dipinjam</span>
                    @elseif($peminjaman->StatusPeminjaman == 'Dikembalikan') <span class="badge bg-kembali">Sudah Dikembalikan</span>
                    @else <span class="badge bg-ditolak">Ditolak</span>
                    @endif
                </p>
                <p><strong>Tgl Pengajuan:</strong> {{ $peminjaman->created_at->format('d M Y') }}</p>
                <p><strong>Tenggat Waktu:</strong> <span id="text-tenggat">{{ in_array($peminjaman->StatusPeminjaman, ['Menunggu', 'Ditolak']) ? '-' : \Carbon\Carbon::parse($peminjaman->TanggalPengembalian)->format('Y-m-d') }}</span></p>
                <p><strong>Total Denda:</strong> <span style="font-size: 18px; font-weight: bold; color: {{ $dendaTampil > 0 ? '#E8A09A' : '#A3B18A' }};">Rp {{ number_format($dendaTampil, 0, ',', '.') }}</span></p>
            </div>

            <hr style="border: 0; border-top: 1px solid #EFEFEF; margin-bottom: 20px;">

            @if($peminjaman->StatusPeminjaman == 'Menunggu')
                <div style="display: flex; gap: 10px;">
                    <form action="{{ url('/konfirmasi/'.$peminjaman->PeminjamanID.'/setujui') }}" method="POST" onsubmit="return confirm('Setujui peminjaman ini?');" style="flex: 1; margin: 0;">
                        @csrf
                        <button type="submit" class="btn-setuju">✓ Setujui Pinjaman</button>
                    </form>
                    <form action="{{ url('/konfirmasi/'.$peminjaman->PeminjamanID.'/tolak') }}" method="POST" onsubmit="return confirm('Tolak peminjaman ini?');" style="flex: 1; margin: 0;">
                        @csrf
                        <button type="submit" class="btn-tolak">✕ Tolak Pinjaman</button>
                    </form>
                </div>
            @elseif($peminjaman->StatusPeminjaman == 'Dipinjam')
                <button type="button" class="btn-kembali" onclick="bukaModal()">📚 Konfirmasi Pengembalian Fisik</button>
            @else
                <p style="text-align: center; color: #888; font-style: italic;">Transaksi ini sudah selesai diproses.</p>
            @endif

        </div>
    </div>

    <div id="modalPengembalian" class="modal-overlay">
        <div class="modal-content">
            <h3>Proses Pengembalian</h3>
            <p style="font-size: 13px; color: #777;">Tenggat Waktu: <strong>{{ \Carbon\Carbon::parse($peminjaman->TanggalPengembalian)->format('d M Y') }}</strong></p>
            
            <form action="{{ url('/konfirmasi/'.$peminjaman->PeminjamanID.'/kembalikan') }}" method="POST">
                @csrf
                <label>Pilih Tanggal Dikembalikan:</label>
                <input type="date" name="TanggalDikembalikan" id="inputTanggal" value="{{ date('Y-m-d') }}" onchange="hitungDenda()">

                <div class="denda-preview">
                    <p style="margin: 0 0 5px 0; font-size: 14px; font-weight: 600;">Estimasi Denda:</p>
                    <h2 id="angkaDenda">Rp 0</h2>
                </div>

                <button type="submit" class="btn-simpan-modal">Simpan & Terima Buku</button>
                <button type="button" class="btn-tutup-modal" onclick="tutupModal()">Batal</button>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('modalPengembalian');
        const inputTgl = document.getElementById('inputTanggal');
        const angkaDenda = document.getElementById('angkaDenda');
        
        // Ambil data tanggal tenggat dari database (format YYYY-MM-DD)
        const tenggatStr = "{{ $peminjaman->TanggalPengembalian }}";

        function bukaModal() {
            modal.style.display = 'flex';
            hitungDenda(); // Langsung hitung saat modal dibuka
        }

        function tutupModal() {
            modal.style.display = 'none';
        }

        function hitungDenda() {
            // Ubah string tanggal menjadi objek Date
            let tglPilih = new Date(inputTgl.value);
            let tglTenggat = new Date(tenggatStr);

            // Reset jam agar perhitungannya murni selisih hari
            tglPilih.setHours(0,0,0,0);
            tglTenggat.setHours(0,0,0,0);

            let denda = 0;

            // Jika tanggal pilih melebihi tanggal tenggat
            if (tglPilih > tglTenggat) {
                // Rumus menghitung selisih hari
                let selisihWaktu = Math.abs(tglPilih - tglTenggat);
                let selisihHari = Math.ceil(selisihWaktu / (1000 * 60 * 60 * 24));
                denda = selisihHari * 1000;
            }

            // Tampilkan ke layar dengan format Rupiah
            angkaDenda.innerText = 'Rp ' + denda.toLocaleString('id-ID');
            
            // Ubah warna jika ada denda
            if(denda > 0) {
                angkaDenda.style.color = '#E8A09A'; // Merah
            } else {
                angkaDenda.style.color = '#A3B18A'; // Hijau
            }
        }
    </script>
</body>
</html>