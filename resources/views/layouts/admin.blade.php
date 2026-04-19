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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
            overflow-y: auto;
        }

        .sidebar-menu::-webkit-scrollbar { width: 4px; }
        .sidebar-menu::-webkit-scrollbar-track { background: transparent; }
        .sidebar-menu::-webkit-scrollbar-thumb { background: rgba(0, 217, 255, 0.2); border-radius: 10px; }
        .sidebar-menu::-webkit-scrollbar-thumb:hover { background: rgba(0, 217, 255, 0.5); }

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
            justify-content: space-between; /* Membuat gap maksimal antara Kiri dan Kanan */
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(0, 217, 255, 0.1);
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

        .mobile-overlay.active {
            display: block; opacity: 1;
        }

        .hunter-top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            width: 100%;
            box-sizing: border-box;
        }

        .hunter-role-badge {
            background: rgba(0,217,255,0.1); 
            color: var(--accent-cyan); 
            border: 1px solid rgba(0,217,255,0.3); 
            font-size: 0.8rem; 
            font-weight: 800; 
            padding: 0.5rem 1rem; 
            border-radius: 8px; 
            letter-spacing: 0.05em; 
            text-transform: uppercase;
            display: flex;
            align-items: center;
        }

        .hunter-top-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        @media (max-width: 900px) {
            #sr-sidebar { transform: translateX(-100%); }
            #sr-sidebar.open { transform: translateX(0); }
            #sr-main {
                margin-left: 0;
                padding: 15px;
                padding-top: 60px;
                width: 100%;
                box-sizing: border-box;
                overflow-x: hidden;
            }
            .hamburger-menu { display: block; }
            .hamburger-menu.hidden { opacity: 0; pointer-events: none; }
            .close-sidebar-btn { display: block; }
            .mobile-overlay.active { display: block; opacity: 1; }
            
            /* Responsive Header Reverse Trick */
            .hunter-top-bar {
                flex-direction: column-reverse;
                gap: 1.2rem;
                align-items: stretch;
            }
            .hunter-top-actions {
                justify-content: flex-end; /* Dorong notif ke kanan atas */
            }
            .hunter-role-badge {
                justify-content: center;
                text-align: center;
                font-size: 0.75rem;
            }
            .back-home span {
                display: none; /* Sembunyikan teks 'Beranda Global' agar muat di HP, sisakan icon */
            }

            /* Responsive Table Trick (No Scroll, Card Layout) */
            .responsive-table {
                display: block;
                width: 100%;
            }
            .responsive-table thead {
                display: none; /* Sembunyikan Header */
            }
            .responsive-table tbody, .responsive-table tr, .responsive-table td {
                display: block;
                width: 100%;
            }
            .responsive-table tr {
                margin-bottom: 1rem;
                background: rgba(10, 16, 22, 0.8);
                border: 1px solid var(--panel-border);
                border-radius: 12px;
                padding: 1rem;
                box-sizing: border-box;
            }
            .responsive-table td {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                padding: 0.5rem 0 !important;
                border-bottom: 1px dashed rgba(255,255,255,0.05); /* Garis pisah dalam card */
                text-align: left !important;
                box-sizing: border-box;
            }
            .responsive-table td:last-child {
                border-bottom: none;
            }
            .responsive-table td::before {
                content: attr(data-label);
                font-size: 0.7rem;
                text-transform: uppercase;
                color: var(--text-muted);
                margin-bottom: 0.3rem;
                font-weight: 800;
                letter-spacing: 0.05em;
            }

            /* Responsive Buttons */
            .mobile-full-btn {
                width: 100%;
                text-align: center;
                display: block;
                box-sizing: border-box;
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
        
        /* SweetAlert Cyberpunk Theme */
        .hunter-swal-popup {
            border: 1px solid rgba(0, 217, 255, 0.3) !important;
            box-shadow: 0 0 30px rgba(0, 217, 255, 0.15) !important;
            border-radius: 12px !important;
        }
        .hunter-swal-title {
            color: #00d9ff !important;
            font-family: 'Inter', sans-serif !important;
            font-weight: 800 !important;
        }
        .hunter-swal-confirm-btn {
            background: transparent !important;
            border: 1px solid #ef4444 !important;
            color: #ef4444 !important;
            border-radius: 8px !important;
            font-weight: bold !important;
            transition: all 0.3s !important;
        }
        .hunter-swal-confirm-btn:hover {
            background: rgba(239, 68, 68, 0.1) !important;
        }
        .hunter-swal-cancel-btn {
            background: transparent !important;
            border: 1px solid rgba(255,255,255,0.2) !important;
            color: #fff !important;
            border-radius: 8px !important;
            font-weight: bold !important;
            transition: all 0.3s !important;
        }
        .hunter-swal-cancel-btn:hover {
            background: rgba(255, 255, 255, 0.1) !important;
        }

        /* ---------------------------------
           🎯 SONNER-STYLE TOASTIFY CLASSES
           --------------------------------- */
        .hunter-toast {
            display: flex !important;
            align-items: center !important;
            gap: 16px !important;
            padding: 16px 24px !important;
            border: 1px solid var(--accent-cyan) !important;
            box-shadow: 0 0 30px rgba(0, 217, 255, 0.15) !important;
            background: rgba(2, 4, 10, 0.9) !important;
            color: var(--accent-cyan) !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
            border-radius: 12px !important;
            font-family: 'Outfit', 'Inter', sans-serif !important;
            font-weight: bold !important;
            font-size: 0.95rem !important;
            letter-spacing: 0.025em !important;
            margin-top: 100px !important; /* Offset from header */
            box-sizing: border-box !important;
            z-index: 99999 !important;
            min-width: 300px !important;
            justify-content: center !important;
        }

        .hunter-toast.hunter-toast-error {
            border-color: #ef4444 !important;
            box-shadow: 0 0 30px rgba(239, 68, 68, 0.15) !important;
            color: #ef4444 !important;
            background: rgba(2, 4, 10, 0.95) !important;
        }

    </style>
    @stack('styles')
</head>
<body>

    <div class="bg-glow"></div>

    <div class="bg-glow"></div>

    <!-- Overlay Atas Layar Mobile -->
    <div id="mobileOverlay" class="mobile-overlay" onclick="toggleSidebar()"></div>

    @php
        $lang = session('locale', 'id');
        $toggleLang = $lang === 'id' ? 'en' : 'id';
        
        $mTitle = $lang === 'id' ? 'Papan Utama' : 'Dashboard';
        $mCek = $lang === 'id' ? 'Ketersediaan Alat' : 'Inventory Check';
        $mForm = $lang === 'id' ? 'Pengajuan Peminjaman' : 'Loan Request';
        $mRiwayat = $lang === 'id' ? 'Riwayat' : 'History Log';
        $mProfil = $lang === 'id' ? 'Kartu Identitas' : 'ID Card';
        $mKeluar = $lang === 'id' ? 'KELUAR' : 'LOGOUT';

        $dashboardRoute = 'student.dashboard';
        if (Auth::check()) {
            if (Auth::user()->role === 'master') $dashboardRoute = 'master.dashboard';
            elseif (Auth::user()->role === 'admin') $dashboardRoute = 'admin.dashboard';
            elseif (Auth::user()->role === 'asisten') $dashboardRoute = 'asisten.dashboard';
            elseif (Auth::user()->role === 'dosen') $dashboardRoute = 'dosen.dashboard';
        }
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
            <!-- Dashboard Pusat -->
            <a href="{{ route($dashboardRoute) }}" class="menu-item {{ request()->routeIs($dashboardRoute) && (!request()->has('tab') || request('tab') == 'overview') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                {{ $lang === 'id' ? 'Pusat Komando' : 'Command Center' }}
            </a>

            @if(Auth::user()->role === 'admin')
                <!-- Menu Eksklusif Admin -->
                <a href="{{ route($dashboardRoute, ['tab' => 'users']) }}" class="menu-item {{ request('tab') == 'users' ? 'active' : '' }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    {{ $lang === 'id' ? 'Manajemen Pengguna' : 'User Management' }}
                </a>
                <a href="{{ route($dashboardRoute, ['tab' => 'logs']) }}" class="menu-item {{ request('tab') == 'logs' ? 'active' : '' }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="12" y1="18" x2="12" y2="12"></line><line x1="9" y1="15" x2="15" y2="15"></line></svg>
                    {{ $lang === 'id' ? 'Radar Forensik Log' : 'Forensic Log Radar' }}
                </a>
            @endif

            @if(in_array(Auth::user()->role, ['master', 'asisten']))
                <!-- Menu Eksklusif Operasional Lab -->
                <a href="{{ route($dashboardRoute, ['tab' => 'approvals']) }}" class="menu-item {{ request('tab') == 'approvals' ? 'active' : '' }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    {{ $lang === 'id' ? 'Persetujuan (ACC)' : 'Approvals' }}
                </a>
                @if(Auth::user()->role !== 'master')
                <a href="{{ route($dashboardRoute, ['tab' => 'returns']) }}" class="menu-item {{ request('tab') == 'returns' ? 'active' : '' }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"><polyline points="9 10 4 15 9 20"></polyline><path d="M20 4v7a4 4 0 0 1-4 4H4"></path></svg>
                    {{ $lang === 'id' ? 'Pengembalian' : 'Returns' }}
                </a>
                @endif
                <a href="{{ route($dashboardRoute, ['tab' => 'schedule']) }}" class="menu-item {{ request('tab') == 'schedule' ? 'active' : '' }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                    {{ $lang === 'id' ? 'Agenda Kalender' : 'Schedule' }}
                </a>
                <a href="{{ route($dashboardRoute, ['tab' => 'inventory']) }}" class="menu-item {{ request('tab') == 'inventory' ? 'active' : '' }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                    {{ $lang === 'id' ? 'Gudang Inventaris' : 'Inventory' }}
                </a>
                <a href="{{ route($dashboardRoute, ['tab' => 'riwayat']) }}" class="menu-item {{ request('tab') == 'riwayat' ? 'active' : '' }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="12" y1="18" x2="12" y2="12"></line><line x1="9" y1="15" x2="15" y2="15"></line></svg>
                    {{ $lang === 'id' ? 'Riwayat Aktivitas' : 'Audit Logs' }}
                </a>
                <a href="{{ route($dashboardRoute, ['tab' => 'maintenance']) }}" class="menu-item {{ request('tab') == 'maintenance' ? 'active' : '' }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>
                    {{ $lang === 'id' ? 'Logistik Perbaikan' : 'Maintenance' }}
                </a>
            @endif

            @if(Auth::user()->role === 'master')
                <!-- Menu Eksklusif Master Lab -->
                <a href="{{ route($dashboardRoute, ['tab' => 'laboratories']) }}" class="menu-item {{ request('tab') == 'laboratories' ? 'active' : '' }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
                    {{ $lang === 'id' ? 'Data Laboratorium' : 'Laboratory Data' }}
                </a>
                <a href="{{ route($dashboardRoute, ['tab' => 'aslab_management']) }}" class="menu-item {{ request('tab') == 'aslab_management' ? 'active' : '' }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    {{ $lang === 'id' ? 'Manajemen Asisten' : 'Aslab Management' }}
                </a>
                <a href="{{ route($dashboardRoute, ['tab' => 'analytics']) }}" class="menu-item {{ request('tab') == 'analytics' ? 'active' : '' }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                    {{ $lang === 'id' ? 'Laporan Analitik' : 'Analytics Report' }}
                </a>
            @endif

            @if(Auth::user()->role === 'dosen')
                <!-- Menu Eksklusif Pemantauan Dosen -->
                <a href="{{ route($dashboardRoute, ['tab' => 'schedule']) }}" class="menu-item {{ request('tab') == 'schedule' ? 'active' : '' }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                    {{ $lang === 'id' ? 'Jadwal Laboratorium' : 'Laboratory Schedule' }}
                </a>
                <a href="{{ route($dashboardRoute, ['tab' => 'riwayat']) }}" class="menu-item {{ request('tab') == 'riwayat' ? 'active' : '' }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="12" y1="18" x2="12" y2="12"></line><line x1="9" y1="15" x2="15" y2="15"></line></svg>
                    {{ $lang === 'id' ? 'Riwayat Aktivitas' : 'Audit Logs' }}
                </a>
                <a href="{{ route($dashboardRoute, ['tab' => 'monitoring']) }}" class="menu-item {{ request('tab') == 'monitoring' ? 'active' : '' }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>
                    {{ $lang === 'id' ? 'Monitoring Penggunaan' : 'Usage Monitoring' }}
                </a>
                <a href="{{ route($dashboardRoute, ['tab' => 'analytics']) }}" class="menu-item {{ request('tab') == 'analytics' ? 'active' : '' }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                    {{ $lang === 'id' ? 'Laporan Analitik' : 'Analytics Dashboard' }}
                </a>
            @endif

            <!-- Pengaturan -->
            <a href="{{ route($dashboardRoute, ['tab' => 'settings']) }}" class="menu-item {{ request('tab') == 'settings' ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                {{ $lang === 'id' ? 'Profil Akun' : 'Account Profile' }}
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
        <!-- Hamburger Menu is inside SR Mobile Scroll Context -->
        <div id="hamburgerBtn" class="hamburger-menu" onclick="toggleSidebar()">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </div>

        <div class="hunter-top-bar">
            <!-- ROLES BADGE HEADER POSITION (LEFT SIDE OF TOP BAR) -->
            <div style="display:flex; align-items: center;">
                <span class="hunter-role-badge">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="display: inline-block; vertical-align: middle; margin-right: 5px;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    @if(Auth::user()->role === 'admin')
                        OTORITAS: ADMIN SISTEM
                    @elseif(Auth::user()->role === 'master')
                        OTORITAS: MASTER LABORATORIUM
                    @elseif(Auth::user()->role === 'asisten')
                        OTORITAS: ASISTEN LABORATORIUM
                    @elseif(Auth::user()->role === 'dosen')
                        OTORITAS: DOSEN PENGAMPU
                    @else
                        STAFF
                    @endif
                </span>
            </div>

            <!-- RIGHT SIDE ACTIONS -->
            <div class="hunter-top-actions">
                <!-- Notification Bell -->
                <div style="position: relative;" id="notifContainer">
                    <a href="{{ route('notifications.index') }}" style="background: none; border: none; color: var(--text-muted); cursor: pointer; position: relative; padding: 0.5rem; transition: color 0.3s; display: flex; align-items: center; text-decoration: none;" onmouseover="this.style.color='#00d9ff'" onmouseout="this.style.color='var(--text-muted)'">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>
                        @php $badgeCount = $unreadNotifs ?? $peringatanSistem ?? 0; @endphp
                        @if($badgeCount > 0)
                            <span style="position: absolute; top: 0px; right: 0px; background: #ef4444; color: white; border-radius: 50%; min-width: 14px; height: 14px; display: flex; align-items: center; justify-content: center; font-size: 0.55rem; font-weight: 900; box-shadow: 0 0 8px rgba(239, 68, 68, 0.9); padding: 0 3px; border: 2px solid var(--body-bg);">
                                {{ $badgeCount > 99 ? '99+' : $badgeCount }}
                            </span>
                        @endif
                    </a>
                </div>

                <!-- Language Switcher -->
                <a href="{{ url('/lang/'.$toggleLang) }}" class="lang-switch">LANG : {{ strtoupper($lang) }}</a>
                
                <!-- Back to Home -->
                <a href="/" class="back-home">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                    <span>Beranda Global</span>
                </a>
            </div>
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
        // Cyberpunk SweetAlert Native Confirmation Interceptor
        window.confirmDestructiveAction = function(event, form, lang, warningEn, warningId) {
            event.preventDefault();
            const message = lang === 'id' ? warningId : warningEn;
            const title = lang === 'id' ? 'AUTENTIKASI SISTEM' : 'SYSTEM AUTHENTICATION';
            const confirmText = lang === 'id' ? 'EKSEKUSI' : 'EXECUTE';
            const cancelText = lang === 'id' ? 'BATALKAN' : 'CANCEL';

            Swal.fire({
                title: title,
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: confirmText,
                cancelButtonText: cancelText,
                customClass: {
                    popup: 'hunter-swal-popup',
                    title: 'hunter-swal-title',
                    htmlContainer: 'hunter-swal-text',
                    confirmButton: 'hunter-swal-confirm-btn',
                    cancelButton: 'hunter-swal-cancel-btn'
                },
                background: '#0a1016',
                color: '#fff',
                iconColor: '#ef4444'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        };

        // Cyberpunk Sonner-Style Toast Function
        function showHunterToast(message, type = 'success') {
            const isError = type === 'error';
            
            Toastify({
                text: message,
                duration: 4000,
                close: false,
                gravity: "top", 
                position: "center", 
                className: isError ? "hunter-toast hunter-toast-error" : "hunter-toast",
                style: {
                    background: "transparent", // Biarkan CSS mengatur background agar tidak ditimpa oleh default toastify
                    boxShadow: "none" // Biarkan CSS mengatur box-shadow
                }
            }).showToast();
        }

        // Auto Trigger Based on Laravel Sessions & Validation Errors
        @if(session('success'))
            showHunterToast(@json(session('success')), 'success');
        @endif

        @if(session('error') || session('status_error'))
            showHunterToast(@json(session('error') ?? session('status_error')), 'error');
        @endif

        @if($errors->any())
            @foreach($errors->all() as $error)
                showHunterToast(@json($error), 'error');
            @endforeach
        @endif
    </script>
</body>
</html>
