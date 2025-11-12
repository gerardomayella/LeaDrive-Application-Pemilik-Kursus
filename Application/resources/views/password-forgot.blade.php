@extends('layouts.base', ['title' => 'Lupa Password - Kirim OTP', 'hideTopbar' => true])

@push('styles')
    <style>
        body { background:#1c1c1c; color:#fff; }
        .auth-shell { display:flex; align-items:center; justify-content:center; min-height: calc(100vh - 44px); }
        .card { background:#2c2c2c; padding:2rem; border-radius:10px; width:100%; max-width:420px; }
        .input { width:100%; padding:0.75rem; margin:0.5rem 0 1rem; border:1px solid #444; border-radius:6px; background:#333; color:#fff; }
        .btn { width:100%; padding:0.85rem; background:#ff7f00; border:none; border-radius:6px; color:#fff; font-weight:600; }
        .alert-success { background:#4caf50; color:#fff; padding:0.75rem; border-radius:6px; margin-bottom:1rem; }
        .alert-error { background:#ff4444; color:#fff; padding:0.75rem; border-radius:6px; margin-bottom:1rem; }
        a { color:#ff7f00; }
    </style>
@endpush

@section('content')
    <div class="auth-shell">
    <div class="card">
        <h1 style="color:#ff7f00;margin-bottom:1rem;">Lupa Password</h1>
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert-error">
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
            <input type="email" id="email" name="email" value="{{ old('email', session('email_prefill')) }}" required class="input">
            <button type="submit" class="btn">Kirim Kode OTP</button>
        </form>
        <p style="margin-top:1rem;">Ingat password? <a href="{{ route('login') }}">Kembali ke Login</a></p>
    </div>
    </div>
@endsection
