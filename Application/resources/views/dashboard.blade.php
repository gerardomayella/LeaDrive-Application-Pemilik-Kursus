@extends('layouts.base', ['title' => 'Dashboard - LeadDrive'])

@push('styles')
<style>
    :root {
        --glass-bg: rgba(30, 37, 48, 0.5);
        --glass-border: rgba(255, 255, 255, 0.08);
        --glass-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        --primary-gradient: linear-gradient(135deg, #ff7f00 0%, #ff5500 100%);
    }

    .dashboard-container {
        padding: 1.5rem;
        min-height: calc(100vh - 70px);
        background: radial-gradient(circle at top right, #1f1508 0%, #0f141a 60%);
        font-family: 'Inter', sans-serif;
    }

    /* Welcome Section */
    .welcome-card {
        background: linear-gradient(135deg, rgba(255, 127, 0, 0.1), rgba(255, 85, 0, 0.05));
        border: 1px solid rgba(255, 127, 0, 0.2);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        backdrop-filter: blur(12px);
    }

    .welcome-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(255, 127, 0, 0.15), transparent 70%);
        pointer-events: none;
    }

    .welcome-content {
        position: relative;
        z-index: 1;
    }

    .welcome-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: #fff;
        margin-bottom: 0.5rem;
        letter-spacing: -0.02em;
    }

    .welcome-subtitle {
        color: #cbd5e1;
        font-size: 1rem;
        max-width: 600px;
        line-height: 1.5;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: var(--glass-bg);
        border: 1px solid var(--glass-border);
        border-radius: 16px;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1.25rem;
        backdrop-filter: blur(12px);
        transition: transform 0.2s, background 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        background: rgba(30, 37, 48, 0.7);
        border-color: rgba(255, 255, 255, 0.15);
    }

    .stat-icon {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .stat-info {
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .stat-label {
        color: #94a3b8;
        font-size: 0.85rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.25rem;
    }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: #fff;
        line-height: 1.1;
        min-height: 32px;
    }

    /* Main Grid */
    .main-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
    }

    .section-card {
        background: var(--glass-bg);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        display: flex;
        flex-direction: column;
        height: 100%;
        backdrop-filter: blur(12px);
        overflow: hidden;
    }

    .card-header {
        padding: 1.5rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .card-title i {
        color: #ff7f00;
    }

    .card-link {
        color: #ff7f00;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: color 0.2s;
    }

    .card-link:hover {
        color: #ff9f40;
    }

    .card-body {
        padding: 1.5rem;
    }

    /* Activity List */
    .activity-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .activity-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: rgba(255, 255, 255, 0.03);
        border-radius: 12px;
        border: 1px solid transparent;
        transition: all 0.2s;
    }

    .activity-item:hover {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(255, 255, 255, 0.1);
        transform: translateX(4px);
    }

    .activity-icon-box {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.05);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ff7f00;
        font-size: 1.1rem;
    }

    .activity-content {
        flex: 1;
    }

    .activity-text {
        color: #fff;
        font-size: 0.95rem;
        font-weight: 500;
        margin-bottom: 0.2rem;
    }

    .activity-sub {
        color: #94a3b8;
        font-size: 0.85rem;
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    /* Quick Actions */
    .quick-actions-grid {
        display: grid;
        gap: 1rem;
    }

    .quick-action-btn {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 12px;
        color: #fff;
        text-decoration: none;
        transition: all 0.2s;
    }

    .quick-action-btn:hover {
        background: rgba(255, 255, 255, 0.06);
        border-color: #ff7f00;
        transform: translateY(-2px);
    }

    .quick-icon-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
    }

    .quick-info {
        flex: 1;
    }

    .quick-name {
        font-weight: 600;
        font-size: 0.95rem;
        display: block;
        margin-bottom: 0.1rem;
    }

    .quick-desc {
        font-size: 0.8rem;
        color: #94a3b8;
    }

    /* Skeleton Loading */
    .skeleton {
        background: linear-gradient(90deg, rgba(255, 255, 255, 0.05) 25%, rgba(255, 255, 255, 0.1) 50%, rgba(255, 255, 255, 0.05) 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
        border-radius: 6px;
    }

    .skeleton-text {
        height: 1rem;
        width: 60%;
        margin-bottom: 0.5rem;
    }

    .skeleton-value {
        height: 2rem;
        width: 40%;
    }

    .skeleton-circle {
        width: 42px;
        height: 42px;
        border-radius: 10px;
    }

    @keyframes shimmer {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }

    @media (max-width: 1024px) {
        .main-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 640px) {
        .page-container { padding: 1rem; }
        .stats-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<div class="dashboard-container">
    <div class="container mx-auto">
        <!-- Welcome Banner -->
        <div class="welcome-card">
            <div class="welcome-content">
                <h1 class="welcome-title">Dashboard Overview</h1>
                <p class="welcome-subtitle">Selamat datang kembali! Berikut adalah ringkasan aktivitas dan performa kursus mengemudi Anda hari ini.</p>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(255, 127, 0, 0.15); color: #ff7f00;">
                    <i class="fas fa-receipt"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-label">Pesanan Hari Ini</span>
                    <span class="stat-value" id="stat-order-today">
                        <div class="skeleton skeleton-value"></div>
                    </span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(59, 130, 246, 0.15); color: #3b82f6;">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-label">Total Peserta</span>
                    <span class="stat-value" id="stat-total-peserta">
                        <div class="skeleton skeleton-value"></div>
                    </span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(16, 185, 129, 0.15); color: #10b981;">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-label">Jadwal Aktif</span>
                    <span class="stat-value" id="stat-jadwal-aktif">
                        <div class="skeleton skeleton-value"></div>
                    </span>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(139, 92, 246, 0.15); color: #8b5cf6;">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-label">Rating Rata-rata</span>
                    <span class="stat-value">4.8</span>
                </div>
            </div>
        </div>

        <div class="main-grid">
            <!-- Recent Activity -->
            <div class="section-card">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fas fa-history"></i> Aktivitas Terbaru
                    </div>
                    <a href="{{ route('orders.index') }}" class="card-link">Lihat Semua</a>
                </div>
                <div class="card-body">
                    <div class="activity-list" id="recent-activity-list">
                        <!-- Skeleton Items -->
                        @for($i = 0; $i < 3; $i++)
                        <div class="activity-item">
                            <div class="skeleton skeleton-circle"></div>
                            <div class="activity-content">
                                <div class="skeleton skeleton-text" style="width: 40%;"></div>
                                <div class="skeleton skeleton-text" style="width: 70%; height: 0.8rem;"></div>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="section-card">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fas fa-bolt"></i> Akses Cepat
                    </div>
                </div>
                <div class="card-body">
                    <div class="quick-actions-grid">
                        <a href="{{ route('orders.index') }}" class="quick-action-btn">
                            <div class="quick-icon-circle" style="background: rgba(255, 127, 0, 0.15); color: #ff7f00;">
                                <i class="fas fa-receipt"></i>
                            </div>
                            <div class="quick-info">
                                <span class="quick-name">Kelola Pesanan</span>
                                <span class="quick-desc">Cek pesanan & pembayaran</span>
                            </div>
                            <i class="fas fa-chevron-right" style="color: #64748b; font-size: 0.8rem;"></i>
                        </a>

                        <a href="{{ route('instruktur.index') }}" class="quick-action-btn">
                            <div class="quick-icon-circle" style="background: rgba(59, 130, 246, 0.15); color: #3b82f6;">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="quick-info">
                                <span class="quick-name">Data Instruktur</span>
                                <span class="quick-desc">Atur jadwal & tim</span>
                            </div>
                            <i class="fas fa-chevron-right" style="color: #64748b; font-size: 0.8rem;"></i>
                        </a>

                        <a href="{{ route('mobil.index') }}" class="quick-action-btn">
                            <div class="quick-icon-circle" style="background: rgba(16, 185, 129, 0.15); color: #10b981;">
                                <i class="fas fa-car"></i>
                            </div>
                            <div class="quick-info">
                                <span class="quick-name">Armada Mobil</span>
                                <span class="quick-desc">Cek kondisi kendaraan</span>
                            </div>
                            <i class="fas fa-chevron-right" style="color: #64748b; font-size: 0.8rem;"></i>
                        </a>

                        <a href="{{ route('profile.show') }}" class="quick-action-btn">
                            <div class="quick-icon-circle" style="background: rgba(139, 92, 246, 0.15); color: #8b5cf6;">
                                <i class="fas fa-id-card"></i>
                            </div>
                            <div class="quick-info">
                                <span class="quick-name">Profil Kursus</span>
                                <span class="quick-desc">Update info publik</span>
                            </div>
                            <i class="fas fa-chevron-right" style="color: #64748b; font-size: 0.8rem;"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    async function fetchDashboardSummary() {
        try {
            const response = await fetch('{{ route('dashboard.summary') }}', {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            if (!response.ok) throw new Error('Failed to fetch summary');

            const data = await response.json();
            updateDashboardStats(data.stats || {});
            updateRecentActivity(data.recent_orders || []);
        } catch (error) {
            console.error('Dashboard summary error:', error);
            // Optional: Show error state in UI
        }
    }

    function updateDashboardStats(stats) {
        const setVal = (id, val) => {
            const el = document.getElementById(id);
            if (el && val !== undefined) el.textContent = val;
        };
        setVal('stat-order-today', stats.pesanan_hari_ini);
        setVal('stat-total-peserta', stats.total_peserta);
        setVal('stat-jadwal-aktif', stats.jadwal_aktif);
    }

    function updateRecentActivity(orders) {
        const listEl = document.getElementById('recent-activity-list');
        if (!listEl) return;

        if (!orders.length) {
            listEl.innerHTML = `
                <div style="text-align: center; padding: 2rem; color: #64748b;">
                    <i class="fas fa-inbox" style="font-size: 2rem; margin-bottom: 0.5rem; opacity: 0.5;"></i>
                    <p>Belum ada aktivitas terbaru</p>
                </div>`;
            return;
        }

        listEl.innerHTML = orders.map(order => `
            <div class="activity-item">
                <div class="activity-icon-box">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="activity-content">
                    <div class="activity-text">${order.user_name || 'Peserta'}</div>
                    <div class="activity-sub">
                        <span>${order.paket || 'Paket Kursus'}</span>
                        <span>•</span>
                        <span style="color: ${order.status_color || '#f59e0b'}">${capitalize(order.status)}</span>
                    </div>
                </div>
                <div style="font-size: 0.8rem; color: #64748b;">${order.time_ago || '-'}</div>
            </div>
        `).join('');
    }

    function capitalize(text) {
        if (!text) return '';
        return text.charAt(0).toUpperCase() + text.slice(1);
    }

    // Fetch immediately on load
    document.addEventListener('DOMContentLoaded', fetchDashboardSummary);
    
    // Refresh every 30 seconds
    setInterval(fetchDashboardSummary, 30000);
</script>
@endpush
