@extends('layouts.public')

@section('title', 'Tentang SIM-LAB')

@section('content')
<style>
    .about-hero {
        position: relative;
        width: 96%;
        max-width: 1600px;
        margin: 1rem auto 0 auto; /* Menariknya ke bawah menghindari bentrok dengan Navbar Floating */
        border-radius: 20px; /* Bentuk melengkung yang lebih serasi dengan desain Navbar Jinwoo */
        aspect-ratio: 16 / 9;
        max-height: 600px; 
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 2rem;
        box-sizing: border-box; /* PERISTIWA PENTING: Mencegah padding mendesak width 100% sehingga layar jebol ke kanan */
        border-bottom: 2px solid rgba(0, 217, 255, 0.2);
        overflow: hidden;
    }
    
    .video-background {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100vw;
        height: 56.25vw; /* 9/16 aspect ratio base on viewport width */
        pointer-events: none; /* prevents clicking video to pause */
    }

    /* As the hero is fixed at 600px height, if the view width dips below 1066.66px, the 16:9 box becomes shorter than 600px. We must switch to fixed dimensions! */
    @media (max-width: 1066.6px) {
        .video-background {
            height: 600px;
            width: 1066.66px;
        }
    }
    
    .about-hero::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(5, 8, 15, 0.4); /* gradient overly on top of video */
        z-index: 1;
        border-radius: 20px; /* Mengikuti radius pembungkus */
    }

    /* Mute Button styling */
    .mute-btn {
        position: absolute;
        bottom: 2rem;
        right: 2rem;
        z-index: 10;
        background: rgba(0,0,0,0.6);
        border: 1px solid rgba(255,255,255,0.2);
        color: #fff;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
        backdrop-filter: blur(5px);
    }
    
    .mute-btn:hover {
        background: rgba(0, 217, 255, 0.4);
        border-color: #00d9ff;
        transform: scale(1.1);
    }

    .about-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 5rem 2rem;
    }

    .section-title {
        font-size: 2rem;
        font-weight: 900;
        color: #fff;
        margin-bottom: 2.5rem;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
    }
    
    .section-title::after {
        content: '';
        width: 60px;
        height: 4px;
        background: #00d9ff;
        border-radius: 2px;
    }

    /* Visi Misi Grid */
    .vm-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        margin-bottom: 6rem;
    }

    .vm-card {
        background: rgba(10, 14, 23, 0.8);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 12px;
        padding: 2.5rem;
        transition: all 0.3s ease;
    }

    .vm-card:hover {
        border-color: rgba(0, 217, 255, 0.3);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5), 0 0 20px rgba(0, 217, 255, 0.05);
        transform: translateY(-5px);
    }

    .vm-icon {
        width: 64px;
        height: 64px;
        background: rgba(0, 217, 255, 0.1);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #00d9ff;
        margin-bottom: 1.5rem;
    }

    .vm-card h2 {
        font-size: 1.8rem;
        color: #fff;
        margin-bottom: 1rem;
        font-weight: 800;
    }

    .vm-card p, .vm-card li {
        font-size: 1.05rem;
        color: var(--text-muted, #94a3b8);
        line-height: 1.8;
    }

    .vm-card ul {
        padding-left: 1.5rem;
    }

    /* Tata Tertib Grid */
    .rules-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-bottom: 6rem;
    }

    .rule-card {
        background: linear-gradient(180deg, rgba(14, 20, 31, 0.8) 0%, rgba(10, 14, 23, 0.8) 100%);
        border-top: 3px solid #3b82f6;
        border-radius: 8px;
        padding: 2rem;
    }

    .rule-card.warning { border-top-color: #ef4444; }
    .rule-card.success { border-top-color: #10b981; }

    .rule-card h3 {
        color: #fff;
        font-size: 1.25rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Team Section */
    .team-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 3rem;
        margin-bottom: 6rem;
        text-align: center;
    }

    .team-card {
        background: rgba(10, 14, 23, 0.5);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 12px;
        padding: 2rem;
    }

    .team-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        margin: 0 auto 1.5rem auto;
        border: 4px solid rgba(0, 217, 255, 0.2);
        background: #1a2333;
    }

    .team-name {
        color: #fff;
        font-size: 1.25rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .team-role {
        color: #00d9ff;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 700;
    }

    /* Map & Contact */
    .contact-section {
        display: flex;
        gap: 3rem;
        background: rgba(10, 14, 23, 0.8);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 12px;
        overflow: hidden;
    }

    .contact-info {
        flex: 1;
        padding: 3rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .contact-map {
        flex: 1;
        min-height: 350px;
        background: #111;
    }

    .contact-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .contact-item svg {
        color: #3b82f6;
        flex-shrink: 0;
        margin-top: 0.2rem;
    }

    .contact-text h4 {
        color: #fff;
        margin: 0 0 0.25rem 0;
        font-size: 1.1rem;
    }
    
    .contact-text p {
        color: var(--text-muted);
        margin: 0;
        line-height: 1.6;
    }

    @media (max-width: 992px) {
        .vm-grid { grid-template-columns: 1fr; gap: 2rem; }
        .contact-section { flex-direction: column; }
        .contact-map { height: 300px; min-height: auto; }
    }

    @media (max-width: 768px) {
        .about-hero {
            padding: 1.5rem;
        }
        .hero-title { font-size: 1.8rem; }
        .hero-subtitle { font-size: 0.9rem; }
        .about-container { padding: 3rem 1rem; }
        .contact-info { padding: 2rem 1.5rem; }
        
        .mute-btn {
            width: 40px;
            height: 40px;
            bottom: 1rem;
            right: 1rem;
        }
        .mute-btn svg { width: 18px; height: 18px; }
    }
</style>

<!-- HERO -->
<div class="about-hero">
    <!-- Blank anchor for YouTube Iframe API -->
    <div id="yt-player" class="video-background"></div>
    
    <!-- Floating Mute Toggle -->
    <button id="muteToggle" class="mute-btn" onclick="toggleMute()" aria-label="Toggle Sound">
        <!-- SVG Unmuted (Volume High) by default, but typically autoplay forces mute. We will update via JS -->
        <svg id="icon-unmuted" style="display: block;" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"></path></svg>
        <!-- SVG Muted (Volume X) -->
        <svg id="icon-muted" style="display: none;" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><line x1="23" y1="9" x2="17" y2="15"></line><line x1="17" y1="9" x2="23" y2="15"></line></svg>
    </button>
</div>

<div class="about-container">
    
    <!-- VISI & MISI -->
    <div class="section-title">{{ __('public.about.vm_title') }}</div>
    <div class="vm-grid">
        <div class="vm-card">
            <div class="vm-icon">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg>
            </div>
            <h2>{{ __('public.about.visi_title') }}</h2>
            <p>{{ __('public.about.visi_desc') }}</p>
        </div>
        <div class="vm-card">
            <div class="vm-icon">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            </div>
            <h2>{{ __('public.about.misi_title') }}</h2>
            <ul>
                <li>{{ __('public.about.misi_1') }}</li>
                <li>{{ __('public.about.misi_2') }}</li>
                <li>{{ __('public.about.misi_3') }}</li>
                <li>{{ __('public.about.misi_4') }}</li>
            </ul>
        </div>
    </div>

    <!-- TATA TERTIB -->
    <div class="section-title">{{ __('public.about.tata_tertib') }}</div>
    <div class="rules-grid">
        <div class="rule-card success">
            <h3><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg> {{ __('public.about.rule_1_title') }}</h3>
            <p style="color:var(--text-muted);font-size:0.95rem;line-height:1.6;">{{ __('public.about.rule_1_desc') }}</p>
        </div>
        <div class="rule-card">
            <h3><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg> {{ __('public.about.rule_2_title') }}</h3>
            <p style="color:var(--text-muted);font-size:0.95rem;line-height:1.6;">{{ __('public.about.rule_2_desc') }}</p>
        </div>
        <div class="rule-card warning">
            <h3><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg> {{ __('public.about.rule_3_title') }}</h3>
            <p style="color:var(--text-muted);font-size:0.95rem;line-height:1.6;">{{ __('public.about.rule_3_desc') }}</p>
        </div>
    </div>

    <!-- STRUKTUR TEAM -->
    <div class="section-title">{{ __('public.about.pilar_pengelola') }}</div>
    <div class="team-grid">
        <div class="team-card">
            <img src="{{ Storage::url('pengelola/prof_dr_nurhasan_m_kes_.webp') }}" onerror="this.src='https://ui-avatars.com/api/?name=Rektor+UNESA&background=1e293b&color=10b981&size=120'" alt="Rektor" class="team-avatar">
            <div class="team-name">Prof. Dr. Nurhasan, M.Kes.</div>
            <div class="team-role">{{ __('public.about.role_rektor') }}</div>
        </div>
        <div class="team-card">
            <img src="{{ Storage::url('pengelola/prof_dr_suparji_s_pd_m_pd_.webp') }}" onerror="this.src='https://ui-avatars.com/api/?name=Kaprodi+Teknik&background=1e293b&color=3b82f6&size=120'" alt="Kepala Teknik" class="team-avatar">
            <div class="team-name">Prof. Dr. Suparji, S.Pd., M.Pd.</div>
            <div class="team-role">{{ __('public.about.role_ka_teknik') }}</div>
        </div>
        <div class="team-card">
            <img src="{{ Storage::url('pengelola/paramitha_nerisafitra_s_st_m_kom_.webp') }}" onerror="this.src='https://ui-avatars.com/api/?name=Asisten+Kepala&background=1e293b&color=00d9ff&size=120'" alt="Kaprodi TI" class="team-avatar">
            <div class="team-name">Paramitha Nerisafitra, S.ST., M.Kom</div>
            <div class="team-role">{{ __('public.about.role_ka_ti') }}</div>
        </div>
    </div>

    <!-- KONTAK MAP -->
    <div class="section-title">{{ __('public.about.lokasi_kontak') }}</div>
    <div class="contact-section">
        <div class="contact-info">
            <div class="contact-item">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                <div class="contact-text">
                    <h4>{{ __('public.about.contact_1_title') }}</h4>
                    <p>{!! __('public.about.contact_1_desc') !!}</p>
                </div>
            </div>
            <div class="contact-item">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                <div class="contact-text">
                    <h4>{{ __('public.about.contact_2_title') }}</h4>
                    <p>{!! __('public.about.contact_2_desc') !!}</p>
                </div>
            </div>
            <div class="contact-item">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                <div class="contact-text">
                    <h4>{{ __('public.about.contact_3_title') }}</h4>
                    <p>{!! __('public.about.contact_3_desc') !!}</p>
                </div>
            </div>
        </div>
        <div class="contact-map">
            <!-- Google Maps Embed Dummy Ketintang -->
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15829.130935515328!2d112.72023531649984!3d-7.310804797880922!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fbf0cf3dffff%3A0xe6bf44bc426b3a0!2sUniversitas%20Negeri%20Surabaya%20-%20Kampus%20Ketintang!5e0!3m2!1sen!2sid!4v1714392095819!5m2!1sen!2sid" width="100%" height="100%" style="border:0; filter: grayscale(100%) invert(90%) contrast(1.2) hue-rotate(180deg);" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>

</div>

<script src="https://www.youtube.com/iframe_api"></script>
<script>
    var ytPlayer;
    var iconMuted = document.getElementById('icon-muted');
    var iconUnmuted = document.getElementById('icon-unmuted');

    function onYouTubeIframeAPIReady() {
        ytPlayer = new YT.Player('yt-player', {
            videoId: 'sfQJXnzpaCs',
            playerVars: {
                'autoplay': 1,
                'controls': 0,
                'rel': 0,
                'showinfo': 0,
                'modestbranding': 1,
                'loop': 1,
                'playlist': 'sfQJXnzpaCs', // Sangat wajib untuk fitur loop tiada akhir
                'enablejsapi': 1,
                'origin': window.location.origin
            },
            events: {
                'onReady': onPlayerReady,
                'onStateChange': onPlayerStateChange
            }
        });
    }

    function onPlayerReady(event) {
        // Coba putar versi unmute duluan
        ytPlayer.unMute();
        var promise = event.target.playVideo();
        
        // Pengecekan jika Browser memblokir pelepasan suara otomatis (autoplay policy)
        setTimeout(() => {
            if (ytPlayer.isMuted() || ytPlayer.getPlayerState() !== 1) {
                // Berarti terblokir, kita harus Mute agar minimal video tetap berjalan otomatis
                ytPlayer.mute();
                ytPlayer.playVideo();
                updateMuteIcon(true);
            } else {
                updateMuteIcon(false);
            }
        }, 1000);
    }

    function onPlayerStateChange(event) {
        // Event = 0 adalah Status ENDED. Ini pengaman ekstra selain playlist loop.
        if (event.data === 0) {
            ytPlayer.playVideo();
        }
    }

    function toggleMute() {
        if (!ytPlayer) return;
        if (ytPlayer.isMuted()) {
            ytPlayer.unMute();
            updateMuteIcon(false);
        } else {
            ytPlayer.mute();
            updateMuteIcon(true);
        }
    }

    function updateMuteIcon(isMuted) {
        if (isMuted) {
            iconMuted.style.display = 'block';
            iconUnmuted.style.display = 'none';
        } else {
            iconMuted.style.display = 'none';
            iconUnmuted.style.display = 'block';
        }
    }
</script>
@endsection
