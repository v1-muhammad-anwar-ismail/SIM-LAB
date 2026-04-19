@extends('layouts.public')

@section('title', 'Sidak Ekosistem Detail')

@section('content')
<style>
    .catalog-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 8rem 2rem 4rem 2rem;
    }

    .hero-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        margin-bottom: 4rem;
        align-items: start;
    }

    .hero-img-wrapper {
        width: 100%;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid rgba(0, 217, 255, 0.2);
        box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        background: #05080f;
    }

    .hero-img-wrapper img {
        width: 100%;
        aspect-ratio: 16/9;
        object-fit: cover;
        display: block;
    }

    .hero-content {
        display: flex;
        flex-direction: column;
    }

    .badge-type {
        display: inline-block;
        background: rgba(0, 217, 255, 0.1);
        color: #00d9ff;
        border: 1px solid rgba(0, 217, 255, 0.3);
        padding: 0.25rem 0.75rem;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 800;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        margin-bottom: 1rem;
        width: fit-content;
    }

    .detail-title {
        font-size: 2.2rem;
        font-weight: 900;
        color: #fff;
        margin: 0 0 1rem 0;
        line-height: 1.2;
    }

    .detail-desc {
        font-size: 1rem;
        color: var(--text-muted, #94a3b8);
        line-height: 1.7;
        margin-bottom: 2rem;
    }

    /* Grid PIC & Info */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: rgba(0, 0, 0, 0.3);
        border-radius: 8px;
        border: 1px dashed rgba(255,255,255,0.1);
    }

    .info-item h4 {
        font-size: 0.75rem;
        color: var(--text-muted, #94a3b8);
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin: 0 0 0.5rem 0;
    }

    .pic-profile {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .pic-profile img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 1px solid rgba(0, 217, 255, 0.3);
    }

    .pic-profile .no-img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #1e293b;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: bold;
        border: 1px solid rgba(0, 217, 255, 0.3);
    }

    .pic-info h5 {
        margin: 0;
        color: #fff;
        font-size: 0.95rem;
    }
    
    .pic-info span {
        font-size: 0.75rem;
        color: var(--text-muted, #94a3b8);
    }

    /* Booking Button */
    .btn-booking {
        background: linear-gradient(90deg, #00d9ff, #3b82f6);
        color: #fff;
        border: none;
        padding: 1.2rem;
        font-size: 1rem;
        font-weight: 800;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 0 15px rgba(0, 217, 255, 0.3);
        width: 100%;
        display: block;
        text-align: center;
    }

    .btn-booking:hover {
        transform: translateY(-3px);
        box-shadow: 0 0 25px rgba(0, 217, 255, 0.5);
    }

    /* Target Schedule Cards */
    .schedule-section h3 {
        color: #fff;
        font-size: 1.25rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .schedule-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1rem;
    }

    .booking-card {
        background: rgba(255,255,255,0.03);
        border-left: 3px solid #f59e0b;
        padding: 1.2rem;
        border-radius: 0 8px 8px 0;
        transition: all 0.3s ease;
    }

    .booking-card:hover {
        background: rgba(255,255,255,0.05);
    }

    .booking-card.ongoing {
        border-left-color: #ef4444;
    }

    .booking-card-date {
        font-size: 0.85rem;
        color: #f59e0b;
        font-weight: 700;
        margin-bottom: 0.5rem;
        letter-spacing: 0.05em;
    }
    .booking-card.ongoing .booking-card-date { color: #ef4444; }

    .booking-card-user {
        color: #fff;
        font-size: 1rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .booking-card-time {
        font-size: 0.8rem;
        color: var(--text-muted, #94a3b8);
        line-height: 1.5;
    }

    @media (max-width: 900px) {
        .hero-section {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        .detail-title { 
            font-size: 1.8rem; 
        }
    }

    @media (max-width: 480px) {
        .catalog-container { padding: 6rem 1rem 3rem 1rem; }
        .detail-title { font-size: 1.4rem; } /* Pengecilan drastis font Title untuk Mobile */
        .info-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="catalog-container">
    @if(session('error'))
        <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.4); color: #fca5a5; padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
            {{ session('error') }}
        </div>
    @endif

    @php
        $fotos = $item->fotos ?? [];
        $imgSrc = count($fotos) > 0 ? Storage::url($fotos[0]) : null;
    @endphp

    <div class="hero-section">
        <!-- 1. GAMBAR SEBELAH KIRI -->
        <div class="hero-img-wrapper">
            @if($imgSrc)
                <img src="{{ $imgSrc }}" alt="Image Cover">
            @else
                <div style="width: 100%; aspect-ratio: 16/9; display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,0.2);">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                </div>
            @endif
        </div>

        <!-- 2 & 3. DESKRIPSI SEBELAH KANAN DAN BUTTON DI BAWAHNYA -->
        <div class="hero-content">
            <span class="badge-type">{{ $type === 'lab' ? __('public.home.badge_lab') : __('public.home.badge_alat') }}</span>
            <h1 class="detail-title">{{ $type === 'lab' ? $item->nama_lab : $item->nama_alat }}</h1>
            <p class="detail-desc">{{ $item->deskripsi }}</p>

            <div class="info-grid">
                @if($type === 'alat')
                    <div class="info-item">
                        <h4>{{ __('public.detail.lokasi') }}</h4>
                        <div style="color: #fff; font-weight: 600; display:flex; align-items:center; gap:0.5rem;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#00d9ff"><path d="M22 21H2V5a2 2 0 0 1 2-2h4l2 2h10a2 2 0 0 1 2 2v14z"></path></svg>
                            {{ $item->laboratorium->nama_lab ?? __('public.home.unassigned') }}
                        </div>
                        <div style="margin-top: 1rem;">
                            <h4>{{ __('public.detail.sisa_stok') }}</h4>
                            <span style="color: {{ $item->available_stok > 0 ? '#10b981' : '#ef4444' }}; font-weight: 800; font-size: 1.2rem;">{{ $item->available_stok }} {{ __('public.home.unit') }}</span>
                        </div>
                    </div>
                @endif

                @php
                    $targetLab = $type === 'lab' ? $item : $item->laboratorium;
                @endphp

                @if($targetLab)
                    <!-- Master Lab Profile -->
                    <div class="info-item">
                        <h4>{{ __('public.detail.tab_identitas') }} (Master)</h4>
                        @if($targetLab->master)
                            <div class="pic-profile">
                                @if($targetLab->master->avatar)
                                    <img src="{{ $targetLab->master->avatar }}" alt="Avatar">
                                @else
                                    <div class="no-img">{{ substr($targetLab->master->name, 0, 1) }}</div>
                                @endif
                                <div class="pic-info">
                                    <h5>{{ $targetLab->master->name }}</h5>
                                    <span>NIP: {{ $targetLab->master->nomor_induk ?? '-' }}</span>
                                </div>
                            </div>
                        @else
                            <span style="color: #ef4444; font-size: 0.85rem;">{{ __('public.detail.no_pic') }}</span>
                        @endif
                    </div>

                    <!-- Aslab Profile (First active aslab) -->
                    <div class="info-item">
                        <h4>Asisten Jaga</h4>
                        @if($targetLab->aslabs && $targetLab->aslabs->count() > 0)
                            @php $aslab = $targetLab->aslabs->first(); @endphp
                            <div class="pic-profile">
                                @if($aslab->avatar)
                                    <img src="{{ $aslab->avatar }}" alt="Avatar">
                                @else
                                    <div class="no-img">{{ substr($aslab->name, 0, 1) }}</div>
                                @endif
                                <div class="pic-info">
                                    <h5>{{ $aslab->name }}</h5>
                                    <span>NIM: {{ $aslab->nomor_induk ?? '-' }}</span>
                                </div>
                            </div>
                        @else
                            <span style="color: rgba(255,255,255,0.3); font-size: 0.85rem;">[Belum Ada Asisten]</span>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Deep Linking Booking -->
            <form action="{{ route('public.intent') }}" method="POST" style="margin-top: 1rem;">
                @csrf
                <input type="hidden" name="type" value="{{ $type }}">
                <input type="hidden" name="id" value="{{ $item->id }}">
                <button type="submit" class="btn-booking">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="vertical-align: middle; margin-right: 8px; margin-top: -3px;"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                    {{ __('public.detail.btn_ajukan') }}
                </button>
                @if(!Auth::check())
                    <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 1rem; text-align: center; text-transform: uppercase;">{{ __('public.detail.btn_login') }}</div>
                @endif
            </form>
        </div>
    </div>

    <!-- 4. RADAR PEMINJAMAN BERJALAN DIPISAH DI BAWAHNYA KERANGKA GAMBAR & DESKRIPSI -->
    <div class="schedule-section">
        <h3>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
            {{ __('public.detail.radar_title') }}
        </h3>
        @if($activeSchedules->count() > 0)
            <div class="schedule-grid">
                @foreach($activeSchedules as $jadwal)
                    @php 
                        $isOngoing = $jadwal->status === 'dipinjam';
                        $kembaliTgl = \Carbon\Carbon::parse($jadwal->tanggal_kembali); // Note: tanggal_kembali does not exist directly? Wait we used tanggal_selesai
                        $pinjamTgl = \Carbon\Carbon::parse($jadwal->tanggal_pinjam); // Wait, tanggal_mulai
                        // To be extremely safe due to earlier bug fix:
                        $mulaiTgl = \Carbon\Carbon::parse($jadwal->tanggal_mulai);
                        $selesaiTgl = \Carbon\Carbon::parse($jadwal->tanggal_selesai);
                    @endphp
                    <div class="booking-card {{ $isOngoing ? 'ongoing' : '' }}">
                        <div class="booking-card-date">
                            {{ $isOngoing ? __('public.schedule.status_berjalan') : __('public.schedule.status_disetujui') }}
                        </div>
                        <div class="booking-card-user">{{ $jadwal->user->name ?? 'SYSTEM' }}</div>
                        <div class="booking-card-time">
                            {{ __('public.schedule.waktu_dari') }}: {{ $mulaiTgl->format('d M Y') }} s.d. {{ $selesaiTgl->format('d M Y') }}<br>
                            {{ __('public.schedule.pukul') }}: {{ $mulaiTgl->format('H:i') }} s.d. {{ $selesaiTgl->format('H:i') }}
                        </div>
                        @if($type === 'alat')
                        <div style="font-size: 0.7rem; color: #00d9ff; margin-top: 0.5rem; text-transform: uppercase; font-weight: bold;">
                            @php
                                $detail = $jadwal->detailPeminjaman->where('alat_id', $item->id)->first();
                            @endphp
                            Beban Resor: {{ $detail ? $detail->jumlah : 0 }} Unit
                        </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div style="background: rgba(255,255,255,0.02); border: 1px dashed rgba(255,255,255,0.1); padding: 3rem; border-radius: 8px; text-align: center; color: var(--text-muted);">
                {{ __('public.detail.no_radar') }}
            </div>
        @endif
    </div>

</div>
@endsection
