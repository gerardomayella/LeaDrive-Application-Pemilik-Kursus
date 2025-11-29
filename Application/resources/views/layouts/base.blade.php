<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'LeadDrive' }}</title>
    
    <!-- Performance Optimization -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="preconnect" href="https://unpkg.com" crossorigin>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons (Load non-critical CSS asynchronously) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"></noscript>
    
    <style>
        :root {
            --bg-dark: #0f141a;
            --bg-card: #1e2530;
            --bg-hover: #2a3441;
            --primary: #ff7f00;
            --primary-hover: #e66a00;
            --text-main: #ffffff;
            --text-muted: #ffffff; /* All text white */
            --border-color: rgba(255, 255, 255, 0.08);
            --sidebar-width: 260px;
            --header-height: 70px;
            --glass-bg: rgba(30, 37, 48, 0.7);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-main);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Global Link Styles */
        a { color: var(--text-main); text-decoration: none; }
        a:hover { color: var(--text-main); }

        /* Layout */
        .app-wrapper {
            display: flex;
            min-height: 100vh;
            position: relative;
        }

        .sidebar {
            width: var(--sidebar-width);
            background: var(--bg-card);
            border-right: 1px solid var(--border-color);
            position: fixed;
            height: 100vh;
            z-index: 100;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-y: auto;
        }

        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            width: 100%;
        }

        .topbar {
            height: var(--header-height);
            background: rgba(15, 20, 26, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            position: sticky;
            top: 0;
            z-index: 90;
        }

        .content-area {
            padding: 2rem;
            flex: 1;
            animation: fadeIn 0.5s ease-out;
            overflow-x: hidden; /* Prevent horizontal scroll on main content */
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.active { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .sidebar-overlay {
                position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 95;
                opacity: 0; pointer-events: none; transition: opacity 0.3s;
                backdrop-filter: blur(4px);
            }
            .sidebar-overlay.active { opacity: 1; pointer-events: auto; }
            .topbar { padding: 0 1rem; }
            .content-area { padding: 1rem; }
        }

        /* Components */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.95rem;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
            text-decoration: none;
            white-space: nowrap;
            color: var(--text-main); /* Ensure buttons have white text */
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-hover));
            color: white;
            box-shadow: 0 4px 12px rgba(255, 127, 0, 0.2);
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(255, 127, 0, 0.3); }

        .btn-danger {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }
        .btn-danger:hover { background: rgba(239, 68, 68, 0.2); }

        .card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.2);
            border-color: rgba(255, 255, 255, 0.15);
        }

        /* Typography */
        h1, h2, h3 { color: var(--text-main); font-weight: 600; margin-bottom: 1rem; }
        .text-muted { color: var(--text-muted); }
        .page-title { font-size: 1.5rem; margin: 0; }

        /* Tables */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin: 0 -1.5rem; /* Negative margin to flush with card edges on mobile */
            padding: 0 1.5rem;
        }
        table { width: 100%; border-collapse: collapse; white-space: nowrap; }
        th {
            text-align: left;
            padding: 1rem;
            color: var(--text-muted);
            font-weight: 500;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        td {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-main);
        }
        tr:hover td { background: var(--bg-hover); }

        /* Forms */
        .form-control {
            width: 100%;
            padding: 0.75rem;
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            color: white;
            transition: 0.2s;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(255, 127, 0, 0.1);
        }

        /* Helpers */
        .flex { display: flex; }
        .flex-between { display: flex; justify-content: space-between; align-items: center; }
        .items-center { align-items: center; }
        .gap-2 { gap: 0.5rem; }
        .gap-4 { gap: 1rem; }
        .mb-4 { margin-bottom: 1rem; }
        .mt-4 { margin-top: 1rem; }
        
        /* Scrollbar */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: var(--bg-dark); }
        ::-webkit-scrollbar-thumb { background: #333; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #444; }

        /* Global Loading Bar */
        #nprogress-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 3px;
            background: linear-gradient(90deg, #ff7f00, #ffb255);
            z-index: 9999;
            transition: width 0.2s ease;
            box-shadow: 0 0 10px rgba(255, 127, 0, 0.5);
        }

        /* Loading Spinner for Map/Components */
        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 3px solid rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            border-top-color: var(--primary);
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
    @stack('styles')
</head>
<body class="{{ empty($hideTopbar) ? 'has-sidebar' : '' }}">
    
    @if (empty($hideTopbar))
        <div class="app-wrapper">
            <div class="sidebar-overlay" id="sidebarOverlay"></div>
            @include('partials.sidebar')
            <div class="main-content">
                @include('partials.topbar')
                <div class="content-area">
                    @yield('content')
                </div>
            </div>
        </div>
    @else
        @yield('content')
    @endif

    <div id="nprogress-bar"></div>

    <script>
        // Mobile Sidebar Toggle
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }

        // Close sidebar when clicking overlay
        document.getElementById('sidebarOverlay')?.addEventListener('click', toggleSidebar);

        // Global Loading Bar Logic
        const progressBar = document.getElementById('nprogress-bar');
        
        function startLoading() {
            progressBar.style.width = '30%';
            progressBar.style.opacity = '1';
        }

        function finishLoading() {
            progressBar.style.width = '100%';
            setTimeout(() => {
                progressBar.style.opacity = '0';
                setTimeout(() => {
                    progressBar.style.width = '0%';
                }, 200);
            }, 300);
        }

        // Hook into window load
        window.addEventListener('beforeunload', startLoading);
        
        // Hook into Fetch API
        const originalFetch = window.fetch;
        window.fetch = async function(...args) {
            startLoading();
            try {
                const response = await originalFetch(...args);
                return response;
            } finally {
                finishLoading();
            }
        };
    </script>
    
    <!-- Instant.page for hover preloading -->
    <script src="//instant.page/5.2.0" type="module" integrity="sha384-jnZyxPjiipYXnSU0ygqeac2q7CVYMbh84GO0uHNhzg8f267tpmjkfqhd0Rw0Yr+s"></script>
    
    @stack('scripts')
</body>
</html>
