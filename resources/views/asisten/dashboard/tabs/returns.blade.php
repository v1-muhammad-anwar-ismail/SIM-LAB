    <div class="welcome-banner" style="margin-bottom: 2rem;">
        <div class="status-badge" style="background: rgba(34, 197, 94, 0.1); color: #22c55e; border-color: rgba(34, 197, 94, 0.3);">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 10 4 15 9 20"></polyline><path d="M20 4v7a4 4 0 0 1-4 4H4"></path></svg>
            {{ $lang === 'id' ? 'Sirkulasi Barang' : 'Asset Circulation' }}
        </div>
        <h1 class="welcome-title">{{ $lang === 'id' ? 'Validasi Pengembalian' : 'Return Validation' }}</h1>
        <p class="welcome-subtitle">
            {{ $lang === 'id' ? 'Awasi daftar peminjam aktif. Pastikan kuantitas dan kualitas barang sesuai sebelum dicap Selesai.' : 'Monitor active borrowers. Ensure asset quantity and quality match before marking as Completed.' }}
        </p>
    </div>
    <style>
        /* Button Resize Mobile */
    .btn-full-mobile {
        width: 100%;
        justify-content: center;
        text-align: center;
    }
    @media (min-width: 768px) {
        .btn-full-mobile {
            width: auto;
        }
    }
</style>

    <!-- PANEL 1: SIAP DIAMBIL (HANDOVER) -->
    <div style="background: rgba(10, 16, 22, 0.5); border: 1px solid var(--panel-border); border-radius: 1rem; padding: 1.5rem; margin-bottom: 2rem;">
        <h3 style="font-size: 1.25rem; font-weight: 800; margin-top: 0; margin-bottom: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 1rem; color: #0ea5e9;">{{ $lang === 'id' ? 'Menunggu Penyerahan (Siap Diambil)' : 'Ready for Handover (Pickup)' }}</h3>

        @if(isset($readyList) && $readyList->count() > 0)
            <div style="overflow-x: auto;">
                <table class="responsive-table" style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="border-bottom: 2px solid rgba(14, 165, 233,0.2); color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase;">
                            <th style="padding: 1rem;">{{ $lang === 'id' ? 'PEMINJAM' : 'BORROWER' }}</th>
                            <th style="padding: 1rem;">{{ $lang === 'id' ? 'BARANG YANG DISIAPKAN' : 'PREPARED ITEMS' }}</th>
                            <th style="padding: 1rem; text-align: center;">{{ $lang === 'id' ? 'AKSI EKSEKUSI' : 'EXECUTION ACTION' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($readyList as $app)
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); transition: background 0.3s;" onmouseover="this.style.background='rgba(14, 165, 233,0.05)'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 1rem;">
                                <div style="font-size: 0.8rem; color: #0ea5e9; font-family: monospace; border: 1px solid rgba(14, 165, 233,0.3); display: inline-block; padding: 0.2rem 0.5rem; border-radius: 4px; margin-bottom: 0.4rem;">#REQ-{{ str_pad($app->id, 5, '0', STR_PAD_LEFT) }}</div>
                                <div style="font-weight: 700; color: #fff; font-size: 0.9rem; line-height: 1.4; word-break: break-word;">{{ $app->user->name ?? 'Anonim' }}</div>
                            </td>
                            <td style="padding: 1rem;">
                                @if($app->jenis_peminjaman === 'alat' || $app->jenis_peminjaman === 'keduanya')
                                    <ul style="margin: 0; padding-left: 1rem; color: #cbd5e1; font-size: 0.9rem;">
                                        @foreach($app->detailPeminjaman as $det)
                                            <li>{{ $det->alat->nama_alat ?? 'Alat Terhapus' }} (x{{ $det->jumlah }})</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <div style="color: #cbd5e1; font-style: italic;">Akses Ruangan Saja</div>
                                @endif
                            </td>
                            <td style="padding: 1rem; text-align: center;">
                                <form action="{{ route('asisten.returns.handover', $app->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-full-mobile" style="background: rgba(14, 165, 233, 0.1); color: #0ea5e9; border: 1px solid #0ea5e9; padding: 0.6rem 1.2rem; border-radius: 8px; cursor: pointer; transition: 0.3s; font-weight: 800; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 0.5rem;" onmouseover="this.style.background='#0ea5e9'; this.style.color='#000'" onmouseout="this.style.background='rgba(14, 165, 233, 0.1)'; this.style.color='#0ea5e9'">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                                        {{ $lang === 'id' ? 'SERAHKAN BARANG' : 'HANDOVER ITEMS' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align: center; padding: 3rem 1rem;">
                <p style="color: var(--text-muted); font-size: 0.95rem;">{{ $lang === 'id' ? 'Tidak ada barang/ruangan yang menunggu untuk diambil.' : 'No items/rooms waiting to be picked up.' }}</p>
            </div>
        @endif
    </div>

    <!-- PANEL 2: PEMINJAMAN AKTIF DI LUAR -->
    <div style="background: rgba(10, 16, 22, 0.5); border: 1px solid var(--panel-border); border-radius: 1rem; padding: 1.5rem;">
        <h3 style="font-size: 1.25rem; font-weight: 800; margin-top: 0; margin-bottom: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 1rem; color: #22c55e;">{{ $lang === 'id' ? 'Peminjaman Sedang Berjalan (Di Luar)' : 'Ongoing Loans (Currently Out)' }}</h3>

        @if(isset($returnsList) && $returnsList->count() > 0)
            <div style="overflow-x: auto;">
                <table class="responsive-table" style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="border-bottom: 2px solid rgba(0,217,255,0.2); color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase;">
                            <th style="padding: 1rem;">{{ $lang === 'id' ? 'PEMINJAM & BATAS WAKTU' : 'BORROWER & DEADLINE' }}</th>
                            <th style="padding: 1rem;">{{ $lang === 'id' ? 'BARANG YANG DIBAWA' : 'BORROWED ITEMS' }}</th>
                            <th style="padding: 1rem; text-align: center;">{{ $lang === 'id' ? 'AKSI EKSEKUSI' : 'EXECUTION ACTION' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($returnsList as $app)
                        @php
                            $isOverdue = \Carbon\Carbon::now()->isAfter(\Carbon\Carbon::parse($app->tanggal_selesai));
                        @endphp
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); transition: background 0.3s;" onmouseover="this.style.background='rgba(0,217,255,0.05)'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 1rem;">
                                <div style="font-size: 0.8rem; color: #00d9ff; font-family: monospace; border: 1px solid rgba(0,217,255,0.3); display: inline-block; padding: 0.2rem 0.5rem; border-radius: 4px; margin-bottom: 0.4rem;">#REQ-{{ str_pad($app->id, 5, '0', STR_PAD_LEFT) }}</div>
                                <div style="font-size: 0.8rem; margin-bottom: 0.5rem; color: {{ $isOverdue ? '#ef4444' : '#22c55e' }}; font-weight: bold;">
                                    {{ $lang === 'id' ? 'Tenggat: ' : 'Deadline: ' }} {{ \Carbon\Carbon::parse($app->tanggal_selesai)->diffForHumans() }}
                                    @if($isOverdue)
                                        <span style="border: 1px solid #ef4444; padding: 0.1rem 0.3rem; border-radius: 4px; margin-left: 0.5rem; background: rgba(239, 68, 68, 0.1);">TERLAMBAT</span>
                                    @endif
                                </div>
                                <div style="font-weight: 700; color: #fff; font-size: 0.9rem; line-height: 1.4; word-break: break-word;">{{ $app->user->name ?? 'Anonim' }}</div>
                            </td>
                            <td style="padding: 1rem;">
                                @if($app->jenis_peminjaman === 'alat' || $app->jenis_peminjaman === 'keduanya')
                                    <ul style="margin: 0; padding-left: 1rem; color: #fff; font-size: 0.9rem;">
                                        @foreach($app->detailPeminjaman as $det)
                                            <li>{{ $det->alat->nama_alat ?? 'Alat Terhapus' }} (x{{ $det->jumlah }})</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <div style="color: #cbd5e1; font-style: italic;">Ruangan Saja</div>
                                @endif
                            </td>
                            <td style="padding: 1rem; text-align: center;">
                                <button class="btn-full-mobile" onclick="returnModal({{ $app->id }}, '{{ addslashes($app->user->name ?? '') }}')" style="background: rgba(0, 217, 255, 0.1); color: var(--accent-cyan); border: 1px solid var(--accent-cyan); padding: 0.6rem 1.2rem; border-radius: 8px; cursor: pointer; transition: 0.3s; font-weight: 800; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 0.5rem;" onmouseover="this.style.background='var(--accent-cyan)'; this.style.color='#000'" onmouseout="this.style.background='rgba(0, 217, 255, 0.1)'; this.style.color='var(--accent-cyan)'">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                    {{ $lang === 'id' ? 'TERIMA BARANG' : 'RECEIVE ITEMS' }}
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align: center; padding: 4rem 1rem;">
                <p style="color: var(--text-muted); font-size: 0.95rem;">{{ $lang === 'id' ? 'Tidak ada peminjaman aktif.' : 'No active loans.' }}</p>
            </div>
        @endif
    </div>

    <!-- Modal Retur Barang -->
    <div id="returnModal" class="custom-modal">
        <div class="modal-content" style="border-color: #22c55e;">
            <svg class="modal-close" onclick="closeModal('returnModal')" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            <h2 style="color: #22c55e; font-weight: 800; margin-top: 0; margin-bottom: 0.5rem;">{{ $lang === 'id' ? 'FORM VALIDASI RETUR' : 'RETURN VALIDATION FORM' }}</h2>
            <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 1.5rem;" id="returnStudentName">Mahasiswa: -</p>
            
            <form id="returnForm" method="POST">
                @csrf
                <div class="modal-form-group">
                    <label>{{ $lang === 'id' ? 'KONDISI BARANG SAAT KEMBALI' : 'ASSET CONDITION UPON RETURN' }}</label>
                    <select name="laporan_rusak" class="modal-select" required>
                        <option value="0">Semua Barang Lengkap & Baik (Normal)</option>
                        <option value="1">Terdapat Barang Rusak / Hilang (Bermasalah)</option>
                    </select>
                </div>
                <div class="modal-form-group">
                    <label>{{ $lang === 'id' ? 'CATATAN (WAJIB JIKA RUSAK)' : 'NOTES (REQUIRED IF DAMAGED)' }}</label>
                    <textarea name="catatan_kondisi" class="modal-input" rows="3" placeholder="Sebutkan detail bila ada alat yang cacat/hilang, denda, dll..."></textarea>
                </div>
                <button type="submit" style="width: 100%; color: #000; background: #22c55e; border: none; padding: 1rem; border-radius: 8px; font-weight: 900; letter-spacing: 0.1em; cursor: pointer; margin-top: 1rem; transition: 0.3s; box-shadow: 0 0 15px rgba(34, 197, 94, 0.4);">
                    {{ $lang === 'id' ? 'KONFIRMASI SELESAI' : 'CONFIRM COMPLETION' }}
                </button>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function returnModal(id, studentName) {
            const modal = document.getElementById('returnModal');
            const form = document.getElementById('returnForm');
            document.getElementById('returnStudentName').innerText = 'Peminjam: ' + studentName;
            
            form.action = `/asisten/dashboard/returns/${id}`;
            openModal('returnModal');
        }
    </script>
    @endpush
