<style>
    .logs-terminal {
        background: rgba(10, 16, 22, 0.8);
        border: 1px solid var(--panel-border);
        border-radius: 12px;
        padding: 2rem;
        font-family: 'Inter', sans-serif; /* Tampilan Bersih SANS */
        position: relative;
        overflow: hidden;
    }

    .logs-terminal::after {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: repeating-linear-gradient(
            0deg,
            rgba(0, 0, 0, 0.1),
            rgba(0, 0, 0, 0.1) 1px,
            transparent 1px,
            transparent 2px
        );
        pointer-events: none;
        opacity: 0.3;
    }

    .log-line {
        display: flex;
        gap: 1.5rem;
        padding: 0.8rem;
        border-bottom: 1px solid rgba(255,255,255,0.02);
        color: var(--text-light);
        font-size: 0.85rem;
        transition: background 0.2s;
    }

    .log-line:hover {
        background: rgba(0, 217, 255, 0.05);
    }

    .log-time {
        color: var(--text-muted);
        flex: 0 0 180px; /* Lebar absolut agar tak mudah terdesak */
        font-weight: bold;
    }

    .log-actor {
        flex: 0 0 240px; /* Lebar absolut */
        color: var(--accent-cyan);
        font-weight: 800;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .log-action {
        color: #eab308;
        flex-grow: 1;
        word-break: break-word; /* Mencegah baris kepanjangan */
    }

    /* Danger Keyword Highlighting */
    .keyword-danger { color: #ef4444; font-weight: 900; background: rgba(239, 68, 68, 0.1); padding: 0 4px; }
    .keyword-success { color: #22c55e; font-weight: 900; background: rgba(34, 197, 94, 0.1); padding: 0 4px; }
    .keyword-warning { color: #eab308; font-weight: 900; background: rgba(234, 179, 8, 0.1); padding: 0 4px; }

    .pagination-wrapper {
        margin-top: 2rem;
        font-family: 'Inter', sans-serif;
    }
    .pagination-wrapper nav div.hidden { display: none; }
    .pagination-wrapper nav span.relative { background: transparent; border-color: rgba(255,255,255,0.1); color: var(--text-muted); }
    .pagination-wrapper nav a.relative { background: rgba(0,217,255,0.05); border-color: rgba(0,217,255,0.2); color: var(--accent-cyan); }
    .pagination-wrapper nav span[aria-current="page"] span { background: var(--accent-cyan); border-color: var(--accent-cyan); color: #000; }

    .custom-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.85);
        backdrop-filter: blur(5px);
        align-items: center;
        justify-content: center;
    }

    .custom-modal.active {
        display: flex;
        animation: cyberFadeIn 0.3s ease-out forwards;
    }

    .custom-modal .modal-content {
        background: rgba(10, 16, 22, 0.95);
        border: 1px solid var(--accent-cyan);
        border-radius: 12px;
        padding: 2rem;
        width: 90%;
        max-width: 500px;
        box-shadow: 0 0 30px rgba(0, 217, 255, 0.15);
        position: relative;
    }

    @keyframes cyberFadeIn {
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1); }
    }
</style>

<div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: flex-end;">
    <div>
        <h2 style="margin: 0; color: #fff; font-weight: 900; text-transform: uppercase; font-size: 1.25rem;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 8px;"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
            {{ $lang === 'id' ? 'Radar Forensik Log Aktivitas' : 'Forensic Activity Log Radar' }}
        </h2>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 0.5rem; margin-bottom: 0;">
            {{ $lang === 'id' ? 'Seluruh jejak kaki transaksi modifikasi data seluruh pengguna terekam tanpa ampun di sini.' : 'All transaction manipulation footprints are recorded here without mercy.' }}
        </p>
    </div>
</div>

<div class="logs-terminal">
    <!-- Terminal Header Fake -->
    <div style="font-size: 0.75rem; color: var(--text-muted); border-bottom: 1px dashed rgba(255,255,255,0.1); padding-bottom: 1rem; margin-bottom: 1rem; text-transform: uppercase;">
        <div class="live-indicator" style="color: var(--accent-cyan); display: flex; align-items: center; gap: 6px; margin-bottom: 0.5rem;">
            <span style="display:inline-block; width: 8px; height: 8px; border-radius: 50%; background: var(--accent-cyan); box-shadow: 0 0 8px var(--accent-cyan); animation: blink 1s infinite;"></span>
            LIVE SYSTEM
        </div>
        [ <span id="cyber-live-clock">{{ \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}</span> ] CONNECTED TO GLOBAL_ACTIVITY_LOG SERVER... <span style="color: #22c55e;">OK</span>
        <br>FETCHING DATABASE TRACES... <span style="color: #22c55e;">OK</span>
    </div>

    <style>
        @keyframes blink { 0% { opacity: 1; } 50% { opacity: 0.3; } 100% { opacity: 1; } }
    </style>

    @foreach($logsList as $log)
        <div class="log-line" style="cursor: pointer;" 
             data-time="{{ \Carbon\Carbon::parse($log->created_at)->format('dM-Y H:i:s') }}"
             data-actor="[{{ strtoupper($log->user->role ?? 'DELETED_USER') }}] {{ $log->user->name ?? 'Unknown Identity' }}"
             onclick="openLogDetailModal(this)">
            <div class="hidden-action" style="display: none;">
                @php
                    $rawAct = $log->aktivitas;
                    $rawAct = str_replace('MEMUSNAHKAN', '<span class="keyword-danger">MEMUSNAHKAN</span>', $rawAct);
                    $rawAct = str_replace('Menolak', '<span class="keyword-danger">MENOLAK</span>', $rawAct);
                    $rawAct = str_replace('DITOLAK', '<span class="keyword-danger">DITOLAK</span>', $rawAct);
                    $rawAct = str_replace('MENCIPTAKAN', '<span class="keyword-success">MENCIPTAKAN</span>', $rawAct);
                    $rawAct = str_replace('Menyetujui', '<span class="keyword-success">MENYETUJUI</span>', $rawAct);
                    $rawAct = str_replace('MENGUBAH JABATAN', '<span class="keyword-warning">MENGUBAH JABATAN</span>', $rawAct);
                @endphp
                {!! $rawAct !!}
            </div>
            
            <div class="log-time">>> {{ \Carbon\Carbon::parse($log->created_at)->format('dM-Y H:i:s') }}</div>
            <div class="log-actor">[{{ strtoupper($log->user->role ?? 'DELETED_USER') }}] {{ $log->user->name ?? 'Unknown Identity' }}</div>
            <div class="log-action">
                {!! $rawAct !!}
            </div>
        </div>
    @endforeach

    @if($logsList->isEmpty())
        <div style="text-align: center; padding: 3rem; color: var(--text-muted); font-family: 'Inter', sans-serif;">
            _NO_LOGS_DETECTED_
        </div>
    @endif
</div>

<!-- Pagination Panel -->
<div class="pagination-wrapper">
    {{ $logsList->appends(['tab' => 'logs'])->links() }}
</div>

<!-- Modal Detail Log -->
<div id="logDetailModal" class="custom-modal">
    <div class="modal-content" style="max-width: 500px;">
        <span onclick="closeLogModal()" style="color: #fff; cursor: pointer; position: absolute; right: 20px; top: 20px; font-size: 1.5rem; line-height: 1;">&times;</span>
        <h3 style="color: var(--accent-cyan); margin-top: 0; font-weight: 900; text-transform: uppercase;">{{ $lang === 'id' ? 'Detail Forensik Log' : 'Forensic Log Detail' }}</h3>
        
        <div style="margin-bottom: 1rem; margin-top: 1.5rem;">
            <label style="display:block; font-size: 0.75rem; color: var(--text-muted); font-weight: bold; margin-bottom: 0.5rem;">TIMESTAMP SYSTEM</label>
            <div id="modalLogTime" style="color: var(--text-light); font-family: monospace; font-size: 0.9rem; padding: 0.8rem; background: rgba(0,0,0,0.5); border-radius: 4px; border: 1px solid rgba(255,255,255,0.1);"></div>
        </div>
        
        <div style="margin-bottom: 1rem;">
            <label style="display:block; font-size: 0.75rem; color: var(--text-muted); font-weight: bold; margin-bottom: 0.5rem;">ACTOR IDENTITY</label>
            <div id="modalLogActor" style="color: var(--accent-cyan); font-weight: bold; font-size: 0.9rem; padding: 0.8rem; background: rgba(0,217,255,0.05); border-radius: 4px; border: 1px solid rgba(0,217,255,0.2);"></div>
        </div>
        
        <div style="margin-bottom: 2rem;">
            <label style="display:block; font-size: 0.75rem; color: var(--text-muted); font-weight: bold; margin-bottom: 0.5rem;">ACTION EXECUTED</label>
            <div id="modalLogAction" style="color: var(--text-light); font-size: 0.95rem; padding: 1rem; background: rgba(255,255,255,0.02); border-radius: 6px; border: 1px solid rgba(255,255,255,0.05); line-height: 1.6;"></div>
        </div>
        
        <button type="button" style="width: 100%; border: 1px solid rgba(255,255,255,0.2); background: transparent; color: #fff; padding: 0.8rem; border-radius: 6px; font-weight: bold; cursor: pointer; transition: all 0.2s;" onclick="closeLogModal()" onmouseover="this.style.background='rgba(255,255,255,0.1)';" onmouseout="this.style.background='transparent';">TUTUP PANEL DETAIL</button>
    </div>
</div>

<script>
    function openLogDetailModal(element) {
        document.getElementById('modalLogTime').innerText = element.getAttribute('data-time');
        document.getElementById('modalLogActor').innerText = element.getAttribute('data-actor');
        document.getElementById('modalLogAction').innerHTML = element.querySelector('.hidden-action').innerHTML;
        document.getElementById('logDetailModal').classList.add('active');
    }
    
    function closeLogModal() {
        document.getElementById('logDetailModal').classList.remove('active');
    }

    // Auto-close modal when clicking outside
    window.addEventListener('click', function(event) {
        if (event.target.id === 'logDetailModal') {
            closeLogModal();
        }
    });

    function updateCyberClock() {
        const clockEl = document.getElementById('cyber-live-clock');
        if (!clockEl) return;
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        clockEl.innerText = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    }
    // Eksekusi Detak Waktu Client-Side (1000ms)
    setInterval(updateCyberClock, 1000);
</script>
