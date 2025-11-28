@extends('layouts.base', ['title' => 'Pesanan Kursus - LeadDrive'])

@push('styles')
<style>
    :root {
        --glass-bg: rgba(30, 37, 48, 0.5);
        --glass-border: rgba(255, 255, 255, 0.08);
        --glass-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        --primary-gradient: linear-gradient(135deg, #ff7f00 0%, #ff5500 100%);
    }

    .page-container {
        padding: 1.5rem;
        min-height: calc(100vh - 70px);
        background: radial-gradient(circle at top right, #1f1508 0%, #0f141a 60%);
        font-family: 'Inter', sans-serif;
    }

    /* Header Section */
    .page-header {
        margin-bottom: 2rem;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .page-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: #fff;
        letter-spacing: -0.02em;
        margin: 0;
    }

    .page-subtitle {
        color: #94a3b8;
        font-size: 0.95rem;
        margin: 0;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: var(--glass-bg);
        border: 1px solid var(--glass-border);
        border-radius: 16px;
        padding: 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        backdrop-filter: blur(12px);
        transition: transform 0.2s ease, background 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        background: rgba(30, 37, 48, 0.7);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .stat-info {
        display: flex;
        flex-direction: column;
    }

    .stat-label {
        color: #94a3b8;
        font-size: 0.8rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .stat-value {
        color: #fff;
        font-size: 1.5rem;
        font-weight: 700;
        line-height: 1.2;
    }

    /* Filters Section */
    .filters-card {
        background: var(--glass-bg);
        border: 1px solid var(--glass-border);
        border-radius: 16px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
        backdrop-filter: blur(12px);
    }

    .filters-form {
        display: grid;
        grid-template-columns: 2fr 1.5fr 1.5fr auto;
        gap: 1rem;
        align-items: end;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .form-label {
        color: #cbd5e1;
        font-size: 0.85rem;
        font-weight: 500;
        margin-left: 0.25rem;
    }

    .form-control {
        background: rgba(15, 20, 26, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #fff;
        padding: 0.75rem 1rem;
        border-radius: 10px;
        font-size: 0.9rem;
        width: 100%;
        outline: none;
        transition: all 0.2s;
    }

    .form-control:focus {
        border-color: #ff7f00;
        background: rgba(15, 20, 26, 0.8);
        box-shadow: 0 0 0 2px rgba(255, 127, 0, 0.1);
    }

    .btn-filter {
        background: var(--primary-gradient);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        height: 42px;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        white-space: nowrap;
    }

    .btn-filter:hover {
        filter: brightness(1.1);
        transform: translateY(-1px);
    }

    /* Table Section */
    .table-card {
        background: var(--glass-bg);
        border: 1px solid var(--glass-border);
        border-radius: 16px;
        overflow: hidden;
        backdrop-filter: blur(12px);
        box-shadow: var(--glass-shadow);
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        white-space: nowrap;
    }

    th {
        background: rgba(255, 255, 255, 0.03);
        color: #94a3b8;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 1rem 1.5rem;
        text-align: left;
        border-bottom: 1px solid var(--glass-border);
    }

    td {
        padding: 1rem 1.5rem;
        color: #fff;
        border-bottom: 1px solid rgba(255, 255, 255, 0.03);
        font-size: 0.9rem;
        vertical-align: middle;
    }

    tr:last-child td {
        border-bottom: none;
    }

    tr:hover td {
        background: rgba(255, 255, 255, 0.02);
    }

    /* Custom Cell Styles */
    .user-info {
        display: flex;
        flex-direction: column;
    }

    .user-name {
        font-weight: 600;
        color: #fff;
        margin-bottom: 0.15rem;
    }

    .user-meta {
        font-size: 0.8rem;
        color: #94a3b8;
    }

    .price-text {
        font-family: 'Monaco', 'Consolas', monospace;
        color: #ffb255;
        font-weight: 600;
    }

    /* Badges */
    .badge {
        padding: 0.35rem 0.75rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        letter-spacing: 0.02em;
    }

    .badge-success { background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.2); }
    .badge-warning { background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.2); }
    .badge-info { background: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.2); }
    .badge-purple { background: rgba(139, 92, 246, 0.15); color: #a78bfa; border: 1px solid rgba(139, 92, 246, 0.2); }

    /* Progress Bar */
    .progress-container {
        min-width: 140px;
    }

    .progress-labels {
        display: flex;
        justify-content: space-between;
        font-size: 0.75rem;
        color: #94a3b8;
        margin-bottom: 0.35rem;
    }

    .progress-track {
        height: 6px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 3px;
        overflow: hidden;
    }

    .progress-bar {
        height: 100%;
        background: var(--primary-gradient);
        border-radius: 3px;
        transition: width 0.5s ease;
    }

    /* Action Button */
    .btn-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.05);
        color: #94a3b8;
        transition: all 0.2s;
        border: 1px solid transparent;
    }

    .btn-icon:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
        border-color: rgba(255, 255, 255, 0.1);
    }

    /* Responsive Adjustments */
    @media (max-width: 1024px) {
        .filters-form {
            grid-template-columns: 1fr 1fr;
        }
        .btn-filter {
            grid-column: span 2;
            justify-content: center;
        }
    }

    @media (max-width: 640px) {
        .page-container { padding: 1rem; }
        .filters-form { grid-template-columns: 1fr; }
        .btn-filter { grid-column: span 1; }
        
        .stat-card { padding: 1rem; }
        .stat-icon { width: 40px; height: 40px; font-size: 1rem; }
        .stat-value { font-size: 1.25rem; }
    }
</style>
@endpush

@section('content')
<div class="page-container">
    <div class="container mx-auto">
        <!-- Header -->
        <div class="page-header">
            <h1 class="page-title">Pesanan Kursus</h1>
            <p class="page-subtitle">Kelola dan pantau perkembangan peserta kursus Anda.</p>
        </div>

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1); color: #fbbf24;">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-label">Belum Bayar</span>
                    <span class="stat-value">{{ $counts['belum_membayar'] ?? 0 }}</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: #34d399;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-label">Lunas</span>
                    <span class="stat-value">{{ $counts['sudah_membayar'] ?? 0 }}</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(59, 130, 246, 0.1); color: #60a5fa;">
                    <i class="fas fa-spinner"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-label">Berjalan</span>
                    <span class="stat-value">{{ $counts['on_going'] ?? 0 }}</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(139, 92, 246, 0.1); color: #a78bfa;">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-label">Selesai</span>
                    <span class="stat-value">{{ $counts['finish'] ?? 0 }}</span>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="filters-card">
            <form method="GET" class="filters-form">
                <div class="form-group">
                    <label class="form-label">Pencarian</label>
                    <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" class="form-control" placeholder="Nama peserta atau ID...">
                </div>
                <div class="form-group">
                    <label class="form-label">Status Pembayaran</label>
                    <select name="status_pesanan" class="form-control" style="cursor: pointer;">
                        <option value="" style="background: #1e2530;">Semua</option>
                        <option value="belum membayar" {{ ($filters['status_pesanan'] ?? '')==='belum membayar' ? 'selected' : '' }} style="background: #1e2530;">Belum Membayar</option>
                        <option value="sudah membayar" {{ ($filters['status_pesanan'] ?? '')==='sudah membayar' ? 'selected' : '' }} style="background: #1e2530;">Sudah Membayar</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Status Kursus</label>
                    <select name="status_kursus" class="form-control" style="cursor: pointer;">
                        <option value="" style="background: #1e2530;">Semua</option>
                        <option value="pending" {{ ($filters['status_kursus'] ?? '')==='pending' ? 'selected' : '' }} style="background: #1e2530;">Pending</option>
                        <option value="on going" {{ ($filters['status_kursus'] ?? '')==='on going' ? 'selected' : '' }} style="background: #1e2530;">On Going</option>
                        <option value="finish" {{ ($filters['status_kursus'] ?? '')==='finish' ? 'selected' : '' }} style="background: #1e2530;">Finish</option>
                    </select>
                </div>
                <button type="submit" class="btn-filter">
                    <i class="fas fa-filter"></i> Filter Data
                </button>
            </form>
        </div>

        <!-- Table -->
        <div class="table-card">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th style="padding-left: 2rem;">Peserta</th>
                            <th>Paket</th>
                            <th>Pembayaran</th>
                            <th>Status</th>
                            <th>Progress</th>
                            <th style="text-align: right; padding-right: 2rem;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $ord)
                            @php
                                $jadwalTotal = $ord->jadwal->count();
                                $jadwalSelesai = $ord->jadwal->where('status', 'selesai')->count();
                                $progress = $jadwalTotal > 0 ? intval(($jadwalSelesai / $jadwalTotal) * 100) : 0;
                                $bayarStatus = $ord->latestPembayaran?->status === 'sudah membayar' ? 'sudah membayar' : 'belum membayar';
                                $statusKursus = strtolower($ord->status_pemesanan ?? 'pending');
                            @endphp
                            <tr>
                                <td style="padding-left: 2rem;">
                                    <div class="user-info">
                                        <div class="user-name">{{ $ord->user->name ?? 'Peserta' }}</div>
                                        <div class="user-meta">{{ \Carbon\Carbon::parse($ord->tanggal_pemesanan)->format('d M Y') }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="user-info">
                                        <div class="user-name">{{ $ord->paket->nama_paket ?? '-' }}</div>
                                        <div class="price-text">Rp {{ number_format($ord->paket->harga ?? 0, 0, ',', '.') }}</div>
                                    </div>
                                </td>
                                <td>
                                    @if($bayarStatus === 'sudah membayar')
                                        <span class="badge badge-success"><i class="fas fa-check"></i> Lunas</span>
                                    @else
                                        <span class="badge badge-warning"><i class="fas fa-clock"></i> Belum Bayar</span>
                                    @endif
                                </td>
                                <td>
                                    @if($statusKursus === 'finish')
                                        <span class="badge badge-purple">Selesai</span>
                                    @elseif($statusKursus === 'on going')
                                        <span class="badge badge-info">Berjalan</span>
                                    @else
                                        <span class="badge badge-warning">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="progress-container">
                                        <div class="progress-labels">
                                            <span>{{ $progress }}%</span>
                                            <span>{{ $jadwalSelesai }}/{{ $jadwalTotal }}</span>
                                        </div>
                                        <div class="progress-track">
                                            <div class="progress-bar" style="width: {{ $progress }}%;"></div>
                                        </div>
                                    </div>
                                </td>
                                <td style="text-align: right; padding-right: 2rem;">
                                    <a href="#" class="btn-icon" title="Lihat Detail">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 4rem;">
                                    <div style="color: #94a3b8; font-size: 0.95rem;">
                                        <i class="fas fa-inbox" style="font-size: 2rem; margin-bottom: 0.5rem; display: block; opacity: 0.5;"></i>
                                        Belum ada data pesanan
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
