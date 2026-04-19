@extends('layouts.public')

@section('title', 'Beranda Etalase')

@section('content')
<style>
    .catalog-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 5rem 2rem 4rem 2rem;
    }

    /* Carousel Section */
    .carousel-section {
        position: relative;
        width: 100%;
        height: 500px;
        margin-bottom: 4rem;
        border-radius: 12px;
        overflow: hidden;
        background: #05080f;
        box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    }

    .carousel-track {
        display: flex;
        width: 100%;
        height: 100%;
        transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1);
    }

    .carousel-slide {
        min-width: 100%;
        height: 100%;
        position: relative;
    }

    .carousel-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        position: absolute;
        top: 0;
        left: 0;
        opacity: 0.5; /* dark tint */
    }

    .carousel-content {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding: 2rem;
        background: linear-gradient(0deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.2) 60%, rgba(0,0,0,0.5) 100%);
    }

    .carousel-badge {
        background: rgba(0, 217, 255, 0.2);
        color: #00d9ff;
        border: 1px solid rgba(0, 217, 255, 0.4);
        padding: 0.25rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 800;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        margin-bottom: 1rem;
    }

    .carousel-title {
        font-size: 3rem;
        font-weight: 900;
        color: #fff;
        margin: 0 0 1rem 0;
        text-shadow: 0 4px 10px rgba(0,0,0,0.8);
    }

    .carousel-desc {
        color: #ddd;
        max-width: 700px;
        margin-bottom: 2rem;
        font-size: 1.1rem;
        line-height: 1.6;
    }

    .carousel-actions {
        display: flex;
        gap: 1rem;
    }

    .c-btn {
        padding: 0.8rem 2rem;
        border-radius: 6px;
        font-size: 0.9rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.3s;
        border: none;
        display: inline-block;
    }

    .c-btn-primary {
        background: linear-gradient(90deg, #00d9ff, #3b82f6);
        color: #fff;
        box-shadow: 0 0 15px rgba(0, 217, 255, 0.4);
    }

    .c-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 0 25px rgba(0, 217, 255, 0.6);
    }

    .c-btn-secondary {
        background: rgba(255,255,255,0.05);
        color: #fff;
        border: 1px solid rgba(255,255,255,0.2);
    }

    .c-btn-secondary:hover {
        background: rgba(255,255,255,0.1);
    }

    .carousel-controls {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 100%;
        display: flex;
        justify-content: space-between;
        padding: 0 2rem;
        pointer-events: none;
        z-index: 10;
        box-sizing: border-box;
    }

    .c-ctrl-btn {
        pointer-events: auto;
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        color: #fff;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
    }

    .c-ctrl-btn:hover {
        background: rgba(0, 217, 255, 0.3);
        border-color: #00d9ff;
    }

    .section-title {
        font-size: 1.8rem;
        font-weight: 900;
        color: #fff;
        border-bottom: 2px solid rgba(255,255,255,0.1);
        padding-bottom: 0.5rem;
        margin-bottom: 2rem;
        margin-top: 4rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Grid Layout */
    .grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
    }

    /* Card Styling */
    .entity-card {
        background: rgba(10, 14, 23, 0.8);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .entity-card:hover {
        transform: translateY(-5px);
        border-color: rgba(0, 217, 255, 0.4);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5), 0 0 15px rgba(0, 217, 255, 0.1);
    }

    .card-img {
        width: 100%;
        height: 200px;
        background: #111;
        object-fit: cover;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }

    .card-img-placeholder {
        width: 100%;
        height: 200px;
        background: linear-gradient(45deg, #0a0e17, #1a2333);
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(255,255,255,0.1);
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }

    .card-content {
        padding: 1.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: #fff;
        margin: 0 0 0.5rem 0;
        line-height: 1.3;
    }

    .card-desc {
        font-size: 0.85rem;
        color: var(--text-muted, #94a3b8);
        margin: 0 0 1.5rem 0;
        line-height: 1.5;
        flex: 1;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card-meta {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        padding-top: 1rem;
        border-top: 1px dashed rgba(255,255,255,0.1);
        gap: 1rem;
    }

    .meta-stock {
        font-size: 0.9rem;
        font-weight: 700;
        color: #10b981;
    }

    .meta-stock.empty { color: #ef4444; }
    .meta-stock.room { color: #3b82f6; }

    .btn-detail {
        background: rgba(0, 217, 255, 0.1);
        color: #00d9ff;
        border: 1px solid rgba(0, 217, 255, 0.3);
        padding: 0.75rem 1rem;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.3s;
        text-align: center;
        width: 100%;
        display: block;
        box-sizing: border-box;
    }

    .btn-detail:hover {
        background: #00d9ff;
        color: #000;
        box-shadow: 0 0 15px rgba(0, 217, 255, 0.4);
    }

    /* Paging logic reuse */
    .pagination-controls {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 3rem;
    }

    .page-btn {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        color: var(--text-muted);
        width: 36px;
        height: 36px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s;
    }

    .page-btn:hover, .page-btn.active {
        background: rgba(0, 217, 255, 0.1);
        color: #00d9ff;
        border-color: rgba(0, 217, 255, 0.3);
    }
    .page-btn.active {
        background: #00d9ff;
        color: #000;
    }

    @media (max-width: 768px) {
        .carousel-section { height: auto; border-radius: 8px; }
        .carousel-track { height: auto; align-items: stretch; }
        .carousel-slide { display: flex; flex-direction: column; height: auto; }
        .carousel-img { 
            position: relative; 
            width: 100%; 
            height: 56.25vw; /* 16:9 Aspect Ratio */
            opacity: 1; 
            border-bottom: 2px solid rgba(0,217,255,0.3);
        }
        
        /* Hide text content completely on mobile */
        .carousel-content { 
            display: none !important;
        }
        
        /* Push controls below track in normal flow */
        .carousel-controls { 
            position: relative;
            top: auto; 
            bottom: auto; 
            transform: none; 
            padding: 1rem 0; 
            justify-content: center; 
            gap: 3rem; 
            background: #0a0e17;
        }
        .c-ctrl-btn { width: 44px; height: 44px; }
        
        .grid-container { grid-template-columns: 1fr; }
        .section-title { font-size: 1.25rem; font-weight: 800; margin-top: 3rem; }
        .section-title svg { width: 20px; height: 20px; }
    }
</style>

<div class="catalog-container">
    
    <!-- Hero Carousel -->
    @if(count($carouselItems) > 0)
    <div class="carousel-section">
        <div class="carousel-track" id="carouselTrack">
            @foreach($carouselItems as $idx => $item)
                @php
                    $isLab = $item->slide_type === 'lab';
                    $title = $isLab ? $item->nama_lab : $item->nama_alat;
                    $badge = $isLab ? __('public.home.badge_lab') : __('public.home.badge_alat');
                    $fotoArr = is_string($item->fotos) ? json_decode($item->fotos, true) : $item->fotos;
                    $imgSrc = (is_array($fotoArr) && count($fotoArr) > 0) ? Storage::url($fotoArr[0]) : null;
                @endphp
                <div class="carousel-slide">
                    <a href="{{ route('public.detail', ['type' => $isLab ? 'lab' : 'alat', 'id' => $item->id]) }}" style="display:block; width:100%; height:100%;">
                        @if($imgSrc)
                            <img src="{{ $imgSrc }}" alt="Hero" class="carousel-img">
                        @else
                            <div class="carousel-img" style="display:flex; justify-content:center; align-items:center; background:#111;">NO IMAGE</div>
                        @endif
                    </a>
                    <div class="carousel-content">
                        <span class="carousel-badge">{{ $badge }}</span>
                        <h1 class="carousel-title">{{ $title }}</h1>
                        <p class="carousel-desc">{{ Str::limit($item->deskripsi, 150) }}</p>
                        
                        <div class="carousel-actions">
                            <form action="{{ route('public.intent') }}" method="POST" style="margin:0;">
                                @csrf
                                <input type="hidden" name="type" value="{{ $isLab ? 'lab' : 'alat' }}">
                                <input type="hidden" name="id" value="{{ $item->id }}">
                                <button type="submit" class="c-btn c-btn-primary">{{ __('public.home.btn_ajukan') }}</button>
                            </form>
                            <a href="{{ route('public.detail', ['type' => $isLab ? 'lab' : 'alat', 'id' => $item->id]) }}" class="c-btn c-btn-secondary">{{ __('public.home.btn_detail') }}</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="carousel-controls">
            <button class="c-ctrl-btn" onclick="prevSlide()"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg></button>
            <button class="c-ctrl-btn" onclick="nextSlide()"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg></button>
        </div>
    </div>
    @endif

    <!-- Catalog Sections -->

    <h2 class="section-title">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
        {{ __('public.home.title_lab') }}
    </h2>
    <div class="grid-container" id="grid-lab">
        @foreach($laboratoriums as $lab)
        <div class="entity-card lab-item">
            @if($lab->fotos && is_array($lab->fotos) && count($lab->fotos) > 0)
                <img src="{{ Storage::url($lab->fotos[0]) }}" alt="{{ $lab->nama_lab }}" class="card-img">
            @else
                <div class="card-img-placeholder">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 21H2V5a2 2 0 0 1 2-2h4l2 2h10a2 2 0 0 1 2 2v14z"></path></svg>
                </div>
            @endif
            <div class="card-content">
                <h3 class="card-title">{{ $lab->nama_lab }}</h3>
                <p class="card-desc">{{ Str::limit($lab->deskripsi, 120) }}</p>
                <div class="card-meta">
                    <div class="meta-stock room">
                        <span style="font-size: 0.7rem; color: var(--text-muted); display: block; text-transform: uppercase; margin-bottom: 0.25rem;">{{ __('public.home.asset_terdaftar') }}</span>
                        <span style="font-size: 1.25rem;">{{ $lab->alat_count }} {{ __('public.home.perangkat') }}</span>
                    </div>
                    <a href="{{ route('public.detail', ['type' => 'lab', 'id' => $lab->id]) }}" class="btn-detail">{{ __('public.home.btn_sidak') }}</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <h2 class="section-title" style="margin-top: 6rem;">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#00d9ff" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
        {{ __('public.home.title_alat') }}
    </h2>
    <div class="grid-container" id="grid-alat">
        @foreach($alats as $alat)
        <div class="entity-card alat-item">
            @if($alat->fotos && is_array($alat->fotos) && count($alat->fotos) > 0)
                <img src="{{ Storage::url($alat->fotos[0]) }}" alt="{{ $alat->nama_alat }}" class="card-img">
            @else
                <div class="card-img-placeholder">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                </div>
            @endif
            <div class="card-content">
                <h3 class="card-title">{{ $alat->nama_alat }}</h3>
                <div style="font-size: 0.7rem; color: #3b82f6; text-transform: uppercase; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 4px;">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M22 21H2V5a2 2 0 0 1 2-2h4l2 2h10a2 2 0 0 1 2 2v14z"></path></svg>
                    {{ __('public.home.lokasi') }}: {{ $alat->laboratorium->nama_lab ?? __('public.home.unassigned') }}
                </div>
                <p class="card-desc">{{ Str::limit($alat->deskripsi, 100) }}</p>
                <div class="card-meta">
                    <div class="meta-stock {{ $alat->available_stok > 0 ? '' : 'empty' }}">
                        <span style="font-size: 0.7rem; color: var(--text-muted); display: block; text-transform: uppercase; margin-bottom: 0.25rem;">{{ __('public.home.sisa_stok') }}</span>
                        <span style="font-size: 1.25rem;">{{ $alat->available_stok }} {{ __('public.home.unit') }}</span>
                    </div>
                    <a href="{{ route('public.detail', ['type' => 'alat', 'id' => $alat->id]) }}" class="btn-detail">{{ __('public.home.btn_akses') }}</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>

<script>
    // CAROUSEL LOGIC
    const track = document.getElementById('carouselTrack');
    const slidesCount = {{ count($carouselItems) }};
    let currentSlide = 0;
    let carouselInterval;

    function goToSlide(index) {
        if(slidesCount === 0) return;
        if(index >= slidesCount) index = 0;
        if(index < 0) index = slidesCount - 1;
        currentSlide = index;
        track.style.transform = `translateX(-${currentSlide * 100}%)`;
    }

    function nextSlide() {
        goToSlide(currentSlide + 1);
        resetInterval();
    }

    function prevSlide() {
        goToSlide(currentSlide - 1);
        resetInterval();
    }

    function startInterval() {
        if(slidesCount > 1) {
            carouselInterval = setInterval(() => goToSlide(currentSlide + 1), 5000);
        }
    }

    function resetInterval() {
        clearInterval(carouselInterval);
        startInterval();
    }
    
    // PAGINATION LOGIC
    function getItemsPerPage() {
        if (window.innerWidth < 768) return 5;
        if (window.innerWidth < 1024) return 6;
        return 9;
    }

    let currentPageState = { lab: 1, alat: 1 };

    function renderPagination(tabId) {
        const items = document.querySelectorAll(`.${tabId}-item`);
        if(items.length === 0) return;

        const itemsPerPage = getItemsPerPage();
        const totalPages = Math.ceil(items.length / itemsPerPage);
        
        let currentPage = currentPageState[tabId];
        if (currentPage > totalPages) currentPage = totalPages;
        if (currentPage < 1) currentPage = 1;
        currentPageState[tabId] = currentPage;

        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;

        items.forEach((item, index) => {
            item.style.display = (index >= startIndex && index < endIndex) ? 'flex' : 'none';
        });

        let paginationContainer = document.getElementById(`pagination-${tabId}`);
        if(!paginationContainer) {
            paginationContainer = document.createElement('div');
            paginationContainer.id = `pagination-${tabId}`;
            paginationContainer.className = 'pagination-controls';
            document.getElementById(`grid-${tabId}`).parentNode.insertBefore(paginationContainer, document.getElementById(`grid-${tabId}`).nextSibling);
        }

        paginationContainer.innerHTML = '';
        if (totalPages <= 1) return;

        for (let i = 1; i <= totalPages; i++) {
            const btn = document.createElement('button');
            btn.className = `page-btn ${i === currentPage ? 'active' : ''}`;
            btn.innerText = i;
            btn.onclick = () => {
                currentPageState[tabId] = i;
                renderPagination(tabId);
                // Scroll to top of section logic if needed
            };
            paginationContainer.appendChild(btn);
        }
    }

    function init() {
        startInterval();
        renderPagination('lab');
        renderPagination('alat');
    }

    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            renderPagination('lab');
            renderPagination('alat');
        }, 250);
    });

    document.addEventListener('DOMContentLoaded', init);
</script>
@endsection
