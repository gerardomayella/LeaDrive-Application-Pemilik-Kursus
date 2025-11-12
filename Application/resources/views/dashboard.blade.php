<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pemilik Kursus - LeadDrive</title>
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
        .btn-primary { background:#ff8a00; color:#111; border-color:#ff9f33; }
        .btn-primary:hover { background:#ffa640; }
        .btn-danger { background:#c73b2f; border-color:#d25a50; color:#fff; }
        .container { max-width:1040px; margin:22px auto; padding:0 18px; }

        .card-shell { background:#121a22; border:1px solid #243243; border-radius:16px; padding:26px; box-shadow:0 10px 30px rgba(0,0,0,.35); }
        .title-wrap { text-align:center; margin-bottom:18px; }
        .title { margin:4px 0 6px; font-size:26px; color:#ffb255; }
        .subtitle { margin:0; color:#b9c3cd; }

        .alert { display:flex; align-items:center; justify-content:space-between; gap:10px; background:#3a260d; border:1px solid #6a4a1d; color:#ffd7a3; padding:14px; border-radius:12px; margin:16px 0 22px; }
        .alert .left { display:flex; align-items:center; gap:10px; }

        .stats { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; margin-bottom:20px; }
        .stat { background:#1a2430; border:1px solid #2a3a4b; border-radius:12px; padding:16px; }
        .stat .label { color:#c5d0db; font-size:13px; }
        .stat .value { color:#57b7ff; font-weight:800; font-size:22px; margin-top:6px; }

        .two-col { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
        .panel { background:#121a22; border:1px solid #243243; border-radius:12px; padding:18px; }
        .panel h3 { margin:0 0 12px; color:#ffb255; }
        .menu { display:flex; flex-direction:column; gap:10px; }
        .menu a, .menu .item-disabled { display:flex; align-items:center; gap:10px; background:#1a2430; border:1px solid #2a3a4b; color:#e6e6e6; text-decoration:none; padding:12px 14px; border-radius:10px; }
        .menu a:hover { background:#202e3c; }
        .item-disabled { opacity:.6; cursor:not-allowed; }

        /* table for current activities */
        .table { width:100%; border-collapse:separate; border-spacing:0; }
        .table th, .table td { text-align:left; padding:10px 12px; border-bottom:1px solid #243243; }
        .table th { color:#c5d0db; font-weight:700; background:#101820; position:sticky; top:0; }
        .table tr:hover td { background:#16222c; }

        .footer { display:flex; justify-content:center; margin-top:20px; }

        @media (max-width: 900px) {
            .stats { grid-template-columns:1fr; }
            .two-col { grid-template-columns:1fr; }
        }
    </style>
</head>
<body>
    <header class="topbar">
        <div class="brand">
            <img src="{{ asset('images/logo.jpg') }}" alt="LeadDrive">
            LeadDrive
        </div>
        <div class="right">
            <img class="avatar" src="{{ $kursus && $kursus->foto_logo ? asset('storage/'.$kursus->foto_logo) : asset('images/logo.jpg') }}" alt="Profil Kursus">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger">Keluar</button>
            </form>
        </div>
    </header>

    <main class="container">
        <div class="card-shell">
            <div class="title-wrap">
                <div style="font-size:28px">👤</div>
                <h1 class="title">Dashboard Pemilik Kursus</h1>
                <p class="subtitle">Kelola profil dan operasional kursus mengemudi Anda</p>
            </div>

            @php $profilLengkap = (bool)($kursus->status ?? false); @endphp

            <section class="stats">
                <div class="stat">
                    <div class="label">Pesanan Hari Ini</div>
                    <div class="value">0</div>
                </div>
                <div class="stat">
                    <div class="label">Total Peserta</div>
                    <div class="value">0</div>
                </div>
                <div class="stat">
                    <div class="label">Jadwal Aktif</div>
                    <div class="value">0</div>
                </div>
            </section>

            <section class="two-col">
                <div class="panel">
                    <h3>Menu Utama</h3>
                    <div class="menu">
                        <a href="{{ route('paket.index') }}">Atur Paket Kursus</a>
                        <a href="{{ route('instruktur.index') }}">Kelola Instruktur</a>
                        <a href="{{ route('orders.index') }}">Pesanan Kursus</a>
                        <div class="item-disabled" title="Lengkapi profil terlebih dahulu">Rating & Ulasan</div>
                        <a href="{{ route('mobil.index') }}">Kelola Kendaraan</a>
                    </div>
                </div>
                <div class="panel">
                    <h3>Aktivitas Saat Ini</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Peserta</th>
                                <th>Instruktur</th>
                                <th>Paket</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="3" style="opacity:.8">Belum ada data aktivitas</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <div class="footer">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Keluar</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
