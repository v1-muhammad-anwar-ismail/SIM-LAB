<div class="welcome-banner">
    <h1 class="welcome-title">{{ $lang === 'id' ? 'Pusat Komando Asisten' : 'Assistant Command Center' }}</h1>
    <p class="welcome-subtitle">
        {{ $lang === 'id' ? 'Pantau dan kelola seluruh sirkulasi inventaris ' . ($laboratorium ? $laboratorium->nama : 'Laboratorium') . ' dari sini.' : 'Monitor and manage all inventory circulation for ' . ($laboratorium ? $laboratorium->nama : 'Laboratory') . ' from here.' }}
    </p>
</div>

@if(!$laboratorium)
<div style="padding: 2rem; background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 12px; margin-bottom: 2rem;">
    <h3 style="color: #ef4444; margin: 0 0 0.5rem 0;">{{ $lang === 'id' ? 'Peringatan Sistem' : 'System Warning' }}</h3>
    <p style="color: #f87171; margin: 0;">{{ $lang === 'id' ? 'Akun Anda belum terikat ke laboratorium mana pun. Harap hubungi Master Lab untuk menugaskan Anda.' : 'Your account is not bound to any laboratory. Please contact the Lab Master to assign you.' }}</p>
</div>
@endif

<div class="dashboard-grid">
    <div class="stat-card" onclick="window.location.href='{{ route('asisten.dashboard', ['tab' => 'approvals']) }}'" style="cursor: pointer;" title="{{ $lang === 'id' ? 'Buka Persetujuan' : 'Open Approvals' }}">
        <div class="stat-header">
            <span style="font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600;">{{ $lang === 'id' ? 'Menunggu ACC' : 'Pending Approvals' }}</span>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #eab308;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
        </div>
        <div class="stat-value" style="color: #eab308;">{{ $pendingPeminjaman }}</div>
        <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $lang === 'id' ? 'Pengajuan perlu ditinjau' : 'Requests need review' }}</div>
    </div>
    
    <div class="stat-card" onclick="window.location.href='{{ route('asisten.dashboard', ['tab' => 'inventory']) }}'" style="cursor: pointer;" title="{{ $lang === 'id' ? 'Buka Gudang Inventaris' : 'Open Inventory' }}">
        <div class="stat-header">
            <span style="font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600;">{{ $lang === 'id' ? 'Total Eksemplar Aset' : 'Total Asset Instances' }}</span>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #3b82f6;"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
        </div>
        <div class="stat-value" style="color: #3b82f6;">{{ $totAlat }}</div>
        <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $lang === 'id' ? 'Dikelola oleh lab ini' : 'Managed by this lab' }}</div>
    </div>

    <div class="stat-card" onclick="window.location.href='{{ route('asisten.dashboard', ['tab' => 'returns']) }}'" style="cursor: pointer;" title="{{ $lang === 'id' ? 'Buka Pengembalian' : 'Open Returns' }}">
        <div class="stat-header">
            <span style="font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600;">{{ $lang === 'id' ? 'Sedang Dipinjam' : 'Currently Borrowed' }}</span>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #22c55e;"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
        </div>
        <div class="stat-value" style="color: #22c55e;">{{ $monitoringAktif }}</div>
        <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $lang === 'id' ? 'Alat berada di luar gudang' : 'Assets currently outside' }}</div>
    </div>

    <div class="stat-card" onclick="window.location.href='{{ route('asisten.dashboard', ['tab' => 'maintenance']) }}'" style="cursor: pointer;" title="{{ $lang === 'id' ? 'Buka Logistik Perbaikan' : 'Open Maintenance' }}">
        <div class="stat-header">
            <span style="font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600;">{{ $lang === 'id' ? 'Aset Rusak' : 'Damaged Assets' }}</span>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #ef4444;"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
        </div>
        <div class="stat-value" style="color: #ef4444;">{{ $totRusak }}</div>
        <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $lang === 'id' ? 'Perlu tindakan perbaikan' : 'Requires repair action' }}</div>
    </div>
</div>

<div class="dashboard-grid" style="grid-template-columns: 1fr;">
    <div class="stat-card">
        <h3 style="color: #fff; margin-top: 0; margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between;">
            <span>{{ $lang === 'id' ? 'Menunggu Peninjauan Terbaru' : 'Recent Pending Reviews' }}</span>
            <a href="{{ route('asisten.dashboard', ['tab' => 'approvals']) }}" style="font-size: 0.85rem; color: #22c55e; text-decoration: none; border: 1px solid rgba(34, 197, 94, 0.3); padding: 0.4rem 0.8rem; border-radius: 6px;">{{ $lang === 'id' ? 'Ke Papan Antrean' : 'Go to Approvals' }}</a>
        </h3>
        
        @if($recentPeminjaman->count() > 0)
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; min-width: 600px;">
                    <thead>
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase;">
                            <th style="padding: 1rem; text-align: left;">{{ $lang === 'id' ? 'Mahasiswa' : 'Student' }}</th>
                            <th style="padding: 1rem; text-align: left;">{{ $lang === 'id' ? 'Jadwal' : 'Schedule' }}</th>
                            <th style="padding: 1rem; text-align: left;">{{ $lang === 'id' ? 'Keperluan' : 'Purpose' }}</th>
                            <th style="padding: 1rem; text-align: right;">{{ $lang === 'id' ? 'Aksi Cepat' : 'Quick Actions' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentPeminjaman as $pm)
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                            <td style="padding: 1rem; color: #fff;">
                                <div style="font-weight: 600;">{{ $pm->user->name ?? 'Terhapus' }}</div>
                                <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $pm->user->email ?? '' }}</div>
                            </td>
                            <td style="padding: 1rem; color: #cbd5e1; font-size: 0.9rem;">
                                {{ \Carbon\Carbon::parse($pm->tanggal_mulai)->format('d M y H:i') }}<br>
                                <span style="color: var(--text-muted);">s/d</span> {{ \Carbon\Carbon::parse($pm->tanggal_selesai)->format('d M y H:i') }}
                            </td>
                            <td style="padding: 1rem; color: #cbd5e1; font-size: 0.9rem; max-width: 250px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
                                {{ $pm->keperluan }}
                            </td>
                            <td style="padding: 1rem; text-align: right;">
                                <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                    <form action="{{ route('asisten.approvals.process', $pm->id) }}" method="POST" style="margin:0;">
                                        @csrf
                                        <input type="hidden" name="action" value="approve">
                                        <input type="hidden" name="catatan" value="ACC cepat via Pusat Komando">
                                        <button type="submit" style="background: rgba(34, 197, 94, 0.1); color: #22c55e; border: 1px solid #22c55e; padding: 0.4rem 0.8rem; border-radius: 6px; font-weight: bold; font-size: 0.75rem; cursor: pointer;" title="{{ $lang === 'id' ? 'Setujui Langsung' : 'Approve Immediately' }}">{{ $lang === 'id' ? 'ACC' : 'APPROVE' }}</button>
                                    </form>
                                    <form action="{{ route('asisten.approvals.process', $pm->id) }}" method="POST" style="margin:0;">
                                        @csrf
                                        <input type="hidden" name="action" value="reject">
                                        <input type="hidden" name="catatan" value="Ditolak cepat via Pusat Komando">
                                        <button type="submit" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid #ef4444; padding: 0.4rem 0.8rem; border-radius: 6px; font-weight: bold; font-size: 0.75rem; cursor: pointer;" title="{{ $lang === 'id' ? 'Tolak Langsung' : 'Reject Immediately' }}">{{ $lang === 'id' ? 'TOLAK' : 'REJECT' }}</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align: center; padding: 3rem 1rem; color: var(--text-muted);">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem; opacity: 0.5;"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="9" y1="3" x2="9" y2="21"></line></svg>
                <p>{{ $lang === 'id' ? 'Sempurna! Tidak ada antrean peminjaman baru.' : 'Perfect! No new loan queues.' }}</p>
            </div>
        @endif
    </div>
</div>
