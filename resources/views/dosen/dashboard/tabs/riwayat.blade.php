<style>
    .riwayat-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .riwayat-title {
        margin: 0;
        font-weight: 900;
        font-size: 1.5rem;
        color: #fff;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .search-box {
        position: relative;
        flex-grow: 1;
        max-width: 400px;
    }

    .search-box input {
        width: 100%;
        background: rgba(10, 16, 22, 0.8);
        border: 1px solid var(--panel-border);
        color: #fff;
        padding: 0.8rem 1rem 0.8rem 2.5rem;
        border-radius: 8px;
        font-family: inherit;
        transition: all 0.3s ease;
        box-sizing: border-box;
    }

    .search-box input:focus {
        outline: none;
        border-color: var(--accent-cyan);
        box-shadow: 0 0 15px rgba(0, 217, 255, 0.2);
    }

    .search-box svg {
        position: absolute;
        left: 0.8rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
    }

    .logs-container {
        background: rgba(10, 16, 22, 0.5);
        border: 1px solid var(--panel-border);
        border-radius: 12px;
        backdrop-filter: blur(10px);
        overflow: hidden;
    }

    .log-header {
        display: grid;
        grid-template-columns: 1fr 2fr 1fr 1.5fr 1fr;
        padding: 1rem 1.5rem;
        background: rgba(0, 0, 0, 0.4);
        border-bottom: 1px solid var(--panel-border);
        font-weight: 800;
        font-size: 0.8rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .log-list {
        max-height: 60vh;
        overflow-y: auto;
    }

    /* Custom Scrollbar for Logs */
    .log-list::-webkit-scrollbar { width: 6px; }
    .log-list::-webkit-scrollbar-track { background: transparent; }
    .log-list::-webkit-scrollbar-thumb { background: rgba(0, 217, 255, 0.2); border-radius: 10px; }
    .log-list::-webkit-scrollbar-thumb:hover { background: rgba(0, 217, 255, 0.5); }

    .log-card {
        display: grid;
        grid-template-columns: 1fr 2fr 1fr 1.5fr 1fr;
        padding: 1.2rem 1.5rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        align-items: center;
        gap: 1rem;
        transition: background 0.2s ease;
    }

    .log-card:hover {
        background: rgba(0, 217, 255, 0.02);
    }

    .log-card:last-child {
        border-bottom: none;
    }

    .log-val {
        font-size: 0.9rem;
        color: var(--text-light);
        word-break: break-word;
    }

    .val-ticket {
        font-family: monospace;
        color: var(--accent-cyan);
        font-weight: bold;
    }

    .val-type {
        font-size: 0.75rem;
        padding: 0.2rem 0.5rem;
        border-radius: 4px;
        background: rgba(255,255,255,0.1);
        display: inline-block;
        margin-top: 0.3rem;
        color: #fff;
    }

    .type-alat { background: rgba(147, 51, 234, 0.2); color: #d8b4fe; border: 1px solid rgba(147, 51, 234, 0.4); }
    .type-ruang { background: rgba(59, 130, 246, 0.2); color: #93c5fd; border: 1px solid rgba(59, 130, 246, 0.4); }

    .val-status {
        font-size: 0.75rem;
        font-weight: 800;
        padding: 0.3rem 0.6rem;
        border-radius: 20px;
        text-transform: uppercase;
        display: inline-block;
        text-align: center;
    }

    .status-menunggu { background: rgba(234, 179, 8, 0.1); color: #eab308; border: 1px solid rgba(234, 179, 8, 0.3); }
    .status-disetujui { background: rgba(34, 197, 94, 0.1); color: #22c55e; border: 1px solid rgba(34, 197, 94, 0.3); }
    .status-ditolak { background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.3); }
    .status-dipinjam { background: rgba(59, 130, 246, 0.1); color: #3b82f6; border: 1px solid rgba(59, 130, 246, 0.3); }
    .status-selesai { background: rgba(168, 162, 158, 0.1); color: #a8a29e; border: 1px solid rgba(168, 162, 158, 0.3); }

    .val-time {
        font-size: 0.8rem;
        color: var(--text-muted);
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem;
        color: var(--text-muted);
    }

    /* Responsivitas Mobile: Tabel berubah jadi baris vertikal per Card */
    @media (max-width: 992px) {
        .log-header {
            display: none; /* Sembunyikan header tabel di mobile */
        }
        .log-card {
            grid-template-columns: 1fr;
            gap: 0.5rem;
            position: relative;
            padding-bottom: 1.5rem;
        }
        .log-val::before {
            content: attr(data-label);
            display: block;
            font-size: 0.7rem;
            color: var(--text-muted);
            text-transform: uppercase;
            font-weight: 800;
            margin-bottom: 0.2rem;
        }
        .val-status {
            position: absolute;
            top: 1.2rem;
            right: 1.5rem;
        }
    }
</style>

<div class="riwayat-header">
    <h2 class="riwayat-title">
        {{ $lang === 'id' ? 'Buku Besar Riwayat Peminjaman' : 'Borrowing History Ledger' }}
    </h2>
    <div class="search-box">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
        <input type="text" id="searchInput" placeholder="{{ $lang === 'id' ? 'Cari ID Tiket, Pemohon, Ruang...' : 'Search Ticket ID, Applicant, Room...' }}">
    </div>
</div>

<div class="logs-container">
    <div class="log-header">
        <div>{{ $lang === 'id' ? 'ID Tiket' : 'Ticket ID' }}</div>
        <div>{{ $lang === 'id' ? 'Pemohon & Tujuan' : 'Applicant & Purpose' }}</div>
        <div>{{ $lang === 'id' ? 'Kategori' : 'Category' }}</div>
        <div>{{ $lang === 'id' ? 'Alokasi Waktu' : 'Time Allocation' }}</div>
        <div>{{ $lang === 'id' ? 'Status' : 'Status' }}</div>
    </div>

    <div class="log-list" id="logList">
        @forelse($riwayatPeminjaman as $log)
            <div class="log-card">
                <div class="log-val" data-label="ID TIKET">
                    <span class="val-ticket">#TK-{{ str_pad($log->id, 5, '0', STR_PAD_LEFT) }}</span>
                    <br>
                    <span class="val-type {{ $log->jenis_peminjaman === 'alat' ? 'type-alat' : 'type-ruang' }}">
                        {{ strtoupper($log->jenis_peminjaman) }}
                    </span>
                </div>
                
                <div class="log-val" data-label="PEMOHON & LOKASI">
                    <strong style="color: #fff;">{{ $log->user->name ?? 'Anonim' }}</strong><br>
                    <span style="font-size: 0.8rem; color: var(--text-muted);">
                        @if($log->jenis_peminjaman === 'ruang')
                            {{ $log->laboratorium->nama_lab ?? 'Non-Spesifik' }}
                        @else
                            {{ $log->detailPeminjaman->count() }} Item Alat Tersertakan
                        @endif
                    </span>
                </div>

                <div class="log-val" data-label="KATEGORI LAB">
                    <span class="val-type type-ruang" style="background: rgba(255,255,255,0.05); color: var(--text-muted); border: 1px solid rgba(255,255,255,0.1);">
                        {{ $log->laboratorium->nama_lab ?? '-' }}
                    </span>
                </div>

                <div class="log-val val-time" data-label="WAKTU PELAKSANAAN">
                    Mulai: <strong style="color: var(--text-light);">{{ \Carbon\Carbon::parse($log->tanggal_mulai)->format('d M y, H:i') }}</strong><br>
                    Selesai: <strong style="color: var(--text-light);">{{ \Carbon\Carbon::parse($log->tanggal_selesai)->format('d M y, H:i') }}</strong>
                </div>

                <div class="log-val" data-label="STATUS">
                    <span class="val-status status-{{ $log->status }}">
                        {{ strtoupper($log->status) }}
                    </span>
                    
                    {{-- Pengecualian Khusus: Dosen bisa membatalkan tiket DARURAT miliknya sendiri selama masih tertahan (menunggu) --}}
                    @if($log->user_id === Auth::id() && $log->status === 'menunggu')
                        <form id="cancelForm-{{$log->id}}" action="{{ route('student.peminjaman.cancel', $log->id) }}" method="POST" style="margin-top: 0.6rem;">
                            @csrf
                            <button type="button" onclick="confirmCancel('{{$log->id}}')" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.3); padding: 0.3rem 0.5rem; border-radius: 4px; font-size: 0.7rem; font-weight: 800; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 0.3rem; margin-top: 0.2rem;" onmouseover="this.style.background='rgba(239, 68, 68, 0.2)'" onmouseout="this.style.background='rgba(239, 68, 68, 0.1)'">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                {{ $lang === 'id' ? 'BATALKAN' : 'CANCEL' }}
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="empty-state">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem; opacity: 0.5;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                <p>{{ $lang === 'id' ? 'Belum Ada Entri Riwayat Peminjaman Pada Sistem.' : 'No Borrowing Log Entries in the System Yet.' }}</p>
            </div>
        @endforelse
    </div>
</div>

<script>
    // JS Filtering Instan NFR-01
    document.getElementById('searchInput').addEventListener('input', function(e) {
        let keyword = e.target.value.toLowerCase().trim();
        let cards = document.querySelectorAll('.log-card');
        let hasVisible = false;

        cards.forEach(card => {
            // Karena tabel Cyberpunk memuat seluruh text di innerText
            let cardText = card.innerText.toLowerCase();
            
            if(cardText.indexOf(keyword) > -1) {
                // Jangan pakai block, karena CSS mentargetkan Grid
                // Kita kosongkan display agar kembali ke class original grid di desktop atau flex di mobile
                card.style.display = ''; 
                hasVisible = true;
            } else {
                card.style.display = 'none';
            }
        });

        // Tangani empty state pencarian
        let emptySearch = document.getElementById('emptySearch');
        if(!hasVisible && cards.length > 0) {
            if(!emptySearch) {
                emptySearch = document.createElement('div');
                emptySearch.id = 'emptySearch';
                emptySearch.className = 'empty-state';
                emptySearch.innerHTML = `Pencarian untuk "<strong>${keyword}</strong>" tidak ditemukan.`;
                document.getElementById('logList').appendChild(emptySearch);
            } else {
                emptySearch.style.display = 'block';
                emptySearch.innerHTML = `Pencarian untuk "<strong>${keyword}</strong>" tidak ditemukan.`;
            }
        } else if (emptySearch) {
            emptySearch.style.display = 'none';
        }
    });

    // Custom Modal Pembatalan Logic
    let activeCancelFormId = null;
    function confirmCancel(id) {
        activeCancelFormId = 'cancelForm-' + id;
        openModal('cancelConfirmModal');
    }
    function executeCancel() {
        if(activeCancelFormId) {
            document.getElementById(activeCancelFormId).submit();
        }
    }
</script>

<!-- Modal Konfirmasi Batal -->
<div id="cancelConfirmModal" class="custom-modal">
    <div class="modal-content" style="max-width: 400px; text-align: center; padding: 2rem; border-top: 4px solid #ef4444;">
        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem;"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
        <h3 style="color: #fff; margin-top: 0; font-weight: 800; text-transform: uppercase;">{{ $lang === 'id' ? 'Konfirmasi Pembatalan' : 'Cancel Confirmation' }}</h3>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 2rem; line-height: 1.6;">
            {{ $lang === 'id' ? 'Yakin ingin MEMBATALKAN tiket Booking Darurat ini? Tindakan ini tidak dapat dipulihkan.' : 'Are you sure you want to CANCEL this Emergency Booking ticket? This action is irreversible.' }}
        </p>
        <div style="display: flex; gap: 1rem; justify-content: center;">
            <button type="button" onclick="closeModal('cancelConfirmModal')" style="padding: 0.8rem 1.5rem; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: var(--text-light); border-radius: 6px; cursor: pointer; font-weight: bold; transition: all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.1)'" onmouseout="this.style.background='rgba(255,255,255,0.05)'">
                {{ $lang === 'id' ? 'KEMBALI' : 'GO BACK' }}
            </button>
            <button type="button" onclick="executeCancel()" style="padding: 0.8rem 1.5rem; background: #ef4444; border: none; color: #fff; font-weight: bold; border-radius: 6px; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                {{ $lang === 'id' ? 'YA, BATALKAN TIKET' : 'YES, CANCEL IT' }}
            </button>
        </div>
    </div>
</div>
