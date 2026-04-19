<style>
    .admin-overview-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .admin-stat-card {
        background: rgba(10, 16, 22, 0.7);
        border: 1px solid var(--panel-border);
        border-radius: 12px;
        padding: 1.5rem;
        position: relative;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
        cursor: pointer;
    }

    .admin-stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 20px rgba(0, 217, 255, 0.15);
    }

    .admin-stat-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: var(--accent-cyan);
    }

    .stat-card-warning::before { background: #eab308; }
    .stat-card-danger::before { background: #ef4444; }
    .stat-card-success::before { background: #22c55e; }

    .stat-icon {
        position: absolute;
        right: -10px;
        bottom: -10px;
        opacity: 0.05;
        width: 100px;
        height: 100px;
        color: var(--text-light);
    }

    .stat-value {
        font-size: clamp(2rem, 4vw, 2.5rem);
        font-weight: 900;
        color: var(--text-light);
        margin: 0.5rem 0;
        text-shadow: 0 0 15px rgba(255,255,255,0.1);
        word-wrap: break-word;
        word-break: break-all;
        line-height: 1.1;
    }

    .stat-label {
        font-size: 0.85rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.1em;
        font-weight: 800;
    }

    .role-dist-container {
        background: rgba(10, 16, 22, 0.7);
        border: 1px solid var(--panel-border);
        border-radius: 12px;
        padding: 2rem;
    }

    .role-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .role-box {
        background: rgba(0, 0, 0, 0.4);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 8px;
        padding: 1.2rem;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: center;
        gap: 0.8rem;
    }

    .role-box .role-name {
        font-size: 0.8rem;
        text-transform: uppercase;
        font-weight: 800;
        color: var(--text-muted);
    }

    .role-box .role-count {
        font-size: clamp(1.5rem, 3.5vw, 2rem);
        font-weight: 900;
        color: var(--accent-cyan);
        word-wrap: break-word;
        word-break: break-all;
        line-height: 1;
    }
</style>

<div class="welcome-banner" style="background: radial-gradient(circle at 100% 0%, rgba(0, 217, 255, 0.1) 0%, transparent 50%), linear-gradient(135deg, rgba(10, 12, 16, 0.8) 0%, rgba(2, 4, 10, 0.9) 100%); border: 1px solid rgba(0, 217, 255, 0.2); border-radius: 1rem; padding: clamp(1.5rem, 4vw, 2.5rem); margin-bottom: 2rem;">
    <h1 class="welcome-title" style="font-size: clamp(1.5rem, 4vw, 2.2rem); font-weight: 900; margin: 0 0 0.5rem 0; background: linear-gradient(to right, #fff, var(--accent-cyan)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; line-height: 1.2;">
        {{ $lang === 'id' ? 'Terminal Pusat Intelijen Sistem' : 'System Intelligence Central Terminal' }}
    </h1>
    <p class="welcome-subtitle" style="color: var(--text-muted); font-size: clamp(0.85rem, 2vw, 0.95rem); max-width: 700px; line-height: 1.6; margin: 0;">
        {{ $lang === 'id' ? 'Selamat datang kembali, Administrator. Anda berada di tingkat tertinggi Otoritas Data. Segala kerusakan hierarki yang dilakukan di ruangan ini tidak dapat dipulihkan.' : 'Welcome back, Administrator. You are at the highest tier of Data Authority. Any hierarchy damage done in this room is irreversible.' }}
    </p>
</div>

<!-- TOP METRICS -->
<div class="admin-overview-grid">
    <a href="{{ route('admin.dashboard', ['tab' => 'users']) }}" class="admin-stat-card" style="text-decoration: none; display: block;">
        <svg class="stat-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
        <div class="stat-label">{{ $lang === 'id' ? 'Total Populasi Akun' : 'Total Account Population' }}</div>
        <div class="stat-value">{{ number_format($totalUsers) }}</div>
        <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $lang === 'id' ? 'Entitas di-database' : 'Entities in database' }}</div>
    </a>

    <a href="{{ route('admin.dashboard', ['tab' => 'logs']) }}" class="admin-stat-card stat-card-warning" style="text-decoration: none; display: block;">
        <svg class="stat-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
        <div class="stat-label">{{ $lang === 'id' ? 'Total Riwayat Transaksi' : 'Total Transaction History' }}</div>
        <div class="stat-value" style="color: #eab308;">{{ number_format($totalPeminjaman) }}</div>
        <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $lang === 'id' ? 'Siklus pinjam/ruang/alat' : 'Borrow cycles' }}</div>
    </a>

    <a href="{{ route('admin.dashboard', ['tab' => 'logs']) }}" class="admin-stat-card stat-card-success" style="text-decoration: none; display: block;">
        <svg class="stat-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
        <div class="stat-label">{{ $lang === 'id' ? 'Peminjaman Aktif (Live)' : 'Live Borrowings' }}</div>
        <div class="stat-value" style="color: #22c55e;">{{ number_format($activePeminjaman) }}</div>
        <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $lang === 'id' ? 'Sedang menunggu/dipinjam' : 'Currently pending/borrowed' }}</div>
    </a>
</div>

<!-- ROLE DISTRIBUTION MATRIX -->
<div class="role-dist-container">
    <h3 style="margin-top: 0; font-weight: 900; color: #fff; text-transform: uppercase;">{{ $lang === 'id' ? 'Topografi Otoritas Pengguna' : 'User Authority Topography' }}</h3>
    <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 0;">{{ $lang === 'id' ? 'Distribusi pangkat dari total entitas yang tercatat di pangkalan data saat ini.' : 'Rank distribution of tracked entities.' }}</p>
    
    <div class="role-grid">
        @php
            $roles = ['mahasiswa', 'asisten', 'master', 'dosen', 'admin'];
            $roleNamesId = ['Mahasiswa', 'Asisten Lab', 'Master Lab', 'Dosen', 'Admin Sistem'];
            $roleNamesEn = ['Student', 'Lab Assistant', 'Lab Master', 'Lecturer', 'System Admin'];
        @endphp

        @foreach($roles as $index => $rKey)
            <div class="role-box">
                <div class="role-name">{{ $lang === 'id' ? $roleNamesId[$index] : $roleNamesEn[$index] }}</div>
                <div class="role-count">
                    {{ isset($roleDistribution[$rKey]) ? $roleDistribution[$rKey] : 0 }}
                </div>
            </div>
        @endforeach
    </div>
</div>
