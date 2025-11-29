@extends('layouts.base', ['title' => 'Registrasi - Data Akun Dasar | LeadDrive', 'hideTopbar' => true])

@push('styles')
    <style>
        .auth-shell {
            min-height: 100vh;
            background: radial-gradient(circle at top right, #2a1b0a 0%, #0f141a 60%);
            padding: 2rem 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .container {
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
        }
        
        /* Progress Indicator */
        .progress-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 3rem;
            position: relative;
        }

        .progress-line {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 200px;
            height: 2px;
            background: rgba(255, 255, 255, 0.1);
            z-index: 0;
        }

        .progress-step {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.1rem;
            position: relative;
            z-index: 1;
            transition: all 0.3s ease;
            margin: 0 2rem;
        }

        .step-active {
            background: linear-gradient(135deg, #ff7f00 0%, #ff5500 100%);
            color: white;
            box-shadow: 0 0 20px rgba(255, 127, 0, 0.4);
            transform: scale(1.1);
        }

        .step-pending {
            background: rgba(30, 37, 48, 0.8);
            color: #64748b;
            border: 2px solid rgba(255, 255, 255, 0.1);
        }
        
        .step-title {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .step-title h1 {
            color: #ffffff;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }

        .step-title p {
            color: #94a3b8;
            font-size: 1rem;
        }

        .form-card {
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

        .form-card h2 {
            color: #ffffff;
            font-size: 1.5rem;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.75rem;
            color: #cbd5e1;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .form-group label .required {
            color: #ff7f00;
            margin-left: 4px;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 16px;
            background: rgba(15, 20, 26, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: #ffffff;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #ff7f00;
            background: rgba(15, 20, 26, 0.8);
            box-shadow: 0 0 0 4px rgba(255, 127, 0, 0.1);
        }

        .password-requirements {
            margin-top: 1rem;
            padding: 1.25rem;
            background: rgba(15, 20, 26, 0.4);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .password-requirements h4 {
            color: #ff7f00;
            margin-bottom: 0.75rem;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .password-requirements ul {
            list-style: none;
            padding-left: 0;
            color: #94a3b8;
            font-size: 0.85rem;
            margin: 0;
        }

        .password-requirements li {
            margin-bottom: 0.4rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .password-requirements li::before {
            content: "•";
            color: #ff7f00;
            font-weight: bold;
        }

        .password-toggle {
            position: relative;
        }

        .password-toggle input {
            padding-right: 48px;
        }

        .password-toggle-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #64748b;
            font-size: 1.1rem;
            transition: color 0.2s;
            background: none;
            border: none;
            padding: 0;
        }

        .password-toggle-icon:hover {
            color: #ff7f00;
        }

        .checkbox-group {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            margin-bottom: 2rem;
            padding: 1rem;
            background: rgba(15, 20, 26, 0.4);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .checkbox-group input[type="checkbox"] {
            margin-top: 0.25rem;
            accent-color: #ff7f00;
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .checkbox-group label {
            color: #cbd5e1;
            font-size: 0.9rem;
            line-height: 1.5;
            cursor: pointer;
        }

        .checkbox-group a {
            color: #ff7f00;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .checkbox-group a:hover {
            text-decoration: underline;
            color: #ff9f40;
        }

        .btn-primary {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #ff7f00 0%, #ff5500 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(255, 127, 0, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(255, 127, 0, 0.35);
        }

        .error-message {
            color: #f87171;
            font-size: 0.85rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        @media (max-width: 768px) {
            .form-row { grid-template-columns: 1fr; gap: 0; }
            .auth-shell { padding: 1rem; }
            .form-card { padding: 1.5rem; }
            .progress-line { width: 150px; }
            .progress-step { width: 40px; height: 40px; font-size: 1rem; margin: 0 1.5rem; }
        }
    </style>
@endpush

@section('content')
    <div class="auth-shell">
        <div class="container">
            <!-- Progress Indicator -->
            <div class="progress-container">
                <div class="progress-line"></div>
                <div class="progress-step step-active">1</div>
                <div class="progress-step step-pending">2</div>
                <div class="progress-step step-pending">3</div>
            </div>

            <!-- Step Title -->
            <div class="step-title">
                <h1>Data Akun Dasar</h1>
                <p>Lengkapi informasi akun Anda untuk memulai</p>
            </div>

            <!-- Form Card -->
            <div class="form-card">
                <h2>Daftar sebagai Pemilik Kursus</h2>

                @if ($errors->any())
                    <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); color: #f87171; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem;">
                        <ul style="list-style: none; padding: 0; margin: 0;">
                            @foreach ($errors->all() as $error)
                                <li style="margin-bottom: 0.25rem; display: flex; align-items: center; gap: 0.5rem;">
                                    <i class="fas fa-exclamation-circle"></i> {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register.step1.submit') }}" method="POST">
                    @csrf
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Nama Lengkap <span class="required">*</span></label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" placeholder="Contoh: Budi Santoso" required>
                            @error('name')
                                <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email <span class="required">*</span></label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="email@contoh.com" required>
                            @error('email')
                                <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="nomor_hp">Nomor HP <span class="required">*</span></label>
                            <input type="text" id="nomor_hp" name="nomor_hp" class="form-control" value="{{ old('nomor_hp') }}" placeholder="081234567890" required>
                            @error('nomor_hp')
                                <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Password <span class="required">*</span></label>
                            <div class="password-toggle">
                                <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password kuat" required>
                                <button type="button" class="password-toggle-icon" onclick="togglePassword('password', this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password <span class="required">*</span></label>
                        <div class="password-toggle">
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                            <button type="button" class="password-toggle-icon" onclick="togglePassword('password_confirmation', this)">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="password-requirements">
                        <h4>Syarat Password:</h4>
                        <ul>
                            <li>Minimal 8 karakter</li>
                            <li>Mengandung huruf besar dan kecil</li>
                            <li>Mengandung angka</li>
                        </ul>
                    </div>

                    <div class="checkbox-group">
                        <input type="checkbox" id="terms" name="terms" value="1" required>
                        <label for="terms">
                            Saya menyetujui <a href="#">Syarat & Ketentuan</a> dan <a href="#">Kebijakan Privasi LeadDrive</a>
                        </label>
                    </div>
                    @error('terms')
                        <div class="error-message" style="margin-top: -1.5rem; margin-bottom: 1.5rem;"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror

                    <button type="submit" class="btn btn-primary">
                        Lanjutkan ke Data Kursus <i class="fas fa-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId, btnElement) {
            const input = document.getElementById(inputId);
            const icon = btnElement.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
@endsection

