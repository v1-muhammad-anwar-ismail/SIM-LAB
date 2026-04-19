@extends('layouts.student')

@section('content')

@php
    $lang = session('locale', 'id');
    // Language dictionaries
    $welcomeStr = $lang === 'id' ? 'SELAMAT DATANG DI SISTEM TERMINAL MAHASISWA,' : 'WELCOME TO THE STUDENT TERMINAL SYSTEM,';
    $tabTitle = strtoupper(str_replace('_', ' ', $tab));
    if($tab === 'overview') $tabTitle = $lang === 'id' ? 'RINGKASAN PROFIL' : 'OVERVIEW';
    if($tab === 'ketersediaan') $tabTitle = $lang === 'id' ? 'KETERSEDIAAN ALAT' : 'INVENTORY CHECK';
    if($tab === 'pengajuan') $tabTitle = $lang === 'id' ? 'FORM PENGUJUAN' : 'LOAN REQUEST';
    if($tab === 'riwayat') $tabTitle = $lang === 'id' ? 'RIWAYAT PEMINJAMAN' : 'LOAN HISTORY';
    if($tab === 'settings') $tabTitle = $lang === 'id' ? 'PENGATURAN PROFIL' : 'ACCOUNT SETTINGS';

    $nameFirst = explode(' ', $user->name)[0];
@endphp

<style>
    /* Specific styling for the content pane */
    .dashboard-header {
        margin-bottom: 2rem;
        animation: fade-in-up 0.5s ease-out;
    }

    @media print {
        @page { size: auto; margin: 1cm; }
        html, body { min-height: auto !important; height: auto !important; }
        body { margin: 0; padding: 0 !important; background: #fff !important; color: #000 !important; }
        
        /* Menyembunyikan seluruh sidebar atau nav bila ada di body root (layouts.student) */
        #sr-sidebar, #mobileOverlay, #hamburgerBtn, .bg-glow, .top-bar, .dashboard-header, .welcome-banner, .history-filter-btn { display: none !important; }
        #sr-main { margin: 0 !important; padding: 0 !important; width: auto !important; left: 0 !important; }
        
        /* Pada kontainer utama riwayat, sembunyikan semua list */
        #riwayat-container > .riwayat-card { display: none !important; }
        
        /* Hanya tampilkan card yang ditarget */
        #riwayat-container > .riwayat-card.print-active { 
            display: block !important; 
            border: 2px solid #000 !important;
            padding: 2rem !important;
            background: transparent !important;
            color: #000 !important;
            page-break-inside: avoid;
            box-shadow: none !important;
            width: auto !important;
            border-radius: 12px;
        }

        .print-only-identity { display: block !important; color: #000 !important; }
        .print-only-footer { display: block !important; color: #000 !important; margin-top: 1.5rem !important; }
        
        .print-active * {
            color: #000 !important;
            border-color: #000 !important;
            background: transparent !important;
        }
        
        .print-hide { display: none !important; }
    }
    .header-title {
        font-size: 2rem;
        font-weight: 900;
        text-transform: uppercase;
        font-style: italic;
        letter-spacing: -1px;
    }
    .header-title span { color: var(--accent-cyan); }
    .header-subtitle {
        color: var(--text-muted);
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.3em;
        margin-top: 0.5rem;
        text-transform: uppercase;
    }

    .glass-card {
        background-color: var(--panel-bg);
        border: 1px solid var(--panel-border);
        border-radius: 1rem;
        padding: 1.5rem;
        position: relative;
        overflow: hidden;
    }
    .glass-card::before {
        content: '';
        position: absolute;
        top: 0; right: 0;
        width: 300px; height: 300px;
        background: radial-gradient(circle, rgba(0,217,255,0.05) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
        transition: all 0.7s ease;
    }
    .glass-card:hover::before {
        background: radial-gradient(circle, rgba(0,217,255,0.1) 0%, transparent 70%);
    }

    @keyframes fade-in-up {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up { animation: fade-in-up 0.5s ease-out; }

    /* Forms */
    .hunter-input {
        width: 100%;
        background-color: #0a0c10;
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 0.75rem;
        padding: 0.75rem 1rem;
        color: white;
        transition: all 0.3s;
        box-sizing: border-box;
        font-family: inherit;
        font-size: 0.85rem;
    }
    
    select.hunter-input {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        padding-right: 2rem; /* Ruang untuk teks sebelum nabrak *//* Opsi tambahan untuk dropdown list browser */
    }
    .hunter-input:focus {
        outline: none;
        border-color: rgba(0,217,255,0.5);
    }
    .hunter-btn {
        width: 100%;
        background-color: var(--accent-cyan);
        color: #000;
        font-weight: 900;
        text-transform: uppercase;
        padding: 1rem;
        border-radius: 0.75rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
    }
    .hunter-btn:hover {
        box-shadow: 0 0 20px rgba(0,217,255,0.6);
        transform: scale(1.02);
    }

    /* Responsive Form Grids */
    .responsive-grid-2 {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    @media (min-width: 768px) {
        .responsive-grid-2 {
            grid-template-columns: 1fr 1fr;
        }
    }

    .responsive-alat-row {
        display: grid;
        grid-template-columns: 1fr; /* 1 Kolom untuk layar Mobile (bertumpuk vertikal 3 baris) */
        gap: 0.75rem;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px dashed rgba(255,255,255,0.1);
    }
    
    .trash-btn {
        width: 100%;
        background: rgba(239, 68, 68, 0.1);
        border: 1px dashed #ef4444;
        color: #ef4444;
        padding: 0.75rem;
        border-radius: 0.5rem;
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
        font-weight: 800;
        font-size: 0.75rem;
        transition: all 0.3s;
    }
    .trash-btn:hover {
        background: rgba(239, 68, 68, 0.2);
    }

    @media (min-width: 768px) {
        .responsive-alat-row {
            grid-template-columns: 3fr 1fr auto;
            gap: 1rem;
            margin-bottom: 1rem;
            padding-bottom: 0;
            border-bottom: none;
        }
        .trash-btn {
            width: auto;
            background: transparent;
            border: none;
            padding: 0.5rem;
            opacity: 0.6;
        }
        .trash-btn:hover {
            background: transparent;
            opacity: 1;
        }
        .trash-text {
            display: none; /* Sembunyikan teks di Desktop, cukup Ikon */
        }
    }

    /* Button Resize Mobile */
    .submit-btn {
        width: 100%;
        font-size: 0.85rem;
        padding: 0.75rem;
        box-shadow: 0 0 15px rgba(0,217,255,0.4);
    }
    @media (min-width: 768px) {
        .submit-btn {
            font-size: 1rem;
            padding: 1rem;
        }
    }

    /* History UI */
    .history-filter-btn {
        background-color: transparent;
        border: 1px solid rgba(255,255,255,0.2);
        color: var(--text-muted);
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: bold;
        text-transform: uppercase;
        cursor: pointer;
        transition: all 0.3s;
    }
    .history-filter-btn.active {
        background-color: var(--accent-cyan);
        border-color: var(--accent-cyan);
        color: #000;
        box-shadow: 0 0 10px rgba(0,217,255,0.4);
    }
    .history-filter-btn:hover:not(.active) {
        border-color: rgba(255,255,255,0.5);
        color: #fff;
    }

    .riwayat-card {
        background-color: #0a0c10;
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 1rem;
        padding: 1.5rem;
        margin-bottom: 1rem;
        transition: all 0.3s;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    .riwayat-card:hover {
        border-color: rgba(0,217,255,0.3);
        box-shadow: 0 5px 20px rgba(0,0,0,0.5);
        transform: translateY(-2px);
    }
    
    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 900;
        text-transform: uppercase;
        display: inline-block;
    }
    .status-menunggu { background: rgba(234, 179, 8, 0.1); color: #eab308; border: 1px solid #eab308; }
    .status-disetujui { background: rgba(59, 130, 246, 0.1); color: #3b82f6; border: 1px solid #3b82f6; }
    .status-dipinjam { background: rgba(0, 217, 255, 0.1); color: #00d9ff; border: 1px solid #00d9ff; }
    .status-dikembalikan { background: rgba(34, 197, 94, 0.1); color: #22c55e; border: 1px solid #22c55e; }
    .status-ditolak { background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid #ef4444; }

    .riwayat-detail-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
        background: rgba(255,255,255,0.02);
        padding: 1rem;
        border-radius: 0.5rem;
    }
    @media (min-width: 768px) {
        .riwayat-detail-grid { grid-template-columns: 1fr 1fr; }
    }

    /* Avatar Grid */
    .profile-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 2rem;
        margin-top: 1.5rem;
    }
    @media (min-width: 1024px) {
        .profile-grid { grid-template-columns: 1fr 2fr; }
    }

    .stat-box {
        background-color: #0f1023;
        border: 1px solid rgba(255,255,255,0.05);
        padding: 1rem;
        border-radius: 0.75rem;
        text-align: center;
    }
    
    .coming-soon-wrapper {
        text-align: center;
        padding: 5rem 0;
    }

    /* ----- PRINT PDF LOGIC ----- */
    @media print {
        body * {
            visibility: hidden;
        }
        
        /* Hilangkan elemen yang tidak perlu dicetak */
        .sidebar, .top-bar, .profile-nav, .status-badge, .history-filter-btn {
            display: none !important;
        }

        /* Hanya card yang aktif yang akan ditampilkan (trick js bisa kita pakai) namun secara kasar kita menyuruh cetak parent */
        #sr-main, #sr-main * {
            visibility: visible;
        }
        
        #sr-main {
            position: absolute;
            left: 0;
            top: 0;
            margin: 0;
            padding: 0;
        }

        .riwayat-card {
            background: none !important;
            border: 1px solid #000 !important;
            box-shadow: none !important;
            margin-bottom: 2rem;
            color: #000 !important;
            page-break-inside: avoid;
        }

        .riwayat-card * {
            color: #000 !important; /* Paksa tinta hitam hemat cetak */
        }
        
        .print-hide {
            display: none !important;
        }
    }
    /* Custom Radio Cards untuk Lab */
    .radio-card-grid {
        display: flex; gap: 1rem; flex-wrap: wrap; padding-bottom: 1rem;
    }
    .radio-card { flex: 0 0 auto; width: calc(25% - 0.75rem); min-width: 150px; position: relative; cursor: pointer; }
    @media(max-width: 768px) {
        .radio-card { width: 100%; } /* Mode Full-Width pada layar seluler */
    }
    .radio-card input[type="radio"] { display: none; }
    .radio-card .card-content {
        background: #0a0c10; border: 2px solid rgba(255,255,255,0.1); border-radius: 12px; overflow: hidden; transition: all 0.3s; opacity: 0.5;
    }
    .radio-card:hover .card-content { opacity: 0.8; border-color: rgba(0, 217, 255, 0.4); }
    .radio-card input[type="radio"]:checked + .card-content {
        border-color: var(--accent-cyan); box-shadow: 0 0 15px rgba(0, 217, 255, 0.3); opacity: 1; transform: translateY(-3px);
    }
    .radio-card .image-wrapper { width: 100%; padding-bottom: 56.25%; background: #000; position: relative; overflow: hidden; }
    .radio-card img { position: absolute; top:0; left:0; width: 100%; height: 100%; object-fit: cover; pointer-events: none; }
    .radio-card .text-wrapper { padding: 0.75rem; text-align: center; font-size: 0.75rem; font-weight: 700; color: #fff; line-height: 1.3; }

    /* E-Commerce Catalog untuk Alat */
    .alat-wrapper-container { margin-bottom: 2.5rem; padding: 1.5rem; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.05); border-radius: 0.5rem; }
    .catalog-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; }
    
    @media(max-width: 768px) {
        .catalog-grid { grid-template-columns: repeat(1, 1fr); }
        .alat-wrapper-container { padding: 0.5rem; margin-bottom: 1.5rem; border-radius: 0.75rem; }
    }
    .catalog-item {
        background: #0a0c10; border: 2px solid rgba(255,255,255,0.05); border-radius: 12px; overflow: hidden; display: flex; flex-direction: column; transition: 0.3s;
    }
    .catalog-item.selected { border-color: var(--accent-cyan); box-shadow: 0 0 15px rgba(0,217,255,0.15); }
    .catalog-item .image-wrapper { width: 100%; padding-bottom: 56.25%; background: #000; position: relative; }
    .catalog-item img { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; }
    .catalog-item .stock-badge {
        position: absolute; top: 0.5rem; right: 0.5rem; background: rgba(0,0,0,0.8); color: var(--accent-cyan); font-size: 0.65rem; font-weight: 900; padding: 0.2rem 0.5rem; border-radius: 4px; backdrop-filter: blur(2px); border: 1px solid var(--accent-cyan);
    }
    .catalog-info { padding: 1rem; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between; }
    .catalog-title { font-size: 0.9rem; font-weight: 800; color: #fff; margin-bottom: 0.25rem; line-height: 1.3; }
    .catalog-code { font-size: 0.65rem; color: var(--text-muted); font-weight: 700; letter-spacing: 1px; }
    
    .catalog-counter {
        display: flex; align-items: center; justify-content: space-between; margin-top: 1rem; background: rgba(0,0,0,0.5); border-radius: 6px; padding: 0.2rem; border: 1px solid rgba(255,255,255,0.05);
    }
    .catalog-counter button {
        background: rgba(255,255,255,0.05); border: none; color: #fff; cursor: pointer; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-weight: bold; border-radius: 4px; transition: 0.2s;
    }
    .catalog-counter button:hover { background: var(--accent-cyan); color: #000; }
    .catalog-counter button:disabled { opacity: 0.3; cursor: not-allowed; background: rgba(255,255,255,0.05); color: #fff; }
    .catalog-counter .qty-display { font-weight: 900; color: var(--accent-cyan); font-size: 1.1rem; width: 40px; text-align: center; }

</style>

<div class="dashboard-header">
    <h1 class="header-title"><span>{{ $tabTitle }}</span></h1>
    <p class="header-subtitle" style="word-break: break-word;">{{ $welcomeStr }} {{ strtoupper($user->name) }}</p>
</div>



<div class="glass-card animate-fade-in-up" style="min-height: 500px;">
    
    @if($tab === 'overview')
        <div class="profile-grid">
            <!-- Left Column: Identity -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <!-- Avatar Card -->
                <div style="background: #0f1023; border: 1px solid #1a202c; border-radius: 1rem; padding: 1.5rem; text-align: center; position: relative;">
                    <div style="position: relative; margin-bottom: 1rem; display: inline-block;">
                        @if($user->avatar)
                            <img src="{{ $user->avatar }}" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 3px solid var(--accent-cyan); box-shadow: 0 0 20px var(--glow-cyan);">
                        @else
                            <div style="width: 120px; height: 120px; background: rgba(0, 217, 255, 0.15); border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center; color: var(--accent-cyan); font-size: 3rem; font-weight: 900; border: 3px solid var(--accent-cyan); box-shadow: 0 0 20px var(--glow-cyan);">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                        <div style="position: absolute; bottom: -5px; right: -5px; background: #eab308; color: #000; font-weight: 900; padding: 0.2rem 0.8rem; border-radius: 20px; font-size: 0.65rem; border: 2px solid #0f1023;">MAHASISWA</div>
                    </div>
                    <h2 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 0.25rem;">{{ $user->name }}</h2>
                    <p style="color: var(--text-muted); font-size: 0.75rem; margin-bottom: 1rem;">NIM. {{ explode('@', $user->email)[0] }}</p>
                    
                    <div style="background: #0a0c10; padding: 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.05); text-align: left;">
                        <p style="color: #9ca3af; font-size: 0.75rem; font-style: italic;">"{{ $user->bio ?? ($lang === 'id' ? 'Belum ada deskripsi profil tambahan yang dicantumkan.' : 'No additional profile description provided.') }}"</p>
                    </div>
                </div>

                <!-- Stats Grid -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="stat-box">
                        <h4 style="font-size: 1.5rem; font-weight: 900; color: var(--accent-cyan); margin: 0;">{{ $activeLoans }}</h4>
                        <p style="font-size: 0.6rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-top: 0.25rem;">{{ $lang === 'id' ? 'Aktif' : 'Active' }}</p>
                    </div>
                    <div class="stat-box">
                        <h4 style="font-size: 1.5rem; font-weight: 900; color: #a855f7; margin: 0;">{{ $pendingRequests }}</h4>
                        <p style="font-size: 0.6rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-top: 0.25rem;">{{ $lang === 'id' ? 'Tertunda' : 'Pending' }}</p>
                    </div>
                    <div class="stat-box">
                        <h4 style="font-size: 1.5rem; font-weight: 900; color: #eab308; margin: 0;">{{ $completedLoans }}</h4>
                        <p style="font-size: 0.6rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-top: 0.25rem;">{{ $lang === 'id' ? 'Riwayat' : 'History' }}</p>
                    </div>
                    <div class="stat-box">
                        <h4 style="font-size: 1.5rem; font-weight: 900; color: #ef4444; margin: 0;">{{ $lateReturns }}</h4>
                        <p style="font-size: 0.6rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-top: 0.25rem;">{{ $lang === 'id' ? 'Terlambat' : 'Overdue' }}</p>
                    </div>
                </div>
            </div>

            <!-- Right Column: Recent Activities Log -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div style="background: #0f1023; border: 1px solid #1a202c; border-radius: 1rem; padding: 1.5rem;">
                    <h3 style="font-weight: 800; font-size: 1rem; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem; color: #fff;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        {{ $lang === 'id' ? 'Riwayat Peminjaman Terakhir' : 'Recent Loan History' }}
                    </h3>
                    
                    @if(isset($recentLoans) && $recentLoans->isNotEmpty())
                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            @foreach($recentLoans as $loan)
                                <div style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); border-radius: 0.75rem; padding: 1rem; display: flex; justify-content: space-between; align-items: center; transition: all 0.3s;" onmouseover="this.style.background='rgba(0, 217, 255, 0.05)'" onmouseout="this.style.background='rgba(255, 255, 255, 0.02)'">
                                    <div>
                                        <p style="margin: 0 0 0.25rem; font-size: 0.85rem; font-weight: bold; color: #fff;">{{ $loan->jenis_peminjaman === 'alat' ? ($lang === 'id' ? 'Peminjaman Alat' : 'Equipment') : ($lang === 'id' ? 'Peminjaman Ruang' : 'Room') }}</p>
                                        <p style="margin: 0; font-size: 0.7rem; color: var(--text-muted);">{{ \Carbon\Carbon::parse($loan->created_at)->diffForHumans() }}</p>
                                    </div>
                                    <span class="status-badge status-{{ $loan->status }}">
                                        @php
                                            $sStr = strtoupper($loan->status);
                                            if($lang === 'en') {
                                                if($loan->status === 'menunggu') $sStr = 'PENDING';
                                                if($loan->status === 'disetujui') $sStr = 'APPROVED';
                                                if($loan->status === 'dipinjam') $sStr = 'ACTIVE';
                                                if($loan->status === 'dikembalikan') $sStr = 'RETURNED';
                                                if($loan->status === 'ditolak') $sStr = 'REJECTED';
                                            }
                                        @endphp
                                        {{ $sStr }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div style="text-align: center; padding: 3rem 0; border: 2px dashed rgba(255,255,255,0.05); border-radius: 0.75rem;">
                            <p style="color: var(--text-muted); font-size: 0.85rem;">{{ $lang === 'id' ? 'Belum ada riwayat aktivitas tercatat. Silakan lakukan transaksi peminjaman alat atau ruangan.' : 'No recent activity recorded. Please proceed to request equipment or rooms.' }}</p>
                        </div>
                    @endif
                    
                    <a href="{{ route('student.dashboard', ['tab' => 'riwayat']) }}" style="display: block; text-align: center; font-size: 0.75rem; color: var(--accent-cyan); font-weight: bold; margin-top: 1.5rem; transition: color 0.3s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='var(--accent-cyan)'">
                        {{ $lang === 'id' ? 'Lihat Semua Riwayat' : 'View All History' }}
                    </a>
                </div>
            </div>
        </div>

    @elseif($tab === 'settings')
        <div class="profile-grid">
            <!-- Edit Profile -->
            <div>
                <h3 style="font-size: 1.25rem; font-weight: 800; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 1rem; margin-bottom: 1.5rem;">{{ $lang === 'id' ? 'Edit Data Identitas' : 'Edit Card' }}</h3>
                <form action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <!-- Avatar Upload -->
                    <div style="text-align: center; margin-bottom: 2rem;">
                        <label style="cursor: pointer; display: inline-block; position: relative;" class="avatar-hover-label">
                            @if($user->avatar)
                                <img id="avatar-preview" src="{{ $user->avatar }}" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 2px solid var(--accent-cyan);">
                            @else
                                <div id="avatar-placeholder" style="width: 100px; height: 100px; background: rgba(0, 217, 255, 0.15); border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center; color: var(--accent-cyan); font-size: 2.5rem; font-weight: 900; border: 2px solid var(--accent-cyan);">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <img id="avatar-preview" src="#" style="display:none; width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 2px solid var(--accent-cyan);">
                            @endif
                            <div style="position: absolute; bottom: 0; right: 0; background: var(--accent-cyan); padding: 5px; border-radius: 50%; color: #000;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                            </div>
                            <input type="file" id="avatar-input" name="avatar" accept="image/jpeg, image/png, image/jpg, image/gif" style="display: none;">
                        </label>
                        <p style="font-size: 0.7rem; color: var(--text-muted); margin-top: 0.5rem; letter-spacing: 1px; text-transform: uppercase;">{{ $lang === 'id' ? 'Unggah Foto Profil' : 'Upload Profile Picture' }}</p>
                        <p style="font-size: 0.6rem; color: var(--text-muted); margin-top: 0.25rem; font-style: italic;">{{ $lang === 'id' ? 'Maksimal ukuran: 20MB (JPG, JPEG, PNG, GIF)' : 'Max size: 20MB (JPG, JPEG, PNG, GIF)' }}</p>
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-size: 0.75rem; font-weight: bold; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.5rem;">{{ $lang === 'id' ? 'Nama Lengkap (Sistem Induk)' : 'Full Name' }}</label>
                        <input type="text" name="name" class="hunter-input" value="{{ $user->name }}" required>
                    </div>

                    <div style="margin-bottom: 2rem;">
                        <label style="display: block; font-size: 0.75rem; font-weight: bold; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.5rem;">{{ $lang === 'id' ? 'Deskripsi Profil Tambahan' : 'Additional Profile Description' }}</label>
                        <textarea name="bio" class="hunter-input" style="min-height: 100px; resize: none;" maxlength="150">{{ $user->bio ?? '' }}</textarea>
                    </div>

                    <button type="submit" class="hunter-btn">{{ $lang === 'id' ? 'SIMPAN PEMBARUAN' : 'UPDATE PROFILE' }}</button>
                </form>
            </div>

            <!-- Change Password -->
            <div>
                <h3 style="font-size: 1.25rem; font-weight: 800; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 1rem; margin-bottom: 1.5rem; color: #ef4444;">{{ $lang === 'id' ? 'Perbarui Sandi Keamanan' : 'Change Security Password' }}</h3>
                <form action="{{ route('student.password.update') }}" method="POST" style="background: #0f1023; border: 1px solid #1a202c; border-radius: 1rem; padding: 1.5rem;">
                    @csrf
                    
                    <div style="margin-bottom: 1.25rem;">
                        <label style="display: block; font-size: 0.65rem; font-weight: bold; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.5rem;">{{ $lang === 'id' ? 'Kata Sandi Lama' : 'Current Password' }}</label>
                        <div style="position: relative;">
                            <input type="password" name="currentPassword" class="hunter-input focus:border-red-500" style="padding-right: 2.5rem;" required>
                            <button type="button" onclick="togglePassword(this)" style="position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--text-muted); cursor: pointer; padding: 0;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </button>
                        </div>
                    </div>

                    <div class="responsive-grid-2" style="gap: 1rem; margin-bottom: 1.5rem;">
                        <div>
                            <label style="display: block; font-size: 0.65rem; font-weight: bold; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.5rem;">{{ $lang === 'id' ? 'Kata Sandi Baru' : 'New Password' }}</label>
                            <div style="position: relative;">
                                <input type="password" name="newPassword" class="hunter-input" style="padding-right: 2.5rem;" required minlength="8">
                                <button type="button" onclick="togglePassword(this)" style="position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--text-muted); cursor: pointer; padding: 0;">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                </button>
                            </div>
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.65rem; font-weight: bold; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.5rem;">{{ $lang === 'id' ? 'Konfirmasi Kata Sandi' : 'Confirm Password' }}</label>
                            <div style="position: relative;">
                                <input type="password" name="newPassword_confirmation" class="hunter-input" style="padding-right: 2.5rem;" required minlength="8">
                                <button type="button" onclick="togglePassword(this)" style="position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--text-muted); cursor: pointer; padding: 0;">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <button type="submit" style="background: #ef4444; color: #fff; width: 100%; border: none; padding: 0.75rem; border-radius: 0.5rem; font-weight: bold; cursor: pointer;">{{ $lang === 'id' ? 'Ubah Sandi Sekarang' : 'Execute Update' }}</button>
                </form>
            </div>
        </div>
    @elseif($tab === 'ketersediaan')
        <!-- TAB: INVENTORY CHECK -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; border-bottom: 1px solid rgba(0,217,255,0.2); padding-bottom: 1rem;">
            <div>
                <h2 style="font-weight: 900; font-style: italic; letter-spacing: 0.1em; margin: 0; text-transform: uppercase;">
                    {{ $lang === 'id' ? 'DATABASE KETERSEDIAAN ALAT' : 'EQUIPMENT INVENTORY DATABASE' }}
                </h2>
                <p style="color: var(--text-muted); font-size: 0.8rem; margin-top: 0.25rem;">
                    {{ $lang === 'id' ? 'Akses Live Data Inventaris Kampus' : 'Live Access to Campus Inventory Data' }}
                </p>
            </div>
        </div>

        <div style="background: rgba(0,217,255,0.05); color: #00d9ff; border: 1px solid rgba(0,217,255,0.2); padding: 0.75rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.8rem; font-weight: 600; display: flex; align-items: flex-start; gap: 0.75rem;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink: 0;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
            <div>
                {{ $lang === 'id' ? 'TIPS: Anda dapat mengklik langsung kartu Aset atau Ruangan di bawah ini untuk dibawa seketika ke halaman Pengajuan, lengkap dengan opsi yang sudah dipilihkan oleh sistem untuk Anda secara presisi!' : 'TIPS: You can comfortably click the Asset or Room cards below to be routed instantly to the Loan Form with precise options pre-selected for you!' }}
            </div>
        </div>

        @if(isset($alats) && $alats->isEmpty())
        <!-- EMPTY STATE -->
        <div style="text-align: center; margin-top: 5rem; padding: 3rem; background: rgba(255,255,255,0.02); border-radius: 12px; border: 1px dashed rgba(255,255,255,0.1);">
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem; margin-left: auto; margin-right: auto; display: block;">
                <circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line><line x1="8" y1="11" x2="14" y2="11"></line>
            </svg>
            <h2 style="font-weight: 900; color: var(--text-muted); letter-spacing: 0.05em; margin-bottom: 0.5rem; text-transform: uppercase;">
                {{ $lang === 'id' ? 'ARSIP MASIH KOSONG' : 'ARCHIVE IS EMPTY' }}
            </h2>
            <p style="color: var(--text-muted); font-size: 0.85rem; max-width: 400px; margin: 0 auto; line-height: 1.6;">
                {{ $lang === 'id' ? 'Admin pusat belum memasukkan suplai data inventaris peralatan apa pun ke dalam pangkalan data SIM-LAB.' : 'Central admin has not entered any equipment inventory data into the SIM-LAB database yet.' }}
            </p>
        </div>
        @elseif(isset($alats))
        <!-- DATA GRID -->
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
            @foreach($alats as $item)
                @php
                    $isAvailable = $item->available_stok > 0 && $item->kondisi !== 'rusak';
                    $statusColor = $isAvailable ? 'var(--primary-cyan)' : '#ef4444';
                    $statusTextID = $isAvailable ? 'TERSEDIA' : 'TIDAK TERSEDIA';
                    $statusTextEN = $isAvailable ? 'AVAILABLE' : 'UNAVAILABLE';
                @endphp
                <a href="{{ route('student.dashboard', ['tab' => 'pengajuan', 'auto_jenis' => 'alat', 'auto_lab' => $item->laboratorium_id]) }}" style="text-decoration: none; display: block; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); border-radius: 12px; overflow: hidden; position: relative; transition: transform 0.3s ease, box-shadow 0.3s ease;" class="hover:border-cyan-500 hover:shadow-[0_0_15px_rgba(0,217,255,0.2)]">
                    
                    <!-- Image Frame -->
                    <div style="aspect-ratio: 16/9; background: #05080f; position: relative; display:flex; justify-content:center; align-items:center; overflow:hidden;">
                        @if(!empty($item->fotos) && is_array($item->fotos) && count($item->fotos) > 0)
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($item->fotos[0]) }}" alt="{{ $item->nama_alat }}" style="width: 100%; height: 100%; object-fit: cover; opacity: 0.8; transition: transform 0.5s ease;" class="hover:scale-110">
                        @else
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" style="opacity: 0.5;" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                        @endif
                        
                        <!-- Status Badge -->
                        <div style="position: absolute; top: 1rem; right: 1rem; background: rgba(0,0,0,0.7); border: 1px solid {{ $statusColor }}; color: {{ $statusColor }}; padding: 0.25rem 0.75rem; border-radius: 4px; font-size: 0.6rem; font-weight: 900; letter-spacing: 1px; backdrop-filter: blur(4px);">
                            {{ $lang === 'id' ? $statusTextID : $statusTextEN }}
                        </div>
                    </div>
                    
                    <!-- Content Details -->
                    <div style="padding: 1.25rem;">
                        <div style="font-size: 0.65rem; color: var(--text-muted); font-weight: 700; letter-spacing: 1px; margin-bottom: 0.25rem; text-transform: uppercase;">
                            {{ $item->kode_alat }}
                        </div>
                        <h3 style="font-size: 1.1rem; font-weight: 800; color: #fff; margin: 0 0 0.5rem 0;">
                            {{ $item->nama_alat }}
                        </h3>
                        
                        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-top: 1rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.05);">
                            <div style="font-size: 0.65rem; color: var(--text-muted); line-height: 1.4;">
                                <span style="display: block;"><strong>{{ $lang === 'id' ? 'Asal Lab:' : 'Origin Lab:' }}</strong> <span style="color:#fff;">{{ $item->laboratorium ? $item->laboratorium->nama_lab : 'Unknown' }}</span></span>
                                <span style="display: block;"><strong>{{ $lang === 'id' ? 'Master Lab:' : 'Head Master:' }}</strong> <span style="color:#fff;">{{ $item->laboratorium && $item->laboratorium->master ? $item->laboratorium->master->name : 'Unassigned' }}</span></span>
                                <span style="display: block;"><strong>{{ $lang === 'id' ? 'Asisten Jaga:' : 'Aslab Guard:' }}</strong> 
                                    <span style="color:#fff;">
                                    @if($item->laboratorium && count($item->laboratorium->aslabs) > 0)
                                        {{ collect($item->laboratorium->aslabs)->pluck('name')->join(', ') }}
                                    @else
                                        {{ $lang === 'id' ? 'Belum Ada' : 'None' }}
                                    @endif
                                    </span>
                                </span>
                            </div>
                            <div style="text-align: right; flex-shrink: 0;">
                                <span style="display:block; font-size:0.6rem; text-transform:uppercase; margin-bottom:0.1rem; color: var(--text-muted);">{{ $lang === 'id' ? 'Stok Aktual' : 'Live Stock' }}</span>
                                <span style="color: {{ $item->available_stok > 0 ? 'var(--primary-cyan)' : '#ef4444' }}; font-weight: 900; font-size: 1.2rem;">{{ $item->available_stok }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div style="background: rgba(0,217,255,0.1); text-align: center; padding: 0.5rem; font-size: 0.7rem; font-weight: 800; color: var(--primary-cyan); text-transform: uppercase;">
                        {{ $lang === 'id' ? 'KLIK UNTUK AJUKAN ➔' : 'CLICK TO REQUEST ➔' }}
                    </div>
                </a>
            @endforeach
        </div>
        @endif
        
        @if(isset($labs) && $labs->isNotEmpty())
        <div style="margin-top: 3rem; border-top: 1px solid rgba(0,217,255,0.2); padding-top: 2rem;">
            <h2 style="font-weight: 900; font-style: italic; letter-spacing: 0.1em; margin: 0 0 1.5rem 0; text-transform: uppercase;">
                {{ $lang === 'id' ? 'KETERSEDIAAN RUANG LABORATORIUM' : 'LABORATORY ROOM AVAILABILITY' }}
            </h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
                @foreach($labs as $lab)
                    <a href="{{ route('student.dashboard', ['tab' => 'pengajuan', 'auto_jenis' => 'ruang', 'auto_lab' => $lab->id]) }}" style="text-decoration: none; display: block; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); border-radius: 12px; overflow: hidden; position: relative; transition: transform 0.3s ease, box-shadow 0.3s ease;" class="hover:border-cyan-500 hover:shadow-[0_0_15px_rgba(0,217,255,0.2)]">
                        
                        <!-- Image Frame -->
                        <div style="aspect-ratio: 16/9; background: #05080f; position: relative; display:flex; justify-content:center; align-items:center; overflow:hidden;">
                            @if(!empty($lab->fotos) && is_array($lab->fotos) && count($lab->fotos) > 0)
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($lab->fotos[0]) }}" alt="{{ $lab->nama_lab }}" style="width: 100%; height: 100%; object-fit: cover; opacity: 0.8; transition: transform 0.5s ease;" class="hover:scale-110">
                            @else
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" style="opacity: 0.5;" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                            @endif
                            
                            <div style="position: absolute; top: 1rem; right: 1rem; background: rgba(0,0,0,0.7); border: 1px solid var(--primary-cyan); color: var(--primary-cyan); padding: 0.25rem 0.75rem; border-radius: 4px; font-size: 0.6rem; font-weight: 900; letter-spacing: 1px; backdrop-filter: blur(4px);">
                                {{ $lang === 'id' ? 'TERSEDIA' : 'AVAILABLE' }}
                            </div>
                        </div>
                        
                        <!-- Content Details -->
                        <div style="padding: 1.25rem;">
                            <h3 style="font-size: 1.1rem; font-weight: 800; color: #fff; margin: 0 0 0.5rem 0;">
                                {{ $lab->nama_lab }}
                            </h3>
                            <div style="font-size: 0.8rem; color: var(--text-muted); line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 2.8em;">
                                {{ $lab->deskripsi ?? ($lang === 'id' ? 'Tidak ada deskripsi.' : 'No description.') }}
                            </div>
                            
                            <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.05);">
                                <span style="display: block; font-size: 0.65rem; color: var(--text-muted); margin-bottom: 0.25rem;"><strong>{{ $lang === 'id' ? 'Kepala Lab:' : 'Head Master:' }}</strong> <span style="color:#fff;">{{ $lab->master ? $lab->master->name : ($lang === 'id' ? 'Belum Ditetapkan' : 'Unassigned') }}</span></span>
                                <span style="display: block; font-size: 0.65rem; color: var(--text-muted);"><strong>{{ $lang === 'id' ? 'Asisten Jaga:' : 'Aslab Guard:' }}</strong> 
                                    <span style="color:#fff;">
                                    @if(count($lab->aslabs) > 0)
                                        {{ collect($lab->aslabs)->pluck('name')->join(', ') }}
                                    @else
                                        {{ $lang === 'id' ? 'Belum Ada' : 'None' }}
                                    @endif
                                    </span>
                                </span>
                            </div>
                        </div>
                        
                        <div style="background: rgba(0,217,255,0.1); text-align: center; padding: 0.5rem; font-size: 0.7rem; font-weight: 800; color: var(--primary-cyan); text-transform: uppercase;">
                            {{ $lang === 'id' ? 'KLIK UNTUK PINJAM RUANG ➔' : 'CLICK TO BOOK ROOM ➔' }}
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        @endif
        
    @elseif($tab === 'pengajuan')
        <!-- Flatpickr CDN for Datetime -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">

        <!-- TAB: LOAN REQUEST FORM -->
            <h2 style="font-weight: 900; letter-spacing: 0.1em; margin-top: 0; margin-bottom: 0.5rem; text-transform: uppercase;">
                {{ $lang === 'id' ? 'FORMULIR PENGAJUAN' : 'LOAN PERMIT FORM' }}
            </h2>
            <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 2.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.05);">
                {{ $lang === 'id' ? 'Isi formulir ini untuk meminta hak akses ruangan atau peminjaman inventaris perangkat laboratorium.' : 'Fill out this form to request access to rooms or borrow laboratory equipment inventory.' }}
            </p>

            <form action="{{ route('student.pengajuan.store') }}" method="POST" id="pengajuanForm">
                @csrf
                
                <div class="responsive-grid-2" style="margin-bottom: 2rem;">
                    <!-- Jenis Peminjaman -->
                    <div>
                        <label style="display: block; font-size: 0.75rem; font-weight: bold; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.5rem;">{{ $lang === 'id' ? 'Tipe Peminjaman' : 'Loan Type' }}</label>
                        <select name="jenis_peminjaman" id="jenis_peminjaman" class="hunter-input" required onchange="toggleAlatContainer()">
                            <option value="alat">{{ $lang === 'id' ? 'Pinjam Alat' : 'Equipment' }}</option>
                            <option value="ruang">{{ $lang === 'id' ? 'Pinjam Ruangan' : 'Room' }}</option>
                        </select>
                    </div>
                </div>

                <!-- Pilihan Lab -->
                <div style="margin-bottom: 2.5rem;">
                    <label style="display: block; font-size: 0.75rem; font-weight: bold; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.5rem;">{{ $lang === 'id' ? 'Lokasi Laboratorium' : 'Laboratory Location' }}</label>
                    <div class="radio-card-grid">
                            @if(isset($labs))
                                @foreach($labs as $lab)
                                    <label class="radio-card">
                                        <input type="radio" name="laboratorium_id" value="{{ $lab->id }}" required onchange="filterAlatByLab('{{ $lab->id }}')">
                                        <div class="card-content">
                                            <div class="image-wrapper">
                                                @if(!empty($lab->fotos) && is_array($lab->fotos) && count($lab->fotos) > 0)
                                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($lab->fotos[0]) }}" alt="{{ $lab->nama_lab }}">
                                                @else
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" style="opacity: 0.3; position:absolute; top:50%; left:50%; transform:translate(-50%, -50%);" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                                @endif
                                            </div>
                                            <div class="text-wrapper">
                                                {{ $lab->nama_lab }}
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            @endif
                        </div>
                </div>

                <!-- E-COMMERCE CATALOG ASET -->
                <div class="alat-wrapper-container" id="alat_wrapper">
                    <label style="display: flex; justify-content: space-between; align-items: center; font-size: 0.75rem; font-weight: bold; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.5rem;">
                        <span>{{ $lang === 'id' ? 'KATALOG ASET EKSKLUSIF' : 'EXCLUSIVE ASSET CATALOG' }}</span>
                        @if(isset($semuaAlat))
                        <span style="background: rgba(0,217,255,0.1); border: 1px solid var(--primary-cyan); color: var(--primary-cyan); padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.6rem;">
                            {{ $lang === 'id' ? 'Tersedia: ' : 'Available: ' }} {{ $semuaAlat->count() }} {{ $lang === 'id' ? 'Spesifikasi' : 'Specs' }} | {{ $semuaAlat->sum('available_stok') }} Unit
                        </span>
                        @endif
                    </label>
                    <div style="background: rgba(0,217,255,0.05); color: #00d9ff; border: 1px solid rgba(0,217,255,0.2); padding: 0.75rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.8rem; font-weight: 600; display: flex; align-items: flex-start; gap: 0.75rem;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink: 0;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 16 12 12 12 8"></polyline><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                        <div>
                            {{ $lang === 'id' ? 'TIPS: Silakan pilih lokasi laboratorium di atas terlebih dahulu. Sistem akan secara cerdas menyaring dan hanya menampilkan deretan perangkat keras yang diotorisasi khusus dari instalasi lab yang Anda pilih untuk mencegah pertukaran silang aset.' : 'TIPS: Please select a laboratory location above first. The system will intelligently filter and display only authorized hardware natively belonging to your selected lab facility to prevent cross-asset mapping.' }}
                        </div>
                    </div>

                    <div class="catalog-grid" id="alat_list">
                        @if(isset($semuaAlat))
                            @foreach($semuaAlat as $index => $alat)
                                <div class="catalog-item" id="catalog-item-{{ $alat->id }}" data-lab-id="{{ $alat->laboratorium_id }}" data-index="{{ $index }}" style="display: {{ $index < 15 ? 'flex' : 'none' }};">
                                    <!-- Hidden Inputs untuk form submit -->
                                    <input type="hidden" name="alat_id[]" value="{{ $alat->id }}" id="input-alat-{{ $alat->id }}" disabled>
                                    <input type="hidden" name="jumlah[]" value="0" id="input-qty-{{ $alat->id }}" disabled>
                                    
                                    <div class="image-wrapper">
                                        <div class="stock-badge">{{ $lang === 'id' ? 'Sisa:' : 'Left:' }} {{ $alat->available_stok }}</div>
                                        @if(!empty($alat->fotos) && is_array($alat->fotos) && count($alat->fotos) > 0)
                                            <img src="{{ \Illuminate\Support\Facades\Storage::url($alat->fotos[0]) }}" alt="{{ $alat->nama_alat }}">
                                        @else
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" style="opacity: 0.3; position:absolute; top:50%; left:50%; transform:translate(-50%, -50%);" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                                        @endif
                                    </div>
                                    
                                    <div class="catalog-info" style="gap: 0.5rem;">
                                        <div>
                                            <div class="catalog-code">{{ $alat->kode_alat }}</div>
                                            <div class="catalog-title">{{ $alat->nama_alat }}</div>
                                            <div style="font-size: 0.65rem; color: var(--text-muted); margin-top: 0.5rem; line-height: 1.4;">
                                                <span style="display: block;"><strong>{{ $lang === 'id' ? 'Asal Lab:' : 'Origin Lab:' }}</strong> {{ $alat->laboratorium ? $alat->laboratorium->nama_lab : 'Unknown' }}</span>
                                                <span style="display: block;"><strong>{{ $lang === 'id' ? 'Master Lab:' : 'Head Master:' }}</strong> {{ $alat->laboratorium && $alat->laboratorium->master ? $alat->laboratorium->master->name : 'Unassigned' }}</span>
                                                <span style="display: block;"><strong>{{ $lang === 'id' ? 'Asisten Jaga:' : 'Aslab Guard:' }}</strong> 
                                                    @if($alat->laboratorium && count($alat->laboratorium->aslabs) > 0)
                                                        {{ collect($alat->laboratorium->aslabs)->pluck('name')->join(', ') }}
                                                    @else
                                                        {{ $lang === 'id' ? 'Belum Ada Penugasan' : 'No Assignment' }}
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                        <div class="catalog-counter">
                                            <button type="button" onclick="updateQty('{{ $alat->id }}', -1, {{ $alat->available_stok }})">-</button>
                                            <span class="qty-display" id="display-qty-{{ $alat->id }}">0</span>
                                            <button type="button" onclick="updateQty('{{ $alat->id }}', 1, {{ $alat->available_stok }})">+</button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <!-- Client-Side Pagination Toggle -->
                    @if(isset($semuaAlat) && $semuaAlat->count() > 15)
                    <div id="catalog-pagination" style="display: flex; justify-content: center; gap: 0.5rem; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid rgba(255,255,255,0.05);">
                        <button type="button" onclick="changeCatalogPage(-1)" class="hunter-btn" style="width: auto; padding: 0.5rem 1.5rem; background: rgba(0,0,0,0.5); border: 1px solid var(--accent-cyan); color: var(--accent-cyan);">&laquo; {{ $lang === 'id' ? 'SEBELUMNYA' : 'PREV' }}</button>
                        <span id="catalog-page-indicator" style="display: flex; align-items: center; justify-content: center; min-width: 40px; font-weight: bold; color: #fff;">1</span>
                        <button type="button" onclick="changeCatalogPage(1)" class="hunter-btn" style="width: auto; padding: 0.5rem 1.5rem; background: rgba(0,0,0,0.5); border: 1px solid var(--accent-cyan); color: var(--accent-cyan);">{{ $lang === 'id' ? 'SELANJUTNYA' : 'NEXT' }} &raquo;</button>
                    </div>
                    @endif
                </div>

                <!-- Trigger Button Agenda Jadwal -->
                <div id="btn_show_schedule_container" style="display: none; margin-bottom: 2rem; background: rgba(234, 179, 8, 0.05); border: 1px solid rgba(234, 179, 8, 0.2); padding: 1.25rem; border-radius: 12px; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                    <div>
                        <h4 style="color: #eab308; margin-top: 0; margin-bottom: 0.5rem; font-size: 0.85rem; display: flex; align-items: center; gap: 0.5rem;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                            {{ $lang === 'id' ? 'DATABASE AGENDA SIBUK' : 'BUSY AGENDA DATABASE' }}
                        </h4>
                        <div style="font-size: 0.7rem; color: var(--text-muted);">{{ $lang === 'id' ? 'Hindari waktu merah agar tidak bentrok dengan reservasi yang tertera.' : 'Avoid red times to prevent clashes with existing reservations.' }}</div>
                    </div>
                    <button type="button" onclick="openScheduleModal()" style="background: rgba(234, 179, 8, 0.1); border: 1px solid #eab308; color: #eab308; padding: 0.5rem 1rem; border-radius: 6px; font-weight: bold; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.background='rgba(234, 179, 8, 0.2)'" onmouseout="this.style.background='rgba(234, 179, 8, 0.1)'">
                        {{ $lang === 'id' ? 'Buka Pop-up Agenda' : 'Open Agenda Modal' }}
                    </button>
                </div>

                <!-- MODAL JADWAL (POP-UP) -->
                <div id="scheduleModal" onclick="if(event.target === this) this.style.display='none'" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 9999; align-items: center; justify-content: center; backdrop-filter: blur(4px); cursor: pointer;">
                    <div style="background: #0f1023; border: 1px solid #eab308; border-radius: 12px; width: 90%; max-width: 500px; max-height: 80vh; display: flex; flex-direction: column; overflow: hidden; box-shadow: 0 0 30px rgba(234, 179, 8, 0.2); animation: fade-in-up 0.3s ease-out;">
                        <div style="padding: 1rem 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.1); display: flex; justify-content: space-between; align-items: center; background: rgba(234, 179, 8, 0.05);">
                            <h3 style="margin: 0; color: #eab308; font-size: 1rem; font-weight: 800; display:flex; align-items:center; gap:0.5rem;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                {{ $lang === 'id' ? 'Agenda Sibuk Lab Terpilih' : 'Selected Lab Agenda' }}
                            </h3>
                            <button type="button" onclick="this.closest('#scheduleModal').style.display='none'" style="background: none; border: none; color: #fff; cursor: pointer; font-size: 1.5rem; line-height: 1; padding: 0.25rem;">&times;</button>
                        </div>
                        <div id="schedule_content" style="padding: 1.5rem; overflow-y: auto; display: flex; flex-direction: column; gap: 0.75rem;">
                            <!-- Injected rows by script -->
                        </div>
                    </div>
                </div>

                <!-- Waktu Peminjaman -->
                <div class="responsive-grid-2">
                    <div>
                        <label style="display: block; font-size: 0.75rem; font-weight: bold; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.5rem;">{{ $lang === 'id' ? 'Waktu Mulai' : 'Start Time' }}</label>
                        <input type="text" name="tanggal_mulai" class="hunter-input flatpickr-input" required placeholder="{{ $lang === 'id' ? 'Pilih tanggal & waktu' : 'Select date & time' }}">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.75rem; font-weight: bold; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.5rem;">{{ $lang === 'id' ? 'Batas Pengembalian' : 'End Time / Return' }}</label>
                        <input type="text" name="tanggal_selesai" class="hunter-input flatpickr-input" required placeholder="{{ $lang === 'id' ? 'Pilih tanggal & waktu' : 'Select date & time' }}">
                    </div>
                </div>

                <!-- Tujuan -->
                <div style="margin-bottom: 2.5rem;">
                    <label style="display: block; font-size: 0.75rem; font-weight: bold; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.5rem;">{{ $lang === 'id' ? 'Tujuan Peminjaman / Detail Tugas' : 'Purpose / Task Details' }}</label>
                    <textarea name="tujuan_peminjaman" class="hunter-input" style="min-height: 120px; resize: none;" required placeholder="{{ $lang === 'id' ? 'Jelaskan untuk proyek kelas apa atau tujuan penggunaan aset ini...' : 'Explain for what class project or the purpose of using these assets...' }}"></textarea>
                </div>

                <!-- Submit Drop -->
                <button type="submit" class="hunter-btn submit-btn">
                    {{ $lang === 'id' ? 'AJUKAN SEKARANG' : 'SUBMIT NOW' }}
                </button>
            </form>

    @elseif($tab === 'riwayat')
        <!-- TAB: HISTORY LOG -->
        <div class="print-hide">
            <h2 style="font-weight: 900; letter-spacing: 0.1em; margin-top: 0; margin-bottom: 0.5rem; text-transform: uppercase;">
                {{ $lang === 'id' ? 'BUKU BESAR RIWAYAT' : 'HISTORY LOG ARCHIVE' }}
            </h2>
            <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.05);">
                {{ $lang === 'id' ? 'Seluruh rekam jejak pengajuan peminjaman Anda beserta status real-time.' : 'All your loan request history tracks and their real-time statuses.' }}
            </p>
        </div>

        <!-- Status Filter Buttons -->
        <div class="print-hide" style="display: flex; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 2rem;">
            <button class="history-filter-btn active" onclick="filterRiwayat('all', this)">{{ $lang === 'id' ? 'SEMUA' : 'ALL' }}</button>
            <button class="history-filter-btn" onclick="filterRiwayat('menunggu', this)">{{ $lang === 'id' ? 'MENUNGGU' : 'PENDING' }}</button>
            <button class="history-filter-btn" onclick="filterRiwayat('disetujui', this)">{{ $lang === 'id' ? 'DISETUJUI' : 'APPROVED' }}</button>
            <button class="history-filter-btn" onclick="filterRiwayat('dipinjam', this)">{{ $lang === 'id' ? 'DIPINJAM' : 'ACTIVE' }}</button>
            <button class="history-filter-btn" onclick="filterRiwayat('dikembalikan', this)">{{ $lang === 'id' ? 'SELESAI' : 'RETURNED' }}</button>
            <button class="history-filter-btn" onclick="filterRiwayat('ditolak', this)">{{ $lang === 'id' ? 'DITOLAK' : 'REJECTED' }}</button>
        </div>

        @if(isset($riwayats) && $riwayats->isEmpty())
            <div style="text-align: center; padding: 4rem 1rem; border: 1px dashed rgba(255,255,255,0.1); border-radius: 1rem;">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="1.5" style="margin: 0 auto 1rem; opacity: 0.5;">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline>
                </svg>
                <p style="color: var(--text-muted);">{{ $lang === 'id' ? 'Anda belum memiliki rekam jejak peminjaman apapun.' : 'You do not have any loan history records yet.' }}</p>
                <a href="{{ route('student.dashboard', ['tab' => 'pengajuan']) }}" class="hunter-btn" style="display: inline-block; margin-top: 1rem; padding: 0.75rem 1.5rem; width: auto; font-size: 0.8rem;">
                    {{ $lang === 'id' ? 'AJUKAN SEKARANG' : 'REQUEST NOW' }}
                </a>
            </div>
        @else
            <div id="riwayat-container">
                @foreach($riwayats as $riw)
                    <div class="riwayat-card" id="riwayat-{{ $riw->id }}" data-status="{{ $riw->status }}">
                        
                        <!-- Print-only Identity Header -->
                        <div class="print-only-identity" style="display: none; border-bottom: 2px dashed #000; padding-bottom: 1.5rem; margin-bottom: 1.5rem; text-align: center;">
                            <h1 style="margin: 0; font-weight: 900; font-size: 1.6rem; letter-spacing: 0.05em; text-transform: uppercase;">Bukti Transaksi SIM-LAB</h1>
                            <p style="margin: 0.5rem 0 0; font-size: 1rem;"><strong>{{ $lang === 'id' ? 'Peminjam' : 'Borrower' }}:</strong> {{ $user->name }} ({{ $user->nomor_induk }})</p>
                            <p style="margin: 0.2rem 0; font-size: 0.9rem;"><strong>{{ $lang === 'id' ? 'ID Resi' : 'Receipt ID' }}:</strong> #REQ-{{ str_pad($riw->id, 5, '0', STR_PAD_LEFT) }}</p>
                            <p style="margin: 0.2rem 0; font-size: 0.8rem; color: #555 !important;">Dicetak pada: {{ \Carbon\Carbon::now()->format('d M Y H:i:s') }}</p>
                        </div>

                        <!-- Header Card -->
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 1rem;">
                            <div>
                                <h3 style="margin: 0 0 0.25rem; font-size: 1.1rem; font-weight: 800; color: #fff;">
                                    {{ $riw->jenis_peminjaman === 'alat' ? ($lang === 'id' ? 'Peminjaman Alat' : 'Equipment Loan') : ($lang === 'id' ? 'Peminjaman Ruang' : 'Room Loan') }}
                                </h3>
                                <p style="margin: 0; font-size: 0.75rem; color: var(--text-muted);">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 4px; margin-top: -2px;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                    {{ \Carbon\Carbon::parse($riw->created_at)->format('d M Y - H:i') }}
                                </p>
                            </div>
                            <!-- Status Badge -->
                            <div>
                                <span class="status-badge status-{{ $riw->status }}">
                                    @php
                                        $statusStr = strtoupper($riw->status);
                                        if($lang === 'en') {
                                            if($riw->status === 'menunggu') $statusStr = 'PENDING';
                                            if($riw->status === 'disetujui') $statusStr = 'APPROVED';
                                            if($riw->status === 'dipinjam') $statusStr = 'ACTIVE';
                                            if($riw->status === 'dikembalikan') $statusStr = 'RETURNED';
                                            if($riw->status === 'ditolak') $statusStr = 'REJECTED';
                                        }
                                    @endphp
                                    {{ $statusStr }}
                                </span>
                            </div>
                        </div>

                        <!-- Body Card -->
                        <div class="riwayat-detail-grid">
                            <div>
                                <p style="margin: 0 0 0.25rem; font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; font-weight: bold;">{{ $lang === 'id' ? 'Laboratorium' : 'Laboratory' }}</p>
                                <p style="margin: 0; font-size: 0.85rem; font-weight: 600; color: #fff;">{{ $riw->laboratorium ? $riw->laboratorium->nama_lab : 'Unknown' }}</p>
                            </div>
                            <div>
                                <p style="margin: 0 0 0.25rem; font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; font-weight: bold;">{{ $lang === 'id' ? 'Jadwal Mulai' : 'Start Schedule' }}</p>
                                <p style="margin: 0; font-size: 0.85rem; font-weight: 600; color: #fff;">{{ \Carbon\Carbon::parse($riw->tanggal_mulai)->format('d M Y, H:i') }}</p>
                            </div>
                            <div style="grid-column: 1 / -1;">
                                <p style="margin: 0 0 0.25rem; font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; font-weight: bold;">{{ $lang === 'id' ? 'Batas Pengembalian' : 'Return Due' }}</p>
                                <p style="margin: 0; font-size: 0.85rem; font-weight: 600; color: #fff;">{{ \Carbon\Carbon::parse($riw->tanggal_selesai)->format('d M Y, H:i') }}</p>
                            </div>
                            <div style="grid-column: 1 / -1; margin-top: 0.5rem;">
                                <p style="margin: 0 0 0.25rem; font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; font-weight: bold;">{{ $lang === 'id' ? 'Tujuan' : 'Purpose' }}</p>
                                <p style="margin: 0; font-size: 0.85rem; color: #ccc; line-height: 1.5; background: rgba(0,0,0,0.3); padding: 0.75rem; border-radius: 0.5rem; border: 1px solid rgba(255,255,255,0.05); font-style: italic;">
                                    "{{ $riw->tujuan_peminjaman }}"
                                </p>
                            </div>
                        </div>

                        <!-- Sub-List Alat -->
                        @if($riw->jenis_peminjaman === 'alat' && $riw->detailPeminjaman && $riw->detailPeminjaman->count() > 0)
                            <div style="margin-top: 0.5rem;">
                                <p style="margin: 0 0 0.5rem; font-size: 0.75rem; color: var(--accent-cyan); font-weight: bold; text-transform: uppercase;">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 4px; margin-top: -2px;"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                                    {{ $lang === 'id' ? 'Alat Dipinjam' : 'Borrowed Items' }} ({{ $riw->detailPeminjaman->count() }})
                                </p>
                                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                    @foreach($riw->detailPeminjaman as $detail)
                                        <div style="display: flex; justify-content: space-between; align-items: center; background: rgba(255,255,255,0.03); padding: 0.75rem; border-radius: 0.5rem; border: 1px solid rgba(255,255,255,0.02);">
                                            <span style="font-size: 0.8rem; font-weight: 600; color: #fff;">{{ $detail->alat ? $detail->alat->nama_alat : 'Alat Dihapus' }}</span>
                                            <span style="font-size: 0.75rem; color: var(--text-muted); background: #000; padding: 0.2rem 0.5rem; border-radius: 4px;">{{ $detail->jumlah }}x</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Footer Spesial PDF: Penanggung Jawab / Approver -->
                        @if(in_array($riw->status, ['disetujui', 'dipinjam', 'selesai', 'dikembalikan']) && $riw->approval->count() > 0)
                            @php
                                // Ambil siapa yang terakhir menyetujui transaksi ini
                                $latestApproval = $riw->approval->where('status_approval', 'disetujui')->last();
                                $approver = $latestApproval ? $latestApproval->approver : null;
                            @endphp
                            @if($approver)
                            <div class="print-only-footer" style="display: none; border-top: 2px dashed #000; padding-top: 1.5rem; text-align: left;">
                                <p style="margin: 0 0 0.5rem; font-size: 0.85rem; font-weight: bold; text-transform: uppercase;">Disahkan & Disetujui Oleh:</p>
                                <p style="margin: 0; font-size: 1.1rem; font-weight: 900;">{{ $approver->name }}</p>
                                <p style="margin: 0.2rem 0; font-size: 0.85rem;"><strong>Wewenang:</strong> {{ strtoupper($approver->role) === 'MASTER' ? 'Master Lab / Dosen Penanggung Jawab' : 'Asisten Laboratorium' }}</p>
                                <p style="margin: 0.2rem 0; font-size: 0.85rem;"><strong>Email Resmi:</strong> {{ $approver->email }}</p>
                            </div>
                            @endif
                        @endif

                        <!-- Tombol Batal Peminjaman -->
                        @if($riw->status === 'menunggu')
                            <div style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px dashed rgba(255,255,255,0.05); text-align: right;" class="print-hide">
                                <form action="{{ route('student.peminjaman.cancel', $riw->id) }}" method="POST" style="display: inline-block;" onsubmit="confirmDestructiveAction(event, this, '{{ $lang }}', 'Are you sure you want to cancel this request? This action cannot be undone.', 'Apakah Anda yakin ingin membatalkan pengajuan ini? Tindakan ini tidak dapat diubah.')">
                                    @csrf
                                    <button type="submit" class="hunter-btn" style="padding: 0.5rem 1rem; width: auto; font-size: 0.75rem; background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid #ef4444;">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 4px; margin-top: -2px;"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                                        {{ $lang === 'id' ? 'BATALKAN PENGAJUAN' : 'CANCEL REQUEST' }}
                                    </button>
                                </form>
                            </div>
                        @endif

                        <!-- Tombol Cetak PDF -->
                        @if(in_array($riw->status, ['disetujui', 'dipinjam', 'selesai']))
                            <div style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px dashed rgba(255,255,255,0.05); text-align: right;" class="print-hide">
                                <button type="button" onclick="printReceipt('riwayat-{{ $riw->id }}')" class="hunter-btn" style="padding: 0.5rem 1rem; width: auto; font-size: 0.75rem; background: rgba(0, 217, 255, 0.1); color: var(--accent-cyan); border: 1px solid var(--accent-cyan);">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 4px; margin-top: -2px;"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                                    {{ $lang === 'id' ? 'CETAK BUKTI PDF' : 'PRINT PDF RECEIPT' }}
                                </button>
                            </div>
                        @endif

                    </div>
                @endforeach
            </div>
        @endif

    @else
        <div class="coming-soon-wrapper">
            <div style="width: 80px; height: 80px; background: rgba(0,217,255,0.1); border-radius: 50%; color: var(--accent-cyan); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
            </div>
            <h2 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 0.5rem;">MODUL TERKUNCI</h2>
            <p style="color: var(--text-muted); max-width: 400px; margin: 0 auto; font-size: 0.85rem;">UI untuk sistem <strong>{{ $tabTitle }}</strong> akan diaktifkan secara bertahap pada fase arsitektur berikutnya sesuai keputusan Anda.</p>
        </div>
    @endif
</div>

<script>
    const avatarInput = document.getElementById('avatar-input');
    if(avatarInput) {
        avatarInput.addEventListener('change', function(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('avatar-preview');
                const placeholder = document.getElementById('avatar-placeholder');
                
                output.src = reader.result;
                output.style.display = 'inline-block';
                
                if(placeholder) {
                    placeholder.style.display = 'none';
                }
            };
            if(event.target.files[0]){
                reader.readAsDataURL(event.target.files[0]);
            }
        });
    }

    function togglePassword(btn) {
        const input = btn.previousElementSibling;
        const svg = btn.querySelector('svg');
        if(input.type === 'password') {
            input.type = 'text';
            svg.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
            btn.style.color = '#ef4444'; // Red active text like danger tab
        } else {
            input.type = 'password';
            svg.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
            btn.style.color = 'var(--text-muted)';
        }
    }

    // --- LOGIKA PENGAJUAN PEMINJAMAN ---
    function toggleAlatContainer() {
        const jenis = document.getElementById('jenis_peminjaman').value;
        const alatWrapper = document.getElementById('alat_wrapper');
        const alatInputs = alatWrapper.querySelectorAll('input[type="hidden"]');
        
        if (jenis === 'ruang') {
            alatWrapper.style.display = 'none';
            // Disable all hidden inputs so they are not submitted
            alatInputs.forEach(el => el.disabled = true);
            document.getElementById('btn_show_schedule_container').style.display = 'flex';
        } else {
            alatWrapper.style.display = 'block';
            document.getElementById('btn_show_schedule_container').style.display = 'flex';
            // Only re-enable the inputs that have quantity > 0
            alatInputs.forEach(el => {
                const alatId = el.id.replace('input-alat-', '').replace('input-qty-', '');
                const qty = parseInt(document.getElementById('input-qty-' + alatId)?.value || 0);
                if (qty > 0) {
                    el.disabled = false;
                }
            });
        }
    }

    function openScheduleModal() {
        const modal = document.getElementById('scheduleModal');
        modal.style.display = 'flex';
    }

    // Variabel Global Data Agenda
    const globalSchedules = {!! isset($scheduleEvents) ? $scheduleEvents : '[]' !!};

    function filterAlatByLab(labId) {
        // --- 1. FILTER KATALOG ASET ---
        document.querySelectorAll('.catalog-item').forEach(el => {
            const qtyInput = el.querySelector('input[type="hidden"][name="jumlah[]"]');
            if (qtyInput) {
                const alatIdMatch = qtyInput.id.replace('input-qty-','');
                updateQty(alatIdMatch, -9999, parseInt(qtyInput.value) || 1); // Reset keras ke 0
            }

            if (!labId || el.getAttribute('data-lab-id') === labId) {
                el.style.display = 'flex';
                el.style.animation = 'fade-in-up 0.4s ease-out';
            } else {
                el.style.display = 'none';
            }
        });

        // Hide pagination bila di-filter spesifik
        const pagin = document.getElementById('catalog-pagination');
        if (pagin) {
            pagin.style.display = labId ? 'none' : 'flex';
        }

        // --- 2. UPDATE AGENDA SCHEDULE ---
        const jenis = document.getElementById('jenis_peminjaman').value;
        const scheduleContent = document.getElementById('schedule_content');
        scheduleContent.innerHTML = ''; // Kosongkan dulu
        
        let filteredEvents = globalSchedules.filter(evt => evt.lab_id == labId && evt.jenis === jenis);
        
        if (filteredEvents.length === 0) {
            scheduleContent.innerHTML = `<div style="color: #22c55e; font-size: 0.75rem; font-weight: bold;">{{ $lang === 'id' ? 'Jadwal kosong (Aman dipinjam kapan saja) ✔' : 'Schedule clear (Safe to borrow anytime) ✔' }}</div>`;
        } else {
            filteredEvents.forEach(evt => {
                const startObj = new Date(evt.start);
                const endObj = new Date(evt.end);
                const formatOpts = { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' };
                
                const html = `
                <div style="background: rgba(0,0,0,0.3); border-left: 3px solid #eab308; padding: 0.6rem; border-radius: 4px; display: flex; flex-direction: column; gap: 0.25rem;">
                    <span style="font-size: 0.65rem; color: #fff; font-weight: bold; line-height: 1.2;">${evt.title}</span>
                    <span style="font-size: 0.65rem; color: var(--text-muted);">${startObj.toLocaleString('{{ $lang }}', formatOpts)} - ${endObj.toLocaleString('{{ $lang }}', formatOpts)}</span>
                </div>`;
                scheduleContent.innerHTML += html;
            });
        }
    }

    function updateQty(alatId, change, maxStok) {
        const qtyInput = document.getElementById('input-qty-' + alatId);
        const alatInput = document.getElementById('input-alat-' + alatId);
        const displaySpan = document.getElementById('display-qty-' + alatId);
        const cardItem = document.getElementById('catalog-item-' + alatId);
        
        let currentQty = parseInt(qtyInput.value) || 0;
        let newQty = currentQty + change;
        
        // Boundaries checks
        if (newQty < 0) newQty = 0;
        if (newQty > maxStok) {
            Swal.fire({
                icon: 'warning',
                title: 'Stok Terbatas',
                text: 'Kuantitas tidak dapat melebihi stok yang tersedia!',
                background: '#0a0c10', color: '#fff', confirmButtonColor: '#00d9ff'
            });
            return;
        }
        
        // Update DOM
        qtyInput.value = newQty;
        displaySpan.innerText = newQty;
        
        // Form states
        if (newQty > 0) {
            qtyInput.disabled = false;
            alatInput.disabled = false;
            cardItem.classList.add('selected');
        } else {
            qtyInput.disabled = true;
            alatInput.disabled = true;
            cardItem.classList.remove('selected');
        }
    }

    // Client Side Pagination Logic
    let currentCatalogPage = 1;
    const itemsPerPage = 15;
    
    function changeCatalogPage(direction) {
        const items = document.querySelectorAll('.catalog-item');
        const maxPage = Math.ceil(items.length / itemsPerPage);
        
        currentCatalogPage += direction;
        
        // Boundaries
        if (currentCatalogPage < 1) currentCatalogPage = 1;
        if (currentCatalogPage > maxPage) currentCatalogPage = maxPage;
        
        document.getElementById('catalog-page-indicator').innerText = currentCatalogPage;
        
        const startIdx = (currentCatalogPage - 1) * itemsPerPage;
        const endIdx = startIdx + itemsPerPage - 1;
        
        items.forEach((item) => {
            const idx = parseInt(item.getAttribute('data-index'));
            if (idx >= startIdx && idx <= endIdx) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    }

    // Inisialisasi on load
    document.addEventListener("DOMContentLoaded", function() {
        if(document.getElementById('jenis_peminjaman')) {
            // URL Auto-Select Logic
            const urlParams = new URLSearchParams(window.location.search);
            const autoJenis = urlParams.get('auto_jenis');
            const autoLab = urlParams.get('auto_lab');
            const autoAlat = urlParams.get('auto_alat');
            
            if (autoJenis) {
                const jenisInput = document.getElementById('jenis_peminjaman');
                if(jenisInput) {
                    jenisInput.value = autoJenis;
                    toggleAlatContainer();
                }
            } else {
                toggleAlatContainer();
            }
            
            if (autoLab) {
                // Beri sedikit delay agar event listener onChange siap
                setTimeout(() => {
                    const labRadio = document.querySelector(`input[name="laboratorium_id"][value="${autoLab}"]`);
                    if(labRadio) {
                        labRadio.checked = true;
                        filterAlatByLab(autoLab);
                        
                        // Bila ada auto alat spesifik yang di klik dari luar
                        if(autoAlat) {
                            setTimeout(() => {
                                // Eksekusi virtual +1 pada stok display
                                const btnContainer = document.getElementById('display-qty-' + autoAlat);
                                if(btnContainer && btnContainer.parentElement) {
                                    const nextBtnStr = btnContainer.parentElement.innerHTML;
                                    const regex = /updateQty\('[\d]+', 1, (\d+)\)/;
                                    const match = regex.exec(nextBtnStr);
                                    let maxS = 999;
                                    if(match) maxS = parseInt(match[1]);
                                    
                                    // Reset ke 0 lalu ke 1
                                    updateQty(autoAlat, -999, maxS);
                                    updateQty(autoAlat, 1, maxS);
                                }
                            }, 50);
                        }

                        // Auto-scroll pelan ke area form
                        window.scrollTo({
                            top: document.getElementById('jenis_peminjaman').offsetTop - 100,
                            behavior: 'smooth'
                        });
                    }
                }, 100);
            }
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        flatpickr(".flatpickr-input", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true,
            minDate: "today",
            disableMobile: "true",
            minTime: "07:00",
            maxTime: "18:00",
            disable: [
                function(date) {
                    // Return true to disable (0 = Sunday, 6 = Saturday)
                    return (date.getDay() === 0 || date.getDay() === 6);
                }
            ],
            locale: {
                firstDayOfWeek: 1 // Start week on Monday
            }
        });
    });

    // History Filter Logic
    function filterRiwayat(status, btnElement) {
        // Update active class on buttons
        const buttons = document.querySelectorAll('.history-filter-btn');
        buttons.forEach(btn => btn.classList.remove('active'));
        btnElement.classList.add('active');

        // Filter cards
        const cards = document.querySelectorAll('.riwayat-card');
        cards.forEach(card => {
            if (status === 'all' || card.getAttribute('data-status') === status) {
                card.style.display = 'flex';
                // Add tiny animation to make it feel fresh
                card.style.animation = 'none';
                card.offsetHeight; // trigger reflow
                card.style.animation = 'fade-in-up 0.4s ease-out';
            } else {
                card.style.display = 'none';
            }
        });
    }

    function printReceipt(id) {
        const card = document.getElementById(id);
        if (card) {
            // Sembunyikan elemen utama dan tampilkan elemen spesifik di mode layar HTML
            card.classList.add('print-active');
            window.print();
            // Lepaskan kembali mode cetak setelah dialog print ditutup
            card.classList.remove('print-active');
        }
    }
</script>

@push('scripts')
<script>
    // Sweetalert native dicoverage melalui admin layout interceptor
</script>
@endpush
@endsection
