@extends('layouts.base', ['title' => 'Rating & Ulasan - LeadDrive'])

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

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }

    .stat-card {
        background: rgba(30, 37, 48, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 20px;
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        backdrop-filter: blur(20px);
        transition: transform 0.3s ease;
        animation: fadeIn 0.5s ease-out forwards;
        opacity: 0;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        background: rgba(30, 37, 48, 0.8);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .stat-icon {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
        color: #ff7f00;
        width: 40px;
        height: 40px;
        background: rgba(255, 127, 0, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
    }

    .stat-label {
        color: #94a3b8;
        font-size: 0.9rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 800;
        color: #ffffff;
        line-height: 1.1;
    }

    .filters-container {
        background: rgba(30, 37, 48, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        backdrop-filter: blur(20px);
    }

    .filters-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        align-items: end;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: #cbd5e1;
        font-weight: 500;
        font-size: 0.9rem;
    }

    .form-control {
        width: 100%;
        padding: 10px 14px;
        background: rgba(15, 20, 26, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        color: #ffffff;
        font-size: 0.95rem;
        transition: all 0.2s ease;
        outline: none;
    }

    .form-control:focus {
        border-color: #ff7f00;
        background: rgba(15, 20, 26, 0.8);
        box-shadow: 0 0 0 3px rgba(255, 127, 0, 0.1);
    }

    .btn-filter {
        background: linear-gradient(135deg, #ff7f00 0%, #ff5500 100%);
        color: white;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        width: 100%;
        height: 42px;
    }

    .btn-filter:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 127, 0, 0.25);
    }

    .review-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 2rem;
    }

    .review-card {
        background: rgba(30, 37, 48, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 20px;
        padding: 1.75rem;
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
        backdrop-filter: blur(20px);
        transition: all 0.3s ease;
        animation: fadeIn 0.5s ease-out forwards;
        opacity: 0;
    }

    .review-card:hover {
        transform: translateY(-5px);
        background: rgba(30, 37, 48, 0.8);
        box-shadow: 0 15px 30px -10px rgba(0, 0, 0, 0.3);
        border-color: rgba(255, 127, 0, 0.3);
    }

    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .user-info {
        display: flex;
        gap: 0.75rem;
        align-items: center;
    }

    .user-avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2a3a4b 0%, #1a2430 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ff7f00;
        font-weight: 700;
        font-size: 1.1rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .user-details h4 {
        margin: 0;
        font-size: 1rem;
        font-weight: 600;
        color: #ffffff;
    }

    .user-details span {
        font-size: 0.8rem;
        color: #94a3b8;
    }

    .rating-badge {
        background: rgba(255, 193, 7, 0.15);
        color: #ffc107;
        padding: 0.35rem 0.75rem;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.35rem;
        border: 1px solid rgba(255, 193, 7, 0.2);
    }

    .review-content {
        color: #cbd5e1;
        font-size: 0.95rem;
        line-height: 1.6;
        flex: 1;
        font-style: italic;
        background: rgba(255, 255, 255, 0.03);
        padding: 1rem;
        border-radius: 12px;
    }

    .review-footer {
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        padding-top: 1rem;
        margin-top: auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.85rem;
        color: #94a3b8;
    }

    .instruktur-tag {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255, 255, 255, 0.05);
        padding: 0.35rem 0.85rem;
        border-radius: 20px;
        color: #cbd5e1;
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .instruktur-tag i {
        color: #ff7f00;
    }

    @media (max-width: 768px) {
        .filters-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="page-container">
    <div class="container mx-auto">
        <div class="page-header">
            <div class="title-section">
                <h1>Ulasan & Rating</h1>
                <p>Feedback dari peserta kursus Anda</p>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card" style="animation-delay: 0.1s">
                <div class="stat-icon"><i class="fas fa-star"></i></div>
                <span class="stat-label">Rata-rata Rating</span>
                <span class="stat-value">{{ number_format($stats['avg'] ?? 0, 1) }}</span>
            </div>
            <div class="stat-card" style="animation-delay: 0.2s">
                <div class="stat-icon" style="color: #3b82f6; background: rgba(59, 130, 246, 0.1);"><i class="fas fa-comment-alt"></i></div>
                <span class="stat-label">Total Ulasan</span>
                <span class="stat-value">{{ number_format($stats['count'] ?? 0) }}</span>
            </div>
            <div class="stat-card" style="animation-delay: 0.3s">
                <div class="stat-icon" style="color: #10b981; background: rgba(16, 185, 129, 0.1);"><i class="fas fa-smile"></i></div>
                <span class="stat-label">Rating 5 Bintang</span>
                <span class="stat-value">{{ number_format($stats['five'] ?? 0) }}</span>
            </div>
            <div class="stat-card" style="animation-delay: 0.4s">
                <div class="stat-icon" style="color: #ef4444; background: rgba(239, 68, 68, 0.1);"><i class="fas fa-frown"></i></div>
                <span class="stat-label">Perlu Perhatian</span>
                <span class="stat-value">{{ number_format(($stats['one'] ?? 0) + ($stats['two'] ?? 0)) }}</span>
            </div>
        </div>

        <!-- Filters -->
        <div class="filters-container">
            <form method="GET" class="filters-grid">
                <div class="form-group">
                    <label>Pencarian</label>
                    <input class="form-control" type="text" name="q" placeholder="Nama / Email..." value="{{ $filters['q'] ?? '' }}">
                </div>
                <div class="form-group">
                    <label>Instruktur</label>
                    <select class="form-control" name="instruktur" style="cursor: pointer;">
                        <option value="" style="background: #1e2530;">Semua Instruktur</option>
                        @foreach ($instrukturs as $ins)
                            <option value="{{ $ins->id_instruktur }}" {{ ($filters['instruktur'] ?? '') == $ins->id_instruktur ? 'selected' : '' }} style="background: #1e2530;">{{ $ins->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Rating</label>
                    <div class="flex gap-2">
                        <input class="form-control" type="number" name="min_rating" placeholder="Min" min="1" max="5" value="{{ $filters['min_rating'] ?? '' }}">
                        <input class="form-control" type="number" name="max_rating" placeholder="Max" min="1" max="5" value="{{ $filters['max_rating'] ?? '' }}">
                    </div>
                </div>
                <div class="form-group">
                    <label>&nbsp;</label>
                    <button class="btn-filter" type="submit">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Reviews Grid -->
        <div class="review-grid">
            @forelse ($items as $it)
                <div class="review-card" style="animation-delay: {{ $loop->index * 0.1 }}s">
                    <div class="review-header">
                        <div class="user-info">
                            <div class="user-avatar">
                                {{ substr($it->user->name ?? 'A', 0, 1) }}
                            </div>
                            <div class="user-details">
                                <h4>{{ $it->user->name ?? 'Anonim' }}</h4>
                                <span>{{ $it->tanggal ? \Carbon\Carbon::parse($it->tanggal)->diffForHumans() : '-' }}</span>
                            </div>
                        </div>
                        <div class="rating-badge">
                            <i class="fas fa-star"></i> {{ $it->rating }}
                        </div>
                    </div>

                    <div class="review-content">
                        "{{ $it->komentar ?? 'Tidak ada komentar tertulis.' }}"
                    </div>

                    <div class="review-footer">
                        <div class="instruktur-tag">
                            <i class="fas fa-chalkboard-teacher"></i>
                            {{ $it->instruktur->nama ?? 'Umum' }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12" style="grid-column: 1 / -1; padding: 5rem 2rem;">
                    <div style="font-size: 4rem; margin-bottom: 1.5rem; opacity: 0.5;">📝</div>
                    <h3 style="font-size: 1.5rem; font-weight: 700; color: #ffffff; margin-bottom: 0.5rem;">Belum ada ulasan</h3>
                    <p style="color: #94a3b8;">Ulasan dari peserta akan muncul di sini.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $items->links() }}
        </div>
    </div>
</div>
@endsection
