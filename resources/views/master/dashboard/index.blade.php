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

    /* Grid Sistem Sementara */
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: rgba(10, 16, 22, 0.5);
        border: 1px solid var(--panel-border);
        border-radius: 1rem;
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s, box-shadow 0.3s, border-color 0.3s;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        border-color: rgba(255, 255, 255, 0.1);
    }

    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
        color: var(--text-muted);
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 900;
        color: #fff;
        margin-bottom: 0.5rem;
    }

    @keyframes fade-in-up {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* ================================== */
    /* STANDARISASI MODAL GLOBAL DASBOR */
    /* ================================== */
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
    .modal-input { width: 100%; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.1); color: #fff; padding: 0.75rem 1rem; border-radius: 8px; font-family: inherit; transition: 0.3s; box-sizing: border-box; }
    .modal-input:focus { outline: none; border-color: var(--accent-cyan); box-shadow: 0 0 10px rgba(0, 217, 255, 0.2); }
    .modal-select { width: 100%; background: #0f172a; border: 1px solid rgba(255,255,255,0.2); color: #fff; padding: 0.75rem 1rem; border-radius: 8px; font-family: inherit; box-sizing: border-box; appearance: none; -webkit-appearance: none; -moz-appearance: none; cursor: pointer; transition: 0.3s; }
    .modal-select:focus { outline: none; border-color: var(--accent-cyan); box-shadow: 0 0 10px rgba(0, 217, 255, 0.2); }
    .modal-select option { background: #0f172a; color: #fff; padding: 0.5rem; }
</style>


@if($tab === 'overview')
    @include('master.dashboard.tabs.overview')
@elseif($tab === 'approvals')
    @include('master.dashboard.tabs.approvals')
@elseif($tab === 'inventory')
    @include('master.dashboard.tabs.inventory')
@elseif($tab === 'laboratories')
    @include('master.dashboard.tabs.laboratories')
@elseif($tab === 'schedule')
    @include('master.dashboard.tabs.schedule')
@elseif($tab === 'aslab_management')
    @include('master.dashboard.tabs.aslab_management')
@elseif($tab === 'riwayat')
    @include('master.dashboard.tabs.riwayat')
@elseif($tab === 'maintenance')
    @include('master.dashboard.tabs.maintenance')
@elseif($tab === 'settings')
    @include('master.dashboard.tabs.settings')
@elseif($tab === 'analytics')
    @include('master.dashboard.tabs.analytics')
@else
    <div style="text-align: center; margin-top: 5rem; padding: 3rem; background: rgba(255,255,255,0.02); border-radius: 12px; border: 1px dashed rgba(255,255,255,0.1);">
        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem; margin-left: auto; margin-right: auto; display: block;">
            <circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line><line x1="8" y1="11" x2="14" y2="11"></line>
        </svg>
        <h2 style="font-weight: 900; color: var(--text-muted); letter-spacing: 0.05em; margin-bottom: 0.5rem; text-transform: uppercase;">{{ $lang === 'id' ? 'MODUL DALAM PENGEMBANGAN' : 'MODULE UNDER DEVELOPMENT' }}</h2>
        <p style="color: var(--text-muted); font-size: 0.85rem; max-width: 400px; margin: 0 auto; line-height: 1.6;">{{ $lang === 'id' ? 'Modul "' . strtoupper($tab) . '" sedang dalam proses tahap perekayasaan lebih lanjut.' : 'The module "' . strtoupper($tab) . '" is currently under further engineering development.' }}</p>
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

    // Fungsi Pengganti confirm() Asli Menjadi SweetAlert2 Sonner Theme
    function confirmDestructiveAction(event, form, lang, textEn, textId) {
        event.preventDefault();
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: lang === 'id' ? 'Konfirmasi Dihapus' : 'Confirm Deletion',
                text: lang === 'id' ? textId : textEn,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: lang === 'id' ? 'OKE, HAPUS' : 'OK',
                cancelButtonText: lang === 'id' ? 'BATAL' : 'Cancel',
                background: '#02040a',
                customClass: {
                    popup: 'sonner-swal-popup',
                    title: 'sonner-swal-title',
                    htmlContainer: 'sonner-swal-text',
                    confirmButton: 'sonner-swal-confirm-btn',
                    cancelButton: 'sonner-swal-cancel-btn',
                    icon: 'sonner-swal-icon'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        } else {
            if(confirm(lang === 'id' ? textId : textEn)) {
                form.submit();
            }
        }
    }
</script>
@endpush

@endsection
