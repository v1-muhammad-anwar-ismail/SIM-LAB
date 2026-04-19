    <div class="welcome-banner" style="margin-bottom: 2rem;">
        <div class="status-badge" style="background: rgba(0, 217, 255, 0.1); color: var(--accent-cyan); border-color: rgba(0, 217, 255, 0.3);">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
            {{ $lang === 'id' ? 'Konfigurasi Ruang' : 'Space Configuration' }}
        </div>
        <h1 class="welcome-title">{{ $lang === 'id' ? 'Direktori Laboratorium' : 'Laboratory Directory' }}</h1>
        <p class="welcome-subtitle">
            {{ $lang === 'id' ? 'Pemetaan tata ruang presisi, alokasi Master Lab, serta manajemen infrastruktur untuk keseluruhan ekosistem ruang kelas laborat.' : 'Precision topology mapping, Lab Master allocations, and infrastructure management for the entire laboratory classroom ecosystem.' }}
        </p>
    </div>

    <!-- Papan List Laboratorium -->
    <div style="background: rgba(10, 16, 22, 0.5); border: 1px solid var(--panel-border); border-radius: 1rem; padding: 1.5rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 1rem; flex-wrap: wrap; gap: 1rem;">
            <h3 style="font-size: 1.25rem; font-weight: 800; margin: 0;">{{ $lang === 'id' ? 'Stasiun Laboratorium Aktif' : 'Active Laboratory Stations' }}</h3>
            <button onclick="openModal('addLabModal')" class="mobile-full-btn" style="background: var(--accent-cyan); color: #000; border: none; padding: 0.6rem 1.2rem; border-radius: 0.5rem; font-weight: 800; text-transform: uppercase; cursor: pointer; transition: 0.3s; box-shadow: 0 0 15px rgba(0, 217, 255, 0.3);" onmouseover="this.style.background='#fff'; this.style.boxShadow='0 0 25px rgba(255,255,255,0.5)'" onmouseout="this.style.background='var(--accent-cyan)'; this.style.boxShadow='0 0 15px rgba(0, 217, 255, 0.3)'">
                + {{ $lang === 'id' ? 'BUKA LABORATORIUM BARU' : 'OPEN NEW LABORATORY' }}
            </button>
        </div>

        @if(isset($laboratoriesList) && $laboratoriesList->count() > 0)
            <div style="overflow-x: auto;">
                <table class="responsive-table" style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="border-bottom: 2px solid rgba(0,217,255,0.2); color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase;">
                            <th style="padding: 1rem;">{{ $lang === 'id' ? 'NAMA STASIUN / LAB' : 'STATION / LAB NAME' }}</th>
                            <th style="padding: 1rem;">{{ $lang === 'id' ? 'KEPALA LAB' : 'HEAD OF LAB' }}</th>
                            <th style="padding: 1rem;">{{ $lang === 'id' ? 'KAPASITAS ASET' : 'ASSET CAPACITY' }}</th>
                            <th style="padding: 1rem;">{{ $lang === 'id' ? 'FUNGSI UMUM' : 'GENERAL FUNCTION' }}</th>
                            <th style="padding: 1rem; text-align: center;">{{ $lang === 'id' ? 'AKSI' : 'ACTIONS' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($laboratoriesList as $lab)
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); transition: background 0.3s;" onmouseover="this.style.background='rgba(0,217,255,0.05)'" onmouseout="this.style.background='transparent'">
                            <td data-label="{{ $lang === 'id' ? 'NAMA STASIUN' : 'STATION NAME' }}" style="padding: 1rem; font-weight: 700; color: #fff; font-size: 1.05rem;">
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    @if($lab->fotos && is_array($lab->fotos) && count($lab->fotos) > 0)
                                        <div style="display: flex; align-items: center; cursor: pointer;" title="Lab Photos">
                                            @foreach(array_slice($lab->fotos, 0, 3) as $index => $foto)
                                                <img src="{{ \Illuminate\Support\Facades\Storage::url($foto) }}" alt="Foto Lab" style="width: 42px; height: 42px; border-radius: 8px; object-fit: cover; border: 1px solid rgba(0,217,255,0.4); box-shadow: 0 0 10px rgba(0,0,0,0.5); {{ $index > 0 ? 'margin-left: -20px;' : '' }}">
                                            @endforeach
                                            @if(count($lab->fotos) > 3)
                                                <div style="width: 42px; height: 42px; border-radius: 8px; background: rgba(0,217,255,0.15); border: 1px solid var(--accent-cyan); display: flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: bold; color: var(--accent-cyan); margin-left: -20px; z-index: 1; box-shadow: 0 0 10px rgba(0,0,0,0.5); backdrop-filter: blur(4px);">
                                                    +{{ count($lab->fotos) - 3 }}
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                    <div>{{ $lab->nama_lab }}</div>
                                </div>
                            </td>
                            <td data-label="{{ $lang === 'id' ? 'KEPALA LAB' : 'HEAD OF LAB' }}" style="padding: 1rem; color: #cbd5e1;">
                                @if($lab->master)
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <div style="width: 24px; height: 24px; border-radius: 50%; background: rgba(0,217,255,0.2); color: #00d9ff; display: flex; justify-content: center; align-items: center; font-size: 0.7rem; font-weight: bold;">
                                            {{ substr($lab->master->name, 0, 1) }}
                                        </div>
                                        <span>{{ $lab->master->name }}</span>
                                    </div>
                                @else
                                    <span style="color: #ef4444; font-style: italic;">{{ $lang === 'id' ? 'KOSONG / TANPA PENGAWAS' : 'VACANT / NO SUPERVISOR' }}</span>
                                @endif
                            </td>
                            <td data-label="{{ $lang === 'id' ? 'KAPASITAS ASET' : 'ASSET CAPACITY' }}" style="padding: 1rem;">
                                <span style="background: rgba(34, 197, 94, 0.1); color: #22c55e; border: 1px solid #22c55e; padding: 0.3rem 0.6rem; border-radius: 4px; font-size: 0.75rem; font-weight: bold; display: inline-block; white-space: nowrap;">{{ $lab->alat_count }} {{ $lang === 'id' ? 'ASET FISIK' : 'PHYSICAL ASSETS' }}</span>
                            </td>
                            <td data-label="{{ $lang === 'id' ? 'FUNGSI UMUM' : 'GENERAL FUNCTION' }}" style="padding: 1rem; color: var(--text-muted); font-size: 0.9rem; max-width: 250px;">
                                {{ $lab->deskripsi ?? '-' }}
                            </td>
                            <td data-label="{{ $lang === 'id' ? 'AKSI' : 'ACTIONS' }}" style="padding: 1rem; text-align: center;">
                                <div style="display: flex; gap: 0.5rem; justify-content: flex-start;">
                                    <button onclick="editModalLab({{ json_encode($lab) }})" style="background: transparent; color: #eab308; border: 1px solid #eab308; padding: 0.4rem; border-radius: 6px; cursor: pointer; transition: 0.3s;" onmouseover="this.style.background='#eab308'; this.style.color='#000'" onmouseout="this.style.background='transparent'; this.style.color='#eab308'" title="Konfigurasi">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"></path><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                    </button>
                                    <form action="{{ route('master.laboratories.destroy', $lab->id) }}" method="POST" onsubmit="confirmDestructiveAction(event, this, '{{ $lang }}', 'Destructive Warning: Shutting down this laboratory will permanently wipe its configuration structure. Continue?', 'Peringatan Sistem: Meniadakan laboratorium ini akan melenyapkan konfigurasi ruang. Anda yakin?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background: transparent; color: #ef4444; border: 1px solid #ef4444; padding: 0.4rem; border-radius: 6px; cursor: pointer; transition: 0.3s;" onmouseover="this.style.background='#ef4444'; this.style.color='#000'" onmouseout="this.style.background='transparent'; this.style.color='#ef4444'" title="Hancurkan Stasiun">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
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
                <p style="color: var(--text-muted); font-size: 0.95rem;">{{ $lang === 'id' ? 'Infrastruktur Laboratorium kosong. Silakan bangun stasiun baru.' : 'Laboratory infrastructure is void. Please construct a new station.' }}</p>
            </div>
        @endif
    </div>

    <!-- Modal Tambah Lab -->
    <div id="addLabModal" class="custom-modal">
        <div class="modal-content">
            <svg class="modal-close" onclick="closeModal('addLabModal')" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            <h2 style="color: var(--accent-cyan); font-weight: 800; margin-top: 0; margin-bottom: 1.5rem;">{{ $lang === 'id' ? 'BUKA LAB BARU' : 'OPEN NEW LAB' }}</h2>
            <form action="{{ route('master.laboratories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-form-group">
                    <label>{{ $lang === 'id' ? 'NAMA LABORATORIUM' : 'LABORATORY NAME' }}</label>
                    <input type="text" name="nama_lab" class="modal-input" required placeholder="{{ $lang === 'id' ? 'Contoh: Lab Komputer Jaringan 1' : 'Example: Network Computer Lab 1' }}">
                </div>
                <div class="modal-form-group">
                    <label>{{ $lang === 'id' ? 'PERAN PENGAWAS (MASTER LAB)' : 'SUPERVISOR ROLE (LAB MASTER)' }}</label>
                    <select name="master_id" class="modal-select">
                        <option value="">{{ $lang === 'id' ? 'Kosongkan / Belum Ada' : 'Leave Vacant / Not Available' }}</option>
                        @foreach($listMasters as $m)
                            <option value="{{ $m->id }}">{{ $m->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-form-group">
                    <label>{{ $lang === 'id' ? 'DESKRIPSI FUNGSI RUANG' : 'ROOM FUNCTION DESCRIPTION' }}</label>
                    <textarea name="deskripsi" class="modal-input" rows="3" placeholder="{{ $lang === 'id' ? 'Deskripsikan tujuan operasional harian laboratorium ini...' : 'Describe the daily operational objectives of this laboratory...' }}" style="resize: vertical;"></textarea>
                </div>
                <div class="modal-form-group">
                    <label>{{ $lang === 'id' ? 'UNGGAH FOTO LAB (MULITPLE)' : 'UPLOAD LAB PHOTOS (MULTIPLE)' }}</label>
                    <div id="addLabGalleryPreview" style="margin-top: 0.5rem; display: flex; gap: 10px; flex-wrap: wrap;"></div>
                    <input type="file" id="addLabFotosInput" name="fotos[]" multiple accept="image/*" style="display: none;">
                </div>
                <button type="submit" style="width: 100%; background: var(--accent-cyan); color: #000; border: none; padding: 1rem; border-radius: 8px; font-weight: 900; letter-spacing: 0.1em; cursor: pointer; margin-top: 1rem; transition: 0.3s;" onmouseover="this.style.boxShadow='0 0 20px rgba(0, 217, 255, 0.5)'" onmouseout="this.style.boxShadow='none'">
                    {{ $lang === 'id' ? 'BANGUN LABORATORIUM' : 'CONSTRUCT LABORATORY' }}
                </button>
            </form>
        </div>
    </div>

    <!-- Modal Edit Lab -->
    <div id="editLabModal" class="custom-modal">
        <div class="modal-content" style="border-color: #0ea5e9;">
            <svg class="modal-close" onclick="closeModal('editLabModal')" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            <h2 style="color: #0ea5e9; font-weight: 800; margin-top: 0; margin-bottom: 1.5rem;">{{ $lang === 'id' ? 'KONFIGURASI STASIUN LAB' : 'LAB STATION CONFIGURATION' }}</h2>
            <form id="editLabForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-form-group">
                    <label>{{ $lang === 'id' ? 'NAMA LABORATORIUM' : 'LABORATORY NAME' }}</label>
                    <input type="text" name="nama_lab" id="edit_lab_nama" class="modal-input" required>
                </div>
                <div class="modal-form-group">
                    <label>{{ $lang === 'id' ? 'PERAN PENGAWAS (MASTER LAB)' : 'SUPERVISOR ROLE (LAB MASTER)' }}</label>
                    <select name="master_id" id="edit_lab_master" class="modal-select">
                        <option value="">{{ $lang === 'id' ? '-- Kosongkan / Cabut Akses --' : '-- Leave Vacant / Revoke Access --' }}</option>
                        @foreach($listMasters as $m)
                            <option value="{{ $m->id }}">{{ $m->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-form-group">
                    <label>{{ $lang === 'id' ? 'DESKRIPSI FUNGSI RUANG' : 'ROOM FUNCTION DESCRIPTION' }}</label>
                    <textarea name="deskripsi" id="edit_lab_desc" class="modal-input" rows="3" style="resize: vertical;"></textarea>
                </div>
                <div class="modal-form-group">
                    <label>{{ $lang === 'id' ? 'UNGGAH FOTO BARU (TIMPA PENUH)' : 'UPLOAD NEW PHOTOS (FULL REPLACE)' }}</label>
                    <div style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.5rem;">{{ $lang === 'id' ? '*Kosongkan jika tidak ingin mengubah kumpulan foto lama.' : '*Leave empty to keep old photos.' }}</div>
                    <div id="editLabGalleryPreview" style="display: flex; gap: 10px; flex-wrap: wrap;"></div>
                    <input type="file" id="editLabFotosInput" name="fotos[]" multiple accept="image/*" style="display: none;">
                </div>
                <button type="submit" style="width: 100%; background: #0ea5e9; color: #000; border: none; padding: 1rem; border-radius: 8px; font-weight: 900; letter-spacing: 0.1em; cursor: pointer; margin-top: 1rem; transition: 0.3s;" onmouseover="this.style.boxShadow='0 0 20px rgba(14, 165, 233, 0.5)'" onmouseout="this.style.boxShadow='none'">
                    {{ $lang === 'id' ? 'SUNTIKKAN PEMBARUAN' : 'INJECT UPDATES' }}
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
            
            return function clearGallery() {
                dt = new DataTransfer();
                render();
            };
        }

        const clearAddLab = initModernGallery('addLabFotosInput', 'addLabGalleryPreview');
        const clearEditLab = initModernGallery('editLabFotosInput', 'editLabGalleryPreview');

        function editModalLab(data) {
            document.getElementById('edit_lab_nama').value = data.nama_lab;
            document.getElementById('edit_lab_master').value = data.master_id || '';
            document.getElementById('edit_lab_desc').value = data.deskripsi || '';
            document.getElementById('editLabForm').action = '/master/dashboard/laboratories/' + data.id;
            clearEditLab();
            openModal('editLabModal');
        }
    </script>
    @endpush
