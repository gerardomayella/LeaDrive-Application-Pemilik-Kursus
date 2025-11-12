<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Kursus - LeadDrive</title>
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
        .container { max-width:1040px; margin:22px auto; padding:0 18px; }

        .shell { background:#121a22; border:1px solid #243243; border-radius:16px; padding:22px; box-shadow:0 10px 30px rgba(0,0,0,.35); }
        .title-wrap { text-align:center; margin-bottom:16px; }
        .title { margin:4px 0 6px; font-size:26px; color:#ffb255; }
        .subtitle { margin:0; color:#b9c3cd; }

        /* Filter bar */
        .filter-bar { display:flex; gap:12px; flex-wrap:wrap; background:#0f1720; border:1px solid #253347; padding:12px; border-radius:12px; }
        .select, .input { background:#1a2430; border:1px solid #2a3a4b; color:#e6e6e6; border-radius:10px; padding:10px 12px; }

        /* Horizontal summary */
        .summary { display:flex; gap:12px; overflow:auto; padding-bottom:6px; margin:14px 0 10px; }
        .chip { min-width:200px; background:#141e29; border:1px solid #2a3a4b; border-radius:12px; padding:12px; }
        .chip .label { color:#c5d0db; font-size:13px; }
        .chip .value { font-weight:800; font-size:22px; margin-top:6px; color:#57b7ff; }

        /* Orders list cards */
        .order { display:flex; align-items:stretch; justify-content:space-between; background:#0f1720; border:1px solid #253347; border-radius:14px; padding:14px; gap:16px; margin:12px 0; }
        .order .left { min-width:260px; }
        .name { font-weight:700; color:#ffb255; }
        .muted { color:#b9c3cd; font-size:14px; margin-top:6px; }
        .pill { display:inline-block; padding:6px 10px; border-radius:999px; font-size:12px; border:1px solid transparent; color:#0c1117; font-weight:700; }
        .pill-success { background:#1fd19b; border-color:#1bb989; }
        .pill-warning { background:#ffcc66; border-color:#f5b94a; }
        .pill-info { background:#57b7ff; border-color:#429fe3; }
        .pill-muted { background:#c9d3dc; border-color:#b6c2cd; }

        .chip { min-width:200px; background:#141e29; border:1px solid #2a3a4b; border-radius:12px; padding:12px; }
        .chip-success { background:#0d2a21; border-color:#1bb989; }
        .chip-warning { background:#2a2412; border-color:#f5b94a; }
        .chip-info { background:#102436; border-color:#429fe3; }
        .chip-total { background:#1a1f2a; border-color:#3a465a; }
        .grid { display:grid; grid-template-columns:repeat(3, 1fr); gap:10px; width:100%; }
        .info { background:#141e29; border:1px solid #263646; border-radius:10px; padding:10px; }
        .info .label { color:#c5d0db; font-size:12px; margin-bottom:6px; }
        .price { color:#5de39a; font-weight:800; font-size:18px; }
        .progress { position:relative; height:8px; background:#2a3a4b; border-radius:999px; overflow:hidden; }
        .progress > span { position:absolute; left:0; top:0; height:100%; background:#ff8a00; }

        .footer { display:flex; justify-content:flex-start; margin-top:16px; }

        @media (max-width: 900px) {
            .grid { grid-template-columns:1fr; }
            .order { flex-direction:column; }
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
        <a class="btn" href="{{ route('dashboard') }}">Dashboard</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn">Keluar</button>
        </form>
    </div>
</header>

<main class="container">
    <div class="shell">
        <div class="title-wrap">
            <div style="font-size:28px">🛒</div>
            <h1 class="title">Pesanan Kursus</h1>
            <p class="subtitle">Kelola pesanan kursus dari peserta</p>
        </div>

        <form method="GET" class="filter-bar">
            <select class="select" name="status_pesanan">
                <option value="">Status Pembayaran</option>
                <option value="belum membayar" {{ ($filters['status_pesanan'] ?? '')==='belum membayar' ? 'selected' : '' }}>Belum Membayar</option>
                <option value="sudah membayar" {{ ($filters['status_pesanan'] ?? '')==='sudah membayar' ? 'selected' : '' }}>Sudah Membayar</option>
            </select>
            <select class="select" name="status_kursus">
                <option value="">Status Pesanan</option>
                <option value="pending" {{ ($filters['status_kursus'] ?? '')==='pending' ? 'selected' : '' }}>Pending</option>
                <option value="on going" {{ ($filters['status_kursus'] ?? '')==='on going' ? 'selected' : '' }}>On Going</option>
                <option value="finish" {{ ($filters['status_kursus'] ?? '')==='finish' ? 'selected' : '' }}>Finish</option>
            </select>
            <select class="select" name="paket">
                <option value="">Semua Paket</option>
                @foreach ($pakets as $pkt)
                    <option value="{{ $pkt->id_paket }}" {{ ($filters['paket'] ?? '')==$pkt->id_paket ? 'selected' : '' }}>{{ $pkt->nama_paket }}</option>
                @endforeach
            </select>
            <input class="input" type="text" name="q" placeholder="Cari peserta" value="{{ $filters['q'] ?? '' }}">
            <button class="btn btn-primary" type="submit">Terapkan</button>
        </form>

        <div class="summary">
            <div class="chip chip-warning"><div class="label">Belum Membayar</div><div class="value">{{ $counts['belum_membayar'] ?? 0 }}</div></div>
            <div class="chip chip-success"><div class="label">Sudah Membayar</div><div class="value">{{ $counts['sudah_membayar'] ?? 0 }}</div></div>
            <div class="chip chip-info"><div class="label">On Going</div><div class="value">{{ $counts['on_going'] ?? 0 }}</div></div>
            <div class="chip chip-success"><div class="label">Finish</div><div class="value">{{ $counts['finish'] ?? 0 }}</div></div>
            <div class="chip chip-total"><div class="label">Total Pesanan</div><div class="value">{{ $counts['total'] ?? 0 }}</div></div>
        </div>

        @foreach ($orders as $ord)
            @php
                $jadwalTotal = $ord->jadwal->count();
                $jadwalSelesai = $ord->jadwal->where('status', 'selesai')->count();
                $progress = $jadwalTotal > 0 ? intval(($jadwalSelesai / $jadwalTotal) * 100) : 0;
                $bayarStatus = $ord->latestPembayaran?->status === 'sudah membayar' ? 'sudah membayar' : 'belum membayar';
                $bayarClass = $bayarStatus === 'sudah membayar' ? 'pill-success' : 'pill-warning';
                $statusClass = match(strtolower($ord->status_pemesanan ?? 'pending')) {
                    'finish' => 'pill-success',
                    'on going' => 'pill-info',
                    default => 'pill-warning',
                };
                $harga = $ord->paket->harga ?? 0;
            @endphp
            <div class="order">
                <div class="left">
                    <div class="name">{{ $ord->user->name ?? 'Peserta' }}</div>
                    <div class="muted">{{ $ord->user->nomor_hp ?? '-' }} • {{ $ord->user->email ?? '-' }}</div>
                </div>
                <div class="grid">
                    <div class="info">
                        <div class="label">Paket Kursus</div>
                        <div>{{ $ord->paket->nama_paket ?? '-' }}</div>
                        <div class="muted">{{ $ord->paket->jenis_kendaraan ?? '-' }}</div>
                    </div>
                    <div class="info">
                        <div class="label">Status Pembayaran</div>
                        <span class="pill {{ $bayarClass }}">{{ ucwords($bayarStatus) }}</span>
                    </div>
                    <div class="info">
                        <div class="label">Status Pesanan</div>
                        <span class="pill {{ $statusClass }}">{{ ucwords($ord->status_pemesanan ?? 'pending') }}</span>
                    </div>
                    <div class="info">
                        <div class="label">Progress</div>
                        <div class="progress"><span style="width: {{ $progress }}%"></span></div>
                        <div class="muted">{{ $jadwalSelesai }}/{{ $jadwalTotal }} sesi</div>
                    </div>
                    <div class="info">
                        <div class="label">Tanggal Pesan</div>
                        <div>{{ $ord->tanggal_pemesanan }}</div>
                    </div>
                    <div class="info" style="display:flex; align-items:center; justify-content:space-between;">
                        <div>
                            <div class="label">Total</div>
                            <div class="price">Rp {{ number_format($harga,0,',','.') }}</div>
                        </div>
                        <a href="#" class="btn btn-primary">Lihat Detail</a>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="footer">
            {{ $orders->links() }}
        </div>

        <div class="footer">
            <a class="btn" href="{{ route('dashboard') }}">Kembali ke Dashboard</a>
        </div>
    </div>
</main>
</body>
</html>
