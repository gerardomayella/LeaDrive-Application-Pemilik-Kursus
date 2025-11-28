<div class="sidebar">
    <div class="sidebar-header">
        <div class="logo-container">
            <img src="{{ asset('images/logo.jpg') }}" alt="LeadDrive" class="logo-img">
            <span class="logo-text">LeadDrive</span>
        </div>
    </div>

    <div class="sidebar-menu">
        <div class="menu-category">Menu Utama</div>
        
        <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-pie menu-icon"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('orders.index') }}" class="menu-item {{ request()->routeIs('orders.*') ? 'active' : '' }}">
            <i class="fas fa-shopping-cart menu-icon"></i>
            <span>Pesanan</span>
            {{-- <span class="badge">3</span> --}}
        </a>

        <div class="menu-category">Manajemen</div>

        <a href="{{ route('paket.index') }}" class="menu-item {{ request()->routeIs('paket.*') ? 'active' : '' }}">
            <i class="fas fa-box-open menu-icon"></i>
            <span>Paket Kursus</span>
        </a>

        <a href="{{ route('instruktur.index') }}" class="menu-item {{ request()->routeIs('instruktur.*') ? 'active' : '' }}">
            <i class="fas fa-chalkboard-teacher menu-icon"></i>
            <span>Instruktur</span>
        </a>

        <a href="{{ route('mobil.index') }}" class="menu-item {{ request()->routeIs('mobil.*') ? 'active' : '' }}">
            <i class="fas fa-car menu-icon"></i>
            <span>Kendaraan</span>
        </a>

        <div class="menu-category">Lainnya</div>

        <a href="{{ route('ulasan.index') }}" class="menu-item {{ request()->routeIs('ulasan.*') ? 'active' : '' }}">
            <i class="fas fa-star menu-icon"></i>
            <span>Ulasan & Rating</span>
        </a>

        <a href="{{ route('profile.show') }}" class="menu-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <i class="fas fa-user-circle menu-icon"></i>
            <span>Profil Kursus</span>
        </a>
    </div>

    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span>Keluar</span>
            </button>
        </form>
    </div>
</div>

<style>
    .sidebar-header {
        height: var(--header-height);
        display: flex;
        align-items: center;
        padding: 0 1.5rem;
        border-bottom: 1px solid var(--border-color);
    }

    .logo-container {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: #ff7f00; /* Orange text */
        font-size: 1.25rem;
        font-weight: 700;
    }

    .logo-img {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        object-fit: cover;
        flex-shrink: 0;
    }

    .sidebar-menu {
        padding: 1.5rem 1rem;
        flex: 1;
        overflow-y: auto;
    }

    .menu-category {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--text-muted);
        margin: 1.5rem 0 0.5rem 0.75rem;
        font-weight: 600;
    }
    .menu-category:first-child { margin-top: 0; }

    .menu-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        color: var(--text-muted);
        transition: all 0.2s;
        margin-bottom: 0.25rem;
        font-weight: 500;
    }

    .menu-item:hover {
        background: var(--bg-hover);
        color: var(--text-main);
        transform: translateX(4px);
    }

    .menu-item.active {
        background: linear-gradient(90deg, rgba(255, 127, 0, 0.15), transparent);
        color: var(--primary);
        border-left: 3px solid var(--primary);
    }

    .menu-icon {
        width: 20px;
        text-align: center;
        font-size: 1.1rem;
    }

    .sidebar-footer {
        padding: 1rem;
        border-top: 1px solid var(--border-color);
    }

    .logout-btn {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem;
        border-radius: 8px;
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.2);
        cursor: pointer;
        transition: all 0.2s;
        font-weight: 500;
    }

    .logout-btn:hover {
        background: rgba(239, 68, 68, 0.2);
        transform: translateY(-2px);
    }
</style>
