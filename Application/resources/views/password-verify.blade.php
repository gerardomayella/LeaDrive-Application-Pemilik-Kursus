<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP & Reset Password</title>
</head>
<body style="background:#1c1c1c;color:#fff;font-family:Arial,sans-serif;display:flex;align-items:center;justify-content:center;min-height:100vh;margin:0;">
    <div style="background:#2c2c2c;padding:2rem;border-radius:10px;width:100%;max-width:420px;">
        <h1 style="color:#ff7f00;margin-bottom:1rem;">Verifikasi OTP</h1>
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
        <form method="POST" action="{{ route('password.verify.reset') }}">
            @csrf
            <label for="email">Email Kursus</label>
            <input type="email" id="email" name="email" value="{{ old('email', $email ?? '') }}" required style="width:100%;padding:0.75rem;margin:0.5rem 0 1rem;border:1px solid #444;border-radius:6px;background:#333;color:#fff;">

            <label for="otp">Kode OTP</label>
            <input type="text" id="otp" name="otp" value="{{ old('otp') }}" required maxlength="6" style="width:100%;padding:0.75rem;margin:0.5rem 0 1rem;border:1px solid #444;border-radius:6px;background:#333;color:#fff;">

            <label for="password">Password Baru</label>
            <input type="password" id="password" name="password" required style="width:100%;padding:0.75rem;margin:0.5rem 0 1rem;border:1px solid #444;border-radius:6px;background:#333;color:#fff;">

            <label for="password_confirmation">Konfirmasi Password Baru</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required style="width:100%;padding:0.75rem;margin:0.5rem 0 1rem;border:1px solid #444;border-radius:6px;background:#333;color:#fff;">

            <button type="submit" style="width:100%;padding:0.85rem;background:#ff7f00;border:none;border-radius:6px;color:#fff;font-weight:600;">Verifikasi & Reset Password</button>
        </form>
        <p style="margin-top:1rem;">Belum menerima kode? <a href="{{ route('password.forgot.show') }}" style="color:#ff7f00;">Kirim ulang OTP</a></p>
        <p style="margin-top:0.5rem;">Kembali ke <a href="{{ route('login') }}" style="color:#ff7f00;">Login</a></p>
    </div>
</body>
</html>
