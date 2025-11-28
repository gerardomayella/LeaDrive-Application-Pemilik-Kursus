@extends('layouts.base', ['title' => 'Verifikasi OTP & Reset Password', 'hideTopbar' => true])

@push('styles')
    <style>
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: radial-gradient(circle at top right, #2a1b0a 0%, #0f141a 60%);
            padding: 1rem;
        }

        .auth-card {
            width: 100%;
            max-width: 450px;
            background: rgba(30, 37, 48, 0.6);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-title {
            font-size: 1.8rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            background: linear-gradient(90deg, #fff, #ffb255);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .auth-subtitle {
            color: #94a3b8;
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: #cbd5e1;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            background: rgba(15, 20, 26, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: #ffffff;
            font-size: 1rem;
            transition: all 0.2s ease;
            outline: none;
        }

        .form-control:focus {
            border-color: #ff7f00;
            background: rgba(15, 20, 26, 0.8);
            box-shadow: 0 0 0 4px rgba(255, 127, 0, 0.1);
        }

        .btn-primary {
            width: 100%;
            padding: 14px;
            border-radius: 12px;
            background: linear-gradient(135deg, #ff7f00 0%, #ff5500 100%);
            color: white;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            box-shadow: 0 4px 12px rgba(255, 127, 0, 0.25);
            margin-top: 1.5rem;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 127, 0, 0.35);
        }

        .auth-footer {
            margin-top: 2rem;
            text-align: center;
            font-size: 0.9rem;
            color: #94a3b8;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .auth-link {
            color: #ff7f00;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .auth-link:hover {
            color: #ff9f33;
            text-decoration: underline;
        }

        .alert {
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.2);
            color: #34d399;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #f87171;
        }
    </style>
@endpush

@section('content')
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h1 class="auth-title">Verifikasi & Reset</h1>
                <p class="auth-subtitle">Masukkan kode OTP dan buat password baru Anda.</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error">
                    <ul style="margin:0; padding-left:1rem; list-style: none;">
                        @foreach ($errors->all() as $error)
                            <li><i class="fas fa-exclamation-circle mr-2"></i> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.verify.reset') }}">
                @csrf
                <div class="form-group">
                    <label for="email" class="form-label">Email Kursus</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $email ?? '') }}" required class="form-control" placeholder="nama@email.com">
                </div>

                <div class="form-group">
                    <label for="otp" class="form-label">Kode OTP</label>
                    <input type="text" id="otp" name="otp" value="{{ old('otp') }}" required maxlength="6" class="form-control" placeholder="123456" style="letter-spacing: 2px; font-weight: 600;">
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password Baru</label>
                    <input type="password" id="password" name="password" required class="form-control" placeholder="••••••••">
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required class="form-control" placeholder="••••••••">
                </div>

                <button type="submit" class="btn-primary">
                    <i class="fas fa-lock-open"></i> Reset Password
                </button>
            </form>

            <div class="auth-footer">
                <p>Belum menerima kode? <a href="{{ route('password.forgot.show') }}" class="auth-link">Kirim ulang OTP</a></p>
                <p>Kembali ke <a href="{{ route('login') }}" class="auth-link">Login</a></p>
            </div>
        </div>
    </div>
@endsection
