<style>
    .admin-form-box {
        background: rgba(10, 16, 22, 0.7);
        border: 1px solid var(--panel-border);
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
        position: relative;
    }
    
    .admin-form-box::before {
        content: '';
        position: absolute;
        top: 0; left: 0; bottom: 0; width: 4px;
        background: var(--accent-cyan);
        border-radius: 12px 0 0 12px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .admin-input {
        background: rgba(0, 0, 0, 0.5);
        border: 1px solid rgba(255,255,255,0.1);
        color: #fff;
        padding: 0.8rem;
        border-radius: 6px;
        width: 100%;
        box-sizing: border-box;
        font-family: inherit;
        transition: border-color 0.3s;
    }

    .admin-input:focus {
        outline: none;
        border-color: var(--accent-cyan);
        box-shadow: 0 0 10px rgba(0,217,255,0.1);
    }

    .admin-btn {
        background: rgba(0, 217, 255, 0.1);
        border: 1px solid var(--accent-cyan);
        color: var(--accent-cyan);
        padding: 0.8rem 1.5rem;
        font-weight: 800;
        text-transform: uppercase;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .admin-btn:hover {
        background: var(--accent-cyan);
        color: #000;
        box-shadow: 0 0 15px rgba(0,217,255,0.3);
    }

    .table-container {
        background: rgba(10, 16, 22, 0.7);
        border: 1px solid var(--panel-border);
        border-radius: 12px;
        overflow-x: auto;
        margin-bottom: 3rem; /* Memberi nafas pada ujung layar */
    }

    .cyber-table {
        width: 100%;
        border-collapse: collapse;
        color: var(--text-light);
        font-size: 0.9rem;
    }

    .cyber-table th {
        background: rgba(0, 0, 0, 0.6);
        padding: 1rem;
        text-align: left;
        font-weight: 800;
        color: var(--text-muted);
        border-bottom: 1px solid rgba(255,255,255,0.05);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-size: 0.8rem;
    }

    .cyber-table td {
        padding: 1rem;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        vertical-align: middle;
    }

    .cyber-table tr:hover td {
        background: rgba(0, 217, 255, 0.02);
    }

    .role-tag {
        display: inline-block;
        padding: 0.3rem 0.6rem;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
    }

    .action-btn-group {
        display: flex;
        flex-direction: column;
        gap: 0.6rem;
    }

    .btn-swap {
        background: rgba(0, 217, 255, 0.1);
        border: 1px solid rgba(0, 217, 255, 0.4);
        color: var(--accent-cyan);
        padding: 0.6rem 0.8rem;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.75rem;
        font-weight: bold;
        transition: all 0.2s;
        width: 100%;
        text-align: center;
    }
    .btn-swap:hover { background: rgba(0, 217, 255, 0.2); box-shadow: 0 0 10px rgba(0,217,255,0.3); }

    .btn-delete {
        background: rgba(0, 217, 255, 0.05);
        border: 1px solid rgba(0, 217, 255, 0.2);
        color: var(--accent-cyan);
        padding: 0.6rem 0.8rem;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.75rem;
        font-weight: bold;
        transition: all 0.2s;
        width: 100%;
        text-align: center;
    }
    .btn-delete:hover { background: rgba(239, 68, 68, 0.2); border-color: #ef4444; color: #ef4444; box-shadow: 0 0 10px rgba(239, 68, 68, 0.3); }

    .btn-delete:hover { background: rgba(239, 68, 68, 0.2); border-color: #ef4444; color: #ef4444; box-shadow: 0 0 10px rgba(239, 68, 68, 0.3); }

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
        max-width: 420px;
        box-shadow: 0 0 30px rgba(0, 217, 255, 0.15);
        position: relative;
    }

    @keyframes cyberFadeIn {
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1); }
    }
</style>

<div style="margin-bottom: 2rem;">
    <h2 style="margin: 0; color: #fff; font-weight: 900; text-transform: uppercase;">{{ $lang === 'id' ? 'Manajemen Populasi Entitas' : 'Entity Population Management' }}</h2>
    <p style="color: var(--text-muted); font-size: 0.9rem;">{{ $lang === 'id' ? 'Panel Otoritas untuk menambah pengguna atau menata ulang hierarki jabatan dalam sistem.' : 'Authority panel to add users or restructure hierarchy in the system.' }}</p>
</div>

<!-- FORM INKUBASI USER BARU -->
<div class="admin-form-box">
    <h3 style="margin-top: 0; color: var(--accent-cyan); font-weight: 800;">{{ $lang === 'id' ? '+ INKUBASI PENGGUNA BARU' : '+ INCUBATE NEW USER' }}</h3>
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="form-grid">
            <div>
                <label style="display:block; margin-bottom: 0.5rem; font-size: 0.8rem; font-weight: bold; color: var(--text-muted);">{{ $lang === 'id' ? 'Nama Lengkap' : 'Full Name' }} <span style="color:#ef4444">*</span></label>
                <input type="text" name="name" class="admin-input" required>
            </div>
            <div>
                <label style="display:block; margin-bottom: 0.5rem; font-size: 0.8rem; font-weight: bold; color: var(--text-muted);">{{ $lang === 'id' ? 'Alamat Email' : 'Email Address' }} <span style="color:#ef4444">*</span></label>
                <input type="email" name="email" class="admin-input" required>
            </div>
            <div>
                <label style="display:block; margin-bottom: 0.5rem; font-size: 0.8rem; font-weight: bold; color: var(--text-muted);">{{ $lang === 'id' ? 'NIM / NIP' : 'ID Number' }}</label>
                <input type="text" name="nomor_induk" class="admin-input">
            </div>
        </div>
        <div class="form-grid">
            <div>
                <label style="display:block; margin-bottom: 0.5rem; font-size: 0.8rem; font-weight: bold; color: var(--text-muted);">{{ $lang === 'id' ? 'Kata Sandi' : 'Password' }} <span style="color:#ef4444">*</span></label>
                <div style="position: relative; display: flex; align-items: center;">
                    <input type="password" id="incubatePassword" name="password" class="admin-input" minlength="8" required style="padding-right: 40px; box-sizing: border-box;">
                    <div onclick="toggleIncubatePassword()" style="position: absolute; right: 10px; cursor: pointer; color: var(--text-muted); display: flex; align-items: center; justify-content: center; height: 100%; transition: color 0.3s;" onmouseover="this.style.color='var(--accent-cyan)'" onmouseout="this.style.color='var(--text-muted)'">
                        <svg id="eyeIconIncubate" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </div>
                </div>
            </div>
            <div>
                <label style="display:block; margin-bottom: 0.5rem; font-size: 0.8rem; font-weight: bold; color: var(--text-muted);">{{ $lang === 'id' ? 'Otoritas (Role)' : 'Authority Role' }} <span style="color:#ef4444">*</span></label>
                <select name="role" class="admin-input" required onchange="toggleIncubateLab(this.value)">
                    <option value="mahasiswa">MAHASISWA (Student)</option>
                    <option value="asisten">ASISTEN LAB (Lab Assistant)</option>
                    <option value="master">MASTER LAB (Lab Head)</option>
                    <option value="dosen">DOSEN (Lecturer)</option>
                    <option value="admin">ADMIN SISTEM (Super Admin)</option>
                </select>
                <div id="incubateLabWrapper" style="display: none; margin-top: 1rem; padding-top: 1rem; border-top: 1px dashed rgba(255,255,255,0.1);">
                    <label style="display:block; margin-bottom: 0.5rem; font-size: 0.8rem; font-weight: bold; color: var(--accent-cyan);">{{ $lang === 'id' ? 'Alokasi Laboratorium Terikat' : 'Linked Laboratory' }} <span style="color:#ef4444">*</span></label>
                    <select name="laboratorium_id" id="incubateLabSelect" class="admin-input" style="border-color: var(--accent-cyan);">
                        <option value="">-- {{ $lang === 'id' ? 'Pilih Domain Ruang Laboratorium' : 'Select Domain' }} --</option>
                        @foreach($laboratoriums as $lab)
                            <option value="{{ $lab->id }}">{{ $lab->nama_lab }}</option>
                        @endforeach
                    </select>
                    <div style="font-size: 0.7rem; color: var(--text-muted); margin-top: 6px;">{{ $lang === 'id' ? '*Wajib untuk menjaga agar dashboard Aslab/Master tidak corrupt.' : '*Required for Master & Aslab dashboard.' }}</div>
                </div>
            </div>
        </div>
        <div style="text-align: right; margin-top: 1rem;">
            <button type="submit" class="admin-btn">{{ $lang === 'id' ? 'EKSEKUSI PENDAFTARAN' : 'EXECUTE REGISTRATION' }}</button>
        </div>
    </form>
</div>

<script>
    function toggleIncubatePassword() {
        const input = document.getElementById('incubatePassword');
        const icon = document.getElementById('eyeIconIncubate');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
        } else {
            input.type = 'password';
            icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
        }
    }

    function toggleIncubateLab(role) {
        document.getElementById('incubateLabWrapper').style.display = ['asisten', 'master'].includes(role) ? 'block' : 'none';
        document.getElementById('incubateLabSelect').required = ['asisten', 'master'].includes(role);
    }
</script>

<!-- TABEL MATRIKS POPULASI -->
<div class="table-container">
    <table class="cyber-table responsive-table">
        <thead>
            <tr>
                <th>UID</th>
                <th>{{ $lang === 'id' ? 'Identitas' : 'Identity' }}</th>
                <th>{{ $lang === 'id' ? 'Kontak' : 'Contact' }}</th>
                <th>{{ $lang === 'id' ? 'Hierarki Role' : 'Role Hierarchy' }}</th>
                <th style="min-width: 150px; text-align: right;">{{ $lang === 'id' ? 'Aksi Berbahaya' : 'Danger Actions' }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usersList as $usr)
                <tr>
                    <td data-label="UID" style="color: var(--text-muted); font-family: monospace;">#{{ str_pad($usr->id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td data-label="{{ $lang === 'id' ? 'Identitas' : 'Identity' }}">
                        <strong style="color: #fff;">{{ $usr->name }}</strong><br>
                        <span style="font-size: 0.75rem; color: var(--text-muted);">NIM/NIP: {{ $usr->nomor_induk ?? '-' }}</span>
                    </td>
                    <td data-label="{{ $lang === 'id' ? 'Kontak' : 'Contact' }}">
                        <span style="color: var(--text-light); border-bottom: 1px dashed rgba(255,255,255,0.2);">{{ $usr->email }}</span>
                    </td>
                    <td data-label="{{ $lang === 'id' ? 'Hierarki Role' : 'Role Hierarchy' }}">
                        @php
                            $roleColor = 'rgba(255,255,255,0.1)'; $roleFont = '#fff';
                            if($usr->role == 'admin') { $roleColor = 'rgba(239, 68, 68, 0.2)'; $roleFont = '#ef4444'; }
                            elseif($usr->role == 'master') { $roleColor = 'rgba(168, 85, 247, 0.2)'; $roleFont = '#a855f7'; }
                            elseif($usr->role == 'dosen') { $roleColor = 'rgba(234, 179, 8, 0.2)'; $roleFont = '#eab308'; }
                            elseif($usr->role == 'asisten') { $roleColor = 'rgba(59, 130, 246, 0.2)'; $roleFont = '#3b82f6'; }
                        @endphp
                        <span class="role-tag" style="background: {{ $roleColor }}; color: {{ $roleFont }}; border: 1px solid {{ str_replace('0.2', '0.4', $roleColor) }};">
                            {{ strtoupper($usr->role) }}
                        </span>
                        @if($usr->role === 'asisten' && $usr->laboratorium_jaga)
                            <div style="font-size: 0.7rem; color: var(--text-muted); margin-top: 4px;">&#9733; Asisten: {{ $usr->laboratorium_jaga->nama_lab }}</div>
                        @elseif($usr->role === 'master' && $usr->laboratorium && $usr->laboratorium->isNotEmpty())
                            <div style="font-size: 0.7rem; color: var(--text-muted); margin-top: 4px;" title="{{ $usr->laboratorium->pluck('nama_lab')->implode(', ') }}">&#9733; Kepala Lab ({{ $usr->laboratorium->count() }})</div>
                        @endif
                    </td>
                    <td data-label="{{ $lang === 'id' ? 'Aksi Berbahaya' : 'Danger Actions' }}" style="text-align: right; min-width: 120px;">
                        <div class="action-btn-group" style="justify-content: center;">
                            <button class="btn-swap mobile-full-btn" onclick="openSwapModal({{ $usr->id }}, '{{ addslashes($usr->name) }}', '{{ $usr->role }}')">{{ $lang === 'id' ? 'MUTASI' : 'SWAP' }}</button>
                            <button type="button" class="btn-delete mobile-full-btn" onclick="openDeleteModal({{ $usr->id }}, '{{ addslashes($usr->name) }}')" {{ $usr->id === Auth::id() ? 'disabled' : '' }} style="{{ $usr->id === Auth::id() ? 'opacity: 0.5; cursor: not-allowed;' : '' }}">EKSEKUSI</button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Ganti Jabatan -->
<div id="swapRoleModal" class="custom-modal">
    <div class="modal-content" style="max-width: 400px;">
        <h3 style="color: var(--accent-cyan); margin-top: 0; font-weight: 900; text-transform: uppercase;">{{ $lang === 'id' ? 'Mutasi Otoritas' : 'Swap Authority' }}</h3>
        <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 1.5rem;">
            {{ $lang === 'id' ? 'Mengangkat pangkat akan mengubah hak akses UI dari entitas ini.' : 'Swapping role changes UI access.' }}
        </p>
        <form id="swapForm" method="POST">
            @csrf
            <div style="margin-bottom: 1.5rem;">
                <label style="display:block; margin-bottom: 0.5rem; font-size: 0.8rem; font-weight: bold; color: var(--text-muted);">{{ $lang === 'id' ? 'Target Entitas' : 'Target Entity' }}</label>
                <input type="text" id="swapTargetName" class="admin-input" disabled style="opacity: 0.5; background: #000;">
            </div>
            <div style="margin-bottom: 1.5rem;">
                <label style="display:block; margin-bottom: 0.5rem; font-size: 0.8rem; font-weight: bold; color: var(--text-muted);">{{ $lang === 'id' ? 'Jabatan Baru' : 'New Role' }}</label>
                <select name="role" id="swapSelectRole" class="admin-input" required onchange="toggleSwapLab(this.value)">
                    <option value="mahasiswa">MAHASISWA</option>
                    <option value="asisten">ASISTEN LAB</option>
                    <option value="master">MASTER LAB</option>
                    <option value="dosen">DOSEN</option>
                    <option value="admin">ADMIN SISTEM</option>
                </select>
                <div id="swapLabWrapper" style="display: none; margin-top: 1rem; padding-top: 1rem; border-top: 1px dashed rgba(255,255,255,0.1);">
                    <label style="display:block; margin-bottom: 0.5rem; font-size: 0.8rem; font-weight: bold; color: var(--accent-cyan);">{{ $lang === 'id' ? 'Alokasi Laboratorium Terikat' : 'Linked Laboratory' }} <span style="color:#ef4444">*</span></label>
                    <select name="laboratorium_id" id="swapLabSelect" class="admin-input" style="border-color: var(--accent-cyan); width: 100%;">
                        <option value="">-- {{ $lang === 'id' ? 'Pilih Domain Tautan Operasional' : 'Select Domain' }} --</option>
                        @foreach($laboratoriums as $lab)
                            <option value="{{ $lab->id }}">{{ $lab->nama_lab }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button type="submit" class="admin-btn" style="width: 100%; border-color: var(--accent-cyan); color: var(--accent-cyan); margin-bottom: 1rem;" onmouseover="this.style.background='var(--accent-cyan)'; this.style.color='#000';" onmouseout="this.style.background='rgba(0, 217, 255, 0.1)'; this.style.color='var(--accent-cyan)';">
                {{ $lang === 'id' ? 'TERAPKAN JABATAN' : 'APPLY ROLE' }}
            </button>
            <button type="button" class="admin-btn" style="width: 100%; background: transparent; border: 1px solid rgba(255,255,255,0.2); color: #fff;" onclick="closeModal('swapRoleModal')">BATAL</button>
        </form>
    </div>
</div>

<!-- Modal Eksekusi Akun -->
<div id="deleteConfirmModal" class="custom-modal">
    <div class="modal-content" style="max-width: 400px;">
        <h3 style="color: #ef4444; margin-top: 0; font-weight: 900; text-transform: uppercase;">{{ $lang === 'id' ? 'Konfirmasi Eksekusi' : 'Confirm Execution' }}</h3>
        <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 1.5rem;">
            {{ $lang === 'id' ? 'PERINGATAN! Menghapus entitas ini (' : 'WARNING! Deleting entity (' }}<span id="deleteTargetName" style="color: #fff; font-weight: bold;"></span>{{ $lang === 'id' ? ') akan membumihanguskan SELURUH RIWAYAT TRANSAKSI CASCADE miliknya di pangkalan data secara permanen!' : ') will cascade destroy ALL THEIR TRANSACTIONS permanently!' }}
        </p>
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="admin-btn" style="width: 100%; border-color: #ef4444; color: #ef4444; margin-bottom: 1rem;" onmouseover="this.style.background='#ef4444'; this.style.color='#000';" onmouseout="this.style.background='rgba(239, 68, 68, 0.1)'; this.style.color='#ef4444';">
                {{ $lang === 'id' ? 'EKSEKUSI PEMUSNAHAN' : 'EXECUTE PURGE' }}
            </button>
            <button type="button" class="admin-btn" style="width: 100%; background: transparent; border: 1px solid rgba(255,255,255,0.2); color: #fff;" onclick="closeModal('deleteConfirmModal')">PENGAMPUNAN (BATAL)</button>
        </form>
    </div>
</div>

<script>
    function openModal(modalId) {
        document.getElementById(modalId).classList.add('active');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('active');
    }

    function openSwapModal(id, name, currentRole) {
        document.getElementById('swapTargetName').value = name + ' (Current: ' + currentRole.toUpperCase() + ')';
        document.getElementById('swapSelectRole').value = currentRole;
        // Dynamically set form action
        let baseUrl = '{{ route("admin.users.swap", ":id") }}';
        document.getElementById('swapForm').action = baseUrl.replace(':id', id);
        
        toggleSwapLab(currentRole);
        openModal('swapRoleModal');
    }

    function toggleSwapLab(role) {
        document.getElementById('swapLabWrapper').style.display = ['asisten', 'master'].includes(role) ? 'block' : 'none';
        document.getElementById('swapLabSelect').required = ['asisten', 'master'].includes(role);
    }

    function openDeleteModal(id, name) {
        document.getElementById('deleteTargetName').innerText = name;
        let baseUrl = '{{ route("admin.users.destroy", ":id") }}';
        document.getElementById('deleteForm').action = baseUrl.replace(':id', id);
        openModal('deleteConfirmModal');
    }
    
    // Auto-close modal when clicking outside content wrapper
    window.onclick = function(event) {
        if (event.target.classList.contains('custom-modal')) {
            event.target.classList.remove('active');
        }
    }
</script>
