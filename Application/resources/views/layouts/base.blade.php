<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'LeadDrive' }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        * { box-sizing: border-box; }
        body { margin:0; font-family: Arial, sans-serif; background:#0f141a; color:#e6e6e6; }
        .topbar { display:flex; align-items:center; justify-content:space-between; padding:14px 22px; background:#0c1117; border-bottom:1px solid #1f2a36; position:sticky; top:0; z-index:20; }
        .brand { display:flex; align-items:center; gap:10px; font-weight:800; letter-spacing:.4px; color:#ffb255; }
        .brand img { width:28px; height:28px; border-radius:6px; object-fit:cover; }
        .right { display:flex; align-items:center; gap:10px; }
        .avatar { width:36px; height:36px; border-radius:50%; border:2px solid #223140; background:#14202b; object-fit:cover; }
        .btn { display:inline-flex; align-items:center; gap:8px; border:0; cursor:pointer; background:#1b2733; color:#e6e6e6; padding:10px 14px; border-radius:10px; border:1px solid #263646; text-decoration:none; font-weight:600; }
        .btn:hover { background:#213142; }
        .btn-primary { background:#2962ff; border-color:#3d73ff; }
        .btn-primary:hover { background:#4174ff; }
        .btn-danger { background:#c73b2f; border-color:#d25a50; color:#fff; }
        .container { max-width:1040px; margin:22px auto; padding:0 18px; }
        .card-shell { background:#121a22; border:1px solid #243243; border-radius:16px; padding:26px; box-shadow:0 10px 30px rgba(0,0,0,.35); }
        .panel { background:#121a22; border:1px solid #243243; border-radius:12px; padding:18px; }
        .title-wrap { text-align:center; margin-bottom:18px; }
        .title { margin:4px 0 6px; font-size:26px; color:#ffb255; }
        .subtitle { margin:0; color:#b9c3cd; }
        
    </style>
    @stack('styles')
</head>
<body>
@if (empty($hideTopbar))
@include('partials.topbar')
@endif
<main class="container">
    @yield('content')
</main>
@stack('scripts')
</body>
</html>
