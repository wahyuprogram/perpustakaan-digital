<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Buku - Perpustakaan Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #F4F1EA; margin: 0; color: #4A3F35; }
        .navbar { background-color: #6B8E23; padding: 15px 30px; display: flex; justify-content: space-between; color: white; }
        .navbar a { color: white; text-decoration: none; font-weight: 600; }
        .container { padding: 40px 30px; max-width: 900px; margin: auto; }
        
        .layout-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; }
        @media(max-width: 768px) { .layout-grid { grid-template-columns: 1fr; } }
        
        .card { background-color: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .btn-pinjam { width: 100%; padding: 12px; background-color: #8B5E3C; color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; margin-bottom: 10px; transition: 0.3s;}
        .btn-pinjam:hover { background-color: #6C472B; }
        .btn-koleksi { width: 100%; padding: 12px; background-color: #DCD7C9; color: #4A3F35; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; transition: 0.3s;}
        .btn-koleksi:hover { background-color: #C1BCAE; }
        
        .ulasan-box { background-color: #FAFAFA; border: 1px solid #EFEFEF; padding: 15px; border-radius: 8px; margin-bottom: 15px; }
        .bintang { color: #FFD700; font-size: 16px; }
        
        .form-ulasan textarea { width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #DCD7C9; margin-top: 10px; box-sizing: border-box; font-family: 'Poppins';}
        .form-ulasan select { width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #DCD7C9; margin-top: 10px;}
        .btn-kirim-ulasan { padding: 10px; background-color: #A3B18A; color: white; border: none; border-radius: 8px; cursor: pointer; margin-top: 10px; width: 100%; font-weight: 600;}
    </style>
</head>
<body>
    <div class="navbar">
        <a href="{{ url('/dashboard') }}">⬅ Kembali</a>
        <span>Detail Buku</span>
    </div>
    
    <div class="container">
        @if(session('success')) <div style="background: #A3B18A; color: white; padding: 10px; border-radius: 8px; margin-bottom: 20px;">{{ session('success') }}</div> @endif
        @if(session('error')) <div style="background: #E8A09A; color: white; padding: 10px; border-radius: 8px; margin-bottom: 20px;">{{ session('error') }}</div> @endif

        <div class="layout-grid">
            <div class="card">
    <h1 style="color: #6B8E23; margin-top: 0; font-size: 24px;">{{ $buku->Judul }}</h1>
    <p><strong>Penulis:</strong> {{ $buku->Penulis }}</p>
    <p><strong>Penerbit:</strong> {{ $buku->Penerbit }}</p>
    <p><strong>Tahun Terbit:</strong> {{ $buku->TahunTerbit }}</p>
    <p><strong>Kategori:</strong> 
        @foreach($buku->kategori as $kat)
            <span style="background: #DCD7C9; padding: 3px 8px; border-radius: 5px; font-size: 12px;">{{ $kat->NamaKategori }}</span>
        @endforeach
    </p>
    
    <p><strong>Stok Tersedia:</strong> 
        @if($buku->Stok > 0)
            <span style="color: #6B8E23; font-weight: 600; font-size: 18px;">{{ $buku->Stok }} Buku</span>
        @else
            <span style="color: #E8A09A; font-weight: 600; font-size: 18px;">Habis</span>
        @endif
    </p>

    <div style="margin-top: 15px; padding: 10px; background-color: #fff3cd; border-left: 5px solid #ffecb5; border-radius: 4px;">
    <p style="margin: 0; font-size: 14px; color: #856404;">
        ⚠️ <strong>Penting:</strong> Waktu peminjaman maksimal <strong>7 hari</strong>. 
        Keterlambatan pengembalian akan dikenakan denda.
    </p>
</div>

    <hr style="border: 0; border-top: 1px solid #EFEFEF; margin: 20px 0;">

    @if($buku->Stok > 0)
        <form action="{{ url('/peminjaman') }}" method="POST">
            @csrf
            <input type="hidden" name="BukuID" value="{{ $buku->BukuID }}">
            
            

            <button type="submit" class="btn-pinjam">📖 Ajukan Peminjaman</button>
        </form>
    @else
        <button type="button" class="btn-pinjam" style="background-color: #ccc; cursor: not-allowed; color: #666;" disabled>🚫 Stok Buku Sedang Kosong</button>
    @endif

    <form action="{{ url('/koleksi') }}" method="POST">
        @csrf
        <input type="hidden" name="BukuID" value="{{ $buku->BukuID }}">
        <button type="submit" class="btn-koleksi">⭐ Tambah ke Koleksi Pribadi</button>
    </form>
</div>

            <div class="card">
                <h2 style="margin-top: 0; font-size: 20px;">Ulasan Pembaca</h2>
                
                <div style="max-height: 300px; overflow-y: auto; margin-bottom: 20px;">
                    @forelse($buku->ulasan as $u)
                        <div class="ulasan-box">
                            <strong style="font-size: 14px;">{{ $u->user->NamaLengkap }}</strong>
                            <div class="bintang">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $u->Rating) ★ @else ☆ @endif
                                @endfor
                            </div>
                            <p style="margin: 5px 0 0 0; font-size: 14px; font-style: italic;">"{{ $u->Ulasan }}"</p>
                            
                            @if($u->Balasan)
                                <div style="background-color: #EFEFEF; padding: 10px; border-radius: 8px; margin-top: 10px; border-left: 3px solid #6B8E23;">
                                    <small style="font-weight: 600; color: #6B8E23;">Balasan Petugas:</small>
                                    <p style="margin: 5px 0 0 0; font-size: 13px;">{{ $u->Balasan }}</p>
                                </div>
                            @endif
                            </div>
                    @empty
                        <p style="color: #888; font-size: 14px;">Belum ada ulasan. Jadilah yang pertama!</p>
                    @endforelse
                </div>

                <hr style="border: 0; border-top: 1px solid #EFEFEF; margin: 20px 0;">

                <form action="{{ url('/ulasan') }}" method="POST" class="form-ulasan">
                    @csrf
                    <input type="hidden" name="BukuID" value="{{ $buku->BukuID }}">
                    <label style="font-size: 14px; font-weight: 600;">Berikan Ulasan Anda:</label>
                    <select name="Rating" required>
                        <option value="5">⭐⭐⭐⭐⭐ (Sangat Bagus)</option>
                        <option value="4">⭐⭐⭐⭐ (Bagus)</option>
                        <option value="3">⭐⭐⭐ (Lumayan)</option>
                        <option value="2">⭐⭐ (Kurang)</option>
                        <option value="1">⭐ (Sangat Kurang)</option>
                    </select>
                    <textarea name="Ulasan" rows="3" required placeholder="Tulis komentar Anda di sini..."></textarea>
                    <button type="submit" class="btn-kirim-ulasan">Kirim Ulasan</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>