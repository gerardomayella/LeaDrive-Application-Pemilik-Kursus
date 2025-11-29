@extends('layouts.base', ['title' => 'Tambah Kendaraan - LeadDrive'])

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

    .toggle-group {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        background: rgba(15, 20, 26, 0.3);
        padding: 0.5rem;
        border-radius: 14px;
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .toggle-option {
        padding: 12px;
        text-align: center;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 600;
        color: #94a3b8;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .toggle-option:hover {
        background: rgba(255, 255, 255, 0.05);
        color: #cbd5e1;
    }

    .toggle-option.active {
        background: rgba(255, 127, 0, 0.15);
        color: #ff7f00;
        border: 1px solid rgba(255, 127, 0, 0.3);
    }

    .help-text {
        color: #64748b;
        font-size: 0.85rem;
        margin-top: 0.4rem;
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
            <h1 class="form-title">Tambah Kendaraan</h1>
            <p class="form-subtitle">Daftarkan kendaraan baru ke armada Anda</p>
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

        <form method="POST" action="{{ route('mobil.store') }}">
            @csrf

            <div class="section">
                <h3 class="section-title"><i class="fas fa-car"></i> Informasi Kendaraan</h3>
                
                <div class="grid-2">
                    <div class="form-group">
                        <label>Merk Kendaraan *</label>
                        <input type="text" name="merk" value="{{ old('merk') }}" class="form-control" required placeholder="Contoh: Toyota Avanza">
                    </div>
                    <div class="form-group">
                        <label>Nomor STNK</label>
                        <input type="text" name="stnk" value="{{ old('stnk') }}" class="form-control" placeholder="Nomor STNK">
                    </div>
                </div>

                <div class="form-group" style="margin-top: 1rem;">
                    <label>Jenis Transmisi</label>
                    <input type="hidden" name="transmisi" id="transmisi" value="{{ old('transmisi','manual') }}">
                    <div class="toggle-group">
                        <div class="toggle-option" data-value="manual">
                            <i class="fas fa-cog"></i> Manual
                        </div>
                        <div class="toggle-option" data-value="matic">
                            <i class="fas fa-bolt"></i> Matic
                        </div>
                    </div>
                    <div class="help-text">Pilih jenis transmisi kendaraan</div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('mobil.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Kendaraan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const hidden = document.getElementById('transmisi');
    const opts = document.querySelectorAll('.toggle-option');
    
    function refresh(){ 
        opts.forEach(o => o.classList.toggle('active', o.dataset.value === hidden.value)); 
    }
    
    opts.forEach(o => o.addEventListener('click', () => { 
        hidden.value = o.dataset.value; 
        refresh(); 
    }));
    
    refresh();
</script>
@endsection
