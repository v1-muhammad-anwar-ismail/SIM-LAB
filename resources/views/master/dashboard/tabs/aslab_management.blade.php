<style>
    /* PREMIUM ASLAB MANAGEMENT STYLES */
    .glass-card {
        background: rgba(10, 16, 22, 0.4);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(0, 217, 255, 0.15);
        border-radius: 1.5rem;
        padding: 2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .cyber-title {
        font-size: 1.3rem;
        font-weight: 900;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        background: linear-gradient(90deg, #00d9ff, #fff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .cyber-input-group {
        position: relative;
        margin-bottom: 1.5rem;
    }
    
    .cyber-input {
        width: 100%;
        background: rgba(0, 0, 0, 0.6);
        border: 2px solid rgba(255, 255, 255, 0.1);
        color: #fff;
        padding: 1.2rem 1.2rem 1.2rem 3.5rem;
        border-radius: 1rem;
        font-size: 1rem;
        font-family: inherit;
        font-weight: 500;
        box-sizing: border-box;
        transition: all 0.3s ease;
        outline: none;
    }
    .cyber-input:focus {
        border-color: var(--accent-cyan);
        box-shadow: 0 0 25px rgba(0, 217, 255, 0.2), inset 0 0 10px rgba(0, 217, 255, 0.1);
        background: rgba(0, 10, 20, 0.8);
    }
    .cyber-input-icon {
        position: absolute;
        left: 1.2rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--accent-cyan);
        pointer-events: none;
        transition: all 0.3s ease;
    }
    .cyber-input:focus ~ .cyber-input-icon {
        color: #fff;
        filter: drop-shadow(0 0 5px var(--accent-cyan));
    }

    .cyber-btn-primary {
        background: linear-gradient(135deg, #00d9ff 0%, #0077ff 100%);
        border: none;
        color: white;
        padding: 1rem 2rem;
        border-radius: 1rem;
        font-weight: 800;
        font-size: 1rem;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        cursor: pointer;
        width: 100%;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 10px 20px rgba(0, 119, 255, 0.3);
    }
    .cyber-btn-primary:before {
        content: '';
        position: absolute;
        top: 0; left: -100%; width: 50%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        transform: skewX(-20deg);
        transition: 0.5s;
    }
    .cyber-btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 25px rgba(0, 217, 255, 0.5);
    }
    .cyber-btn-primary:hover:before {
        left: 150%;
    }
    
    .aslab-list-item {
        background: linear-gradient(145deg, rgba(20, 30, 40, 0.8), rgba(10, 16, 22, 0.9));
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 1rem;
        padding: 1.25rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .aslab-list-item:hover {
        border-color: rgba(0, 217, 255, 0.3);
        box-shadow: 0 10px 20px rgba(0,0,0,0.4), inset 0 0 15px rgba(0,217,255,0.05);
        transform: scale(1.02);
    }

    .fire-btn {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.4);
        color: #ef4444;
        width: 100%;
        padding: 0.8rem;
        border-radius: 8px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }
    .fire-btn:hover {
        background: rgba(239, 68, 68, 0.8);
        color: white;
        border-color: #ef4444;
        box-shadow: 0 0 15px rgba(239, 68, 68, 0.3);
    }

    .capacity-badge {
        background: rgba(0,0,0,0.5);
        border: 1px solid rgba(0, 217, 255, 0.2);
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 900;
        font-size: 1.2rem;
        letter-spacing: 2px;
    }
    
    .recruitment-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    @media (min-width: 1000px) {
        .recruitment-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    .lab-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
        margin-bottom: 3rem;
    }
    @media (min-width: 900px) {
        .lab-grid {
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        }
    }
    
    .aslab-name {
        margin: 0; color: #fff; font-size: 0.9rem; font-weight: 800; display: flex; align-items: flex-start; gap: 0.5rem; flex-wrap: nowrap;
    }
    .aslab-lab-badge {
        display: inline-block; font-size: 0.65rem; color: #fff; background: rgba(0,217,255,0.15); border: 1px solid rgba(0,217,255,0.3); padding: 0.2rem 0.5rem; border-radius: 6px; font-weight: bold; margin-top: 0.5rem; max-width: 100%; white-space: normal;
    }
    
    @media (max-width: 600px) {
        .aslab-name {
            font-size: 0.8rem;
        }
        .aslab-lab-badge {
            font-size: 0.55rem;
            padding: 0.15rem 0.4rem;
        }
    }
</style>

<div class="welcome-banner" style="margin-bottom: 2rem;">
    <h1 class="welcome-title">{{ $lang === 'id' ? 'MANAJEMEN ASISTEN LAB' : 'ASLAB MANAGEMENT' }}</h1>
    <p class="welcome-subtitle">
        {{ $lang === 'id' ? 'Sentral komando rekrutmen Asisten Laboratorium. Kelola kapasitas dan delegasikan staf pada seluruh fasilitas kepemimpinan Anda secara terintegrasi.' : 'Smart Assistant recruitment central command. Manage capacities and delegate staff across all your leadership facilities seamlessly.' }}
    </p>
</div>

@if($myLaboratoria->isEmpty())
    <div class="glass-card" style="text-align: center; padding: 4rem 2rem; border-color: rgba(239,68,68,0.3);">
        <div style="width: 80px; height: 80px; border-radius: 50%; background: rgba(239,68,68,0.1); display: flex; center; align-items: center; justify-content: center; margin: 0 auto 1.5rem; box-shadow: 0 0 30px rgba(239,68,68,0.2);">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
        </div>
        <h2 style="font-weight: 900; color: #ef4444; font-size: 1.5rem; margin-bottom: 1rem; letter-spacing: 0.05em;">{{ $lang === 'id' ? 'TERKUNCI: TIDAK ADA LAB YANG DIPIMPIN' : 'LOCKED: NO LABORATORY ASSIGNED' }}</h2>
        <p style="color: var(--text-muted); font-size: 1rem; max-width: 600px; margin: 0 auto; line-height: 1.6;">
            {{ $lang === 'id' ? 'Sistem mendeteksi bahwa Anda belum ditunjuk sebagai Kepala (Master) untuk Laboratorium manapun. Anda dapat mendaftarkan Laboratorium baru di tab "Data Laboratorium" terlebih dahulu.' : 'The system detects you are not appointed as the Master for any laboratory yet. You can register a new Laboratory in the "Laboratory Data" tab first.' }}
        </p>
    </div>
@else

    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
        <div style="width: 4px; height: 35px; background: var(--accent-cyan); border-radius: 4px; box-shadow: 0 0 10px var(--glow-cyan);"></div>
        <h2 style="margin: 0; color: #fff; font-size: 1.5rem; font-weight: 900; letter-spacing: 1px;">{{ $lang === 'id' ? 'KEKUASAAN TERPILIH' : 'LEADERSHIP REALMS' }}</h2>
    </div>

    <!-- KONFIGURASI LAB GRID -->
    <div class="lab-grid">
        @foreach($myLaboratoria as $mLab)
        <div class="glass-card" style="padding: 1.5rem; border-color: rgba(255,255,255,0.05);">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem; gap: 1rem;">
                <div>
                    <h3 style="color: #fff; font-weight: 900; font-size: 1.2rem; margin: 0; line-height: 1.3;">{{ $mLab->nama_lab }}</h3>
                </div>
                <div style="text-align: right; flex-shrink: 0;">
                    <div class="capacity-badge" style="color: {{ $allActiveAslabs[$mLab->id]->count() >= $mLab->max_aslab ? '#ef4444' : 'var(--accent-cyan)' }}; font-size: 1rem; padding: 0.4rem 0.8rem;">
                        {{ $allActiveAslabs[$mLab->id]->count() }} <span style="opacity:0.5">/</span> {{ $mLab->max_aslab }}
                    </div>
                </div>
            </div>

            <form onsubmit="updateMaxAslab(event, {{ $mLab->id }})">
                <div style="background: rgba(0,0,0,0.3); border-radius: 1rem; padding: 0.8rem; display: flex; gap: 0.8rem; align-items: center; border: 1px solid rgba(255,255,255,0.05);">
                    <div style="flex-grow: 1;">
                        <input type="number" id="input_max_aslab_{{ $mLab->id }}" min="0" max="25" value="{{ $mLab->max_aslab }}" class="cyber-input" style="padding: 0.7rem 1rem; border-radius: 0.5rem; font-size: 1.1rem; text-align: center; color: var(--accent-cyan); border-color: rgba(0,217,255,0.2);" placeholder="Max">
                    </div>
                    <button type="submit" class="cyber-btn-primary" style="width: auto; padding: 0 1rem; height: 45px; border-radius: 0.5rem;" title="{{ $lang === 'id' ? 'Simpan' : 'Save' }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                    </button>
                </div>
            </form>
        </div>
        @endforeach
    </div>

    <!-- MAIN RECRUITMENT GRID -->
    <div class="recruitment-grid">
        
        <!-- BAGIAN KIRI: BURSA REKRUTMEN UNIFIED -->
        <div style="display: flex; flex-direction: column; gap: 2rem;">
            <div class="glass-card">
                <h3 class="cyber-title">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    {{ $lang === 'id' ? 'BURSA REKRUTMEN GLOBAL' : 'GLOBAL RECRUITMENT MARKET' }}
                </h3>
                <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.5rem;">{{ $lang === 'id' ? 'Cari kandidat mahasiswa di seluruh Universitas dan alokasikan ke lab yang Anda kelola.' : 'Search for student candidates university-wide and deploy them to your managed labs.' }}</p>

                <form onsubmit="searchMahasiswaUnified(event)">
                    <div class="cyber-input-group">
                        <input type="text" id="recruit_keyword_unified" class="cyber-input" placeholder="{{ $lang === 'id' ? 'Ketik NIM, Email, atau Nama Mahasiswa...' : 'Type ID, Email, or Student Name...' }}" required>
                        <svg class="cyber-input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    </div>
                    <button type="submit" id="btn_search_recruit_unified" class="cyber-btn-primary">
                        {{ $lang === 'id' ? 'LACAK KANDIDAT' : 'TRACK CANDIDATE' }}
                    </button>
                </form>

                <!-- Div Penampung Hasil Pencarian -->
                <div id="search_result_container_unified" style="margin-top: 2rem; display: none;"></div>
            </div>
        </div>

        <!-- BAGIAN KANAN: DAFTAR ASLAB AKTIF (FIRING LINE) -->
        <div class="glass-card" style="display: flex; flex-direction: column;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 1px dashed rgba(255,255,255,0.1); flex-wrap: wrap; gap: 1rem;">
                <h3 class="cyber-title" style="margin: 0;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
                    {{ $lang === 'id' ? 'KESELURUHAN PASUKAN AKTIF' : 'UNIFIED ACTIVE SQUAD' }}
                </h3>
            </div>

            @php
                $totalActive = 0;
                $allAslabsList = [];
                foreach($myLaboratoria as $mLab) {
                    $totalActive += $allActiveAslabs[$mLab->id]->count();
                    foreach($allActiveAslabs[$mLab->id] as $a) {
                        $a->lab_assigned_name = $mLab->nama_lab;
                        $a->lab_assigned_id = $mLab->id;
                        $allAslabsList[] = $a;
                    }
                }
            @endphp

            @if($totalActive === 0)
                <div style="flex-grow: 1; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; padding: 3rem 1rem; background: rgba(0,0,0,0.2); border-radius: 1rem; border: 1px dashed rgba(0,217,255,0.2);">
                    <div style="width: 80px; height: 80px; border-radius: 50%; background: rgba(0,217,255,0.05); display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--accent-cyan)" stroke-width="1.5" style="opacity: 0.5;">
                            <circle cx="12" cy="12" r="10"></circle><path d="M16 16s-1.5-2-4-2-4 2-4 2"></path><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line>
                        </svg>
                    </div>
                    <h3 style="color: #fff; font-size: 1.1rem; margin-bottom: 0.5rem;">{{ $lang === 'id' ? 'TIDAK ADA ASISTEN' : 'NO ASSISTANTS' }}</h3>
                    <p style="color: var(--text-muted); font-size: 0.9rem; max-width: 250px; line-height: 1.6;">{{ $lang === 'id' ? 'Seluruh fasilitas lab Anda belum memiliki bawahan. Tangkap kandidat di radar sekarang.' : 'All your lab facilities have no personnel yet. Catch a candidate on the radar now.' }}</p>
                </div>
            @else
                <div style="display: flex; flex-direction: column; gap: 1rem; overflow-y: auto; padding-right: 0.5rem; max-height: 500px;" class="custom-scrollbar">
                    @foreach($allAslabsList as $aslab)
                        <div class="aslab-list-item">
                            <div style="display: flex; align-items: center; gap: 1.25rem;">
                                <!-- Avatar Berpendar -->
                                <div style="width: 55px; height: 55px; background: linear-gradient(135deg, rgba(0,217,255,0.2), rgba(0,119,255,0.2)); border: 2px solid var(--accent-cyan); border-radius: 50%; display: flex; align-items: center; justify-content: center; overflow: hidden; box-shadow: 0 0 15px rgba(0, 217, 255, 0.3); flex-shrink: 0;">
                                    @php
                                        $avSrc = '';
                                        if ($aslab->avatar) {
                                            $avSrc = (filter_var($aslab->avatar, FILTER_VALIDATE_URL) || str_starts_with($aslab->avatar, '/storage/')) ? $aslab->avatar : Storage::url($aslab->avatar);
                                        }
                                    @endphp
                                    @if($avSrc)
                                        <img src="{{ $avSrc }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <span style="font-weight: 900; color: #fff; font-size: 1.5rem;">{{ strtoupper(substr($aslab->name, 0, 1)) }}</span>
                                    @endif
                                </div>
                                <!-- Informasi Pegawai -->
                                <div style="flex-grow: 1; min-width: 0;">
                                    <h4 class="aslab-name">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="#10b981" stroke="none" style="flex-shrink:0; margin-top:2px;"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                        <span style="word-break: break-word; line-height: 1.3;">{{ $aslab->name }}</span>
                                    </h4>
                                    <span class="aslab-lab-badge">
                                        LAB: {{ strtoupper($aslab->lab_assigned_name) }}
                                    </span>
                                </div>
                            </div>
                            <!-- Action Pemecatan -->
                            <form action="{{ route('master.aslab.fire', ['id' => $aslab->id, 'lab_id' => $aslab->lab_assigned_id]) }}" method="POST" style="width: 100%;">
                                @csrf
                                <button type="button" class="fire-btn" style="gap: 0.5rem;" onclick="confirmDestructiveAction(event, this.form, '{{ $lang }}', 'Are you sure you want to dismiss this assistant?', 'Anda yakin ingin memecat mahasiswa ini?')" title="{{ $lang === 'id' ? 'Berhentikan Asisten' : 'Dismiss Assistant' }}">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path><line x1="12" y1="2" x2="12" y2="12"></line></svg>
                                    <span style="font-weight: 800; font-size: 0.8rem; letter-spacing: 2px;">{{ $lang === 'id' ? 'BERHENTIKAN' : 'DISMISS' }}</span>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Script Logika AJAX Tab Ini -->
    <script>
        function updateMaxAslab(event, labId) {
            event.preventDefault();
            const inputVal = document.getElementById('input_max_aslab_' + labId).value;
            if(!inputVal || inputVal < 0) return;

            const btn = event.target.querySelector('button');
            const originalIcon = btn.innerHTML;
            btn.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="animation: spin 1s linear infinite;"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg>';

            fetch(`{{ url('/master/dashboard/aslab/update-max') }}/${labId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ max_aslab: inputVal })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    window.location.reload();
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: data.message, background: '#0a0c10', color: '#fff' });
                    btn.innerHTML = originalIcon;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                btn.innerHTML = originalIcon;
            });
        }

        function searchMahasiswaUnified(event) {
            event.preventDefault();
            const keyword = document.getElementById('recruit_keyword_unified').value;
            const container = document.getElementById('search_result_container_unified');
            const btn = document.getElementById('btn_search_recruit_unified');
            
            if(!keyword.trim()) return;

            container.style.display = 'block';
            container.innerHTML = `
                <div style="background: rgba(0,0,0,0.5); padding: 2rem; border-radius: 1rem; border: 1px solid rgba(0,217,255,0.2); text-align: center;">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--accent-cyan)" stroke-width="2" style="animation: spin 1s linear infinite; margin-bottom: 1rem;"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg>
                    <p style="color:var(--accent-cyan); font-weight:800; letter-spacing:2px; margin:0;">MENGANALISIS DATA BASE...</p>
                </div>
            `;
            btn.disabled = true;
            btn.style.opacity = '0.5';

            fetch(`{{ route("master.aslab.search") }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ keyword: keyword })
            })
            .then(res => res.json())
            .then(data => {
                btn.disabled = false;
                btn.style.opacity = '1';

                if(data.status === 'success' && data.html) {
                    container.innerHTML = `
                        <h4 style="color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1rem;">{{ $lang === 'id' ? 'Hasil Pelacakan Satelit' : 'Satellite Tracking Result' }}</h4>
                        ${data.html}
                    `;
                } else {
                    container.innerHTML = `<div style="background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3); padding: 1.5rem; border-radius: 1rem; text-align: center; color: #ef4444; font-weight: bold;"><svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-bottom: 0.5rem;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg><br>${data.message || 'Kandidat tidak terdeteksi di radar.'}</div>`;
                }
            }).catch(err => {
                btn.disabled = false;
                btn.style.opacity = '1';
                container.innerHTML = `<div style="background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3); padding: 1.5rem; border-radius: 1rem; text-align: center; color: #ef4444; font-weight: bold;">Koneksi terputus. Gagal melakukan pelacakan.</div>`;
            });
        }
    </script>
@endif
