    <div class="welcome-banner" style="margin-bottom: 2rem;">
        <div class="status-badge" style="background: rgba(234, 179, 8, 0.1); color: #eab308; border-color: rgba(234, 179, 8, 0.3);">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m9 11 3 3L22 4"></path><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
            {{ $lang === 'id' ? 'Pusat Otorisasi' : 'Authorization Center' }}
        </div>
        <h1 class="welcome-title">{{ $lang === 'id' ? 'Gerbang Persetujuan' : 'Approval Gateway' }}</h1>
        <p class="welcome-subtitle">
            {{ $lang === 'id' ? 'Moderasi dan validasi pengajuan akses peminjaman aset serta pemakaian ruang dari antrean sistem.' : 'Moderate and validate requests for asset lending access and room usage from the system queue.' }}
        </p>
    </div>

    <!-- Papan List Persetujuan -->
    <div style="background: rgba(10, 16, 22, 0.5); border: 1px solid var(--panel-border); border-radius: 1rem; padding: 1.5rem;">
        <h3 style="font-size: 1.25rem; font-weight: 800; margin-top: 0; margin-bottom: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 1rem;">{{ $lang === 'id' ? 'Antrean Membutuhkan Keputusan' : 'Queues Pending Decision' }}</h3>

        @if(isset($approvalsList) && $approvalsList->count() > 0)
            <div style="overflow-x: auto;">
                <table class="responsive-table" style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="border-bottom: 2px solid rgba(0,217,255,0.2); color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase;">
                            <th style="padding: 1rem;">{{ $lang === 'id' ? 'PEMOHON & JADWAL' : 'APPLICANT & SCHEDULE' }}</th>
                            <th style="padding: 1rem;">{{ $lang === 'id' ? 'DETAIL ALOKASI' : 'ALLOCATION DETAILS' }}</th>
                            <th style="padding: 1rem;">{{ $lang === 'id' ? 'KEPERLUAN' : 'PURPOSE' }}</th>
                            <th style="padding: 1rem; text-align: center;">{{ $lang === 'id' ? 'KEPUTUSAN' : 'DECISION' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($approvalsList as $app)
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); transition: background 0.3s;" onmouseover="this.style.background='rgba(0,217,255,0.05)'" onmouseout="this.style.background='transparent'">
                            <td data-label="{{ $lang === 'id' ? 'PEMOHON & JADWAL' : 'APPLICANT' }}" style="padding: 1rem;">
                                <div style="font-size: 0.8rem; color: #00d9ff; font-family: monospace; border: 1px solid rgba(0,217,255,0.3); display: inline-block; padding: 0.2rem 0.5rem; border-radius: 4px; margin-bottom: 0.4rem;">#REQ-{{ str_pad($app->id, 5, '0', STR_PAD_LEFT) }}</div>
                                <div style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.5rem;">
                                    {{ \Carbon\Carbon::parse($app->tanggal_mulai)->format('d/m/Y H:i') }} <span style="color: #eab308; margin: 0 0.2rem;">→</span> {{ \Carbon\Carbon::parse($app->tanggal_selesai)->format('d/m/Y H:i') }}
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
                                                <li>{{ $det->alat->nama_alat ?? 'Alat Terhapus' }} (x{{ $det->jumlah }})</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </td>
                            <td data-label="{{ $lang === 'id' ? 'KEPERLUAN' : 'PURPOSE' }}" style="padding: 1rem; color: #cbd5e1; font-size: 0.9rem; max-width: 250px;">
                                {{ $app->tujuan_peminjaman ?? '-' }}
                            </td>
                            <td data-label="{{ $lang === 'id' ? 'KEPUTUSAN' : 'DECISION' }}" style="padding: 1rem; text-align: center;">
                                <div style="display: flex; flex-direction: column; gap: 0.5rem; justify-content: center; align-items: center;">
                                    <button onclick="approveModal('approve', {{ $app->id }})" style="background: rgba(34, 197, 94, 0.1); color: #22c55e; border: 1px solid #22c55e; padding: 0.4rem 1rem; border-radius: 6px; cursor: pointer; transition: 0.3s; font-weight: bold; font-size: 0.8rem; width: 100px;" onmouseover="this.style.background='#22c55e'; this.style.color='#000'">
                                        {{ $lang === 'id' ? 'ACC' : 'APPROVE' }}
                                    </button>
                                    <button onclick="approveModal('reject', {{ $app->id }})" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid #ef4444; padding: 0.4rem 1rem; border-radius: 6px; cursor: pointer; transition: 0.3s; font-weight: bold; font-size: 0.8rem; width: 100px;" onmouseover="this.style.background='#ef4444'; this.style.color='#000'">
                                        {{ $lang === 'id' ? 'TOLAK' : 'REJECT' }}
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align: center; padding: 4rem 1rem;">
                <p style="color: var(--text-muted); font-size: 0.95rem;">{{ $lang === 'id' ? 'Tidak ada antrean yang membutuhkan persetujuan saat ini.' : 'No queues requiring authorization at the moment.' }}</p>
            </div>
        @endif
    </div>

    <!-- Modal Keputusan -->
    <div id="decisionModal" class="custom-modal">
        <div class="modal-content" style="border-color: #0ea5e9;">
            <svg class="modal-close" onclick="closeModal('decisionModal')" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            <h2 id="decisionTitle" style="color: #0ea5e9; font-weight: 800; margin-top: 0; margin-bottom: 1.5rem;">TITLE</h2>
            <form id="decisionForm" method="POST">
                @csrf
                <input type="hidden" name="action" id="decisionAction">
                <div class="modal-form-group">
                    <label>{{ $lang === 'id' ? 'CATATAN ASISTEN (OPSIONAL)' : 'ASSISTANT NOTES (OPTIONAL)' }}</label>
                    <textarea name="catatan" class="modal-input" rows="4" placeholder="{{ $lang === 'id' ? 'Beri pesan tambahan untuk pemohon...' : 'Provide additional message to the applicant...' }}" style="resize: vertical;"></textarea>
                </div>
                <button type="submit" id="decisionSubmitBtn" style="width: 100%; color: #000; border: none; padding: 1rem; border-radius: 8px; font-weight: 900; letter-spacing: 0.1em; cursor: pointer; margin-top: 1rem; transition: 0.3s;">
                    SUBMIT
                </button>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function approveModal(action, id) {
            const modal = document.getElementById('decisionModal');
            const form = document.getElementById('decisionForm');
            const actionInput = document.getElementById('decisionAction');
            const title = document.getElementById('decisionTitle');
            const submitBtn = document.getElementById('decisionSubmitBtn');
            const lang = '{{ $lang }}';

            form.action = `/asisten/dashboard/approvals/${id}`;
            actionInput.value = action;

            if (action === 'approve') {
                title.innerText = lang === 'id' ? 'SETUJUI PENGAJUAN' : 'APPROVE REQUEST';
                title.style.color = '#22c55e';
                modal.querySelector('.modal-content').style.borderColor = '#22c55e';
                submitBtn.style.background = '#22c55e';
                submitBtn.innerText = lang === 'id' ? 'BERIKAN AKSES' : 'GRANT ACCESS';
            } else {
                title.innerText = lang === 'id' ? 'TOLAK PENGAJUAN' : 'REJECT REQUEST';
                title.style.color = '#ef4444';
                modal.querySelector('.modal-content').style.borderColor = '#ef4444';
                submitBtn.style.background = '#ef4444';
                submitBtn.innerText = lang === 'id' ? 'BATALKAN PERMOHONAN' : 'CANCEL REQUEST';
            }

            openModal('decisionModal');
        }
    </script>
    @endpush
