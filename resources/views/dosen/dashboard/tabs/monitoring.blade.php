<style>
    /* Premium Cyberpunk / Dark Mode Monitoring UI */
    .monitoring-header {
        background: rgba(10, 16, 22, 0.5);
        border: 1px solid var(--panel-border);
        border-radius: 1rem;
        padding: 2rem;
        margin-bottom: 2rem;
        border-top: 4px solid var(--accent-cyan);
        position: relative;
        overflow: hidden;
    }
    
    .monitoring-header::before {
        content: '';
        position: absolute;
        top: 0; right: 0; bottom: 0; left: 0;
        background: radial-gradient(circle at 100% 0%, rgba(0, 217, 255, 0.1) 0%, transparent 50%);
        pointer-events: none;
    }

    .monitoring-title {
        color: #fff;
        margin-top: 0;
        margin-bottom: 0.5rem;
        font-weight: 900;
        letter-spacing: 1px;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .live-indicator {
        display: inline-block;
        width: 12px; height: 12px;
        background-color: #ef4444;
        border-radius: 50%;
        box-shadow: 0 0 10px #ef4444;
        animation: pulse-red 2s infinite;
    }

    @keyframes pulse-red {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(239, 68, 68, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
    }

    .section-title {
        color: var(--accent-cyan);
        font-weight: 800;
        font-size: 1.4rem;
        margin-bottom: 1.5rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-bottom: 1px solid rgba(0, 217, 255, 0.2);
        padding-bottom: 0.5rem;
        display: inline-block;
    }

    /* Badge Helper Class */
    .badge-status {
        display: inline-block;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 900;
        letter-spacing: 1px;
    }

    .grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }

    /* Lab Card */
    .lab-card {
        background: rgba(10, 16, 22, 0.7);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 12px;
        padding: 1.5rem;
        transition: 0.3s;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .lab-card:hover {
        border-color: rgba(0, 217, 255, 0.4);
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 217, 255, 0.1);
    }
    .lab-card.active-lab {
        border-color: rgba(34, 197, 94, 0.4);
        background: linear-gradient(180deg, rgba(34, 197, 94, 0.05) 0%, rgba(10, 16, 22, 0) 100%);
    }
    .lab-card.rusak {
        border-color: rgba(239, 68, 68, 0.4);
        background: linear-gradient(180deg, rgba(239, 68, 68, 0.05) 0%, rgba(10, 16, 22, 0) 100%);
    }
    .lab-card.warning-lab {
        border-color: rgba(234, 179, 8, 0.4);
        background: linear-gradient(180deg, rgba(234, 179, 8, 0.05) 0%, rgba(10, 16, 22, 0) 100%);
    }

    .lab-name {
        font-size: 1.25rem;
        font-weight: 800;
        color: #fff;
        margin-bottom: 0.25rem;
    }
    
    .lab-master {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin-bottom: 1.5rem;
    }

    .lab-status-pill {
        display: inline-block;
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
    }
    .pill-empty {
        background: rgba(255,255,255,0.05);
        color: #cbd5e1;
        border: 1px solid rgba(255,255,255,0.1);
    }
    .pill-busy {
        background: rgba(34, 197, 94, 0.1);
        color: #22c55e;
        border: 1px solid rgba(34, 197, 94, 0.3);
    }

    /* Active Sessions List */
    .session-list {
        background: rgba(10, 16, 22, 0.5);
        border: 1px solid var(--panel-border);
        border-radius: 12px;
        overflow: hidden;
    }
    .session-item {
        padding: 1.5rem;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: 0.2s;
    }
    .session-item:last-child {
        border-bottom: none;
    }
    .session-item:hover {
        background: rgba(255,255,255,0.02);
    }
    
    /* Risk Stock Container */
    .risk-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }
    .risk-card {
        background: rgba(10, 16, 22, 0.8);
        border-left: 4px solid #ef4444;
        border-radius: 8px;
        padding: 1rem;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    .risk-card.warning {
        border-left-color: #eab308;
    }
    
    @media (max-width: 768px) {
        .monitoring-title {
            font-size: 1.5rem;
        }
        .section-title {
            font-size: 1.15rem;
        }
        .session-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        .session-item-right {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: stretch;
            gap: 0.75rem;
            text-align: left;
        }
        .session-item-right > div:last-child {
            order: -1; /* Pindahkan Tanggal Mulai ke Atas */
            text-align: left;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        .badge-status {
            display: block;
            width: 100%;
            text-align: center;
            box-sizing: border-box;
            padding: 10px 16px;
            font-size: 0.8rem;
        }
    }

    /* Risk Stock Container */
    .risk-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }
    .risk-card {
        background: rgba(10, 16, 22, 0.8);
        border-left: 4px solid #ef4444;
        border-radius: 8px;
        padding: 1rem;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    .risk-card.warning {
        border-left-color: #eab308;
    }
</style>

<div class="monitoring-header">
    <h1 class="monitoring-title">
        <span class="live-indicator"></span>
        {{ $lang === 'id' ? 'Pemantauan Radar Global' : 'Global Radar Monitoring' }}
    </h1>
    <p style="color: var(--text-muted); margin: 0; font-size: 0.95rem;">
        {{ $lang === 'id' ? 'Mengobservasi denyut nadi aktivitas seluruh laboratorium secara Real-Time.' : 'Observing the pulse of all laboratory activities in Real-Time.' }}
    </p>
</div>

<!-- SECTION: KAPASITAS LAB & STATUS -->
<h2 class="section-title">{{ $lang === 'id' ? 'Status Titik Laboratorium' : 'Laboratory Node Status' }}</h2>
<div class="grid-container">
    @forelse($liveLabs as $lab)
        @php
            // Ambil foto pertama jika ada, jika tidak pakai placeholder warna gelap
            $fotos = is_string($lab->fotos) ? json_decode($lab->fotos, true) : $lab->fotos;
            $fotoUrl = (is_array($fotos) && count($fotos) > 0) ? asset('storage/' . $fotos[0]) : null;
        @endphp
        <div class="lab-card {{ $lab->active_sessions > 0 ? 'active-lab' : '' }}" onclick="window.location.href='{{ route('dosen.dashboard', ['tab' => 'overview', 'open_modal' => 'bookingModal']) }}'" style="cursor: pointer; padding: 0; overflow: hidden; position: relative;">
            
            <!-- Gambar Ruangan Lab -->
            <div style="aspect-ratio: 16/9; width: 100%; background-color: #0f172a; background-image: url('{{ $fotoUrl }}'); background-size: cover; background-position: center; border-bottom: 1px solid rgba(255,255,255,0.05); position: relative;">
                <div style="position: absolute; inset: 0; background: linear-gradient(to bottom, transparent, rgba(10,16,22,1));"></div>
            </div>

            <!-- Detail Lab -->
            <div style="padding: 1.5rem; display: flex; flex-direction: column; flex-grow: 1;">
                <div style="flex-grow: 1;">
                    <div class="lab-name">{{ $lab->nama_lab }}</div>
                    <div class="lab-master" style="margin-bottom: 0.5rem; color: #94a3b8;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--accent-cyan)" stroke-width="2" style="vertical-align: middle; margin-right: 4px;"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        <strong>Master:</strong> {{ $lab->master->name ?? 'Belum ditentukan' }}
                    </div>
                    <div class="lab-master" style="margin-bottom: 1.5rem; color: #94a3b8; font-size: 0.75rem;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" style="vertical-align: middle; margin-right: 4px;"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        <strong>Aslab:</strong> {{ $lab->aslabs->count() > 0 ? $lab->aslabs->pluck('name')->join(', ') : 'Belum ada' }}
                    </div>
                </div>
                
                <!-- Indikator Sesi -->
                <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-top: auto;">
                    <div>
                        @if($lab->active_sessions > 0)
                            <span class="lab-status-pill pill-busy">
                                {{ $lab->active_sessions }} {{ $lang === 'id' ? 'Sesi Sibuk' : 'Active Sessions' }}
                            </span>
                        @else
                            <span class="lab-status-pill pill-empty">
                                {{ $lang === 'id' ? 'Kondisi Kosong' : 'Clear / Empty' }}
                            </span>
                        @endif
                    </div>
                    
                    @if($lab->active_sessions > 0)
                        <div style="display: flex; gap: 4px;">
                            <span style="display:block; width: 4px; height: 16px; background: #22c55e; animation: pulse-red 1s infinite alternate;"></span>
                            <span style="display:block; width: 4px; height: 24px; background: #22c55e; animation: pulse-red 1.2s infinite alternate;"></span>
                            <span style="display:block; width: 4px; height: 12px; background: #22c55e; animation: pulse-red 0.8s infinite alternate;"></span>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Hover UI (Booking Pancingan) -->
            <div class="booking-overlay" style="position: absolute; inset: 0; background: rgba(0,217,255,0.1); opacity: 0; transition: 0.3s; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(2px);">
                <div style="background: var(--accent-cyan); color: #000; padding: 0.5rem 1.5rem; border-radius: 20px; font-weight: 800; text-transform: uppercase; font-size: 0.85rem; box-shadow: 0 0 20px rgba(0,217,255,0.4);">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 4px;"><path d="M12 5v14"></path><path d="M5 12h14"></path></svg> {{ $lang === 'id' ? 'Booking / Pesan' : 'Book Now' }}
                </div>
            </div>
        </div>
    @empty
        <div style="color: var(--text-muted);">{{ $lang === 'id' ? 'Tidak ada data lab.' : 'No lab data available.' }}</div>
    @endforelse
</div>
<style>
    .lab-card:hover .booking-overlay { opacity: 1 !important; }
</style>

<!-- SECTION: INVENTARIS KRITIS (ALERTS) -->
<h2 class="section-title" style="color: #ef4444; border-bottom-color: rgba(239, 68, 68, 0.2);">
    {{ $lang === 'id' ? 'Radar Inventaris Kritis' : 'Critical Inventory Radar' }}
</h2>
@if($alatRisks && $alatRisks->count() > 0)
    <div class="risk-grid">
        @foreach($alatRisks as $alat)
            @php
                $isRusak = $alat->kondisi === 'rusak';
                $isLowStock = $alat->stok <= 5;
            @endphp
            <div class="risk-card {{ $isRusak ? '' : 'warning' }}">
                <div style="font-weight: 800; color: #fff; word-wrap: break-word;">{{ $alat->nama_alat }}</div>
                <div style="font-size: 0.8rem; color: var(--text-muted);">
                    📍 {{ $alat->laboratorium->nama_lab ?? 'Universal' }}
                </div>
                
                <div style="margin-top: 0.5rem; display: flex; gap: 0.5rem; flex-wrap: wrap;">
                    @if($isRusak)
                        <span style="background: rgba(239, 68, 68, 0.1); color: #ef4444; padding: 2px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: bold; border: 1px solid rgba(239,68,68,0.3);">STATUS: RUSAK</span>
                    @endif
                    @if($isLowStock)
                        <span style="background: rgba(234, 179, 8, 0.1); color: #eab308; padding: 2px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: bold; border: 1px solid rgba(234,179,8,0.3);">STOK MENIPIS ({{ $alat->stok }})</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@else
    <div style="margin-bottom: 2.5rem; padding: 1.5rem; background: rgba(34, 197, 94, 0.05); border: 1px solid rgba(34, 197, 94, 0.2); border-radius: 8px; color: #22c55e;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 0.5rem;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
        {{ $lang === 'id' ? 'Seluruh inventaris dalam kondisi aman secara kuantitas dan kelayakan.' : 'All inventory is safe in quantity and condition.' }}
    </div>
@endif

<!-- SECTION: ASET ALAT TERSEDIA (READY) -->
<h2 class="section-title" style="color: #22c55e; border-bottom-color: rgba(34, 197, 94, 0.2);">
    {{ $lang === 'id' ? 'Aset Alat Tersedia (Ready to Deploy)' : 'Available Asset Inventory' }}
</h2>
@if(isset($availableAlats) && $availableAlats->count() > 0)
    <div class="grid-container">
        @foreach($availableAlats as $alat)
            @php
                $fotosAlat = is_string($alat->fotos) ? json_decode($alat->fotos, true) : $alat->fotos;
                $fotoUrlAlat = (is_array($fotosAlat) && count($fotosAlat) > 0) ? asset('storage/' . $fotosAlat[0]) : null;
            @endphp
            <div class="lab-card" onclick="window.location.href='{{ route('dosen.dashboard', ['tab' => 'overview', 'open_modal' => 'bookingModal']) }}'" style="cursor: pointer; padding: 0; overflow: hidden; position: relative;">
                
                <!-- Gambar Alat -->
                <div style="aspect-ratio: 16/9; width: 100%; background-color: #0f172a; background-image: url('{{ $fotoUrlAlat }}'); background-size: cover; background-position: center; border-bottom: 1px solid rgba(255,255,255,0.05); position: relative;">
                    <div style="position: absolute; inset: 0; background: linear-gradient(to bottom, transparent, rgba(10,16,22,1));"></div>
                </div>

                <!-- Detail Alat -->
                <div style="padding: 1.5rem; display: flex; flex-direction: column; flex-grow: 1;">
                    <div style="flex-grow: 1;">
                        <div class="lab-name" style="font-size: 1.1rem; margin-bottom: 0.5rem; word-wrap: break-word;">{{ $alat->nama_alat }}</div>
                        <div class="lab-master" style="margin-bottom: 0.5rem; color: #94a3b8;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 4px;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                            {{ $alat->laboratorium->nama_lab ?? 'Universal' }}
                        </div>
                    </div>
                </div>

                <!-- Hover UI (Booking Pancingan) -->
                <div class="booking-overlay" style="position: absolute; inset: 0; background: rgba(0,217,255,0.1); opacity: 0; transition: 0.3s; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(2px);">
                    <div style="background: var(--accent-cyan); color: #000; padding: 0.5rem 1.5rem; border-radius: 20px; font-weight: 800; text-transform: uppercase; font-size: 0.85rem; box-shadow: 0 0 20px rgba(0,217,255,0.4);">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 4px;"><path d="M12 5v14"></path><path d="M5 12h14"></path></svg> {{ $lang === 'id' ? 'Booking / Pesan' : 'Book Now' }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div style="margin-bottom: 2.5rem; padding: 1.5rem; background: rgba(239, 68, 68, 0.05); border: 1px solid rgba(239, 68, 68, 0.2); border-radius: 8px; color: #ef4444;">
        {{ $lang === 'id' ? 'Tidak ada satupun alat yang siap untuk dipesan saat ini.' : 'No items are ready to be booked at the moment.' }}
    </div>
@endif

<!-- SECTION: SESI SEDANG BERJALAN (LIVE) -->
<h2 class="section-title">{{ $lang === 'id' ? 'Siaran Langsung Pengajuan & Penggunaan' : 'Live Usage & Requests Broadcast' }}</h2>
@if($liveSessions && $liveSessions->count() > 0)
    <div class="session-list">
        @foreach($liveSessions as $session)
            <div class="session-item">
                <div>
                    <div style="color: #fff; font-weight: 800; font-size: 1.1rem; margin-bottom: 0.25rem;">
                        {{ $session->user->name ?? 'Anonim' }}
                    </div>
                    <div style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 0.5rem;">
                        NIM/ID: <span style="color: #cbd5e1;">{{ $session->user->nomor_induk ?? $session->user->id }}</span> &nbsp; | &nbsp; 
                        Tipe: <span style="color: var(--accent-cyan); text-transform: uppercase;">{{ str_replace('_', ' ', $session->jenis_peminjaman) }}</span>
                    </div>
                    <div style="font-size: 0.9rem; color: #cbd5e1; margin-bottom: 0.25rem;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 4px;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        Ruangan: <span style="font-weight:bold; color: #fff;">{{ $session->laboratorium->nama_lab ?? 'Universal/Luar' }}</span>
                    </div>

                    @if($session->jenis_peminjaman === 'alat' && $session->detailPeminjaman->count() > 0)
                    <div style="font-size: 0.85rem; color: #94a3b8; padding-top: 0.25rem;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 4px;"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                        Alat: <span style="color: #cbd5e1;">{{ $session->detailPeminjaman->map(function($d) { return ($d->alat->nama_alat ?? 'Unknown') . ' (' . $d->jumlah . ')'; })->join(', ') }}</span>
                    </div>
                    @endif
                </div>
                
                <div class="session-item-right" style="text-align: right;">
                    <div style="margin-bottom: 0.75rem;">
                        @if($session->status === 'menunggu')
                            <span class="badge-status" style="background: rgba(234, 179, 8, 0.1); color: #eab308; border: 1px solid rgba(234,179,8,0.3);">
                                VALIDASI TERTUNDA
                            </span>
                        @elseif($session->status === 'disetujui')
                            <span class="badge-status" style="background: rgba(34, 197, 94, 0.1); color: #22c55e; border: 1px solid rgba(34, 197, 94, 0.3);">
                                SIAP DIAMBIL (ACC)
                            </span>
                        @elseif($session->status === 'dipinjam')
                            <span class="badge-status" style="background: rgba(0, 217, 255, 0.1); color: #00d9ff; border: 1px solid rgba(0,217,255,0.3);">
                                SEDANG DIPAKAI
                            </span>
                        @endif
                    </div>
                    <div style="font-size: 0.8rem; color: var(--text-muted);">
                        @if($session->status === 'dipinjam')
                            Selesai: {{ \Carbon\Carbon::parse($session->tanggal_selesai)->format('d M Y, H:i') }}
                        @else
                            Mulai: {{ \Carbon\Carbon::parse($session->tanggal_mulai)->format('d M Y, H:i') }}
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div style="padding: 3rem; text-align: center; background: rgba(10, 16, 22, 0.5); border: 1px dashed rgba(255,255,255,0.1); border-radius: 12px;">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="1.5" style="margin-bottom: 1rem; opacity: 0.5;">
            <circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline>
        </svg>
        <h4 style="color: #fff; margin:0 0 0.5rem 0;">{{ $lang === 'id' ? 'Tidak ada gelombang aktivitas' : 'No activity frequencies' }}</h4>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin: 0;">{{ $lang === 'id' ? 'Saat ini seluruh laboratorium sedang steril dari peminjam.' : 'Currently all laboratories are sterile from borrowers.' }}</p>
    </div>
@endif
<br><br>
