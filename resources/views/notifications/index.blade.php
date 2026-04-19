@php
    $role = Auth::user() ? Auth::user()->role : 'guest';
    $layout = 'layouts.public';
    if ($role === 'mahasiswa') {
        $layout = 'layouts.student';
    } elseif (in_array($role, ['admin', 'dosen', 'master', 'asisten'])) {
        $layout = 'layouts.admin';
    }
@endphp

@extends($layout)

@section('title', 'Pusat Notifikasi | SIM-LAB')

@section('content')
<style>
    .notif-container {
        max-width: 800px;
        margin: 0 auto;
        animation: fade-in-up 0.5s ease-out;
    }
    .notif-header {
        margin-bottom: 2rem;
    }
    .notif-header h1 {
        font-size: 2rem;
        font-weight: 900;
        text-transform: uppercase;
        color: #fff;
        margin: 0 0 0.5rem;
        letter-spacing: 0.05em;
    }
    .notif-header p {
        color: var(--text-muted);
        font-size: 0.9rem;
        margin: 0;
    }
    .notif-card {
        background: rgba(10, 12, 16, 0.6);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 1rem;
        padding: 1.5rem;
        margin-bottom: 1rem;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .notif-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(0,217,255,0.1);
        border-color: rgba(0,217,255,0.3);
    }
    @media (max-width: 768px) {
        .notif-container { padding: 1rem !important; }
        .notif-header h1 { font-size: 1.5rem; }
    }
</style>

<div class="notif-container" style="padding: 2rem 0;">
    <div class="notif-header">
        @if($role === 'dosen')
            <h1 style="color: var(--accent-cyan); display: flex; align-items: center; gap: 0.5rem;">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                {{ $lang === 'en' ? 'Lecturer Warning Radar' : 'Radar Peringatan Dosen' }}
            </h1>
            <p>{{ $lang === 'en' ? 'Early warning system for critical equipment inventory and lab capacity.' : 'Sistem peringatan dini (Early Warning System) atas anomali alat kritis dan kapasitas lab.' }}</p>
        @else
            <h1>{{ $lang === 'en' ? 'Notification Center' : 'Pusat Notifikasi' }}</h1>
            <p>{{ $lang === 'en' ? 'All historical alerts and updates.' : 'Semua riwayat pembaruan dan peringatan sistem.' }}</p>
        @endif
    </div>

    @if(isset($notifikasis) && $notifikasis->count() > 0)
        @foreach($notifikasis as $notif)
            @php
                $targetRoute = null;
                $btnText = $lang === 'en' ? 'Open Related Board' : 'Buka Halaman Terkait';
                $pesanLower = strtolower($notif->pesan);
                $judulLower = strtolower($notif->judul);
                $gabunganPesan = $pesanLower . ' ' . $judulLower;

                // --- SISTEM DETEKSI POLA CERDAS (SMART PATTERN MATCHING) ---
                if ($role === 'admin') {
                    if (str_contains($gabunganPesan, 'pengguna') || str_contains($gabunganPesan, 'akun') || str_contains($gabunganPesan, 'jabatan') || str_contains($gabunganPesan, 'otoritas')) {
                        $targetRoute = route('admin.dashboard', ['tab' => 'users']);
                    } elseif (str_contains($gabunganPesan, 'sandi') || str_contains($gabunganPesan, 'password') || str_contains($gabunganPesan, 'profil')) {
                        $targetRoute = route('admin.dashboard', ['tab' => 'settings']);
                    } else {
                        $targetRoute = route('admin.dashboard', ['tab' => 'logs']); // Default pelacakan selalu ke menu Forensik Log
                    }
                } elseif (str_contains($gabunganPesan, 'disetujui') || str_contains($gabunganPesan, 'ditolak') || str_contains($gabunganPesan, 'dikembalikan') || str_contains($gabunganPesan, 'batal')) {
                    if ($role === 'mahasiswa') {
                        $targetRoute = route('student.dashboard', ['tab' => 'riwayat']);
                    } elseif ($role === 'asisten') {
                        $targetRoute = route('asisten.dashboard', ['tab' => 'returns']);
                    } elseif ($role === 'master') {
                        $targetRoute = route('master.dashboard', ['tab' => 'approvals']);
                    } elseif ($role === 'dosen') {
                        $targetRoute = route('dosen.dashboard', ['tab' => 'riwayat']);
                    }
                } elseif (str_contains($gabunganPesan, 'baru') || str_contains($gabunganPesan, 'mengajukan') || str_contains($gabunganPesan, 'pengajuan')) {
                    if ($role === 'asisten') {
                        $targetRoute = route('asisten.dashboard', ['tab' => 'approvals']);
                    } elseif ($role === 'master') {
                        $targetRoute = route('master.dashboard', ['tab' => 'approvals']);
                    }
                } elseif (str_contains($gabunganPesan, 'kritis') || str_contains($gabunganPesan, 'rusak') || str_contains($gabunganPesan, 'kapasitas')) {
                    if ($role === 'dosen') {
                        $targetRoute = route('dosen.dashboard', ['tab' => 'monitoring']);
                    }
                } elseif (str_contains($gabunganPesan, 'jadwal') || str_contains($gabunganPesan, 'agenda')) {
                    if (in_array($role, ['asisten', 'master'])) {
                        $targetRoute = route($role . '.dashboard', ['tab' => 'schedule']);
                    } elseif ($role === 'dosen') {
                        $targetRoute = route('dosen.dashboard', ['tab' => 'schedule']);
                    }
                }
            @endphp
            <div class="notif-card">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem;">
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--accent-cyan)" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                        <h3 style="margin: 0; font-size: 1.1rem; font-weight: 800; color: #fff;">{{ $notif->judul }}</h3>
                    </div>
                    <span style="font-size: 0.75rem; color: var(--text-muted); background: rgba(255,255,255,0.05); padding: 0.2rem 0.6rem; border-radius: 12px;">
                        {{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}
                    </span>
                </div>
                <p style="margin: 0 0 0 1.6rem; font-size: 0.85rem; color: #cbd5e1; line-height: 1.5; text-align: left; word-break: break-word;">
                    {{ $notif->pesan }}
                </p>
                
                @if($targetRoute)
                <!-- Tombol Pintas Pelacak -->
                <div style="margin-top: 1rem; margin-left: 1.6rem;">
                    <a href="{{ $targetRoute }}" style="display: inline-block; background: rgba(0,217,255,0.1); color: var(--accent-cyan); border: 1px solid var(--accent-cyan); padding: 0.4rem 1rem; border-radius: 6px; font-size: 0.75rem; font-weight: bold; text-decoration: none; transition: 0.3s;" onmouseover="this.style.background='var(--accent-cyan)'; this.style.color='#000';" onmouseout="this.style.background='rgba(0,217,255,0.1)'; this.style.color='var(--accent-cyan)';">
                        {{ $btnText }}
                    </a>
                </div>
                @endif
            </div>
        @endforeach
    @else
        <div style="text-align: center; padding: 5rem 1rem; border: 1px dashed rgba(255,255,255,0.1); border-radius: 1rem; background: rgba(0,0,0,0.2);">
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="1.5" style="margin: 0 auto 1rem; opacity: 0.5;">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                <line x1="2" y1="2" x2="22" y2="22"></line>
            </svg>
            <h3 style="color: #fff; font-size: 1.2rem; font-weight: 800; margin: 0 0 0.5rem;">{{ $lang === 'en' ? 'Blank Radar' : 'Radar Kosong' }}</h3>
            <p style="color: var(--text-muted); font-size: 0.9rem; margin: 0;">{{ $lang === 'en' ? 'You have no notifications.' : 'Anda belum memiliki notifikasi apapun.' }}</p>
        </div>
    @endif
</div>
@endsection
