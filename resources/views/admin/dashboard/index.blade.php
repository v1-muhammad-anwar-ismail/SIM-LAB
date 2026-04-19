@extends('layouts.admin')

@section('content')

    <!-- Tampilkan Notifikasi Global/Success/Error -->
    @if(session('success'))
        <div class="alert-success" style="background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.4); color: #4ade80; padding: 1rem; border-radius: 8px; margin-bottom: 2rem; display: flex; align-items: center; gap: 0.8rem; animation: slideInFade 0.4s ease forwards;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            <div style="font-size: 0.9rem; font-weight: 600;">{{ session('success') }}</div>
        </div>
    @endif

    @if(session('error') || $errors->any())
        <div class="alert-danger" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.4); color: #f87171; padding: 1rem; border-radius: 8px; margin-bottom: 2rem; display: flex; align-items: center; gap: 0.8rem; animation: slideInFade 0.4s ease forwards;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
            <div style="font-size: 0.9rem; font-weight: 600;">
                @if(session('error'))
                    {{ session('error') }}
                @else
                    {{ $errors->first() }}
                @endif
            </div>
        </div>
    @endif

    <!-- Tab Switcher -->
    @if($tab === 'overview')
        @include('admin.dashboard.tabs.overview')
    @elseif($tab === 'users')
        @include('admin.dashboard.tabs.users')
    @elseif($tab === 'logs')
        @include('admin.dashboard.tabs.logs')
    @elseif($tab === 'settings')
        @include('dosen.dashboard.tabs.settings') {{-- Kita meminjam settings dari Dosen yang sudah rampung (krn generic Edit Profil) --}}
    @else
        @include('admin.dashboard.tabs.overview')
    @endif

@endsection

<!-- Global Script untuk Animasi Matrix & Tooltips -->
<style>
    @keyframes slideInFade {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
