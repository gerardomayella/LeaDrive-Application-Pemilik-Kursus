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
        .container { max-width:none; width:100%; margin:22px 18px; padding:0; }
        .card-shell { background:#121a22; border:1px solid #243243; border-radius:16px; padding:26px; box-shadow:0 10px 30px rgba(0,0,0,.35); }
        .panel { background:#121a22; border:1px solid #243243; border-radius:12px; padding:18px; }
        .title-wrap { text-align:center; margin-bottom:18px; }
        .title { margin:4px 0 6px; font-size:26px; color:#ffb255; }
        .subtitle { margin:0; color:#b9c3cd; }
        /* Sidebar */
        .sidebar { position:fixed; top:60px; left:0; width:64px; bottom:0; background:#0c1218; border-right:1px solid #1f2a36; padding:12px 8px; display:flex; flex-direction:column; gap:8px; z-index:30; }
        .sb-link { width:48px; height:48px; display:flex; align-items:center; justify-content:center; border-radius:12px; color:#cfe0ef; text-decoration:none; border:1px solid #233445; background:#121b25; transition:background .18s ease, border-color .18s ease, transform .06s ease; }
        .sb-link:hover { background:#182332; border-color:#2a3d51; }
        .sb-link.active { background:#23364a; border-color:#34506a; }
        .sb-bottom { margin-top:auto; }
        .has-sidebar .container { margin-left:88px; }
    
    </style>
    @stack('styles')
</head>
<body class="{{ empty($hideTopbar) ? 'has-sidebar' : '' }}">
@if (empty($hideTopbar))
@include('partials.topbar')
@include('partials.sidebar')
@endif
<main class="container">
    @yield('content')
</main>
@stack('scripts')
</body>
</html>
