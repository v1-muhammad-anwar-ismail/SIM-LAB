    <div class="welcome-banner" style="margin-bottom: 2rem;">
        <div class="status-badge" style="background: rgba(234, 179, 8, 0.1); color: #eab308; border-color: rgba(234, 179, 8, 0.3);">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="12" y1="18" x2="12" y2="12"></line><line x1="9" y1="15" x2="15" y2="15"></line></svg>
            {{ $lang === 'id' ? 'Jejak Audit & Akuntabilitas Master' : 'Master Audit Trail & Accountability' }}
        </div>
        <h1 class="welcome-title">{{ $lang === 'id' ? 'Riwayat Aktivitas Menyeluruh' : 'Comprehensive Audit Logs' }}</h1>
        <p class="welcome-subtitle">
            {{ $lang === 'id' ? 'Seluruh riwayat persetujuan tingkat tinggi, penolakan, maupun pengembalian aset dari seluruh laboratorium di bawah naungan Anda.' : 'All recorded history of high-level approvals, rejections, and asset returns across all laboratories under your authority.' }}
        </p>
    </div>

    <!-- Papan List Riwayat -->
    <div style="background: rgba(10, 16, 22, 0.5); border: 1px solid var(--panel-border); border-radius: 1rem; padding: 1.5rem;">
        <h3 style="font-size: 1.25rem; font-weight: 800; margin-top: 0; margin-bottom: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 1rem;">{{ $lang === 'id' ? 'Transkrip Peminjaman Selesai' : 'Completed Loan Transcripts' }}</h3>

        @if(isset($riwayatList) && $riwayatList->count() > 0)
            <div style="overflow-x: auto;">
                <table class="responsive-table" style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="border-bottom: 2px solid rgba(0,217,255,0.2); color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase;">
                            <th style="padding: 1rem;">{{ $lang === 'id' ? 'PEMOHON & JADWAL' : 'APPLICANT & SCHEDULE' }}</th>
                            <th style="padding: 1rem;">{{ $lang === 'id' ? 'DETAIL ALOKASI' : 'ALLOCATION DETAILS' }}</th>
                            <th style="padding: 1rem;">{{ $lang === 'id' ? 'AKTOR / ADMIN' : 'ACTOR / ADMIN' }}</th>
                            <th style="padding: 1rem;">{{ $lang === 'id' ? 'STATUS AKHIR' : 'FINAL STATUS' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayatList as $app)
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); transition: background 0.3s;" onmouseover="this.style.background='rgba(0,217,255,0.05)'" onmouseout="this.style.background='transparent'">
                            <td data-label="{{ $lang === 'id' ? 'PEMOHON & JADWAL' : 'APPLICANT' }}" style="padding: 1rem;">
                                <div style="font-size: 0.8rem; color: #00d9ff; font-family: monospace; border: 1px solid rgba(0,217,255,0.3); display: inline-block; padding: 0.2rem 0.5rem; border-radius: 4px; margin-bottom: 0.4rem;">#REQ-{{ str_pad($app->id, 5, '0', STR_PAD_LEFT) }}</div>
                                <div style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.5rem;">
                                    {{ \Carbon\Carbon::parse($app->tanggal_mulai)->format('d/m/Y') }} <span style="color: #eab308; margin: 0 0.2rem;">→</span> {{ \Carbon\Carbon::parse($app->tanggal_selesai)->format('d/m/Y') }}
                                </div>
                                <div style="font-weight: 700; color: #fff; font-size: 0.9rem; line-height: 1.4; word-break: break-word;">{{ $app->user->name ?? 'Anonim' }}</div>
                            </td>
                            <td data-label="{{ $lang === 'id' ? 'DETAIL ALOKASI' : 'ALLOCATION' }}" style="padding: 1rem;">
                                @if($app->jenis_peminjaman === 'ruang' || $app->jenis_peminjaman === 'keduanya')
                                    <div style="margin-bottom: 0.5rem;">
                                        <span style="font-weight: bold; color: #cbd5e1;">Lab:</span> {{ $app->laboratorium->nama_lab ?? 'Semua' }}
                                    </div>
                                @endif
                                @if($app->jenis_peminjaman === 'alat' || $app->jenis_peminjaman === 'keduanya')
                                    <div>
                                        <span style="font-weight: bold; color: #cbd5e1;">{{ $lang === 'id' ? 'Aset:' : 'Assets:' }}</span>
                                        <ul style="margin: 0; padding-left: 1rem; color: #fff; font-size: 0.9rem;">
                                            @foreach($app->detailPeminjaman as $det)
                                                <li>{{ $det->alat->nama_alat ?? 'Alat Terhapus (-RSK)' }} (x{{ $det->jumlah }})</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </td>
                            <td data-label="{{ $lang === 'id' ? 'AKTOR / ADMIN' : 'ACTOR / ADMIN' }}" style="padding: 1rem;">
                                @php
                                    $actor = '-';
                                    $actorRole = '';
                                    if ($app->status === 'batal') {
                                        $actor = $app->user->name ?? 'Mahasiswa';
                                        $actorRole = 'Pemohon';
                                    } elseif ($app->status === 'dikembalikan') {
                                        $lastApproval = $app->approval->last();
                                        if ($lastApproval && $lastApproval->approver) {
                                            $actor = $lastApproval->approver->name;
                                            $actorRole = ucfirst($lastApproval->approver->role);
                                        } else {
                                            $actor = 'Asisten / Master'; 
                                            $actorRole = 'Verifikator';
                                        }
                                    } else {
                                        $lastApproval = $app->approval->last();
                                        if ($lastApproval && $lastApproval->approver) {
                                            $actor = $lastApproval->approver->name;
                                            $actorRole = ucfirst($lastApproval->approver->role);
                                        } else {
                                            $actor = 'Sistem Otomatis';
                                            $actorRole = 'Sistem';
                                        }
                                    }
                                @endphp
                                <div style="font-weight: 700; color: #fff; font-size: 0.85rem; line-height: 1.3;">{{ $actor }}</div>
                                <div style="font-size: 0.70rem; color: var(--accent-cyan); margin-top: 0.3rem; display: inline-block; padding: 0.1rem 0.4rem; border: 1px solid rgba(0,217,255,0.3); border-radius: 4px; font-weight: bold;">{{ $actorRole }}</div>
                            </td>
                            <td data-label="{{ $lang === 'id' ? 'STATUS AKHIR' : 'FINAL STATUS' }}" style="padding: 1rem;">
                                @if($app->status === 'dikembalikan')
                                    <span style="background: rgba(34, 197, 94, 0.1); color: #22c55e; border: 1px solid #22c55e; padding: 0.4rem 1rem; border-radius: 6px; font-weight: bold; font-size: 0.75rem;">
                                        {{ $lang === 'id' ? 'DIKEMBALIKAN' : 'RETURNED' }}
                                    </span>
                                @elseif($app->status === 'ditolak')
                                    <span style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid #ef4444; padding: 0.4rem 1rem; border-radius: 6px; font-weight: bold; font-size: 0.75rem;">
                                        {{ $lang === 'id' ? 'DITOLAK' : 'REJECTED' }}
                                    </span>
                                @elseif($app->status === 'batal')
                                    <span style="background: rgba(100, 116, 139, 0.1); color: #94a3b8; border: 1px solid #94a3b8; padding: 0.4rem 1rem; border-radius: 6px; font-weight: bold; font-size: 0.75rem;">
                                        {{ $lang === 'id' ? 'BATAL' : 'CANCELLED' }}
                                    </span>
                                @else
                                    <span style="background: rgba(234, 179, 8, 0.1); color: #eab308; border: 1px solid #eab308; padding: 0.4rem 1rem; border-radius: 6px; font-weight: bold; font-size: 0.75rem;">
                                        {{ strtoupper($app->status) }}
                                    </span>
                                @endif
                                <div style="margin-top: 1rem; font-size: 0.7rem; color: var(--text-muted); font-style: italic;">
                                    Terkonfirmasi: {{ \Carbon\Carbon::parse($app->updated_at)->format('d M Y, H:i') }}
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align: center; padding: 4rem 1rem;">
                <p style="color: var(--text-muted); font-size: 0.95rem;">{{ $lang === 'id' ? 'Belum ada rekaman jejak riwayat di seluruh laboratorium Anda.' : 'No audit trail recorded in any of your laboratories yet.' }}</p>
            </div>
        @endif
    </div>
