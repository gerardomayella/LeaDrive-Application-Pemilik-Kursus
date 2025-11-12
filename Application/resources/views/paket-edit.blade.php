<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Paket Kursus - LeadDrive</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body { margin:0; font-family: Arial, sans-serif; background:#0f141a; color:#e6e6e6; }
        .container { max-width:840px; margin:24px auto; padding:0 18px; }
        .shell { background:#121a22; border:1px solid #243243; border-radius:16px; padding:24px; box-shadow:0 10px 30px rgba(0,0,0,.35); }
        .title { margin:0 0 18px; color:#ffb255; font-size:22px; font-weight:800; }
        .grid { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
        .field { display:flex; flex-direction:column; gap:8px; }
        .label { font-weight:700; color:#d7dee6; }
        input[type="text"], input[type="number"], textarea { background:#0f1923; color:#e6e6e6; border:1px solid #2b3a49; border-radius:10px; padding:12px 12px; outline:none; }
        textarea { min-height:120px; resize:vertical; }
        .actions { display:flex; justify-content:space-between; margin-top:18px; }
        .btn { display:inline-flex; align-items:center; gap:8px; border:0; cursor:pointer; background:#1b2733; color:#e6e6e6; padding:10px 14px; border-radius:10px; border:1px solid #263646; text-decoration:none; font-weight:600; }
        .btn:hover { background:#213142; }
        .btn-primary { background:#ff8a00; color:#111; border-color:#ff9f33; }
        .btn-primary:hover { background:#ffa640; }
        .toggle { display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-top:6px; }
        .opt { background:#0f1923; border:1px solid #2b3a49; border-radius:10px; padding:12px; cursor:pointer; display:flex; align-items:center; gap:8px; justify-content:center; font-weight:700; }
        .opt.active { border-color:#ff9f33; background:#1a2430; }
    </style>
</head>
<body>
    <main class="container">
        <div class="shell">
            <h1 class="title">Edit Paket Kursus</h1>

            @if ($errors->any())
                <div style="background:#3a260d; border:1px solid #6a4a1d; color:#ffd7a3; padding:12px; border-radius:10px; margin-bottom:12px;">
                    <ul style="margin:0; padding-left:18px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('paket.update', $paket->id_paket) }}">
                @csrf
                @method('PUT')

                <div class="field">
                    <label class="label">Nama Paket *</label>
                    <input type="text" name="nama_paket" value="{{ old('nama_paket', $paket->nama_paket) }}" required>
                </div>

                <div class="grid" style="margin-top:12px;">
                    <div class="field">
                        <label class="label">Harga (Rp) *</label>
                        <input type="number" name="harga" min="0" step="1000" value="{{ old('harga', $paket->harga) }}" required>
                    </div>
                    <div class="field">
                        <label class="label">Durasi Total (Jam) *</label>
                        <input type="number" name="durasi_jam" min="1" step="1" value="{{ old('durasi_jam', $paket->durasi_jam) }}" required>
                    </div>
                </div>

                <div class="field" style="margin-top:12px;">
                    <label class="label">Jenis Kendaraan *</label>
                    <input type="hidden" name="jenis_kendaraan" id="jenis_kendaraan" value="{{ old('jenis_kendaraan', $paket->jenis_kendaraan) }}">
                    <div class="toggle">
                        <div class="opt" data-value="manual">🚗 Mobil Manual</div>
                        <div class="opt" data-value="matic">🚘 Mobil Matic</div>
                    </div>
                </div>

                <div class="field" style="margin-top:12px;">
                    <label class="label">Deskripsi</label>
                    <textarea name="deskripsi">{{ old('deskripsi', $paket->deskripsi) }}</textarea>
                </div>

                <div class="actions">
                    <a class="btn" href="{{ route('paket.index') }}">Batal</a>
                    <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </main>

    <script>
        const hidden = document.getElementById('jenis_kendaraan');
        const opts = document.querySelectorAll('.opt');
        function refreshActive(){
            opts.forEach(o=>{
                o.classList.toggle('active', o.dataset.value === hidden.value);
            });
        }
        opts.forEach(o=>{
            o.addEventListener('click', ()=>{ hidden.value = o.dataset.value; refreshActive(); });
        });
        refreshActive();
    </script>
</body>
</html>
