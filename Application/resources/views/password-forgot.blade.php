<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Kirim OTP</title>
</head>
<body style="background:#1c1c1c;color:#fff;font-family:Arial,sans-serif;display:flex;align-items:center;justify-content:center;min-height:100vh;margin:0;">
    <div style="background:#2c2c2c;padding:2rem;border-radius:10px;width:100%;max-width:420px;">
        <h1 style="color:#ff7f00;margin-bottom:1rem;">Lupa Password</h1>
        @if(session('success'))
            <div style="background:#4caf50;color:#fff;padding:0.75rem;border-radius:6px;margin-bottom:1rem;">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div style="background:#ff4444;color:#fff;padding:0.75rem;border-radius:6px;margin-bottom:1rem;">
                <ul style="margin:0;padding-left:1rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('password.forgot.send') }}">
            @csrf
            <label for="email">Email Kursus</label>
            <input type="email" id="email" name="email" value="{{ old('email', session('email_prefill')) }}" required style="width:100%;padding:0.75rem;margin:0.5rem 0 1rem;border:1px solid #444;border-radius:6px;background:#333;color:#fff;">
            <button type="submit" style="width:100%;padding:0.85rem;background:#ff7f00;border:none;border-radius:6px;color:#fff;font-weight:600;">Kirim Kode OTP</button>
        </form>
        <p style="margin-top:1rem;">Ingat password? <a href="{{ route('login') }}" style="color:#ff7f00;">Kembali ke Login</a></p>
    </div>
</body>
</html>
