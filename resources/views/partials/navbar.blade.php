<style>
/* --- JINWOO S-RANK NAV --- */
:root {
  --nav-neon-grad: linear-gradient(90deg, #22d3ee, #3b82f6, #9333ea, #22d3ee);
  --nav-bevel: polygon(30px 0, calc(100% - 30px) 0, 100% 30px, 100% calc(100% - 30px), calc(100% - 30px) 100%, 30px 100%, 0 calc(100% - 30px), 0 30px);
}

@keyframes navBorderMove {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

#jinwoo-nav {
  position: fixed;
  top: 20px; /* Jarak agar tidak menempel rapat di tepi atas */
  left: 50%;
  transform: translateX(-50%) translateY(0);
  width: 98%;
  max-width: 1500px;
  height: 80px;
  z-index: 100;
  transition: transform 0.4s ease-in-out;
  padding: 2px;
  background: var(--nav-neon-grad);
  background-size: 400% 400%;
  animation: navBorderMove 10s linear infinite;
  clip-path: var(--nav-bevel);
  box-shadow: 0 10px 30px rgba(0,0,0,0.5);
}

#jinwoo-nav.visible { }
#jinwoo-nav.hidden { }

#jinwoo-nav-inner {
  width: 100%;
  height: 100%;
  background: rgba(15, 16, 35, 0.98); /* Sangat gelap kebiruan elegan */
  clip-path: inherit;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0 3rem;
  box-sizing: border-box;
}

.j-logo {
  font-size: 1.5rem;
  font-weight: 900;
  letter-spacing: 0.2em;
  color: #fff;
  text-decoration: none;
  text-transform: uppercase;
  display: flex;
  align-items: center;
  white-space: nowrap; /* Mencegah berantakan jika sempit */
}
.j-logo-cyan {
  color: #00d9ff;
  text-shadow: 0 0 15px rgba(0,217,255,0.8);
  margin-left: 0.25rem;
}

.j-menu-desktop {
  display: flex;
  gap: 0.5rem;
  list-style: none;
  margin: 0; padding: 0;
}

/* Base style untuk tiap item menu */
.j-menu-item {
  position: relative;
  height: 40px;
  padding: 0 1.5rem;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  text-decoration: none;
  color: rgba(255,255,255,0.7);
  background: transparent;
  font-weight: 700;
  text-transform: uppercase;
  font-size: 0.8rem;
  letter-spacing: 0.1em;
}

.j-menu-item:hover {
  color: #fff;
  background: rgba(255,255,255,0.08); /* Efek sorot elegan */
}

.j-menu-item.active {
  background: var(--nav-neon-grad);
  background-size: 300% 300%;
  animation: navBorderMove 8s linear infinite;
  color: #02040a;
  box-shadow: 0 0 20px rgba(0,217,255,0.4);
  transform: translateY(-2px);
}

.j-actions {
  display: flex;
  align-items: center;
  gap: 1.5rem;
}

.j-icon-btn {
  color: rgba(255,255,255,0.7);
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  text-decoration: none;
}
.j-icon-btn:hover {
  color: #00d9ff;
  transform: scale(1.1);
}

.j-hamburger {
  display: none;
  color: rgba(255,255,255,0.7);
  transition: color 0.3s ease;
  align-items: center;
  justify-content: center;
  cursor: pointer;
}
.j-hamburger:hover {
  color: #00d9ff;
}

@media (max-width: 900px) {
  #jinwoo-nav-inner { 
    padding: 0 1.5rem; 
  }
  
  .j-hamburger {
    display: flex;
  }

  .j-menu-desktop { display: none; }

  .j-logo {
    /* Hapus margin statis agar logo otomatis berada di titik tengah berkat space-between */
    margin: 0;
    font-size: 1.2rem;
  }
}

@media (max-width: 480px) {
  #jinwoo-nav-inner {
    padding: 0 1.5rem; /* Memberi ruang aman agar tidak terpotong layar lengkung (Edge Display) */
  }
  .j-logo {
    font-size: 0.95rem;
    margin-left: 0.5rem;
    letter-spacing: 0.1em;
  }
  .j-actions {
    gap: 1.25rem; /* Gap diperlebar agar tidak saling tumpang tindih dengan teks ID */
  }
  .j-icon-btn svg {
    width: 20px;
    height: 20px;
  }
}

/* MOBILE MENU EXTERNAL WRAPPER */
.j-menu-mobile { 
  display: none; 
}

@media (max-width: 900px) {
  .j-menu-mobile {
    display: flex; 
    position: fixed;
    top: 0;
    left: 0;
    width: 280px;
    height: 100vh;
    background: rgba(10, 14, 23, 0.98);
    flex-direction: column;
    padding: 2rem 0;
    border-right: 1px solid rgba(0,217,255,0.3);
    box-shadow: 10px 0 30px rgba(0,0,0,0.8);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    z-index: 999;
    
    /* Konfigurasi Slide Sidebar Kiri */
    transform: translateX(-100%);
    transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .j-sidebar-header {
    display: flex;
    justify-content: flex-end; /* Silang di paling kanan */
    align-items: center;
    padding: 0 1.5rem 1rem 1.5rem;
    margin-bottom: 0.5rem;
  }

  .j-close-btn {
    color: rgba(255,255,255,0.7);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: color 0.3s;
  }
  .j-close-btn:hover { color: #00d9ff; }

  .j-menu-mobile.show-mobile {
    transform: translateX(0);
  }

  .j-menu-mobile .j-menu-item {
    padding: 1rem 2rem;
    justify-content: flex-start;
    border-radius: 0;
    font-size: 0.75rem; /* Font diperkecil */
    border-bottom: 1px solid rgba(255,255,255,0.05);
  }
}
</style>

@php
    // Inisialisasi Deteksi Bahasa
    $lang = session('locale', 'id');
    $toggleLang = $lang === 'id' ? 'en' : 'id';
@endphp

<div id="jinwoo-nav" class="visible">
  <div id="jinwoo-nav-inner">
      <!-- HAMBURGER MOBILE (Paling Kiri) -->
      <div class="j-hamburger" id="jHamburgerBtn" title="Menu">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <line x1="3" y1="12" x2="21" y2="12"></line>
              <line x1="3" y1="6" x2="21" y2="6"></line>
              <line x1="3" y1="18" x2="21" y2="18"></line>
          </svg>
      </div>

      <!-- LOGO -->
      <a href="{{ url('/') }}" class="j-logo">
          SIM-LAB<span class="j-logo-cyan">UNESA</span>
      </a>

      <!-- MENU TENGAH / DESKTOP -->
      <div class="j-menu-desktop">
          <a href="{{ url('/') }}" class="j-menu-item {{ request()->is('/') ? 'active' : '' }}">{{ __('public.navbar.home') }}</a>
          <a href="{{ url('/about') }}" class="j-menu-item {{ request()->is('about') ? 'active' : '' }}">{{ __('public.navbar.about') }}</a>
          <a href="{{ url('/schedule') }}" class="j-menu-item {{ request()->is('schedule') ? 'active' : '' }}">{{ __('public.navbar.schedule') }}</a>
      </div>

      <!-- ICON KANAN -->
      <div class="j-actions">
          <!-- Globe / Bahasa Icon -->
          <a href="{{ url('/lang/' . $toggleLang) }}" class="j-icon-btn" title="Ganti Bahasa ({{ strtoupper($toggleLang) }})">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <circle cx="12" cy="12" r="10"></circle>
                  <line x1="2" y1="12" x2="22" y2="12"></line>
                  <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
              </svg>
              <span style="font-size: 0.65rem; margin-left: 0.25rem; font-weight: bold; text-transform: uppercase;">{{ $lang }}</span>
          </a>

          <!-- Profile / Login Icon -->
          @auth
              @php
                  // Hitung jumlah notifikasi yang belum dibaca
                  $unreadNotif = Auth::user()->notifikasi()->where('is_read', false)->count();
              @endphp
              <!-- Notifikasi Lonceng (Bell) -->
              <a href="{{ route('notifications.index') }}" class="j-icon-btn" style="position: relative; margin-right: 0.5rem;" title="Pusat Peringatan & Notifikasi @if($unreadNotif > 0)({{ $unreadNotif }} Baru)@endif">
                  <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                      <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                  </svg>
                  <!-- Angka Merah Indikator Notifikasi Aktif -->
                  @if($unreadNotif > 0)
                      <span style="position: absolute; top: -4px; right: 0px; background-color: #ef4444; color: white; border-radius: 50%; min-width: 16px; height: 16px; display: flex; align-items: center; justify-content: center; font-size: 0.55rem; font-weight: 900; box-shadow: 0 0 8px rgba(239, 68, 68, 0.9); padding: 0 3px;">
                          {{ $unreadNotif > 99 ? '99+' : $unreadNotif }}
                      </span>
                  @endif
              </a>

              @php
                  // Tentukan rute dashboard berdasarkan letak role masing-masing
                  $dashboardRoute = url('/');
                  $uRole = Auth::user()->role;
                  if ($uRole === 'mahasiswa') {
                      $dashboardRoute = route('student.dashboard');
                  } elseif ($uRole === 'master') {
                      $dashboardRoute = route('master.dashboard');
                  } elseif ($uRole === 'asisten') {
                      $dashboardRoute = route('asisten.dashboard');
                  } elseif ($uRole === 'dosen') {
                      $dashboardRoute = route('dosen.dashboard');
                  } elseif ($uRole === 'admin') {
                      $dashboardRoute = route('admin.dashboard');
                  }
              @endphp
              <a href="{{ $dashboardRoute }}" class="j-icon-btn" style="border-radius: 50%; overflow: hidden; padding: 2px; border: 2px solid rgba(0,217,255,0.6); box-shadow: 0 0 10px rgba(0,217,255,0.3);" title="Ke Dashboard Pusat ({{ Auth::user()->name }})">
                  @if(Auth::user()->avatar)
                      <img src="{{ Auth::user()->avatar }}" alt="Avatar" style="width: 36px; height: 36px; object-fit: cover; border-radius: 50%; display: block;">
                  @else
                      <div style="width: 36px; height: 36px; background: rgba(0, 217, 255, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #00d9ff; font-weight: 800; font-size: 1.1rem; text-transform: uppercase;">
                          {{ substr(Auth::user()->name, 0, 1) }}
                      </div>
                  @endif
              </a>
          @else
              <a href="{{ route('login') }}" class="j-icon-btn" title="Sistem Identitas">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                      <circle cx="12" cy="7" r="4"></circle>
                  </svg>
              </a>
          @endauth
      </div>
  </div>
</div>

<!-- EXTERNAL MOBILE MENU (Agar tidak terpotong clip-path) -->
<div class="j-menu-mobile" id="jMobileMenu">
    <!-- Header Sidebar Mobile -->
    <div class="j-sidebar-header">
        <div class="j-close-btn" id="jCloseBtn" title="Tutup Menu">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </div>
    </div>

    <!-- Teringat dengan Navbar Desktop -->
    <a href="{{ url('/') }}" class="j-menu-item {{ request()->is('/') ? 'active' : '' }}">{{ __('public.navbar.home') }}</a>
    <a href="{{ url('/about') }}" class="j-menu-item {{ request()->is('about') ? 'active' : '' }}">{{ __('public.navbar.about') }}</a>
    <a href="{{ url('/schedule') }}" class="j-menu-item {{ request()->is('schedule') ? 'active' : '' }}">{{ __('public.navbar.schedule') }}</a>
</div>

<script>
  (function(){
      let jLastScroll = 0;
      const jNav = document.getElementById("jinwoo-nav");
      const jHam = document.getElementById("jHamburgerBtn");
      const jMenu = document.getElementById("jMobileMenu");
      const jClose = document.getElementById("jCloseBtn");

      // Fungsi Tutup Laci
      function closeMobileSidebar() {
          if(jMenu && jMenu.classList.contains("show-mobile")) {
              jMenu.classList.remove("show-mobile");
              
              // Kembalikan Navbar Utama ketika ditutup
              if(jNav && window.pageYOffset < 60) {
                  jNav.style.transform = "translateX(-50%) translateY(0)"; // show
              }
          }
      }

      // Handle Scroll Hide/Unhide
      if(jNav) {
          window.addEventListener("scroll", function() {
              let jCurrent = window.pageYOffset || document.documentElement.scrollTop;
              
              // Cek bila scroll down / up
              if (jCurrent > jLastScroll && jCurrent > 60) {
                  // Bersembunyi (Scroll down)
                  jNav.style.transform = "translateX(-50%) translateY(-150px)";
                  closeMobileSidebar(); // Auto tutip
              } else {
                  // Muncul (Scroll up)
                  // Jangan munculkan navbar jika laci sedang terbuka!
                  if(!(jMenu && jMenu.classList.contains("show-mobile")) || jCurrent <= 60) {
                      jNav.style.transform = "translateX(-50%) translateY(0)";
                  }
              }
              jLastScroll = jCurrent <= 0 ? 0 : jCurrent; 
          }, false);
      }

      // Handle Hamburger Click
      if(jHam && jMenu) {
          jHam.addEventListener('click', function(e) {
              e.stopPropagation();
              jMenu.classList.add("show-mobile");
              // SEMBUNYIKAN NAVBAR UTAMA
              if(jNav) jNav.style.transform = "translateX(-50%) translateY(-150px)";
          });
      }

      // Handle Close (X) Click
      if(jClose) {
          jClose.addEventListener('click', function(e){
              e.stopPropagation();
              closeMobileSidebar();
          });
      }

      // Handle Click Outside (Close Navbar)
      document.addEventListener('click', function(e) {
          if(jMenu && jMenu.classList.contains("show-mobile")) {
              if(!jMenu.contains(e.target) && !jHam.contains(e.target)) {
                  closeMobileSidebar();
              }
          }
      });
  })();
</script>
