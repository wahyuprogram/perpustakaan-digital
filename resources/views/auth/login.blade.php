<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Perpustakaan Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        /* TEMA EARTH TONE */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #F4F1EA; /* Warna dasar krem */
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #4A3F35; /* Teks cokelat gelap */
        }
        .login-card {
            background-color: #FFFFFF;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            width: 100%;
            max-width: 400px;
        }
        .login-card h2 {
            text-align: center;
            color: #6B8E23; /* Hijau Sage/Olive */
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #DCD7C9;
            border-radius: 8px;
            box-sizing: border-box;
            background-color: #FAFAFA;
        }
        .form-group input:focus {
            outline: none;
            border-color: #8B5E3C; /* Cokelat Kayu */
        }
        .btn-login {
            width: 100%;
            padding: 12px;
            background-color: #8B5E3C; /* Cokelat Kayu */
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn-login:hover {
            background-color: #6C472B;
        }
        .alert-error {
            background-color: #E8A09A; /* Merah bata soft */
            color: #fff;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }
        .alert-success {
            background-color: #A3B18A; /* Hijau soft */
            color: #fff;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }
        .link-register {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #8B5E3C;
            text-decoration: none;
        }
        .link-register:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <h2>Perpustakaan Digital</h2>

        @if(session('error'))
            <div class="alert-error">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ url('/login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="Username">Username</label>
                <input type="text" id="Username" name="Username" required placeholder="Masukkan username">
            </div>

            <div class="form-group">
                <label for="Password">Password</label>
                <input type="password" id="Password" name="Password" required placeholder="Masukkan password">
            </div>

            <button type="submit" class="btn-login">Masuk</button>
        </form>

        <a href="{{ url('/register') }}" class="link-register">Belum punya akun? Daftar di sini</a>
    </div>

</body>
</html>