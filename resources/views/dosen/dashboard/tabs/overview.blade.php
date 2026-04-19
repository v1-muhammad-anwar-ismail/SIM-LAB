<!-- Flatpickr CDN for Datetime -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">

<style>
    /* Custom Radio Cards untuk Lab */
    .radio-card-grid { display: flex; gap: 1rem; flex-wrap: wrap; padding-bottom: 1rem; }
    .radio-card { flex: 0 0 auto; width: calc(50% - 0.5rem); position: relative; cursor: pointer; }
    @media(max-width: 768px) { .radio-card { width: 100%; } }
    .radio-card input[type="radio"] { display: none; }
    .radio-card .card-content { background: rgba(0,0,0,0.5); border: 2px solid rgba(255,255,255,0.1); border-radius: 8px; overflow: hidden; transition: all 0.3s; opacity: 0.6; }
    .radio-card:hover .card-content { opacity: 0.9; border-color: rgba(0, 217, 255, 0.4); }
    .radio-card input[type="radio"]:checked + .card-content { border-color: var(--accent-cyan); box-shadow: 0 0 15px rgba(0, 217, 255, 0.3); opacity: 1; transform: translateY(-3px); }
    .radio-card .image-wrapper { width: 100%; padding-bottom: 56.25%; background: #000; position: relative; overflow: hidden; }
    .radio-card img { position: absolute; top:0; left:0; width: 100%; height: 100%; object-fit: cover; pointer-events: none; }
    .radio-card .text-wrapper { padding: 0.5rem; text-align: center; font-size: 0.75rem; font-weight: 700; color: #fff; line-height: 1.3; }

    /* Dashboard Metrik Cards */
    .dashboard-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
    .stat-card { background: rgba(10, 16, 22, 0.5); border: 1px solid var(--panel-border); border-radius: 1rem; padding: 1.5rem; display: flex; flex-direction: column; transition: transform 0.3s, box-shadow 0.3s, border-color 0.3s; }
    .stat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5); border-color: rgba(255, 255, 255, 0.1); }
    .stat-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem; color: var(--text-muted); }
    .stat-value { font-size: 2rem; font-weight: 900; color: #fff; margin-bottom: 0.5rem; }

    /* E-Commerce Catalog untuk Alat */
    .catalog-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; max-height: 350px; overflow-y: auto; padding-right: 10px; margin-bottom: 1rem; }
    @media(max-width: 768px) { .catalog-grid { grid-template-columns: repeat(1, 1fr); } }
    .catalog-item { background: rgba(0,0,0,0.5); border: 2px solid rgba(255,255,255,0.05); border-radius: 8px; overflow: hidden; display: flex; flex-direction: column; transition: 0.3s; }
    .catalog-item.selected { border-color: var(--accent-cyan); box-shadow: 0 0 15px rgba(0,217,255,0.15); }
    .catalog-item .image-wrapper { width: 100%; padding-bottom: 56.25%; background: #000; position: relative; }
    .catalog-item img { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; }
    .catalog-item .stock-badge { position: absolute; top: 0.5rem; right: 0.5rem; background: rgba(0,0,0,0.8); color: var(--accent-cyan); font-size: 0.65rem; font-weight: 900; padding: 0.2rem 0.5rem; border-radius: 4px; backdrop-filter: blur(2px); border: 1px solid var(--accent-cyan); }
    .catalog-info { padding: 1rem; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between; }
    .catalog-title { font-size: 0.85rem; font-weight: 800; color: #fff; margin-bottom: 0.25rem; line-height: 1.3; }
    .catalog-code { font-size: 0.6rem; color: var(--text-muted); font-weight: 700; letter-spacing: 1px; }
    .catalog-counter { display: flex; align-items: center; justify-content: space-between; margin-top: 1rem; background: rgba(0,0,0,0.5); border-radius: 6px; padding: 0.2rem; border: 1px solid rgba(255,255,255,0.05); }
    .catalog-counter button { background: rgba(255,255,255,0.05); border: none; color: #fff; cursor: pointer; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-weight: bold; border-radius: 4px; transition: 0.2s; }
    .catalog-counter button:hover { background: var(--accent-cyan); color: #000; }
    .catalog-counter button:disabled { opacity: 0.3; cursor: not-allowed; }
    .catalog-counter .qty-display { font-weight: 900; color: var(--accent-cyan); font-size: 1.1rem; width: 40px; text-align: center; }

    /* Modifikasi Khusus Responsif Mobile */
    @media(max-width: 768px) {
        .mobile-col-header { flex-direction: column; align-items: flex-start !important; gap: 0.5rem; }
        .mobile-col-header span:last-child { align-self: flex-start; }
        .tips-container { font-size: 0.65rem !important; padding: 0.5rem !important; }
        .tips-container svg { width: 16px; height: 16px; }
        .waktu-grid { grid-template-columns: 1fr !important; }
        .agenda-container { flex-direction: column; text-align: left; align-items: flex-start !important; }
        .agenda-btn { width: 100% !important; text-align: center; justify-content: center; display: flex; box-sizing: border-box; }
        .welcome-banner { padding: 1.5rem !important; }
        .welcome-banner-btn { position: static !important; width: 100% !important; justify-content: center; margin-top: 1.5rem; transform: none !important; box-sizing: border-box; }
    }
</style>

<div class="welcome-banner" style="margin-bottom: 2rem; position: relative;">
    <div class="status-badge">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>
        {{ $lang === 'id' ? 'Sistem Pemantauan Dosen' : 'Lecturer Monitoring System' }}
    </div>
    <h1 class="welcome-title">{{ $lang === 'id' ? 'Dashboard Pemonitoran Utama' : 'Main Monitoring Dashboard' }}</h1>
    <p class="welcome-subtitle">
        {{ $lang === 'id' ? 'Selamat menjalankan tugas observasi, ' : 'Welcome to your observation tasks, ' }} <strong>{{ $user->name }}</strong>.
        <br>
        {{ $lang === 'id' ? 'Sistem ini menyaring informasi infrastruktur laboratorium dan melacak penggunaan aset universitas secara terpusat untuk kebutuhan observasi akademis Anda.' : 'This system filters lab infrastructure info and tracks university assets centrally for your academic observation needs.' }}
    </p>

    <button onclick="openModal('bookingModal')" class="welcome-banner-btn hover:shadow-[0_0_20px_rgba(0,217,255,0.6)] hover:scale-105" style="position: absolute; right: 2.5rem; top: 50%; transform: translateY(-50%); background: var(--accent-cyan); color: #000; border: none; padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 900; letter-spacing: 1px; cursor: pointer; transition: 0.3s; display: flex; align-items: center; gap: 0.5rem;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
        {{ $lang === 'id' ? 'BOOKING DARURAT' : 'QUICK BOOKING' }}
    </button>
</div>

<!-- Grid Metrik Utama Dosen -->
<div class="dashboard-grid">
    <div class="stat-card hover:shadow-[0_0_20px_rgba(234,179,8,0.4)]" onclick="window.location.href='{{ route('dosen.dashboard', ['tab' => 'monitoring']) }}'" style="border-top-color: #eab308; cursor: pointer;" title="{{ $lang === 'id' ? 'Buka Monitoring Penggunaan' : 'Open Usage Monitoring' }}">
        <div class="stat-header">
            <span style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">{{ $lang === 'id' ? 'Antrean Menunggu' : 'Pending Queues' }}</span>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#eab308" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
        </div>
        <div class="stat-value" style="color: #eab308;">{{ $pendingPeminjaman ?? 0 }}</div>
    </div>
    <div class="stat-card hover:shadow-[0_0_20px_rgba(168,85,247,0.4)]" onclick="window.location.href='{{ route('dosen.dashboard', ['tab' => 'monitoring']) }}'" style="border-top-color: #a855f7; cursor: pointer;" title="{{ $lang === 'id' ? 'Buka Monitoring Penggunaan' : 'Open Usage Monitoring' }}">
        <div class="stat-header">
            <span style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">{{ $lang === 'id' ? 'Sesi Aktif Dipantau' : 'Monitored Active Sessions' }}</span>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#a855f7" stroke-width="2"><path d="m21.64 3.64-1.28-1.28a1.21 1.21 0 0 0-1.72 0L2.36 18.64a1.21 1.21 0 0 0 0 1.72l1.28 1.28a1.2 1.2 0 0 0 1.72 0L21.64 5.36a1.2 1.2 0 0 0 0-1.72Z"></path><path d="m14 7 3 3"></path><path d="M5 6v4"></path><path d="M19 14v4"></path><path d="M10 2v2"></path><path d="M7 8H3"></path><path d="M21 16h-4"></path><path d="M11 3H9"></path></svg>
        </div>
        <div class="stat-value" style="color: #a855f7;">{{ $monitoringAktif ?? 0 }}</div>
    </div>
    <div class="stat-card hover:shadow-[0_0_20px_rgba(34,197,94,0.4)]" onclick="window.location.href='{{ route('dosen.dashboard', ['tab' => 'riwayat']) }}'" style="border-top-color: #22c55e; cursor: pointer;" title="{{ $lang === 'id' ? 'Buka Riwayat Aktivitas' : 'Open Audit Logs' }}">
        <div class="stat-header">
            <span style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">{{ $lang === 'id' ? 'Total Rekam Sistem' : 'Total System Records' }}</span>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
        </div>
        <div class="stat-value" style="color: #22c55e;">{{ $totalLaporan ?? 0 }}</div>
    </div>
    <div class="stat-card hover:shadow-[0_0_20px_rgba(239,68,68,0.4)]" onclick="window.location.href='{{ route('notifications.index') }}'" style="border-top-color: #ef4444; cursor: pointer;" title="{{ $lang === 'id' ? 'Buka Peringatan Dosen' : 'Open Lecturer Alerts' }}">
        <div class="stat-header">
            <span style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">{{ $lang === 'id' ? 'Peringatan Dosen' : 'Lecturer Alerts' }}</span>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
        </div>
        <div class="stat-value" style="color: #ef4444;">{{ $peringatanSistem ?? 0 }}</div>
    </div>
</div>

<!-- Bagian Aktivitas Terkini (Global Monitoring) -->
<div style="background: rgba(10, 16, 22, 0.5); border: 1px solid var(--panel-border); border-radius: 1rem; padding: 1.5rem; margin-bottom: 2rem;">
    <h3 style="font-size: 1.2rem; font-weight: 800; margin-top: 0; margin-bottom: 1.5rem; color: #fff; display: flex; align-items: center; gap: 0.5rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 1rem;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent-cyan)" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>
        {{ $lang === 'id' ? 'Aktivitas Pemantauan Terkini' : 'Recent Monitoring Activities' }}
    </h3>
    
    @if(isset($recentPeminjaman) && $recentPeminjaman->count() > 0)
        <div style="overflow-x: auto;">
            <table class="responsive-table" style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="border-bottom: 2px solid rgba(0,217,255,0.2); color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase;">
                        <th style="padding: 1rem;">{{ $lang === 'id' ? 'ID TIKET' : 'TICKET ID' }}</th>
                        <th style="padding: 1rem;">{{ $lang === 'id' ? 'PEMOHON' : 'APPLICANT' }}</th>
                        <th style="padding: 1rem;">{{ $lang === 'id' ? 'LOKASI TARGET' : 'TARGET LOCATION' }}</th>
                        <th style="padding: 1rem;">{{ $lang === 'id' ? 'ALOKASI WAKTU' : 'TIME ALLOCATION' }}</th>
                        <th style="padding: 1rem;">{{ $lang === 'id' ? 'STATUS' : 'STATUS' }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentPeminjaman as $req)
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); transition: background 0.3s;" onmouseover="this.style.background='rgba(0,217,255,0.05)'" onmouseout="this.style.background='transparent'">
                        <td data-label="{{ $lang === 'id' ? 'ID TIKET' : 'TICKET ID' }}" style="padding: 1rem; font-family: monospace; color: var(--accent-cyan); font-weight: bold;">#REQ-{{ str_pad($req->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td data-label="{{ $lang === 'id' ? 'PEMOHON' : 'APPLICANT' }}" style="padding: 1rem; font-weight: 600; color: #fff;">{{ $req->user->name ?? 'Anonim' }}</td>
                        <td data-label="{{ $lang === 'id' ? 'LOKASI TARGET' : 'TARGET LOCATION' }}" style="padding: 1rem; color: #cbd5e1;">{{ $req->laboratorium->nama_lab ?? 'Universal' }}</td>
                        <td data-label="{{ $lang === 'id' ? 'ALOKASI WAKTU' : 'TIME ALLOCATION' }}" style="padding: 1rem;">
                            <div style="font-size: 0.85rem;">{{ \Carbon\Carbon::parse($req->tanggal_mulai)->format('d M y H:i') }} <span style="color: var(--accent-cyan);">→</span> {{ \Carbon\Carbon::parse($req->tanggal_selesai)->format('d M y H:i') }}</div>
                        </td>
                        <td data-label="{{ $lang === 'id' ? 'STATUS' : 'STATUS' }}" style="padding: 1rem;">
                            @if($req->status === 'menunggu')
                                <span style="background: rgba(234, 179, 8, 0.2); color: #eab308; padding: 0.3rem 0.6rem; border-radius: 4px; font-size: 0.75rem; font-weight: bold;">{{ strtoupper($req->status) }}</span>
                            @elseif($req->status === 'disetujui' || $req->status === 'dipinjam')
                                <span style="background: rgba(168, 85, 247, 0.2); color: #a855f7; padding: 0.3rem 0.6rem; border-radius: 4px; font-size: 0.75rem; font-weight: bold;">{{ strtoupper($req->status) }}</span>
                            @elseif($req->status === 'ditolak')
                                <span style="background: rgba(239, 68, 68, 0.2); color: #ef4444; padding: 0.3rem 0.6rem; border-radius: 4px; font-size: 0.75rem; font-weight: bold;">{{ strtoupper($req->status) }}</span>
                            @else
                                <span style="background: rgba(34, 197, 94, 0.2); color: #22c55e; padding: 0.3rem 0.6rem; border-radius: 4px; font-size: 0.75rem; font-weight: bold;">{{ strtoupper($req->status) }}</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div style="text-align: center; padding: 3rem 1rem;">
            <p style="color: var(--text-muted); font-size: 0.95rem;">{{ $lang === 'id' ? 'Pemantauan bersih. Tidak mendeteksi riwayat transaksi terkini.' : 'Monitoring is clear. No recent transactions detected.' }}</p>
        </div>
    @endif
</div>

<!-- Modal Quick Booking (Booking Darurat Dosen) -->
<div id="bookingModal" class="custom-modal">
    <div class="modal-content" style="max-width: 800px; padding: 2.5rem;">
        <span class="modal-close" onclick="closeModal('bookingModal')">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </span>
        
        <h2 style="margin-top: 0; color: #fff; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 1rem; margin-bottom: 2rem; font-weight: 900; text-transform: uppercase;">
            {{ $lang === 'id' ? 'Akses Peminjaman Darurat' : 'Emergency Loan Access' }}
        </h2>

        <form action="{{ route('student.pengajuan.store') }}" method="POST">
            @csrf
            
            <div class="modal-form-group">
                <label>{{ $lang === 'id' ? 'Tujuan Kepentingan Khusus' : 'Special Interest Purpose' }}</label>
                <input type="text" name="tujuan_peminjaman" class="modal-input" value="[KEBUTUHAN DARURAT/MENDADAK DOSEN]" required>
            </div>

            <div class="modal-form-group" style="margin-bottom: 1.5rem;">
                <label>{{ $lang === 'id' ? 'Tipe Peminjaman' : 'Loan Type' }}</label>
                <select name="jenis_peminjaman" id="jenis_peminjaman_dosen" class="modal-select" required onchange="toggleAlatContainerDosen()">
                    <option value="alat">{{ $lang === 'id' ? 'Pinjam Inventaris Alat' : 'Borrow Equipment' }}</option>
                    <option value="ruang">{{ $lang === 'id' ? 'Pinjam Ruangan' : 'Borrow Room' }}</option>
                </select>
            </div>

            <div class="modal-form-group" style="margin-bottom: 1.5rem;">
                <label>{{ $lang === 'id' ? 'Lokasi Laboratorium target' : 'Target Laboratory' }}</label>
                <div class="radio-card-grid">
                    @foreach($labs as $lab)
                        <label class="radio-card">
                            <input type="radio" name="laboratorium_id" value="{{ $lab->id }}" required onchange="filterAlatByLabDosen('{{ $lab->id }}')">
                            <div class="card-content">
                                <div class="image-wrapper">
                                    @if(!empty($lab->fotos) && is_array($lab->fotos) && count($lab->fotos) > 0)
                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($lab->fotos[0]) }}" alt="{{ $lab->nama_lab }}">
                                    @else
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" style="opacity: 0.3; position:absolute; top:50%; left:50%; transform:translate(-50%, -50%);" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                    @endif
                                </div>
                                <div class="text-wrapper">
                                    {{ $lab->nama_lab }}
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Katalog Alat Eksekutif -->
            <div id="alat_container_dosen" style="display: block; margin-bottom: 1.5rem;">
                <label class="mobile-col-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                    <span>{{ $lang === 'id' ? 'KATALOG ASET EKSKLUSIF' : 'EXCLUSIVE ASSET CATALOG' }}</span>
                    <span style="background: rgba(0,217,255,0.1); border: 1px solid var(--primary-cyan); color: var(--primary-cyan); padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.6rem;">
                        {{ $lang === 'id' ? 'Tersedia: ' : 'Available: ' }} {{ $semuaAlat->count() }} {{ $lang === 'id' ? 'Spesifikasi' : 'Specs' }}
                    </span>
                </label>
                
                <div class="tips-container" style="background: rgba(0,217,255,0.05); color: #00d9ff; border: 1px solid rgba(0,217,255,0.2); padding: 0.75rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.8rem; font-weight: 600; display: flex; align-items: flex-start; gap: 0.75rem;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink: 0;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 16 12 12 12 8"></polyline><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                    <div>
                        {{ $lang === 'id' ? 'TIPS: Silakan pilih lokasi laboratorium di atas terlebih dahulu. Sistem akan secara cerdas menyaring dan hanya menampilkan deretan perangkat keras yang diotorisasi khusus dari instalasi lab yang Anda pilih untuk mencegah pertukaran silang aset.' : 'TIPS: Please select a laboratory location above first. The system will intelligently filter and display only authorized hardware natively belonging to your selected lab facility to prevent cross-asset mapping.' }}
                    </div>
                </div>

                <div class="catalog-grid" id="alat_list_dosen">
                    @foreach($semuaAlat as $alat)
                        <div class="catalog-item alat-dosen-card" id="catalog-item-{{ $alat->id }}" data-lab-id="{{ $alat->laboratorium_id }}" style="display: none;">
                            <input type="hidden" name="alat_id[]" value="{{ $alat->id }}" id="input-alat-{{ $alat->id }}" disabled>
                            <input type="hidden" name="jumlah[]" value="0" id="input-qty-{{ $alat->id }}" disabled>
                            
                            <div class="image-wrapper">
                                <div class="stock-badge">{{ $lang === 'id' ? 'Sisa:' : 'Left:' }} <span id="avail-{{ $alat->id }}">{{ $alat->available_stok }}</span></div>
                                @if(!empty($alat->fotos) && is_array($alat->fotos) && count($alat->fotos) > 0)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($alat->fotos[0]) }}" alt="{{ $alat->nama_alat }}">
                                @else
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" style="opacity: 0.3; position:absolute; top:50%; left:50%; transform:translate(-50%, -50%);" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                                @endif
                            </div>
                            
                            <div class="catalog-info">
                                <div>
                                    <div class="catalog-code">{{ $alat->kode_alat }}</div>
                                    <div class="catalog-title">{{ $alat->nama_alat }}</div>
                                    <div style="font-size: 0.65rem; color: var(--text-muted); margin-top: 0.5rem; line-height: 1.4;">
                                        <span style="display: block;"><strong>{{ $lang === 'id' ? 'Asal Lab:' : 'Origin Lab:' }}</strong> {{ $alat->laboratorium ? $alat->laboratorium->nama_lab : 'Unknown' }}</span>
                                        <span style="display: block;"><strong>{{ $lang === 'id' ? 'Master Lab:' : 'Head Master:' }}</strong> {{ $alat->laboratorium && $alat->laboratorium->master ? $alat->laboratorium->master->name : 'Unassigned' }}</span>
                                        <span style="display: block;"><strong>{{ $lang === 'id' ? 'Asisten Jaga:' : 'Aslab Guard:' }}</strong> 
                                            @if($alat->laboratorium && count($alat->laboratorium->aslabs) > 0)
                                                {{ collect($alat->laboratorium->aslabs)->pluck('name')->join(', ') }}
                                            @else
                                                {{ $lang === 'id' ? 'Belum Ada Penugasan' : 'No Assignment' }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="catalog-counter">
                                    <button type="button" onclick="ubahQty('{{ $alat->id }}', -1)">-</button>
                                    <div class="qty-display" id="display-qty-{{ $alat->id }}">0</div>
                                    <button type="button" onclick="ubahQty('{{ $alat->id }}', 1)">+</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Trigger Button Agenda Jadwal -->
            <div class="agenda-container" style="margin-bottom: 2rem; background: rgba(234, 179, 8, 0.05); border: 1px solid rgba(234, 179, 8, 0.2); padding: 1.25rem; border-radius: 12px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <h4 style="color: #eab308; margin-top: 0; margin-bottom: 0.5rem; font-size: 0.85rem; display: flex; align-items: center; gap: 0.5rem;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        {{ $lang === 'id' ? 'DATABASE AGENDA SIBUK' : 'BUSY AGENDA DATABASE' }}
                    </h4>
                    <div style="font-size: 0.7rem; color: var(--text-muted);">{{ $lang === 'id' ? 'Hindari waktu merah agar tidak bentrok dengan reservasi yang tertera.' : 'Avoid red times to prevent clashes with existing reservations.' }}</div>
                </div>
                <a href="{{ route('dosen.dashboard', ['tab' => 'schedule']) }}" target="_blank" class="agenda-btn" style="text-decoration: none; background: rgba(234, 179, 8, 0.1); border: 1px solid #eab308; color: #eab308; padding: 0.5rem 1rem; border-radius: 6px; font-weight: bold; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.background='rgba(234, 179, 8, 0.2)'" onmouseout="this.style.background='rgba(234, 179, 8, 0.1)'">
                    {{ $lang === 'id' ? 'Lihat Jadwal Lab' : 'View Lab Schedule' }}
                </a>
            </div>

            <div class="modal-form-group waktu-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div>
                    <label>{{ $lang === 'id' ? 'Waktu Mulai Eksekusi' : 'Execution Start Time' }}</label>
                    <input type="text" name="tanggal_mulai" class="modal-input flatpickr-input" placeholder="Pilih tanggal & waktu" required>
                </div>
                <div>
                    <label>{{ $lang === 'id' ? 'Estimasi Selesai' : 'Estimated Return' }}</label>
                    <input type="text" name="tanggal_selesai" class="modal-input flatpickr-input" placeholder="Pilih tanggal & waktu" required>
                </div>
            </div>

            <button type="submit" style="width: 100%; padding: 1rem; background: var(--accent-cyan); color: #000; border: none; border-radius: 8px; font-weight: 900; letter-spacing: 1px; cursor: pointer; margin-top: 1rem;">
                {{ $lang === 'id' ? 'KIRIM PENGAJUAN DARURAT' : 'SEND EMERGENCY REQUEST' }}
            </button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        flatpickr(".flatpickr-input", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true,
            minDate: "today",
            disableMobile: "true",
            minTime: "07:00",
            maxTime: "18:00",
            disable: [
                function(date) {
                    return (date.getDay() === 0 || date.getDay() === 6);
                }
            ],
            locale: {
                firstDayOfWeek: 1
            }
        });
    });

    function toggleAlatContainerDosen() {
        const jenis = document.getElementById('jenis_peminjaman_dosen').value;
        const container = document.getElementById('alat_container_dosen');
        // Reset qty
        document.querySelectorAll('input[name="jumlah[]"]').forEach(inp => inp.value = 0);
        document.querySelectorAll('.qty-display').forEach(d => d.innerText = '0');
        document.querySelectorAll('input[name="alat_id[]"]').forEach(i => i.disabled = true);
        document.querySelectorAll('.catalog-item').forEach(c => c.classList.remove('selected'));

        if(jenis === 'alat') {
            container.style.display = 'block';
            const selRadio = document.querySelector('input[name="laboratorium_id"]:checked');
            if(selRadio) filterAlatByLabDosen(selRadio.value);
        } else {
            container.style.display = 'none';
        }
    }

    function filterAlatByLabDosen(labId) {
        const jenis = document.getElementById('jenis_peminjaman_dosen').value;
        if(jenis !== 'alat') return; // Do not show tools if room is requested.

        const cards = document.querySelectorAll('.alat-dosen-card');
        cards.forEach(card => {
            if(card.getAttribute('data-lab-id') === labId) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
                card.classList.remove('selected');
                card.querySelector('input[name="alat_id[]"]').disabled = true;
                const qtyInput = card.querySelector('input[name="jumlah[]"]');
                qtyInput.value = 0;
                qtyInput.disabled = true;
                card.querySelector('.qty-display').innerText = '0';
            }
        });
    }

    function ubahQty(alatId, direction) {
        const qtyInput = document.getElementById('input-qty-' + alatId);
        const alatInput = document.getElementById('input-alat-' + alatId);
        const display = document.getElementById('display-qty-' + alatId);
        const card = document.getElementById('catalog-item-' + alatId);
        const maxStok = parseInt(document.getElementById('avail-' + alatId).innerText);
        
        let current = parseInt(qtyInput.value) || 0;
        let next = current + direction;
        
        if(next < 0) next = 0;
        if(next > maxStok) next = maxStok;
        
        qtyInput.value = next;
        display.innerText = next;
        
        if(next > 0) {
            alatInput.disabled = false;
            qtyInput.disabled = false;
            card.classList.add('selected');
        } else {
            alatInput.disabled = true;
            qtyInput.disabled = true;
            card.classList.remove('selected');
        }
    }
</script>
