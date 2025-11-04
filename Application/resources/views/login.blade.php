<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LeadDrive</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            background-color: #1c1c1c;
            color: #fff;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: #2c2c2c;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 100%;
            max-width: 400px;
        }
        .login-container img {
            width: 50px;
            margin-bottom: 1rem;
        }
        .login-container h1 {
            color: #ff7f00;
            margin-bottom: 0.5rem;
        }
        .login-container p {
            margin-bottom: 1.5rem;
            color: #ccc;
        }
        .login-container input {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #444;
            border-radius: 4px;
            background-color: #333;
            color: #fff;
        }
        .login-container button {
            width: 100%;
            padding: 0.75rem;
            background-color: #ff7f00;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 1rem;
            cursor: pointer;
        }
        .login-container button:hover {
            background-color: #e66a00;
        }
        .login-container a {
            color: #ff7f00;
            text-decoration: none;
        }
        .login-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <img src="{{ asset('images/logo.jpg') }}">
        <h1>Masuk ke LeadDrive</h1>
        <p>Kelola kursus mengemudi Anda dengan mudah</p>
        @if(session('success'))
            <div style="background-color: #4caf50; color: #fff; padding: 1rem; border-radius: 6px; margin-bottom: 1rem;">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div style="background-color: #ff4444; color: #fff; padding: 1rem; border-radius: 6px; margin-bottom: 1rem;">
                <ul style="list-style: none; padding: 0; margin: 0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <input type="text" name="email_or_phone" placeholder="Masukkan email atau nomor HP" value="{{ old('email_or_phone') }}" required>
            <input type="password" name="password" placeholder="Masukkan password" required>
            <div style="text-align: left; margin-bottom: 1rem;">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Ingat saya</label>
                <a href="#" style="float: right;">Lupa password?</a>
            </div>
            <button type="submit">Masuk</button>
        </form>
        <p>Belum punya akun? <a href="{{ route('register.step1') }}">Daftar sekarang</a></p>
    </div>
</body>
</html>