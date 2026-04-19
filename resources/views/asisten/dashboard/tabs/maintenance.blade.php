    <div class="welcome-banner" style="margin-bottom: 2rem;">
        <div class="status-badge" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border-color: rgba(239, 68, 68, 0.3);">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>
            {{ $lang === 'id' ? 'Logistik Perbaikan' : 'Maintenance Logistics' }}
        </div>
        <h1 class="welcome-title">{{ $lang === 'id' ? 'Fasilitas Pemulihan Aset' : 'Asset Recovery Facility' }}</h1>
        <p class="welcome-subtitle">
            {{ $lang === 'id' ? 'Lacak dan kelola aset yang rusak atau hilang dari sirkulasi utama inventaris, pulihkan kembali ke ekosistem logistik sehat bila sudah diperbaiki atau ditemukan.' : 'Track and manage broken or lost assets from main inventory circulation, restore them back to healthy logistic ecosystem once repaired or found.' }}
        </p>
    </div>

    <!-- Papan List Rusak -->
    <div style="background: rgba(10, 16, 22, 0.5); border: 1px solid var(--panel-border); border-radius: 1rem; padding: 1.5rem;">
        <h3 style="font-size: 1.25rem; font-weight: 800; margin-top: 0; margin-bottom: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 1rem;">{{ $lang === 'id' ? 'Karantina Aset Menunggu Perbaikan' : 'Quarantine: Awaiting Maintenance' }}</h3>

        @if(isset($maintenanceList) && $maintenanceList->count() > 0)
            <div style="overflow-x: auto;">
                <table class="responsive-table" style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="border-bottom: 2px solid rgba(0,217,255,0.2); color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase;">
                            <th style="padding: 1rem;">{{ $lang === 'id' ? 'KODE RUSAK' : 'BROKEN CODE' }}</th>
                            <th style="padding: 1rem;">{{ $lang === 'id' ? 'DETAIL ASET' : 'ASSET DETAIL' }}</th>
                            <th style="padding: 1rem; width: 150px; text-align: center;">{{ $lang === 'id' ? 'TOTAL RUSAK' : 'TOTAL BROKEN' }}</th>
                            <th style="padding: 1rem; text-align: center;">{{ $lang === 'id' ? 'PEMULIHAN' : 'RECOVERY' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($maintenanceList as $inv)
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); transition: background 0.3s;" onmouseover="this.style.background='rgba(239, 68, 68, 0.05)'" onmouseout="this.style.background='transparent'">
                            <td data-label="{{ $lang === 'id' ? 'KODE RUSAK' : 'CODE' }}" style="padding: 1rem;">
                                <div style="font-size: 0.8rem; color: #ef4444; font-family: monospace; font-weight: bold; border: 1px solid rgba(239, 68, 68, 0.3); display: inline-block; padding: 0.2rem 0.5rem; border-radius: 4px;">{{ $inv->kode_alat }}</div>
                            </td>
                            <td data-label="{{ $lang === 'id' ? 'NAMA ASET' : 'ASSET NAME' }}" style="padding: 1rem; font-weight: 600; color: #fff;">
                                {{ $inv->nama_alat }}
                                <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 5px;">{{ $inv->laboratorium->nama_lab ?? 'Unassigned' }}</div>
                            </td>
                            <td data-label="{{ $lang === 'id' ? 'STOK' : 'STOCK' }}" style="padding: 1rem; font-weight: 900; font-size: 1.2rem; color: #ef4444; text-align: center;">{{ $inv->stok }}</td>
                            <td data-label="{{ $lang === 'id' ? 'AKSI' : 'ACTIONS' }}" style="padding: 1rem; text-align: center;">
                                <button onclick="openRepairModal({{ json_encode($inv) }})" style="background: rgba(34, 197, 94, 0.1); color: #22c55e; border: 1px solid #22c55e; padding: 0.4rem 1rem; border-radius: 6px; cursor: pointer; transition: 0.3s; font-weight: bold; font-size: 0.8rem;" onmouseover="this.style.background='#22c55e'; this.style.color='#000'" onmouseout="this.style.background='rgba(34, 197, 94, 0.1)'; this.style.color='#22c55e'">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 5px;"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                    {{ $lang === 'id' ? 'PULIHKAN' : 'RESTORE' }}
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align: center; padding: 4rem 1rem;">
                <p style="color: var(--text-muted); font-size: 0.95rem;">{{ $lang === 'id' ? 'Luar biasa! Tidak ada aset fisik yang rusak di laboratorium Anda saat ini.' : 'Excellent! There are no broken physical assets in your laboratory at the moment.' }}</p>
            </div>
        @endif
    </div>

    <!-- Modal Perbaikan Aset -->
    <div id="repairAssetModal" class="custom-modal">
        <div class="modal-content" style="border-color: #22c55e;">
            <svg class="modal-close" onclick="closeModal('repairAssetModal')" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            <h2 style="color: #22c55e; font-weight: 800; margin-top: 0; margin-bottom: 0.5rem;" id="repairTitle">{{ $lang === 'id' ? 'PEMULIHAN ASET FISIK' : 'PHYSICAL ASSET RESTORATION' }}</h2>
            <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 2rem;">{{ $lang === 'id' ? 'Stok aset yang dipulihkan akan diinjeksi kembali ke peredaran sirkulasi utama Lab.' : 'Restored asset stock will be injected back into the main Laboratory circulation.' }}</p>

            <form id="repairForm" method="POST" action="">
                @csrf
                
                <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem; background: rgba(34, 197, 94, 0.05); padding: 1rem; border-radius: 8px; border: 1px dashed rgba(34, 197, 94, 0.3);">
                    <!-- Borongan Option -->
                    <label style="flex: 1; display: flex; align-items: flex-start; gap: 0.5rem; cursor: pointer;">
                        <input type="radio" name="repair_mode" value="all" checked onchange="toggleRepairInput(this.value)" style="margin-top: 0.25rem;">
                        <div>
                            <span style="font-weight: bold; color: #fff; display: block;">{{ $lang === 'id' ? 'Borongan (Selesaikan Semua)' : 'Bulk (Restore All)' }}</span>
                            <span style="font-size: 0.75rem; color: var(--text-muted);">{{ $lang === 'id' ? 'Pulihkan 100% inventaris ini sekaligus.' : 'Restore 100% of this inventory entirely.' }}</span>
                        </div>
                    </label>

                    <!-- Cicilan Option -->
                    <label style="flex: 1; display: flex; align-items: flex-start; gap: 0.5rem; cursor: pointer;">
                        <input type="radio" name="repair_mode" value="partial" onchange="toggleRepairInput(this.value)" style="margin-top: 0.25rem;">
                        <div>
                            <span style="font-weight: bold; color: #fff; display: block;">{{ $lang === 'id' ? 'Pilih Cicilan (Partial)' : 'Partial Select' }}</span>
                            <span style="font-size: 0.75rem; color: var(--text-muted);">{{ $lang === 'id' ? 'Pilih jumlah unit spesifik untuk dieksekusi.' : 'Select specific unit count to execute.' }}</span>
                        </div>
                    </label>
                </div>

                <div class="modal-form-group" id="repairAmountGroup" style="display: none;">
                    <label>{{ $lang === 'id' ? 'JUMLAH UNIT YANG DIPULIHKAN' : 'NUMBER OF UNITS TO RESTORE' }}</label>
                    <input type="number" name="jumlah" id="repairAmountInput" class="modal-input" min="1" placeholder="Ex: 2">
                    <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 0.5rem;" id="repairMaxHint"></div>
                </div>

                <button type="submit" style="width: 100%; background: var(--accent-cyan); color: #000; border: none; padding: 1rem; border-radius: 8px; font-weight: 900; letter-spacing: 0.1em; cursor: pointer; margin-top: 1rem; transition: 0.3s; text-transform: uppercase;">
                    + {{ $lang === 'id' ? 'LAKUKAN VAKSINASI STOK' : 'EXECUTE STOCK VACCINATION' }}
                </button>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function openRepairModal(inv) {
            let baseUrl = "{{ route('asisten.maintenance.repair', 'ID_PLACEHOLDER') }}";
            document.getElementById('repairForm').action = baseUrl.replace('ID_PLACEHOLDER', inv.id);
            
            // Set max hints
            document.getElementById('repairMaxHint').innerHTML = "Max stok rusak tersedia: <strong style='color:#ef4444'>" + inv.stok + " unit</strong>";
            document.getElementById('repairAmountInput').max = inv.stok;
            
            openModal('repairAssetModal');
        }

        function toggleRepairInput(val) {
            const group = document.getElementById('repairAmountGroup');
            const input = document.getElementById('repairAmountInput');
            if (val === 'partial') {
                group.style.display = 'block';
                input.required = true;
            } else {
                group.style.display = 'none';
                input.required = false;
                input.value = '';
            }
        }
    </script>
    @endpush
