@extends('layouts.base', ['title' => 'Tambah Instruktur - LeadDrive'])

@push('styles')
    <style>
        .container { max-width:840px; margin:24px auto; padding:0 18px; }
        .shell { background:#121a22; border:1px solid #243243; border-radius:16px; padding:24px; box-shadow:0 10px 30px rgba(0,0,0,.35); }
        .title { margin:0 0 18px; color:#ffb255; font-size:22px; font-weight:800; }
        .grid { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
        .field { display:flex; flex-direction:column; gap:8px; }
        .label { font-weight:700; color:#d7dee6; }
        input[type="text"], input[type="email"], input[type="password"], textarea { background:#0f1923; color:#e6e6e6; border:1px solid #2b3a49; border-radius:10px; padding:12px 12px; outline:none; }
        .actions { display:flex; justify-content:space-between; margin-top:18px; }
        .btn { display:inline-flex; align-items:center; gap:8px; border:0; cursor:pointer; background:#1b2733; color:#e6e6e6; padding:10px 14px; border-radius:10px; border:1px solid #263646; text-decoration:none; font-weight:600; }
        .btn:hover { background:#213142; }
        .btn-primary { background:#ff8a00; color:#111; border-color:#ff9f33; }
        .btn-primary:hover { background:#ffa640; }
        .section { border:1px solid #2a3a4b; border-radius:12px; padding:16px; margin-bottom:16px; }
        .section h3 { margin:0 0 12px; color:#ffb255; font-size:16px; }
        .photo { display:flex; align-items:center; gap:14px; }
        .avatar { width:72px; height:72px; border-radius:50%; background:#0f1923; border:1px solid #2b3a49; display:flex; align-items:center; justify-content:center; font-size:28px; color:#9fb0bf; overflow:hidden; }
        .help { color:#9fb0bf; font-size:12px; }
        .radios { display:flex; gap:18px; align-items:center; }
    </style>
@endpush

@section('content')
    <main class="container">
        <div class="shell">
            <h1 class="title">Tambah Instruktur</h1>

            @if ($errors->any())
                <div style="background:#3a260d; border:1px solid #6a4a1d; color:#ffd7a3; padding:12px; border-radius:10px; margin-bottom:12px;">
                    <ul style="margin:0; padding-left:18px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('instruktur.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="section">
                    <h3>Data Pribadi</h3>
                    <div class="photo">
                        <div class="avatar">
                            <img id="preview" src="{{ old('foto_profil_url') }}" alt="" style="width:100%; height:100%; object-fit:cover; display:{{ old('foto_profil_url') ? 'block' : 'none' }};" />
                            <span id="placeholder" style="display:{{ old('foto_profil_url') ? 'none' : 'block' }};">👤</span>
                        </div>
                        <div>
                            <input type="file" name="foto_profil" id="foto_profil" accept="image/png,image/jpeg">
                            <div class="help">Format: JPG, PNG (Maks 2MB)</div>
                        </div>
                    </div>
                </div>

                <div class="grid">
                    <div class="field">
                        <label class="label">Nama *</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" required>
                    </div>
                    <div class="field">
                        <label class="label">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}">
                    </div>
                </div>

                <div class="grid" style="margin-top:12px;">
                    <div class="field">
                        <label class="label">Password Akun</label>
                        <input type="password" name="password">
                    </div>
                    <div class="field">
                        <label class="label">Nomor SIM</label>
                        <input type="text" name="nomor_sim" value="{{ old('nomor_sim') }}">
                    </div>
                </div>

                <div class="section">
                    <h3>Dokumen Sertifikat</h3>
                    <div class="field">
                        <label class="label">Upload Sertifikat (Opsional)</label>
                        <input type="file" name="sertifikat" id="sertifikat" accept="image/png,image/jpeg,application/pdf">
                        <div class="help">Format: JPG, PNG, PDF (Maks 3MB)</div>
                        <div id="sertifikat_name" class="help"></div>
                    </div>
                </div>

                <div class="section">
                    <h3>Status</h3>
                    <div class="radios">
                        @php $aktif = old('status_aktif','1'); @endphp
                        <label><input type="radio" name="status_aktif" value="1" {{ $aktif==='1' ? 'checked' : '' }}> Aktif</label>
                        <label><input type="radio" name="status_aktif" value="0" {{ $aktif==='0' ? 'checked' : '' }}> Tidak Aktif</label>
                    </div>
                    <div class="help" style="margin-top:6px;">Instruktur yang tidak aktif tidak akan muncul dalam pilihan jadwal</div>
                </div>

                <div class="actions">
                    <a class="btn" href="{{ route('instruktur.index') }}">Batal</a>
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </div>
            </form>
        </div>
    </main>

    <script>
        const input = document.getElementById('foto_profil');
        const preview = document.getElementById('preview');
        const placeholder = document.getElementById('placeholder');
        const sertifikat = document.getElementById('sertifikat');
        const sertifikatName = document.getElementById('sertifikat_name');
        if (input) {
            input.addEventListener('change', function () {
                const file = this.files && this.files[0];
                if (!file) return;
                const url = URL.createObjectURL(file);
                preview.src = url;
                preview.style.display = 'block';
                placeholder.style.display = 'none';
            });
        }
        if (sertifikat) {
            sertifikat.addEventListener('change', function(){
                const f = this.files && this.files[0];
                sertifikatName.textContent = f ? ('File dipilih: ' + f.name) : '';
            });
        }
    </script>
@endsection
