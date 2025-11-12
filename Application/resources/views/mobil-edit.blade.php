@extends('layouts.base', ['title' => 'Edit Kendaraan - LeadDrive'])

@push('styles')
    <style>
        .container { max-width:840px; margin:24px auto; padding:0 18px; }
        .shell { background:#121a22; border:1px solid #243243; border-radius:16px; padding:24px; box-shadow:0 10px 30px rgba(0,0,0,.35); }
        .title { margin:0 0 18px; color:#ffb255; font-size:22px; font-weight:800; }
        .grid { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
        .field { display:flex; flex-direction:column; gap:8px; }
        .label { font-weight:700; color:#d7dee6; }
        input[type="text"], textarea { background:#0f1923; color:#e6e6e6; border:1px solid #2b3a49; border-radius:10px; padding:12px 12px; outline:none; }
        .actions { display:flex; justify-content:space-between; margin-top:18px; }
        .btn { display:inline-flex; align-items:center; gap:8px; border:0; cursor:pointer; background:#1b2733; color:#e6e6e6; padding:10px 14px; border-radius:10px; border:1px solid #263646; text-decoration:none; font-weight:600; }
        .btn:hover { background:#213142; }
        .btn-primary { background:#ff8a00; color:#111; border-color:#ff9f33; }
        .btn-primary:hover { background:#ffa640; }
        .section { border:1px solid #2a3a4b; border-radius:12px; padding:16px; margin-bottom:16px; }
        .section h3 { margin:0 0 12px; color:#ffb255; font-size:16px; }
        .toggle { display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-top:6px; }
        .opt { background:#0f1923; border:1px solid #2b3a49; border-radius:10px; padding:12px; cursor:pointer; display:flex; align-items:center; gap:8px; justify-content:center; font-weight:700; }
        .opt.active { border-color:#ff9f33; background:#1a2430; }
        .help { color:#9fb0bf; font-size:12px; }
    </style>
@endpush

@section('content')
    <main class="container">
        <div class="shell">
            <h1 class="title">Edit Kendaraan</h1>

            @if ($errors->any())
                <div style="background:#3a260d; border:1px solid #6a4a1d; color:#ffd7a3; padding:12px; border-radius:10px; margin-bottom:12px;">
                    <ul style="margin:0; padding-left:18px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('mobil.update', $mobil->id_mobil) }}">
                @csrf
                @method('PUT')

                <div class="section">
                    <h3>Informasi Kendaraan</h3>
                    <div class="grid">
                        <div class="field">
                            <label class="label">Merk Kendaraan *</label>
                            <input type="text" name="merk" value="{{ old('merk', $mobil->merk) }}" required>
                        </div>
                        <div class="field">
                            <label class="label">Nomor STNK</label>
                            <input type="text" name="stnk" value="{{ old('stnk', $mobil->stnk) }}">
                        </div>
                    </div>
                    <div class="field" style="margin-top:12px;">
                        <label class="label">Transmisi</label>
                        <input type="hidden" name="transmisi" id="transmisi" value="{{ old('transmisi', $mobil->transmisi ?? 'manual') }}">
                        <div class="toggle">
                            <div class="opt" data-value="manual">⚙️ Manual</div>
                            <div class="opt" data-value="matic">⚙️ Matic</div>
                        </div>
                        <div class="help">Pilih jenis transmisi kendaraan</div>
                    </div>
                </div>

                <div class="actions">
                    <a class="btn" href="{{ route('mobil.index') }}">Batal</a>
                    <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </main>

    <script>
        const hidden = document.getElementById('transmisi');
        const opts = document.querySelectorAll('.opt');
        function refresh(){ opts.forEach(o=>o.classList.toggle('active', o.dataset.value===hidden.value)); }
        opts.forEach(o=>o.addEventListener('click',()=>{ hidden.value=o.dataset.value; refresh(); }));
        refresh();
    </script>
@endsection
