@extends('layouts.base', ['title' => 'Login - LeadDrive', 'hideTopbar' => true])

@push('styles')
    <style>
        .auth-shell {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: radial-gradient(circle at top right, #2a1b0a 0%, #0f141a 60%);
            padding: 1rem;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            background: rgba(30, 37, 48, 0.6);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
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

        .brand-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .brand-header img {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            margin-bottom: 1.5rem;
            box-shadow: 0 8px 24px rgba(255, 127, 0, 0.2);
            object-fit: cover;
        }

        .brand-header h1 {
            color: #ffffff;
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }

        .brand-header p {
            color: #94a3b8;
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .input-group {
            position: relative;
        }

        .input-group input {
            width: 100%;
            padding: 14px 16px;
            padding-left: 48px;
            background: rgba(15, 20, 26, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: #ffffff;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .input-group input:focus {
            outline: none;
            border-color: #ff7f00;
            background: rgba(15, 20, 26, 0.8);
            box-shadow: 0 0 0 4px rgba(255, 127, 0, 0.1);
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-size: 1.1rem;
            transition: color 0.2s;
        }

        .input-group input:focus + .input-icon {
            color: #ff7f00;
        }

        .actions-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            font-size: 0.9rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #94a3b8;
            cursor: pointer;
        }

        .remember-me input[type="checkbox"] {
            accent-color: #ff7f00;
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        .forgot-password {
            color: #ff7f00;
            font-weight: 500;
            transition: color 0.2s;
        }

        .forgot-password:hover {
            color: #ff9f40;
            text-decoration: underline;
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #ff7f00 0%, #ff5500 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(255, 127, 0, 0.25);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(255, 127, 0, 0.35);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .register-link {
            text-align: center;
            margin-top: 2rem;
            color: #94a3b8;
            font-size: 0.95rem;
        }

        .register-link a {
            color: #ff7f00;
            font-weight: 600;
            margin-left: 0.25rem;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        /* Alerts */
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

        .alert ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }
    </style>
@endpush

@section('content')
    <div class="auth-shell">
        <div class="login-container">
            <div class="brand-header">
                <img src="{{ asset('images/logo.jpg') }}" alt="LeadDrive Logo">
                <h1>Selamat Datang</h1>
                <p>Masuk untuk mengelola kursus Anda</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" name="email_or_phone" placeholder="Email atau Nomor HP" value="{{ old('email_or_phone') }}" required autocomplete="username">
                        <i class="fas fa-envelope input-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <input type="password" name="password" placeholder="Password" required autocomplete="current-password">
                        <i class="fas fa-lock input-icon"></i>
                    </div>
                </div>

                <div class="actions-row">
                    <label class="remember-me">
                        <input type="checkbox" name="remember" id="remember">
                        <span>Ingat saya</span>
                    </label>
                    <a href="{{ route('password.forgot.show') }}" class="forgot-password">Lupa password?</a>
                </div>

                <button type="submit" class="btn-submit">
                    Masuk ke Dashboard
                </button>
            </form>

            <div class="register-link">
                Belum punya akun? <a href="{{ route('register.step1.show') }}">Daftar sekarang</a>
            </div>
        </div>
    </div>
@endsection