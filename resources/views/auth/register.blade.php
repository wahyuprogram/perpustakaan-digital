<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Perpustakaan Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        /* TEMA EARTH TONE */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #F4F1EA; 
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #4A3F35;
            padding: 20px;
        }
        .register-card {
            background-color: #FFFFFF;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            width: 100%;
            max-width: 500px;
        }
        .register-card h2 {
            text-align: center;
            color: #6B8E23;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 14px;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #DCD7C9;
            border-radius: 8px;
            box-sizing: border-box;
            background-color: #FAFAFA;
            font-family: 'Poppins', sans-serif;
        }
        .form-group input:focus, .form-group textarea:focus {
            outline: none;
            border-color: #8B5E3C;
        }
        .btn-register {
            width: 100%;
            padding: 12px;
            background-color: #8B5E3C;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }
        .btn-register:hover {
            background-color: #6C472B;
        }
        .alert-error {
            background-color: #E8A09A;
            color: #fff;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .link-login {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #8B5E3C;
            text-decoration: none;
            font-size: 14px;
        }
        .link-login:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="register-card">
        <h2>Daftar Akun Baru</h2>

        @if ($errors->any())
            <div class="alert-error">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('/register') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="Username">Username</label>
                <input type="text" id="Username" name="Username" value="{{ old('Username') }}" required placeholder="Buat username (tanpa spasi)">
            </div>

            <div class="form-group">
                <label for="Email">Email</label>
                <input type="email" id="Email" name="Email" value="{{ old('Email') }}" required placeholder="Masukkan email aktif">
            </div>

            <div class="form-group">
                <label for="Password">Password</label>
                <input type="password" id="Password" name="Password" required placeholder="Minimal 6 karakter">
            </div>

            <div class="form-group">
                <label for="NamaLengkap">Nama Lengkap</label>
                <input type="text" id="NamaLengkap" name="NamaLengkap" value="{{ old('NamaLengkap') }}" required placeholder="Nama lengkap sesuai KTP/Kartu Pelajar">
            </div>

            <div class="form-group">
                <label for="Alamat">Alamat Lengkap</label>
                <textarea id="Alamat" name="Alamat" rows="3" required placeholder="Masukkan alamat lengkap">{{ old('Alamat') }}</textarea>
            </div>

            <button type="submit" class="btn-register">Daftar Sekarang</button>
        </form>

        <a href="{{ url('/login') }}" class="link-login">Sudah punya akun? Masuk di sini</a>
    </div>

</body>
</html>