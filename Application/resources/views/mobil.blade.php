@extends('layouts.base', ['title' => 'Kelola Kendaraan - LeadDrive'])

@push('styles')
<style>
    .page-container {
        padding: 2rem 1rem;
        min-height: calc(100vh - 70px);
        background: radial-gradient(circle at top right, #2a1b0a 0%, #0f141a 60%);
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2.5rem;
        flex-wrap: wrap;
        gap: 1.5rem;
        background: rgba(30, 37, 48, 0.6);
        backdrop-filter: blur(20px);
        padding: 1.5rem;
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2);
    }

    .title-section h1 {
        font-size: 1.8rem;
        font-weight: 800;
        margin-bottom: 0.25rem;
        background: linear-gradient(90deg, #fff, #ffb255);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .title-section p {
        color: #94a3b8;
        font-size: 0.95rem;
        margin: 0;
    }

    .search-bar {
        display: flex;
        gap: 0.75rem;
        background: rgba(15, 20, 26, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 0.75rem 1rem;
        border-radius: 12px;
        flex: 1;
        max-width: 400px;
        transition: all 0.3s ease;
    }

    .search-bar:focus-within {
        border-color: #ff7f00;
        box-shadow: 0 0 0 3px rgba(255, 127, 0, 0.1);
        background: rgba(15, 20, 26, 0.8);
    }

    .search-input {
        background: transparent;
        border: none;
        color: #ffffff;
        width: 100%;
        outline: none;
        font-size: 0.95rem;
    }

    .search-input::placeholder {
        color: #64748b;
    }

    .btn-add {
        background: linear-gradient(135deg, #ff7f00 0%, #ff5500 100%);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(255, 127, 0, 0.25);
        border: none;
    }

    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(255, 127, 0, 0.35);
    }

    .vehicle-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 2rem;
    }

    .vehicle-card {
        background: rgba(30, 37, 48, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 24px;
        overflow: hidden;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        backdrop-filter: blur(20px);
        animation: fadeIn 0.5s ease-out forwards;
        opacity: 0;
    }

    .vehicle-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.3);
        border-color: rgba(255, 127, 0, 0.3);
        background: rgba(30, 37, 48, 0.8);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .vehicle-image {
        height: 200px;
        background: rgba(255, 255, 255, 0.05);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .vehicle-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .vehicle-card:hover .vehicle-image img {
        transform: scale(1.05);
    }

    .vehicle-placeholder {
        font-size: 5rem;
        color: #ff7f00;
        opacity: 0.2;
    }

    .badge-transmisi {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: rgba(0, 0, 0, 0.7);
        padding: 0.4rem 0.8rem;
        border-radius: 12px;
        font-size: 0.8rem;
        color: white;
        backdrop-filter: blur(4px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 600;
    }

    .vehicle-details {
        padding: 1.75rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .vehicle-name {
        font-size: 1.35rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
        color: #ffffff;
    }

    .vehicle-meta {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
        font-size: 0.95rem;
        color: #94a3b8;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .meta-item i {
        width: 20px;
        text-align: center;
        color: #ff7f00;
        opacity: 0.8;
    }

    .vehicle-actions {
        margin-top: auto;
        display: flex;
        gap: 1rem;
        padding-top: 1.25rem;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
    }

    .btn-icon {
        flex: 1;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        background: rgba(255, 255, 255, 0.03);
        color: #cbd5e1;
        transition: all 0.2s;
        cursor: pointer;
        text-decoration: none;
        font-weight: 500;
        gap: 0.5rem;
        font-size: 0.9rem;
    }

    .btn-icon:hover {
        background: rgba(255, 255, 255, 0.08);
        color: #ffffff;
        border-color: rgba(255, 255, 255, 0.2);
    }

    .btn-icon.danger {
        flex: 0 0 42px;
    }

    .btn-icon.danger:hover {
        background: rgba(239, 68, 68, 0.15);
        color: #f87171;
        border-color: rgba(239, 68, 68, 0.3);
    }

    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 5rem 2rem;
        background: rgba(30, 37, 48, 0.6);
        border: 1px dashed rgba(255, 255, 255, 0.1);
        border-radius: 24px;
        backdrop-filter: blur(20px);
    }

    /* Modal Styles */
    .modal-backdrop {
        position: fixed; inset: 0; background: rgba(0,0,0,0.8);
        display: none; align-items: center; justify-content: center;
        z-index: 1000; backdrop-filter: blur(8px);
        opacity: 0; transition: opacity 0.3s ease;
    }
    
    .modal-backdrop.active {
        opacity: 1;
    }

    .modal-content {
        background: #1e2530;
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 24px;
        padding: 2.5rem;
        width: 100%;
        max-width: 450px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        transform: scale(0.95);
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .modal-backdrop.active .modal-content {
        transform: scale(1);
    }

    .modal-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 1rem;
    }

    .modal-text {
        color: #94a3b8;
        margin-bottom: 2rem;
        line-height: 1.6;
    }

    .modal-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
    }
</style>
@endpush

@section('content')
<div class="page-container">
    <div class="container mx-auto">
        <div class="page-header">
            <div class="title-section">
                <h1>Kelola Kendaraan</h1>
                <p>Armada kendaraan kursus Anda</p>
            </div>
            <div class="flex gap-4 items-center flex-wrap" style="flex: 1; justify-content: flex-end;">
                <form method="GET" action="{{ route('mobil.index') }}" class="search-bar">
                    <i class="fas fa-search" style="color: #64748b; padding-top: 2px;"></i>
                    <input class="search-input" type="text" name="q" value="{{ $q ?? '' }}" placeholder="Cari merk atau plat nomor...">
                </form>
                <a href="{{ route('mobil.create') }}" class="btn-add">
                    <i class="fas fa-plus"></i> Tambah Kendaraan
                </a>
            </div>
        </div>

        @if(session('success'))
            <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: #34d399; padding: 1rem; border-radius: 12px; margin-bottom: 2rem; display: flex; align-items: center; gap: 0.75rem;">
                <i class="fas fa-check-circle text-xl"></i> {{ session('success') }}
            </div>
        @endif

        <div class="vehicle-grid">
            @forelse($mobils as $m)
                <div class="vehicle-card" style="animation-delay: {{ $loop->index * 0.1 }}s">
                    <div class="vehicle-image">
                        @if($m->foto)
                            <img src="{{ asset($m->foto) }}" alt="{{ $m->merk }}">
                        @else
                            <i class="fas fa-car vehicle-placeholder"></i>
                        @endif
                        <div class="badge-transmisi">
                            {{ $m->transmisi ?? 'Manual' }}
                        </div>
                    </div>
                    <div class="vehicle-details">
                        <h3 class="vehicle-name">{{ $m->merk }}</h3>
                        <div class="vehicle-meta">
                            <div class="meta-item" title="Nomor Polisi">
                                <i class="fas fa-id-card"></i> 
                                <span>{{ $m->plat_nomor ?? 'B 1234 XYZ' }}</span>
                            </div>
                            @if($m->stnk)
                            <div class="meta-item" title="Masa Berlaku STNK">
                                <i class="fas fa-calendar-alt"></i> 
                                <span>{{ $m->stnk }}</span>
                            </div>
                            @endif
                        </div>
                        <div class="vehicle-actions">
                            <a href="{{ route('mobil.edit', $m->id_mobil) }}" class="btn-icon">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <button class="btn-icon danger" title="Hapus" 
                                    onclick="confirmDelete('{{ route('mobil.destroy', $m->id_mobil) }}', '{{ $m->merk }}')">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <div style="font-size: 4rem; margin-bottom: 1.5rem; opacity: 0.5;">🚗</div>
                    <h3 style="font-size: 1.5rem; font-weight: 700; color: #ffffff; margin-bottom: 0.5rem;">Belum Ada Kendaraan</h3>
                    <p style="color: #94a3b8; margin-bottom: 2rem;">Mulai tambahkan kendaraan untuk operasional kursus Anda.</p>
                    <a href="{{ route('mobil.create') }}" class="btn-add">
                        <i class="fas fa-plus"></i> Tambah Kendaraan Pertama
                    </a>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $mobils->links() }}
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal-backdrop">
    <div class="modal-content">
        <h3 class="modal-title">Hapus Kendaraan?</h3>
        <p class="modal-text" id="deleteMessage">Apakah Anda yakin ingin menghapus kendaraan ini?</p>
        
        <form id="deleteForm" method="POST" action="" class="modal-actions">
            @csrf
            @method('DELETE')
            <button type="button" class="btn-icon" onclick="closeModal()" style="width: auto; padding: 0.75rem 1.5rem;">Batal</button>
            <button type="submit" class="btn-icon danger" style="width: auto; padding: 0.75rem 1.5rem; background: rgba(239, 68, 68, 0.15); color: #f87171; border-color: rgba(239, 68, 68, 0.3);">Hapus</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const modal = document.getElementById('deleteModal');
    const deleteForm = document.getElementById('deleteForm');
    const deleteMessage = document.getElementById('deleteMessage');

    function confirmDelete(url, name) {
        deleteForm.action = url;
        deleteMessage.textContent = `Apakah Anda yakin ingin menghapus "${name}"? Data yang dihapus tidak dapat dikembalikan.`;
        modal.style.display = 'flex';
        setTimeout(() => modal.classList.add('active'), 10);
    }

    function closeModal() {
        modal.classList.remove('active');
        setTimeout(() => modal.style.display = 'none', 300);
    }

    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });
</script>
@endpush

@endsection
