    <div class="welcome-banner" style="margin-bottom: 2rem;">
        <div class="status-badge" style="background: rgba(0, 217, 255, 0.1); color: var(--accent-cyan); border-color: rgba(0, 217, 255, 0.3);">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 16V7a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v9m16 0H4m16 0 1.28 2.55a1 1 0 0 1-.9 1.45H3.62a1 1 0 0 1-.9-1.45L4 16"></path></svg>
            {{ $lang === 'id' ? 'Manajemen Aset Fisik' : 'Physical Asset Management' }}
        </div>
        <h1 class="welcome-title">{{ $lang === 'id' ? 'Gudang Inventaris' : 'Inventory Warehouse' }}</h1>
        <p class="welcome-subtitle">
            {{ $lang === 'id' ? 'Pusat integrasi visual dari kapasitas perangkat fisik, logistik, dan bahan habis pakai di seluruh laboratorium.' : 'Visual integration hub for physical equipment capacity, logistics, and consumables across all laboratories.' }}
        </p>
    </div>

    <!-- Metriks Aset -->
    <div class="dashboard-grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); margin-bottom: 2rem;">
        <div class="stat-card" style="border-top: 3px solid #00d9ff;">
            <div class="stat-header">
                <span style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">{{ $lang === 'id' ? 'Total Stok Keseluruhan' : 'Total Global Stock' }}</span>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#00d9ff" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
            </div>
            <div class="stat-value" style="color: #00d9ff;">{{ $totAlat ?? 0 }}</div>
        </div>
        <div class="stat-card" style="border-top: 3px solid #22c55e;">
            <div class="stat-header">
                <span style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">{{ $lang === 'id' ? 'Aset Layak Pakai' : 'Usable Assets' }}</span>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            </div>
            <div class="stat-value" style="color: #22c55e;">{{ $totBaik ?? 0 }}</div>
        </div>
        <div class="stat-card" style="border-top: 3px solid #ef4444;">
            <div class="stat-header">
                <span style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">{{ $lang === 'id' ? 'Aset Kritis/Rusak' : 'Critical/Broken Assets' }}</span>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
            </div>
            <div class="stat-value" style="color: #ef4444;">{{ $totRusak ?? 0 }}</div>
        </div>
    </div>

    <!-- Papan Tabel Utama -->
    <div style="background: rgba(10, 16, 22, 0.5); border: 1px solid var(--panel-border); border-radius: 1rem; padding: 1.5rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 1rem; flex-wrap: wrap; gap: 1rem;">
            <h3 style="font-size: 1.25rem; font-weight: 800; margin: 0;">{{ $lang === 'id' ? 'Katalog Peralatan Lab' : 'Lab Equipment Catalog' }}</h3>
            <button onclick="openModal('addAlatModal')" class="mobile-full-btn" style="background: var(--accent-cyan); color: #000; border: none; padding: 0.6rem 1.2rem; border-radius: 0.5rem; font-weight: 800; text-transform: uppercase; cursor: pointer; transition: 0.3s; box-shadow: 0 0 15px rgba(0, 217, 255, 0.3);" onmouseover="this.style.background='#fff'; this.style.boxShadow='0 0 25px rgba(255,255,255,0.5)'" onmouseout="this.style.background='var(--accent-cyan)'; this.style.boxShadow='0 0 15px rgba(0, 217, 255, 0.3)'">
                + {{ $lang === 'id' ? 'TAMBAH ASET BARU' : 'ADD NEW ASSET' }}
            </button>
        </div>

        @if(isset($inventoryList) && $inventoryList->count() > 0)
            <div style="overflow-x: auto;">
                <table class="responsive-table" style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="border-bottom: 2px solid rgba(0,217,255,0.2); color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase;">
                            <th style="padding: 1rem;">{{ $lang === 'id' ? 'KODE' : 'CODE' }}</th>
                            <th style="padding: 1rem;">{{ $lang === 'id' ? 'NAMA ASET' : 'ASSET NAME' }}</th>
                            <th style="padding: 1rem;">{{ $lang === 'id' ? 'LOKASI LAB' : 'LAB LOCATION' }}</th>
                            <th style="padding: 1rem;">{{ $lang === 'id' ? 'STOK' : 'STOCK' }}</th>
                            <th style="padding: 1rem;">{{ $lang === 'id' ? 'KONDISI' : 'CONDITION' }}</th>
                            <th style="padding: 1rem; text-align: center;">{{ $lang === 'id' ? 'AKSI' : 'ACTIONS' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inventoryList as $inv)
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); transition: background 0.3s;" onmouseover="this.style.background='rgba(0,217,255,0.05)'" onmouseout="this.style.background='transparent'">
                            <td data-label="{{ $lang === 'id' ? 'KODE' : 'CODE' }}" style="padding: 1rem; font-family: monospace; color: var(--accent-cyan); font-weight: bold;">{{ $inv->kode_alat }}</td>
                            <td data-label="{{ $lang === 'id' ? 'NAMA ASET' : 'ASSET NAME' }}" style="padding: 1rem; font-weight: 600; color: #fff;">
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    @if($inv->fotos && is_array($inv->fotos) && count($inv->fotos) > 0)
                                        <div style="display: flex; align-items: center; cursor: pointer;" title="Asset Photos">
                                            @foreach(array_slice($inv->fotos, 0, 3) as $index => $foto)
                                                <img src="{{ \Illuminate\Support\Facades\Storage::url($foto) }}" alt="Foto" style="width: 38px; height: 38px; border-radius: 6px; object-fit: cover; border: 1px solid rgba(0,217,255,0.4); box-shadow: 0 0 10px rgba(0,0,0,0.5); {{ $index > 0 ? 'margin-left: -18px;' : '' }}">
                                            @endforeach
                                            @if(count($inv->fotos) > 3)
                                                <div style="width: 38px; height: 38px; border-radius: 6px; background: rgba(0,217,255,0.15); border: 1px solid var(--accent-cyan); display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: bold; color: var(--accent-cyan); margin-left: -18px; z-index: 1; box-shadow: 0 0 10px rgba(0,0,0,0.5); backdrop-filter: blur(4px);">
                                                    +{{ count($inv->fotos) - 3 }}
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                    <div>
                                        {{ $inv->nama_alat }}<br>
                                        <span style="font-size: 0.75rem; color: var(--text-muted);">{{ $inv->jenis_aset === 'lab' ? ($lang === 'id' ? 'Aset Universitas (Umum)' : 'University Asset (General)') : ($lang === 'id' ? 'Milik Pribadi Dosen (Khusus)' : 'Lecturer Personal Asset (Specific)') }}</span>
                                    </div>
                                </div>
                            </td>
                            <td data-label="{{ $lang === 'id' ? 'LOKASI LAB' : 'LAB LOCATION' }}" style="padding: 1rem; color: #cbd5e1;">{{ $inv->laboratorium->nama_lab ?? 'Non-Spesifik' }}</td>
                            <td data-label="{{ $lang === 'id' ? 'STOK' : 'STOCK' }}" style="padding: 1rem; font-weight: bold; font-size: 1.1rem;">{{ $inv->stok }}</td>
                            <td data-label="{{ $lang === 'id' ? 'KONDISI' : 'CONDITION' }}" style="padding: 1rem;">
                                @if($inv->kondisi === 'baik')
                                    <span style="background: rgba(34, 197, 94, 0.1); color: #22c55e; border: 1px solid #22c55e; padding: 0.3rem 0.6rem; border-radius: 4px; font-size: 0.75rem; font-weight: bold; text-transform: uppercase;">{{ $lang === 'id' ? 'BAIK' : 'GOOD' }}</span>
                                @elseif($inv->kondisi === 'perbaikan')
                                    <span style="background: rgba(234, 179, 8, 0.1); color: #eab308; border: 1px solid #eab308; padding: 0.3rem 0.6rem; border-radius: 4px; font-size: 0.75rem; font-weight: bold; text-transform: uppercase;">{{ $lang === 'id' ? 'PERBAIKAN' : 'MAINTENANCE' }}</span>
                                @else
                                    <span style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid #ef4444; padding: 0.3rem 0.6rem; border-radius: 4px; font-size: 0.75rem; font-weight: bold; text-transform: uppercase;">{{ $lang === 'id' ? 'RUSAK' : 'BROKEN' }}</span>
                                @endif
                            </td>
                            <td data-label="{{ $lang === 'id' ? 'AKSI' : 'ACTIONS' }}" style="padding: 1rem; text-align: center;">
                                <div style="display: flex; gap: 0.5rem; justify-content: flex-start;">
                                    <button onclick="editModal({{ json_encode($inv) }})" style="background: transparent; color: #eab308; border: 1px solid #eab308; padding: 0.4rem; border-radius: 6px; cursor: pointer; transition: 0.3s;" onmouseover="this.style.background='#eab308'; this.style.color='#000'" onmouseout="this.style.background='transparent'; this.style.color='#eab308'" title="Edit">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                    </button>
                                    <form action="{{ route('master.inventory.destroy', $inv->id) }}" method="POST" onsubmit="confirmDestructiveAction(event, this, '{{ $lang }}', 'Destructive Warning: Are you sure you want to eradicate this asset?', 'Peringatan Destruktif: Apakah Anda yakin melenyapkan aset ini selamanya?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background: transparent; color: #ef4444; border: 1px solid #ef4444; padding: 0.4rem; border-radius: 6px; cursor: pointer; transition: 0.3s;" onmouseover="this.style.background='#ef4444'; this.style.color='#000'" onmouseout="this.style.background='transparent'; this.style.color='#ef4444'" title="Delete">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align: center; padding: 4rem 1rem;">
                <p style="color: var(--text-muted); font-size: 0.95rem;">{{ $lang === 'id' ? 'Sistem belum merekam satupun data aset gudang.' : 'The system has not recorded any warehouse asset data yet.' }}</p>
            </div>
        @endif
    </div>

    <!-- Modals untuk CRUD Alat -->
    <!-- Modal Tambah -->
    <div id="addAlatModal" class="custom-modal">
        <div class="modal-content">
            <svg class="modal-close" onclick="closeModal('addAlatModal')" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            <h2 style="color: var(--accent-cyan); font-weight: 800; margin-top: 0; margin-bottom: 1.5rem;">{{ $lang === 'id' ? 'REGISTRASI ASET BARU' : 'REGISTER NEW ASSET' }}</h2>
            <form action="{{ route('master.inventory.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-form-group">
                    <label>{{ $lang === 'id' ? 'KODE ALAT' : 'ASSET CODE' }}</label>
                    <input type="text" name="kode_alat" class="modal-input" required placeholder="{{ $lang === 'id' ? 'Contoh: CMP-001' : 'Example: CMP-001' }}">
                </div>
                <div class="modal-form-group">
                    <label>{{ $lang === 'id' ? 'NAMA ASET' : 'ASSET NAME' }}</label>
                    <input type="text" name="nama_alat" class="modal-input" required placeholder="{{ $lang === 'id' ? 'Contoh: Mikroskop Binokuler' : 'Example: Binocular Microscope' }}">
                </div>
                <div class="modal-form-group">
                    <label>{{ $lang === 'id' ? 'LOKASI PENEMPATAN (LAB)' : 'PLACEMENT LOCATION (LAB)' }}</label>
                    <select name="laboratorium_id" class="modal-select">
                        <option value="">{{ $lang === 'id' ? 'Aset Publik (Tanpa Spesifikasi Lab)' : 'Public Asset (No Lab Specs)' }}</option>
                        @foreach($laboratoriums as $lab)
                            <option value="{{ $lab->id }}">{{ $lab->nama_lab }}</option>
                        @endforeach
                    </select>
                </div>
                    <div class="modal-form-group">
                        <label>{{ $lang === 'id' ? 'JENIS ASET' : 'ASSET TYPE' }}</label>
                        <select name="jenis_aset" class="modal-select" required>
                            <option value="lab">{{ $lang === 'id' ? 'Aset Universitas (Umum)' : 'University Asset (General)' }}</option>
                            <option value="pribadi">{{ $lang === 'id' ? 'Milik Pribadi Dosen (Khusus)' : 'Lecturer Personal Asset (Specific)' }}</option>
                        </select>
                    </div>
                    <div class="modal-form-group">
                        <label>{{ $lang === 'id' ? 'KONDISI TERKINI' : 'CURRENT CONDITION' }}</label>
                        <select name="kondisi" class="modal-select" required>
                            <option value="baik">{{ $lang === 'id' ? 'BAIK' : 'GOOD' }}</option>
                            <option value="rusak">{{ $lang === 'id' ? 'RUSAK' : 'BROKEN' }}</option>
                        </select>
                    </div>
                <div class="modal-form-group">
                    <label>{{ $lang === 'id' ? 'KUANTITAS STOK' : 'STOCK QUANTITY' }}</label>
                    <input type="number" name="stok" class="modal-input" required min="1" value="1">
                </div>
                <div class="modal-form-group">
                    <label>{{ $lang === 'id' ? 'UNGGAH FOTO ASET (BISA LEBIH DARI SATU)' : 'UPLOAD ASSET PHOTOS (MULTIPLE ALLOWED)' }}</label>
                    <div id="addAlatGalleryPreview" style="margin-top: 0.5rem; display: flex; gap: 10px; flex-wrap: wrap;"></div>
                    <input type="file" id="addAlatFotosInput" name="fotos[]" multiple accept="image/*" style="display: none;">
                </div>
                <button type="submit" style="width: 100%; background: var(--accent-cyan); color: #000; border: none; padding: 1rem; border-radius: 8px; font-weight: 900; letter-spacing: 0.1em; cursor: pointer; margin-top: 1rem; transition: 0.3s;" onmouseover="this.style.boxShadow='0 0 20px rgba(0, 217, 255, 0.5)'" onmouseout="this.style.boxShadow='none'">
                    {{ $lang === 'id' ? 'SIMPAN KE DATABASE' : 'SAVE TO DATABASE' }}
                </button>
            </form>
        </div>
    </div>

    <!-- Modal Edit -->
    <div id="editAlatModal" class="custom-modal">
        <div class="modal-content" style="border-color: #0ea5e9;">
            <svg class="modal-close" onclick="closeModal('editAlatModal')" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            <h2 style="color: #0ea5e9; font-weight: 800; margin-top: 0; margin-bottom: 1.5rem;">{{ $lang === 'id' ? 'PERBARUI DATA ASET' : 'UPDATE ASSET DATA' }}</h2>
            <form id="editAlatForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-form-group">
                    <label>{{ $lang === 'id' ? 'KODE ALAT' : 'ASSET CODE' }}</label>
                    <input type="text" name="kode_alat" id="edit_kode_alat" class="modal-input" required>
                </div>
                <div class="modal-form-group">
                    <label>{{ $lang === 'id' ? 'NAMA ASET' : 'ASSET NAME' }}</label>
                    <input type="text" name="nama_alat" id="edit_nama_alat" class="modal-input" required>
                </div>
                <div class="modal-form-group">
                    <label>{{ $lang === 'id' ? 'LOKASI PENEMPATAN (LAB)' : 'PLACEMENT LOCATION (LAB)' }}</label>
                    <select name="laboratorium_id" id="edit_lab_id" class="modal-select">
                        <option value="">{{ $lang === 'id' ? 'Aset Publik (Tanpa Spesifikasi Lab)' : 'Public Asset (No Lab Specs)' }}</option>
                        @foreach($laboratoriums as $lab)
                            <option value="{{ $lab->id }}">{{ $lab->nama_lab }}</option>
                        @endforeach
                    </select>
                </div>
                    <div class="modal-form-group">
                        <label>{{ $lang === 'id' ? 'JENIS ASET' : 'ASSET TYPE' }}</label>
                        <select name="jenis_aset" id="edit_jenis_aset" class="modal-select" required>
                            <option value="lab">{{ $lang === 'id' ? 'Aset Universitas (Umum)' : 'University Asset (General)' }}</option>
                            <option value="pribadi">{{ $lang === 'id' ? 'Milik Pribadi Dosen (Khusus)' : 'Lecturer Personal Asset (Specific)' }}</option>
                        </select>
                    </div>
                    <div class="modal-form-group">
                        <label>{{ $lang === 'id' ? 'KONDISI TERKINI' : 'CURRENT CONDITION' }}</label>
                        <select name="kondisi" id="edit_kondisi" class="modal-select" required>
                            <option value="baik">{{ $lang === 'id' ? 'BAIK' : 'GOOD' }}</option>
                            <option value="rusak">{{ $lang === 'id' ? 'RUSAK' : 'BROKEN' }}</option>
                        </select>
                    </div>
                <div class="modal-form-group">
                    <label>{{ $lang === 'id' ? 'KUANTITAS STOK' : 'STOCK QUANTITY' }}</label>
                    <input type="number" name="stok" id="edit_stok" class="modal-input" required min="0">
                </div>
                <div class="modal-form-group">
                    <label>{{ $lang === 'id' ? 'UNGGAH FOTO BARU (TIMPA PENUH)' : 'UPLOAD NEW PHOTOS (FULL REPLACE)' }}</label>
                    <div style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.5rem;">{{ $lang === 'id' ? '*Kosongkan jika tidak ingin mengubah kumpulan foto lama.' : '*Leave empty to keep old photos.' }}</div>
                    <div id="editAlatGalleryPreview" style="display: flex; gap: 10px; flex-wrap: wrap;"></div>
                    <input type="file" id="editAlatFotosInput" name="fotos[]" multiple accept="image/*" style="display: none;">
                </div>
                <button type="submit" style="width: 100%; background: #0ea5e9; color: #000; border: none; padding: 1rem; border-radius: 8px; font-weight: 900; letter-spacing: 0.1em; cursor: pointer; margin-top: 1rem; transition: 0.3s;" onmouseover="this.style.boxShadow='0 0 20px rgba(14, 165, 233, 0.5)'" onmouseout="this.style.boxShadow='none'">
                    {{ $lang === 'id' ? 'SIMPAN PEMBARUAN' : 'SAVE UPDATES' }}
                </button>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function initModernGallery(inputId, previewBoxId) {
            const input = document.getElementById(inputId);
            const container = document.getElementById(previewBoxId);
            let dt = new DataTransfer();

            const addBtn = document.createElement('div');
            addBtn.innerHTML = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>';
            addBtn.style.cssText = 'width: 80px; height: 80px; border: 2px dashed var(--accent-cyan); border-radius: 8px; display: flex; justify-content: center; align-items: center; cursor: pointer; color: var(--accent-cyan); background: rgba(0, 217, 255, 0.05); transition: 0.3s; flex-shrink: 0;';
            addBtn.onmouseover = () => addBtn.style.background = 'rgba(0, 217, 255, 0.2)';
            addBtn.onmouseout = () => addBtn.style.background = 'rgba(0, 217, 255, 0.05)';
            addBtn.onclick = () => input.click();
            
            container.appendChild(addBtn);

            input.addEventListener('change', function(e) {
                for (let i = 0; i < this.files.length; i++) {
                    dt.items.add(this.files[i]);
                }
                render();
            });

            function render() {
                container.innerHTML = '';
                for (let i = 0; i < dt.files.length; i++) {
                    const file = dt.files[i];
                    const reader = new FileReader();
                    
                    const wrap = document.createElement('div');
                    wrap.style.cssText = 'width: 80px; height: 80px; border-radius: 8px; overflow: hidden; position: relative; border: 1px solid var(--panel-border); background: #000; flex-shrink: 0;';
                    
                    const img = document.createElement('img');
                    img.style.cssText = 'width: 100%; height: 100%; object-fit: cover; opacity: 0.8;';
                    
                    const rm = document.createElement('div');
                    rm.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>';
                    rm.style.cssText = 'position: absolute; top: 4px; right: 4px; background: rgba(239, 68, 68, 0.9); color: white; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.2s;';
                    rm.onclick = () => {
                         let newDt = new DataTransfer();
                         for(let j=0; j<dt.files.length; j++) if(j !== i) newDt.items.add(dt.files[j]);
                         dt = newDt;
                         render();
                    };

                    reader.onload = (e) => img.src = e.target.result;
                    reader.readAsDataURL(file);

                    wrap.appendChild(img);
                    wrap.appendChild(rm);
                    container.appendChild(wrap);
                }
                container.appendChild(addBtn);
                input.files = dt.files;
            }
            
            // Expose clear function
            return function clearGallery() {
                dt = new DataTransfer();
                render();
            };
        }

        const clearAddAlat = initModernGallery('addAlatFotosInput', 'addAlatGalleryPreview');
        const clearEditAlat = initModernGallery('editAlatFotosInput', 'editAlatGalleryPreview');

        function editModal(data) {
            document.getElementById('edit_kode_alat').value = data.kode_alat;
            document.getElementById('edit_nama_alat').value = data.nama_alat;
            document.getElementById('edit_lab_id').value = data.laboratorium_id || '';
            document.getElementById('edit_jenis_aset').value = data.jenis_aset;
            document.getElementById('edit_kondisi').value = data.kondisi;
            document.getElementById('edit_stok').value = data.stok;
            
            // Set action URL dinamis
            document.getElementById('editAlatForm').action = '/master/dashboard/inventory/' + data.id;
            clearEditAlat(); // Reset thumbnails
            openModal('editAlatModal');
        }
    </script>
    @endpush
