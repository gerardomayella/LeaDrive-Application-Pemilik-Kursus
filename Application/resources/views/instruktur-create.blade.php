@extends('layouts.base', ['title' => 'Tambah Instruktur - LeadDrive'])

@push('styles')
<style>
    .page-container {
        padding: 2rem 1rem;
        min-height: calc(100vh - 70px);
        background: radial-gradient(circle at top right, #2a1b0a 0%, #0f141a 60%);
        display: flex;
        justify-content: center;
    }

    .form-card {
        background: rgba(30, 37, 48, 0.6);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 24px;
        padding: 2.5rem;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        width: 100%;
        max-width: 800px;
        animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .form-header {
        margin-bottom: 2.5rem;
        text-align: center;
    }

    .form-title {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        background: linear-gradient(90deg, #fff, #ffb255);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .form-subtitle {
        color: #94a3b8;
        font-size: 1rem;
    }

    .section {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .section-title {
        color: #ff7f00;
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    .form-group {
        margin-bottom: 1.25rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: #cbd5e1;
        font-weight: 500;
        font-size: 0.95rem;
    }

    .form-control {
        width: 100%;
        padding: 12px 16px;
        background: rgba(15, 20, 26, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        color: #ffffff;
        font-size: 0.95rem;
        transition: all 0.2s ease;
        outline: none;
    }

    .form-control:focus {
        border-color: #ff7f00;
        background: rgba(15, 20, 26, 0.8);
        box-shadow: 0 0 0 4px rgba(255, 127, 0, 0.1);
    }

    .photo-upload {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .avatar-preview {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.05);
        border: 2px solid rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: #64748b;
        overflow: hidden;
    }

    .file-input-wrapper {
        flex: 1;
    }

    .help-text {
        color: #64748b;
        font-size: 0.85rem;
        margin-top: 0.4rem;
    }

    .radio-group {
        display: flex;
        gap: 1.5rem;
    }

    .radio-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #cbd5e1;
        cursor: pointer;
    }

    .radio-label input[type="radio"] {
        accent-color: #ff7f00;
        width: 18px;
        height: 18px;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2.5rem;
    }

    .btn {
        flex: 1;
        padding: 14px;
        border-radius: 12px;
        font-weight: 600;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
        border: none;
        font-size: 1rem;
    }

    .btn-secondary {
        background: rgba(255, 255, 255, 0.05);
        color: #cbd5e1;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #ffffff;
    }

    .btn-primary {
        background: linear-gradient(135deg, #ff7f00 0%, #ff5500 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(255, 127, 0, 0.25);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(255, 127, 0, 0.35);
    }

    @media (max-width: 768px) {
        .grid-2 { grid-template-columns: 1fr; }
        .form-card { padding: 1.5rem; }
    }
</style>
@endpush

@section('content')
<div class="page-container">
    <div class="form-card">
        <div class="form-header">
            <h1 class="form-title">Tambah Instruktur</h1>
            <p class="form-subtitle">Tambahkan anggota tim pengajar baru</p>
        </div>

        @if ($errors->any())
            <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); color: #f87171; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem;">
                <ul style="margin:0; padding-left:1.25rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('instruktur.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="section">
                <h3 class="section-title"><i class="fas fa-user-circle"></i> Data Pribadi</h3>
                
                <div class="form-group">
                    <label>Foto Profil</label>
                    <div class="photo-upload">
                        <div class="avatar-preview">
                            <img id="preview" src="{{ old('foto_profil_url') }}" alt="" style="width:100%; height:100%; object-fit:cover; display:{{ old('foto_profil_url') ? 'block' : 'none' }};" />
                            <span id="placeholder" style="display:{{ old('foto_profil_url') ? 'none' : 'block' }};"><i class="fas fa-user"></i></span>
                        </div>
                        <div class="file-input-wrapper">
                            <input type="file" name="foto_profil" id="foto_profil" accept="image/png,image/jpeg" class="form-control" style="padding: 8px;">
                            <div class="help-text">Format: JPG, PNG (Maks 2MB)</div>
                        </div>
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label>Nama Lengkap *</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" class="form-control" required placeholder="Nama instruktur">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="email@contoh.com">
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label>Password Akun</label>
                        <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter">
                    </div>
                    <div class="form-group">
                        <label>Nomor SIM</label>
                        <input type="text" name="nomor_sim" value="{{ old('nomor_sim') }}" class="form-control" placeholder="Nomor SIM A/C">
                    </div>
                </div>
            </div>

            <div class="section">
                <h3 class="section-title"><i class="fas fa-certificate"></i> Dokumen & Status</h3>
                
                <div class="form-group">
                    <label>Upload Sertifikat (Opsional)</label>
                    <input type="file" name="sertifikat" id="sertifikat" accept="image/png,image/jpeg,application/pdf" class="form-control" style="padding: 8px;">
                    <div class="help-text">Format: JPG, PNG, PDF (Maks 3MB)</div>
                    <div id="sertifikat_name" class="help-text" style="color: #34d399;"></div>
                </div>

                <div class="form-group" style="margin-top: 1.5rem;">
                    <label>Status Keaktifan</label>
                    <div class="radio-group">
                        @php $aktif = old('status_aktif','1'); @endphp
                        <label class="radio-label">
                            <input type="radio" name="status_aktif" value="1" {{ $aktif==='1' ? 'checked' : '' }}> 
                            <span>Aktif</span>
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="status_aktif" value="0" {{ $aktif==='0' ? 'checked' : '' }}> 
                            <span>Tidak Aktif</span>
                        </label>
                    </div>
                    <div class="help-text">Instruktur yang tidak aktif tidak akan muncul dalam pilihan jadwal</div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('instruktur.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Instruktur
                </button>
            </div>
        </form>
    </div>
</div>

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
            if (f) {
                sertifikatName.innerHTML = '<i class="fas fa-file-alt"></i> ' + f.name;
            } else {
                sertifikatName.textContent = '';
            }
        });
    }
</script>
@endsection
