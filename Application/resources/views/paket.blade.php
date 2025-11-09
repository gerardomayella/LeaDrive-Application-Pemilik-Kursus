<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Paket Kursus - LeadDrive</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body { margin:0; font-family: Arial, sans-serif; background:#0f141a; color:#e6e6e6; }
        .container { max-width:1040px; margin:24px auto; padding:0 18px; }
        .shell { background:#121a22; border:1px solid #243243; border-radius:16px; padding:28px; box-shadow:0 10px 30px rgba(0,0,0,.35); }
        .title-wrap { text-align:center; margin-bottom:22px; }
        .title { margin:6px 0 4px; font-size:26px; color:#ffb255; font-weight:800; }
        .subtitle { margin:0; color:#b9c3cd; }
        .actions { display:flex; align-items:center; gap:10px; margin:10px 0 22px; }
        .link { display:inline-flex; align-items:center; gap:8px; color:#ffcc8a; text-decoration:none; font-weight:700; }
        .link:hover { text-decoration:underline; }
        .empty { border:1px solid #3a4a5a; border-radius:12px; padding:38px 16px; text-align:center; background:#0f1923; }
        .empty .icon { font-size:40px; margin-bottom:12px; }
        .empty .title { color:#d7dee6; font-size:18px; margin:0 0 6px; }
        .empty .desc { color:#9fb0bf; margin:0 0 12px; }
        .btn { display:inline-flex; align-items:center; gap:8px; border:0; cursor:pointer; background:#1b2733; color:#e6e6e6; padding:10px 14px; border-radius:10px; border:1px solid #263646; text-decoration:none; font-weight:600; }
        .btn:hover { background:#213142; }
        .btn-primary { background:#ff8a00; color:#111; border-color:#ff9f33; }
        .btn-primary:hover { background:#ffa640; }
        .footer-actions { margin-top:22px; }
    </style>
</head>
<body>
    <main class="container">
        <div class="shell">
            <div class="title-wrap">
                <div class="icon">📦</div>
                <h1 class="title">Atur Paket Kursus</h1>
                <p class="subtitle">Kelola paket kursus yang ditawarkan kepada peserta</p>
            </div>

            <div class="actions">
                <a class="link" href="{{ route('paket.create') }}">＋ Tambah Paket Baru</a>
            </div>

            @if(isset($pakets) && $pakets->count())
                <div style="display:grid; gap:12px;">
                    @foreach($pakets as $p)
                        <div style="background:#0f1923; border:1px solid #2b3a49; border-radius:10px; padding:14px 16px; display:flex; justify-content:space-between; align-items:center;">
                            <div>
                                <div style="font-weight:800; color:#ffcc8a">{{ $p->nama_paket }}</div>
                                <div style="opacity:.85">Rp {{ number_format($p->harga,0,',','.') }} · {{ $p->durasi_jam }} jam</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <section class="empty">
                    <div class="icon">📦</div>
                    <h3 class="title">Belum Ada Paket Kursus</h3>
                    <p class="desc">Buat paket kursus pertama Anda untuk mulai menerima peserta</p>
                    <a class="link" href="{{ route('paket.create') }}">＋ Buat Paket Pertama</a>
                </section>
            @endif

            <div class="footer-actions">
                <a class="btn" href="{{ route('dashboard') }}">← Kembali ke Dashboard</a>
            </div>
        </div>
    </main>
</body>
</html>
