@extends('layouts.base', ['title' => 'Kelola Instruktur - LeadDrive'])

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

    .instructor-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 2rem;
    }

    .instructor-card {
        background: rgba(30, 37, 48, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 24px;
        overflow: hidden;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        position: relative;
        backdrop-filter: blur(20px);
        animation: fadeIn 0.5s ease-out forwards;
        opacity: 0;
    }

    .instructor-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.3);
        border-color: rgba(255, 127, 0, 0.3);
        background: rgba(30, 37, 48, 0.8);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .instructor-header {
        padding: 1.75rem;
        display: flex;
        align-items: center;
        gap: 1.25rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        background: rgba(255, 255, 255, 0.02);
        position: relative;
    }

    .instructor-avatar {
        width: 70px;
        height: 70px;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.05);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        color: #ff7f00;
        border: 1px solid rgba(255, 255, 255, 0.1);
        overflow: hidden;
    }

    .instructor-info h3 {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 0.25rem;
    }

    .instructor-info p {
        margin: 0;
        font-size: 0.9rem;
        color: #94a3b8;
    }

    .status-badge {
        position: absolute;
        top: 1.25rem;
        right: 1.25rem;
        padding: 0.35rem 0.85rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }

    .status-active {
        background: rgba(16, 185, 129, 0.15);
        color: #34d399;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .status-inactive {
        background: rgba(239, 68, 68, 0.15);
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .instructor-details {
        padding: 1.75rem;
        flex: 1;
    }

    .detail-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
        color: #cbd5e1;
        font-size: 0.95rem;
    }

    .detail-item:last-child {
        margin-bottom: 0;
    }

    .detail-item i {
        width: 24px;
        text-align: center;
        color: #ff7f00;
        opacity: 0.8;
        font-size: 1.1rem;
    }

    .instructor-actions {
        padding: 1.25rem;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        display: flex;
        gap: 1rem;
        background: rgba(0, 0, 0, 0.1);
    }

    .btn-action {
        flex: 1;
        padding: 0.75rem;
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        background: rgba(255, 255, 255, 0.03);
        color: #cbd5e1;
        font-size: 0.9rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-action:hover {
        background: rgba(255, 255, 255, 0.08);
        color: #ffffff;
        border-color: rgba(255, 255, 255, 0.2);
    }

    .btn-action.danger:hover {
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
                <h1>Kelola Instruktur</h1>
                <p>Tim pengajar kursus Anda</p>
            </div>
            <div class="flex gap-4 items-center flex-wrap" style="flex: 1; justify-content: flex-end;">
                <form method="GET" action="{{ route('instruktur.index') }}" class="search-bar">
                    <i class="fas fa-search" style="color: #64748b; padding-top: 2px;"></i>
                    <input class="search-input" type="text" name="q" value="{{ $q ?? '' }}" placeholder="Cari nama atau email...">
                </form>
                <a href="{{ route('instruktur.create') }}" class="btn-add">
                    <i class="fas fa-plus"></i> Tambah Instruktur
                </a>
            </div>
        </div>

        @if(session('success'))
            <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: #34d399; padding: 1rem; border-radius: 12px; margin-bottom: 2rem; display: flex; align-items: center; gap: 0.75rem;">
                <i class="fas fa-check-circle text-xl"></i> {{ session('success') }}
            </div>
        @endif

        <div class="instructor-grid">
            @forelse($instrukturs as $i)
                <div class="instructor-card" style="animation-delay: {{ $loop->index * 0.1 }}s">
                    <div class="status-badge {{ $i->status_aktif ? 'status-active' : 'status-inactive' }}">
                        {{ $i->status_aktif ? 'Aktif' : 'Non-aktif' }}
                    </div>
                    
                    <div class="instructor-header">
                        <div class="instructor-avatar">
                            @if($i->foto)
                                <img src="{{ asset($i->foto) }}" alt="{{ $i->nama }}" style="width:100%; height:100%; object-fit:cover;">
                            @else
                                {{ substr($i->nama, 0, 1) }}
                            @endif
                        </div>
                        <div class="instructor-info">
                            <h3>{{ $i->nama }}</h3>
                            <p>Instruktur Profesional</p>
                        </div>
                    </div>

                    <div class="instructor-details">
                        <div class="detail-item">
                            <i class="fas fa-envelope"></i>
                            <span class="truncate">{{ $i->email }}</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-phone"></i>
                            <span>{{ $i->no_telepon ?? '-' }}</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-id-card"></i>
                            <span>SIM: {{ $i->nomor_sim ?? 'Belum ada' }}</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Bergabung: {{ $i->created_at ? $i->created_at->format('d M Y') : '-' }}</span>
                        </div>
                    </div>

                    <div class="instructor-actions">
                        <a href="{{ route('instruktur.edit', $i->id_instruktur) }}" class="btn-action">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <button class="btn-action danger" onclick="confirmDelete('{{ route('instruktur.destroy', $i->id_instruktur) }}', '{{ $i->nama }}')">
                            <i class="fas fa-trash-alt"></i> Hapus
                        </button>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <div style="font-size: 4rem; margin-bottom: 1.5rem; opacity: 0.5;">👨‍🏫</div>
                    <h3 style="font-size: 1.5rem; font-weight: 700; color: #ffffff; margin-bottom: 0.5rem;">Belum Ada Instruktur</h3>
                    <p style="color: #94a3b8; margin-bottom: 2rem;">Tambahkan instruktur untuk mulai mengelola jadwal kursus.</p>
                    <a href="{{ route('instruktur.create') }}" class="btn-add">
                        <i class="fas fa-plus"></i> Tambah Instruktur Pertama
                    </a>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $instrukturs->links() }}
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="modal-backdrop">
    <div class="modal-content">
        <h3 class="modal-title">Hapus Instruktur?</h3>
        <p class="modal-text" id="deleteMessage">Apakah Anda yakin ingin menghapus data ini?</p>
        
        <form id="deleteForm" method="POST" action="" class="modal-actions">
            @csrf
            @method('DELETE')
            <button type="button" class="btn-action" onclick="closeModal()" style="width: auto; padding: 0.75rem 1.5rem;">Batal</button>
            <button type="submit" class="btn-action danger" style="width: auto; padding: 0.75rem 1.5rem; background: rgba(239, 68, 68, 0.15); color: #f87171; border-color: rgba(239, 68, 68, 0.3);">Hapus</button>
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
        deleteMessage.textContent = `Hapus instruktur "${name}"? Data yang dihapus tidak dapat dikembalikan.`;
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
