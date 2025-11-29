<div class="topbar">
    <div class="flex items-center gap-4">
        <button class="mobile-toggle" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
        
        <div class="page-breadcrumb">
            <h2 class="page-title">{{ $title ?? 'Dashboard' }}</h2>
            <span class="current-date">{{ now()->translatedFormat('l, d F Y') }}</span>
        </div>
    </div>

    <div class="topbar-actions">
        {{-- <button class="action-btn">
            <i class="far fa-bell"></i>
            <span class="notification-dot"></span>
        </button> --}}

        @php
            $displayName = $topbarNama ?? session('kursus_nama', 'Pemilik Kursus');
            $displayFoto = $topbarFoto ?? session('kursus_foto');
            $fallbackAvatar = 'https://ui-avatars.com/api/?name='.urlencode($displayName ?: 'PK').'&background=ff7f00&color=fff';
        @endphp
        <div class="user-profile">
            <div class="user-info">
                <span class="user-name">{{ $displayName }}</span>
                <span class="user-role">Administrator</span>
            </div>
            <div class="user-avatar">
                <img src="{{ $displayFoto ?: $fallbackAvatar }}" alt="Profile">
            </div>
        </div>
    </div>
</div>

<style>
    .mobile-toggle {
        display: none;
        background: none;
        border: none;
        color: var(--text-main);
        font-size: 1.25rem;
        cursor: pointer;
        padding: 0.5rem;
    }

    .page-breadcrumb {
        display: flex;
        flex-direction: column;
    }

    .page-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin: 0;
        line-height: 1.2;
    }

    .current-date {
        font-size: 0.8rem;
        color: var(--text-muted);
    }

    .topbar-actions {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .action-btn {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--border-color);
        width: 40px;
        height: 40px;
        border-radius: 10px;
        color: var(--text-main);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        position: relative;
        transition: all 0.2s;
    }

    .action-btn:hover {
        background: var(--bg-hover);
        transform: translateY(-2px);
    }

    .notification-dot {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 8px;
        height: 8px;
        background: #ef4444;
        border-radius: 50%;
        border: 2px solid var(--bg-card);
    }

    .user-profile {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.5rem;
        border-radius: 12px;
        transition: background 0.2s;
        cursor: pointer;
    }

    .user-profile:hover {
        background: rgba(255, 255, 255, 0.05);
    }

    .user-info {
        text-align: right;
        display: flex;
        flex-direction: column;
    }

    .user-name {
        font-weight: 600;
        font-size: 0.9rem;
    }

    .user-role {
        font-size: 0.75rem;
        color: var(--text-muted);
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        overflow: hidden;
        border: 2px solid var(--primary);
    }

    .user-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    @media (max-width: 1024px) {
        .mobile-toggle { display: block; }
        .user-info { display: none; }
    }
</style>
