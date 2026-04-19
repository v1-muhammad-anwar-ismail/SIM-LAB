@extends('layouts.public')

@section('title', 'Tabel Antrean Ekosistem')

@section('content')
<style>
    .schedule-container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 4rem 2rem 4rem 2rem;
        box-sizing: border-box;
    }

    .header-info {
        text-align: center;
        margin-bottom: 3rem;
    }

    .header-info h1 {
        font-size: 2.2rem;
        font-weight: 900;
        color: #fff;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.5rem;
    }

    .header-info p {
        color: var(--text-muted, #94a3b8);
        font-size: 1rem;
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
    }

    .table-wrapper {
        background: rgba(10, 14, 23, 0.9);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        box-sizing: border-box;
        table-layout: fixed;
    }

    th {
        background: rgba(255,255,255,0.03);
        padding: 1.5rem;
        text-align: left;
        font-size: 0.85rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #94a3b8;
        border-bottom: 1px dashed rgba(255,255,255,0.1);
    }

    td {
        padding: 1.5rem;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        vertical-align: top;
        transition: background 0.3s;
    }

    tbody tr:hover td {
        background: rgba(0, 217, 255, 0.02);
    }
    
    .col-identitas { width: 50%; }
    .col-timeline { width: 50%; border-left: 1px solid rgba(255,255,255,0.05); }

    /* Component styling */
    .aset-badge {
        display: inline-block;
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        padding: 0.25rem 0.75rem;
        border-radius: 4px;
        margin-bottom: 0.75rem;
    }

    .badge-lab { color: #f59e0b; background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.2); }
    .badge-alat { color: #00d9ff; background: rgba(0, 217, 255, 0.1); border: 1px solid rgba(0, 217, 255, 0.2); }

    .aset-name {
        font-size: 1.1rem;
        line-height: 1.5;
        font-weight: 800;
        color: #fff;
        margin-bottom: 1rem;
    }

    .peminjam-info {
        font-size: 0.85rem;
        color: #94a3b8;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(0,0,0,0.3);
        padding: 0.5rem 1rem;
        border-radius: 6px;
        width: fit-content;
    }
    .peminjam-info svg { stroke: #3b82f6; }
    
    .status-badge {
        font-size: 0.8rem;
        font-weight: 800;
        letter-spacing: 0.05em;
        margin-bottom: 1.25rem;
        display: inline-block;
        padding: 0.35rem 1rem;
        border-radius: 6px;
    }
    .status-ongoing { background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239,68,68,0.2); }
    .status-reserved { background: rgba(245, 158, 11, 0.1); color: #f59e0b; border: 1px solid rgba(245,158,11,0.2); }

    .time-detail {
        font-size: 0.9rem;
        color: #ccc;
        line-height: 1.8;
    }
    .time-detail strong { color: #fff; font-weight: 700; display: inline-block; width: 60px;}

    @media (max-width: 768px) {
        .schedule-container { padding: 4rem 1rem 2rem 1rem; }
        .header-info h1 { font-size: 1.6rem; }
        
        table, thead, tbody, th, td, tr {
            display: block;
            width: 100%;
            box-sizing: border-box;
        }
        thead tr {
            display: none; /* Hide header completely on mobile */
        }
        tr {
            border-bottom: 4px solid #05080f; /* Thicker gap between rows */
        }
        td {
            border: none;
            padding: 1.25rem 1rem;
            position: relative;
            width: 100%;
            word-wrap: break-word;
        }
        .col-identitas { 
            width: 100%; 
            border-bottom: 1px dashed rgba(255,255,255,0.1); 
        }
        .col-timeline { 
            width: 100%; 
            border-left: none; 
            background: rgba(0,0,0,0.2);
        }
        
        .peminjam-info {
            width: 100%;
            flex-direction: column;
            align-items: flex-start;
        }
        
        .time-detail {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }
    }
</style>

<div class="schedule-container">
    <div class="header-info">
        <h1>Buku Antrean Global</h1>
        <p>Transparansi penuh. Pantau riwayat lalu-lintas reservas aktif dan jadwal blokir seluruh entitas laboratorium, agar Anda dapat mengambil ancang-ancang waktu yang aman.</p>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th class="col-identitas">{{ __('public.schedule.table_col_1') }}</th>
                    <th class="col-timeline">{{ __('public.schedule.table_col_2') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($activeSchedules as $jadwal)
                    @php
                        $isLab = $jadwal->jenis_peminjaman === 'ruang';
                        $isOngoing = $jadwal->status === 'dipinjam';
                        $mulaiTgl = \Carbon\Carbon::parse($jadwal->tanggal_mulai);
                        $selesaiTgl = \Carbon\Carbon::parse($jadwal->tanggal_selesai);
                    @endphp
                    <tr>
                        <td class="col-identitas">
                            @if($isLab)
                                <div class="aset-badge badge-lab">{{ __('public.schedule.badge_peminjaman_ruangan') }}</div>
                                <div class="aset-name">
                                    🏛️ {{ $jadwal->laboratorium->nama_lab ?? __('public.schedule.data_kosong') }}
                                </div>
                            @else
                                <div class="aset-badge badge-alat">{{ __('public.schedule.badge_peminjaman_hardware') }}</div>
                                <div class="aset-name">
                                    @foreach($jadwal->detailPeminjaman as $dp)
                                        <div style="margin-bottom: 0.25rem;">
                                            <span style="color:#00d9ff;">•</span> {{ $dp->alat->nama_alat ?? __('public.schedule.data_alat_kosong') }} 
                                            <span style="font-size: 0.8rem; color:#94a3b8;">x{{ $dp->jumlah }} {{ __('public.schedule.unit') }}</span>
                                        </div>
                                    @endforeach
                                </div>
                                <div style="font-size: 0.75rem; color:#666; margin-bottom: 1rem;">{{ __('public.schedule.lokasi_pengambilan') }}: {{ $jadwal->laboratorium->nama_lab ?? '-' }}</div>
                            @endif

                            <div class="peminjam-info">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                {{ __('public.schedule.pihak_penanggung') }}: <span style="color:#fff;">{{ $jadwal->user->name ?? __('public.schedule.anonim') }}</span>
                            </div>
                        </td>
                        <td class="col-timeline">
                            <div class="status-badge {{ $isOngoing ? 'status-ongoing' : 'status-reserved' }}">
                                {{ $isOngoing ? __('public.schedule.status_aktif') : __('public.schedule.status_mengantre') }}
                            </div>
                            
                            <div class="time-detail">
                                <div><strong>{{ __('public.schedule.dari') }}</strong> : {{ $mulaiTgl->translatedFormat('l, d M Y') }} {{ __('public.schedule.pukul') }} {{ $mulaiTgl->format('H:i') }} WIB</div>
                                <div><strong>{{ __('public.schedule.sampai') }}</strong> : {{ $selesaiTgl->translatedFormat('l, d M Y') }} {{ __('public.schedule.pukul') }} {{ $selesaiTgl->format('H:i') }} WIB</div>
                                
                                @if($jadwal->tujuan_peminjaman)
                                    <div style="margin-top: 1rem; padding-top: 0.75rem; border-top: 1px dashed rgba(255,255,255,0.1); font-size: 0.8rem; color: #94a3b8; font-style: italic;">
                                        "{{ Str::limit($jadwal->tujuan_peminjaman, 100) }}"
                                    </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" style="text-align: center; padding: 4rem 2rem; color: var(--text-muted);">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" style="margin-bottom: 1rem; opacity: 0.5;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                            <div style="font-size: 1.1rem; color: #fff; margin-bottom: 0.5rem;">{{ __('public.schedule.empty_title') }}</div>
                            {{ __('public.schedule.empty_message') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
