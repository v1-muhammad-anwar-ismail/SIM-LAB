<div class="welcome-banner">
    <div class="status-badge">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
        {{ $lang === 'id' ? 'Sistem Aktif & Terhubung' : 'System Active & Connected' }}
    </div>
    <h1 class="welcome-title">{{ $lang === 'id' ? 'Selamat Datang' : 'Welcome Back' }}, {{ explode(' ', $user->name)[0] }}</h1>
    <p class="welcome-subtitle">
        {{ $lang === 'id' ? 'Ini adalah antarmuka komando pusat eksekutif Anda. Pantau metrik, setujui peminjaman, dan kelola integritas seluruh stasiun laboratorium dari satu titik pantau.' : 'This is your central executive command interface. Monitor metrics, approve loans, and manage the integrity of all laboratory stations from a single vantage point.' }}
    </p>
</div>

<!-- Grid Metrik Utama -->
<div class="dashboard-grid">
    <div class="stat-card" onclick="window.location.href='{{ route('master.dashboard', ['tab' => 'approvals']) }}'" style="border-top-color: #00d9ff; cursor: pointer;" title="{{ $lang === 'id' ? 'Buka Persetujuan' : 'Open Approvals' }}">
        <div class="stat-header">
            <span style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">{{ $lang === 'id' ? 'Persetujuan Pending' : 'Pending Approvals' }}</span>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#00d9ff" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
        </div>
        <div class="stat-value" style="color: #00d9ff;">{{ $pendingPeminjaman ?? 0 }}</div>
    </div>
    <div class="stat-card" onclick="window.location.href='{{ route('master.dashboard', ['tab' => 'riwayat']) }}'" style="border-top-color: #a855f7; cursor: pointer;" title="{{ $lang === 'id' ? 'Buka Riwayat Peminjaman' : 'Open Borrowing History' }}">
        <div class="stat-header">
            <span style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">{{ $lang === 'id' ? 'Peminjaman Aktif' : 'Active Borrowings' }}</span>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#a855f7" stroke-width="2"><path d="m21.64 3.64-1.28-1.28a1.21 1.21 0 0 0-1.72 0L2.36 18.64a1.21 1.21 0 0 0 0 1.72l1.28 1.28a1.2 1.2 0 0 0 1.72 0L21.64 5.36a1.2 1.2 0 0 0 0-1.72Z"></path><path d="m14 7 3 3"></path><path d="M5 6v4"></path><path d="M19 14v4"></path><path d="M10 2v2"></path><path d="M7 8H3"></path><path d="M21 16h-4"></path><path d="M11 3H9"></path></svg>
        </div>
        <div class="stat-value" style="color: #a855f7;">{{ $monitoringAktif ?? 0 }}</div>
    </div>
    <div class="stat-card" onclick="window.location.href='{{ route('master.dashboard', ['tab' => 'laboratories']) }}'" style="border-top-color: #22c55e; cursor: pointer;" title="{{ $lang === 'id' ? 'Buka Data Laboratorium' : 'Open Laboratories Data' }}">
        <div class="stat-header">
            <span style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">{{ $lang === 'id' ? 'Total Rekam Sistem' : 'Total System Records' }}</span>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
        </div>
        <div class="stat-value" style="color: #22c55e;">{{ $totalLaporan ?? 0 }}</div>
    </div>
    <div class="stat-card" onclick="window.location.href='{{ route('notifications.index') }}'" style="border-top-color: #ef4444; cursor: pointer;" title="{{ $lang === 'id' ? 'Buka Pusat Notifikasi' : 'Open Notification Center' }}">
        <div class="stat-header">
            <span style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">{{ $lang === 'id' ? 'Peringatan Master' : 'Master Alerts' }}</span>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
        </div>
        <div class="stat-value" style="color: #ef4444;">{{ $peringatanSistem ?? 0 }}</div>
    </div>
</div>

<!-- Bagian Terkini -->
<div style="background: rgba(10, 16, 22, 0.5); border: 1px solid var(--panel-border); border-radius: 1rem; padding: 1.5rem; margin-bottom: 2rem;">
    <h3 style="font-size: 1.2rem; font-weight: 800; margin-top: 0; margin-bottom: 1.5rem; color: #fff; display: flex; align-items: center; gap: 0.5rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 1rem;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent-cyan)" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>
        {{ $lang === 'id' ? 'Gelombang Pengajuan Antrean' : 'Queue Submission Wave' }}
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
                        <th style="padding: 1rem;">{{ $lang === 'id' ? 'AKSI CEPAT' : 'QUICK ACTIONS' }}</th>
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
                        <td data-label="{{ $lang === 'id' ? 'AKSI CEPAT' : 'QUICK ACTIONS' }}" style="padding: 1rem;">
                            <div style="display: flex; gap: 0.5rem;">
                                <form action="{{ route('master.approvals.process', $req->id) }}" method="POST" style="margin:0;">
                                    @csrf
                                    <input type="hidden" name="action" value="approve">
                                    <input type="hidden" name="catatan" value="ACC Level Tinggi via Pusat Komando Master">
                                    <button type="submit" style="background: rgba(34, 197, 94, 0.1); color: #22c55e; border: 1px solid #22c55e; padding: 0.4rem 0.8rem; border-radius: 6px; font-weight: bold; font-size: 0.75rem; cursor: pointer;" title="{{ $lang === 'id' ? 'Setujui Langsung' : 'Approve Immediately' }}">{{ $lang === 'id' ? 'ACC' : 'APPROVE' }}</button>
                                </form>
                                <form action="{{ route('master.approvals.process', $req->id) }}" method="POST" style="margin:0;">
                                    @csrf
                                    <input type="hidden" name="action" value="reject">
                                    <input type="hidden" name="catatan" value="Ditolak Level Tinggi via Pusat Komando Master">
                                    <button type="submit" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid #ef4444; padding: 0.4rem 0.8rem; border-radius: 6px; font-weight: bold; font-size: 0.75rem; cursor: pointer;" title="{{ $lang === 'id' ? 'Tolak Langsung' : 'Reject Immediately' }}">{{ $lang === 'id' ? 'TOLAK' : 'REJECT' }}</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="margin-top: 1rem; text-align: right;">
            <a href="{{ route('master.dashboard', ['tab' => 'approvals']) }}" style="color: var(--accent-cyan); text-decoration: none; font-weight: bold; font-size: 0.9rem; transition: 0.3s;" onmouseover="this.style.textShadow='0 0 10px rgba(0,217,255,0.5)'" onmouseout="this.style.textShadow='none'">{{ $lang === 'id' ? 'Buka Papan Persetujuan' : 'Open Approvals Board' }}</a>
        </div>
    @else
        <div style="text-align: center; padding: 3rem 1rem;">
            <p style="color: var(--text-muted); font-size: 0.95rem;">{{ $lang === 'id' ? 'Pusat pantau bersih. Tidak mendeteksi anomali atau antrean permohonan terkini.' : 'Monitoring center is clear. No anomalies or recent request queues detected.' }}</p>
        </div>
    @endif
</div>
