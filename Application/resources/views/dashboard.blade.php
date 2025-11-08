<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - LeadDrive</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        * { box-sizing: border-box; }
        body { background-color:#1c1c1c; color:#fff; font-family: Arial, sans-serif; margin:0; }
        .header { display:flex; align-items:center; justify-content:space-between; padding:16px 20px; border-bottom:1px solid #333; background:#1c1c1c; position:sticky; top:0; z-index:10; }
        .brand { display:flex; align-items:center; gap:10px; }
        .brand img { width:36px; height:36px; border-radius:6px; object-fit:cover; }
        .brand .name { color:#ff7f00; font-weight:700; letter-spacing:0.3px; }
        .actions { display:flex; align-items:center; gap:12px; }
        .icon-btn { width:38px; height:38px; display:grid; place-items:center; background:#2c2c2c; border:1px solid #3a3a3a; border-radius:8px; cursor:pointer; }
        .avatar { width:38px; height:38px; border-radius:50%; object-fit:cover; border:2px solid #3a3a3a; background:#2c2c2c; }
        .container { padding:20px; max-width:1100px; margin:0 auto; }
        .section-title { margin:18px 0 10px; color:#ccc; font-size:14px; text-transform:uppercase; letter-spacing:.4px; }
        .summary { display:grid; grid-template-columns: repeat(4, 1fr); gap:14px; }
        .card { background:#2c2c2c; border:1px solid #3a3a3a; border-radius:10px; padding:16px; }
        .card h3 { margin:0 0 8px; color:#ff7f00; font-size:16px; }
        .card p { margin:4px 0; color:#ddd; font-size:14px; }
        .menu-grid { display:grid; grid-template-columns: repeat(3, 1fr); gap:14px; }
        .menu-item { display:flex; flex-direction:column; gap:8px; padding:16px; background:#2c2c2c; border:1px solid #3a3a3a; border-radius:10px; text-decoration:none; color:#fff; transition:transform .08s ease, background .2s ease; }
        .menu-item:hover { transform: translateY(-2px); background:#303030; }
        .menu-item .title { color:#ff7f00; font-weight:600; }
        .menu-item .desc { color:#cfcfcf; font-size:13px; }
        @media (max-width: 992px) { .summary { grid-template-columns: repeat(2, 1fr); } .menu-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 560px) { .summary, .menu-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <header class="header">
        <div class="brand">
            <img src="{{ asset('images/logo.jpg') }}" alt="LeadDrive">
            <div class="name">LEADRIVE</div>
        </div>
        <div class="actions">
            <button class="icon-btn" title="Notifikasi" aria-label="Notifikasi">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="#ff7f00" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C10.34 2 9 3.34 9 5V5.29C6.72 6.15 5 8.39 5 11V16L3 18V19H21V18L19 16V11C19 8.39 17.28 6.15 15 5.29V5C15 3.34 13.66 2 12 2Z"/>
                </svg>
            </button>
            <img class="avatar" src="{{ $kursus && $kursus->foto_logo ? asset('storage/'.$kursus->foto_logo) : asset('images/logo.jpg') }}" alt="Profil Kursus">
        </div>
    </header>

    <main class="container">
        <h2 class="section-title">Ringkasan Kursus</h2>
        <section class="summary">
            <div class="card">
                <h3>Nama Kursus</h3>
                <p>{{ $summary['nama'] }}</p>
            </div>
            <div class="card">
                <h3>Status</h3>
                <p>{{ $summary['status'] }}</p>
            </div>
            <div class="card">
                <h3>Email</h3>
                <p>{{ $summary['email'] }}</p>
            </div>
            <div class="card">
                <h3>No. Telepon</h3>
                <p>{{ $summary['telepon'] }}</p>
            </div>
        </section>

        <h2 class="section-title">Kelola Kursus</h2>
        <nav class="menu-grid">
            <a href="#" class="menu-item">
                <div class="title">Tambah Profil Kursus</div>
                <div class="desc">Lengkapi identitas, alamat, jam operasional, dan logo.</div>
            </a>
            <a href="#" class="menu-item">
                <div class="title">Atur Paket Kursus</div>
                <div class="desc">Tambah/edit paket, harga, durasi, dan fasilitas.</div>
            </a>
            <a href="#" class="menu-item">
                <div class="title">Kelola Instruktur</div>
                <div class="desc">Kelola profil dan ketersediaan instruktur.</div>
            </a>
            <a href="#" class="menu-item">
                <div class="title">Pesanan Kursus</div>
                <div class="desc">Pantau pesanan, pembayaran, dan status jadwal.</div>
            </a>
            <a href="#" class="menu-item">
                <div class="title">Rating & Ulasan</div>
                <div class="desc">Tinjau kepuasan peserta dan tanggapi ulasan.</div>
            </a>
            <a href="#" class="menu-item">
                <div class="title">Kelola Kendaraan</div>
                <div class="desc">Tambah/edit kendaraan praktik dan status servis.</div>
            </a>
        </nav>
    </main>
</body>
</html>
