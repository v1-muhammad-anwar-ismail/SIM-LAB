<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Terminal Mahasiswa | SIM-LAB</title>

    <!-- Fonts & Toastify -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,600,800,900" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <style>
        :root {
            --bg-deep: #05080f;
            --panel-bg: #0a1016;
            --panel-border: #1a202c;
            --accent-cyan: #00d9ff;
            --accent-purple: #9333ea;
            --text-muted: #9ca3af;
            --text-light: #f3f4f6;
            --glow-cyan: rgba(0, 217, 255, 0.4);
        }

        body {
            background-color: var(--bg-deep);
            color: var(--text-light);
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            display: flex;
            min-height: 100vh;
        }

        a { text-decoration: none; }
        
        /* Sidebar Styling */
        #sr-sidebar {
            width: 250px;
            background-color: rgba(10, 16, 22, 0.95);
            border-right: 1px solid var(--panel-border);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            z-index: 50;
            backdrop-filter: blur(10px);
            transition: transform 0.3s ease;
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid var(--panel-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand-logo {
            font-weight: 900;
            font-style: italic;
            font-size: 1.2rem;
            letter-spacing: 2px;
            color: #fff;
        }

        .brand-logo span {
            color: var(--accent-cyan);
        }

        .sidebar-menu {
            padding: 20px 0;
            flex-grow: 1;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 15px 25px;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.2s ease;
            cursor: pointer;
            border-left: 3px solid transparent;
        }

        .menu-item svg {
            margin-right: 12px;
            stroke-width: 2;
        }

        .menu-item.active {
            color: var(--accent-cyan);
            background-color: rgba(0, 217, 255, 0.05);
            border-left-color: var(--accent-cyan);
        }

        .menu-item:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.02);
            padding-left: 30px;
        }

        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid var(--panel-border);
        }

        .logout-btn {
            background: none;
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #ef4444;
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.1);
            border-color: #ef4444;
            box-shadow: 0 0 10px rgba(239, 68, 68, 0.2);
        }

        /* Main Content Shell */
        #sr-main {
            margin-left: 250px;
            flex-grow: 1;
            padding: 40px;
            position: relative;
        }

        /* Top Bar Info */
        .top-bar {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 30px;
            gap: 15px;
        }

        .lang-switch {
            color: var(--text-muted);
            font-size: 0.8rem;
            font-weight: bold;
            border: 1px solid var(--panel-border);
            padding: 5px 10px;
            border-radius: 20px;
            transition: all 0.3s;
        }

        .lang-switch:hover {
            color: var(--accent-cyan);
            border-color: var(--accent-cyan);
        }

        .back-home {
            background-color: var(--panel-bg);
            border: 1px solid var(--panel-border);
            color: var(--text-light);
            padding: 8px 15px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: box-shadow 0.3s;
        }

        .back-home:hover {
            box-shadow: 0 0 15px var(--glow-cyan);
            border-color: var(--accent-cyan);
        }

        /* Responsive Utilities */
        .hamburger-menu {
            display: none;
            cursor: pointer;
            color: #fff;
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 100;
            transition: opacity 0.3s;
        }

        .mobile-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(3px);
            z-index: 40;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .close-sidebar-btn { display: none; background: none; border: none; color: #fff; cursor: pointer; padding: 5px; }

        @media (max-width: 900px) {
            #sr-sidebar {
                transform: translateX(-100%);
            }
            #sr-sidebar.open {
                transform: translateX(0);
            }
            #sr-main {
                margin-left: 0;
                padding: 20px;
                padding-top: 60px;
            }
            .hamburger-menu {
                display: block;
            }
            .hamburger-menu.hidden {
                opacity: 0; pointer-events: none;
            }
            .close-sidebar-btn {
                display: block;
            }
            .mobile-overlay.active {
                display: block; opacity: 1;
            }
        }

        /* Decorative Background */
        .bg-glow {
            position: fixed;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(0,217,255,0.03) 0%, transparent 70%);
            top: -200px;
            right: -200px;
            pointer-events: none;
            z-index: -1;
        }
    </style>
    @stack('styles')
</head>
<body>

    <div class="bg-glow"></div>

    <div class="bg-glow"></div>

    <!-- Overlay Atas Layar Mobile -->
    <div id="mobileOverlay" class="mobile-overlay" onclick="toggleSidebar()"></div>

    <!-- Mobile Toggle -->
    <div id="hamburgerBtn" class="hamburger-menu" onclick="toggleSidebar()">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="3" y1="12" x2="21" y2="12"></line>
            <line x1="3" y1="6" x2="21" y2="6"></line>
            <line x1="3" y1="18" x2="21" y2="18"></line>
        </svg>
    </div>

    @php
        $lang = session('locale', 'id');
        $toggleLang = $lang === 'id' ? 'en' : 'id';
        
        $mTitle = $lang === 'id' ? 'Papan Utama' : 'Dashboard';
        $mCek = $lang === 'id' ? 'Ketersediaan Alat' : 'Inventory Check';
        $mForm = $lang === 'id' ? 'Pengajuan Peminjaman' : 'Loan Request';
        $mRiwayat = $lang === 'id' ? 'Riwayat' : 'History Log';
        $mProfil = $lang === 'id' ? 'Kartu Identitas' : 'ID Card';
        $mKeluar = $lang === 'id' ? 'KELUAR' : 'LOGOUT';
    @endphp

    <!-- Sidebar -->
    <nav id="sr-sidebar">
        <div class="sidebar-header">
            <a href="/" class="brand-logo">SIM-LAB<span>UNESA</span></a>
            <button class="close-sidebar-btn" onclick="toggleSidebar()">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>

        <div class="sidebar-menu">
            <!-- Dashboard / Overview -->
            <a href="{{ route('student.dashboard', ['tab' => 'overview']) }}" class="menu-item {{ request('tab', 'overview') == 'overview' ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                {{ $mTitle }}
            </a>

            <!-- Ketersediaan -->
            <a href="{{ route('student.dashboard', ['tab' => 'ketersediaan']) }}" class="menu-item {{ request('tab') == 'ketersediaan' ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                {{ $mCek }}
            </a>

            <!-- Form -->
            <a href="{{ route('student.dashboard', ['tab' => 'pengajuan']) }}" class="menu-item {{ request('tab') == 'pengajuan' ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                {{ $mForm }}
            </a>

            <!-- Riwayat -->
            <a href="{{ route('student.dashboard', ['tab' => 'riwayat']) }}" class="menu-item {{ request('tab') == 'riwayat' ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                {{ $mRiwayat }}
            </a>

            <!-- Profil -->
            <a href="{{ route('student.dashboard', ['tab' => 'settings']) }}" class="menu-item {{ request('tab') == 'settings' ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                {{ $mProfil }}
            </a>
        </div>

        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 5px;"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                    {{ $mKeluar }}
                </button>
            </form>
        </div>
    </nav>

    <!-- Main Content Shell -->
    <main id="sr-main">
        <div class="top-bar">
            <!-- Notification Bell -->
            <div style="position: relative;" id="notifContainer">
                <a href="{{ route('notifications.index') }}" style="background: none; border: none; color: var(--text-muted); cursor: pointer; position: relative; padding: 0.5rem; transition: color 0.3s; display: flex; align-items: center; text-decoration: none;" onmouseover="this.style.color='#00d9ff'" onmouseout="this.style.color='var(--text-muted)'">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                    @if(isset($unreadNotifs) && $unreadNotifs > 0)
                        <span style="position: absolute; top: 0px; right: 0px; background: #ef4444; color: white; border-radius: 50%; min-width: 14px; height: 14px; display: flex; align-items: center; justify-content: center; font-size: 0.55rem; font-weight: 900; box-shadow: 0 0 8px rgba(239, 68, 68, 0.9); padding: 0 3px; border: 2px solid var(--body-bg);">
                            {{ $unreadNotifs > 99 ? '99+' : $unreadNotifs }}
                        </span>
                    @endif
                </a>
            </div>

            <!-- Language Switcher -->
            <a href="{{ url('/lang/'.$toggleLang) }}" class="lang-switch">LANG : {{ strtoupper($lang) }}</a>
            <!-- Back to Home -->
            <a href="/" class="back-home">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                Beranda Global
            </a>
        </div>

        <!-- Render View Disini -->
        @yield('content')

    </main>

    @stack('scripts')
    
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sr-sidebar');
            const hamburger = document.getElementById('hamburgerBtn');
            const overlay = document.getElementById('mobileOverlay');

            sidebar.classList.toggle('open');
            if(sidebar.classList.contains('open')) {
                hamburger.classList.add('hidden');
                overlay.classList.add('active');
            } else {
                hamburger.classList.remove('hidden');
                overlay.classList.remove('active');
            }
        }
    </script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        // Cyberpunk Sonner-Style Toast Function
        function showHunterToast(message, type = 'success') {
            let borderColor = type === 'success' ? 'rgba(0, 217, 255, 0.3)' : 'rgba(127, 29, 29, 0.5)';
            let textColor = type === 'success' ? '#00d9ff' : '#ef4444';
            let glowColor = type === 'success' ? 'rgba(0,217,255,0.1)' : 'rgba(239,68,68,0.1)';

            Toastify({
                text: message,
                duration: 4000,
                close: false,
                gravity: "top", 
                position: "center", 
                style: {
                    background: "rgba(2, 4, 10, 0.8)",
                    backdropFilter: "blur(12px)",
                    WebkitBackdropFilter: "blur(12px)",
                    color: textColor,
                    border: "1px solid " + borderColor,
                    boxShadow: "0 0 20px " + glowColor,
                    borderRadius: "12px",
                    fontFamily: "'Outfit', 'Inter', sans-serif",
                    fontWeight: "bold",
                    fontSize: "0.875rem",
                    letterSpacing: "0.025em",
                    padding: "16px",
                    marginTop: "60px",
                    display: "flex",
                    alignItems: "center",
                    justifyContent: "center",
                    gap: "16px"
                }
            }).showToast();
        }

        // Auto Trigger Based on Laravel Sessions & Validation Errors
        @if(session('success'))
            showHunterToast("{!! session('success') !!}", 'success');
        @endif

        @if(session('error'))
            showHunterToast("{!! session('error') !!}", 'error');
        @endif

        @if($errors->any())
            @foreach($errors->all() as $error)
                showHunterToast("{!! $error !!}", 'error');
            @endforeach
        @endif
    </script>
</body>
</html>
