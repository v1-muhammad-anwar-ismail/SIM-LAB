@extends('layouts.admin')

@section('content')
<style>
    .welcome-banner {
        background: radial-gradient(circle at 100% 0%, rgba(0, 217, 255, 0.1) 0%, transparent 50%),
                    linear-gradient(135deg, rgba(10, 12, 16, 0.8) 0%, rgba(2, 4, 10, 0.9) 100%);
        border: 1px solid rgba(0, 217, 255, 0.2);
        border-radius: 1rem;
        padding: 2.5rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        animation: fade-in-up 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(0, 217, 255, 0.1);
        border: 1px solid rgba(0, 217, 255, 0.2);
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        color: var(--accent-cyan);
        font-weight: 800;
        font-size: 0.8rem;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        margin-bottom: 1rem;
    }

    .welcome-title {
        font-size: 2.5rem;
        font-weight: 900;
        margin: 0 0 0.5rem 0;
        background: linear-gradient(to right, #fff, var(--text-muted));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        letter-spacing: -0.02em;
        word-wrap: break-word;
    }

    @media (max-width: 768px) {
        .welcome-title {
            font-size: 1.8rem;
            line-height: 1.2;
        }
        .welcome-banner {
            padding: 1.5rem;
        }
    }

    .welcome-subtitle {
        color: var(--text-muted);
        font-size: 1rem;
        max-width: 600px;
        line-height: 1.6;
        margin: 0;
    }

    @keyframes fade-in-up {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Grid Sistem Sementara */
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    /* STANDARISASI MODAL GLOBAL DASBOR */
    .custom-modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.8); backdrop-filter: blur(4px); justify-content: center; align-items: center; }
    .custom-modal.active { display: flex; }
    .modal-content { background: #0a1016; border: 1px solid var(--accent-cyan); border-radius: 12px; padding: 2rem; width: 90%; max-width: 500px; box-shadow: 0 0 30px rgba(0, 217, 255, 0.15); position: relative; max-height: 90vh; overflow-y: auto; }
    .modal-content::-webkit-scrollbar { width: 6px; }
    .modal-content::-webkit-scrollbar-track { background: transparent; }
    .modal-content::-webkit-scrollbar-thumb { background: rgba(0, 217, 255, 0.4); border-radius: 10px; }
    .modal-content::-webkit-scrollbar-thumb:hover { background: rgba(0, 217, 255, 0.8); }
    .modal-close { position: absolute; right: 1.5rem; top: 1.5rem; cursor: pointer; color: var(--text-muted); transition: 0.3s; }
    .modal-close:hover { color: #fff; }
    .modal-form-group { margin-bottom: 1rem; }
    .modal-form-group label { display: block; margin-bottom: 0.5rem; color: #cbd5e1; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600; }
    .modal-input, .modal-select { width: 100%; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.1); color: #fff; padding: 0.75rem 1rem; border-radius: 8px; font-family: inherit; transition: 0.3s; box-sizing: border-box; }
    .modal-input:focus, .modal-select:focus { outline: none; border-color: var(--accent-cyan); box-shadow: 0 0 10px rgba(0, 217, 255, 0.2); }
    .modal-select { background: #0f172a; appearance: none; -webkit-appearance: none; cursor: pointer; }
    .modal-select option { background: #0f172a; color: #fff; padding: 0.5rem; }
</style>

@if($tab === 'settings')
    @include('dosen.dashboard.tabs.settings')
@elseif($tab === 'overview')
    @include('dosen.dashboard.tabs.overview')
@elseif($tab === 'schedule')
    @include('dosen.dashboard.tabs.schedule')
@elseif($tab === 'monitoring')
    @include('dosen.dashboard.tabs.monitoring')
@elseif($tab === 'analytics')
    @include('dosen.dashboard.tabs.analytics')
@elseif($tab === 'riwayat')
    @include('dosen.dashboard.tabs.riwayat')
@else
    <div style="text-align: center; margin-top: 5rem; padding: 3rem; background: rgba(255,255,255,0.02); border-radius: 12px; border: 1px dashed rgba(255,255,255,0.1);">
        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem; margin-left: auto; margin-right: auto; display: block;">
            <circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line><line x1="8" y1="11" x2="14" y2="11"></line>
        </svg>
        <h2 style="font-weight: 900; color: var(--text-muted); letter-spacing: 0.05em; margin-bottom: 0.5rem; text-transform: uppercase;">{{ $lang === 'id' ? 'MODUL DOSEN DALAM PENGEMBANGAN' : 'LECTURER MODULE UNDER DEVELOPMENT' }}</h2>
        <p style="color: var(--text-muted); font-size: 0.85rem; max-width: 400px; margin: 0 auto; line-height: 1.6;">{{ $lang === 'id' ? 'Modul atau Tab "' . strtoupper($tab) . '" sedang dalam proses tahap perekayasaan lebih lanjut.' : 'The module "' . strtoupper($tab) . '" is currently under further engineering development.' }}</p>
    </div>
@endif

@push('scripts')
<script>
    // FUNGSI GLOBAL MODAL CSS (DIGUNAKAN OLEH SELURUH TABS)
    function openModal(id) { document.getElementById(id).classList.add('active'); }
    function closeModal(id) { document.getElementById(id).classList.remove('active'); }
    
    // Tutup modal jika klik luar kotak
    window.onclick = function(event) {
        if (event.target.classList.contains('custom-modal')) {
            event.target.classList.remove('active');
        }
    }

    // Pendeteksi Auto-Open Modal dari URL parameter
    @if(request('open_modal'))
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                openModal('{{ request('open_modal') }}');
            }, 300); // Jeda pendek menjamin seluruh DOM & modal siap
        });
    @endif
</script>
@endpush
@endsection
