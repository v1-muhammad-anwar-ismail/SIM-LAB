    <!-- CDNs FullCalendar -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>

    <div class="welcome-banner" style="margin-bottom: 2rem;">
        <div class="status-badge" style="background: rgba(14, 165, 233, 0.1); color: #0ea5e9; border-color: rgba(14, 165, 233, 0.3);">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
            {{ $lang === 'id' ? 'Kalender Digital' : 'Digital Calendar' }}
        </div>
        <h1 class="welcome-title">{{ $lang === 'id' ? 'Agenda Opesional' : 'Operational Agenda' }}</h1>
        <p class="welcome-subtitle">
            {{ $lang === 'id' ? 'Tinjau visualisasi kalender untuk melihat peminjam yang terdaftar setiap harinya di laboratorium Anda.' : 'Review calendar visualization to see registered borrowers per day in your laboratory.' }}
        </p>
    </div>

    <!-- Papan Kalender -->
    <div style="background: rgba(2, 4, 10, 0.7); border: 1px solid var(--panel-border); border-radius: 1rem; padding: 1.5rem; display: flex; flex-direction: column; gap: 1rem;">
        <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-bottom: 0.5rem;">
            <!-- Legenda -->
            <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.8rem; color: #cbd5e1;">
                <div style="width: 12px; height: 12px; border-radius: 50%; background: #22c55e;"></div> {{ $lang === 'id' ? 'Menunggu Diambil (ACC)' : 'Pending Retrieval (ACC)' }}
            </div>
            <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.8rem; color: #cbd5e1;">
                <div style="width: 12px; height: 12px; border-radius: 50%; background: #eab308;"></div> {{ $lang === 'id' ? 'Sedang Dipinjam' : 'Currently Borrowed' }}
            </div>
        </div>

        <div id='simlab-calendar' style="min-height: 600px; color: #cbd5e1;"></div>
    </div>

    <style>
        /* Modernisasi Kalender ke Dark Mode SIM-LAB */
        .fc-theme-standard td, .fc-theme-standard th {
            border-color: rgba(255,255,255,0.05) !important;
        }
        .fc-col-header-cell {
            background: rgba(10, 16, 22, 0.8) !important;
            padding: 8px 0 !important;
        }
        .fc-day-today {
            background: rgba(0, 217, 255, 0.05) !important;
        }
        .fc-daygrid-day-number {
            color: #fff !important;
            font-weight: 600;
        }
        .fc .fc-button-primary {
            background-color: transparent !important;
            border-color: rgba(0,217,255,0.3) !important;
            color: #00d9ff !important;
            text-transform: uppercase;
            font-weight: bold;
            font-size: 0.8rem;
            transition: all 0.3s ease;
        }
        .fc .fc-button-primary:hover {
            background-color: rgba(0,217,255,0.1) !important;
            box-shadow: 0 0 10px rgba(0,217,255,0.2) !important;
        }
        .fc .fc-button-active {
            background-color: var(--accent-cyan) !important;
            color: #000 !important;
            border-color: var(--accent-cyan) !important;
        }
        .fc-event {
            cursor: pointer;
            border-radius: 4px !important;
            padding: 2px 4px !important;
            font-size: 0.8rem !important;
            font-weight: 600 !important;
            border: none !important;
            color: #fff !important;
        }

        /* List View Styles Fixed Transparency */
        .fc-list-event-title a, .fc-list-event-time {
            color: #fff !important;
        }
        .fc-list-day-cushion {
            background: rgba(0, 217, 255, 0.1) !important;
            color: #00d9ff !important;
        }
        .fc-list-event:hover td {
            background-color: rgba(255, 255, 255, 0.05) !important;
        }
        .fc .fc-list-empty-wrap2 {
            background: rgba(10, 16, 22, 0.8) !important;
        }
        .fc-theme-standard .fc-list {
            border-color: rgba(255, 255, 255, 0.1) !important;
            background: rgba(10, 16, 22, 0.6) !important;
        }

        /* Modifikasi Khusus Responsif Mobile */
        @media (max-width: 768px) {
            .fc-header-toolbar.fc-toolbar {
                flex-wrap: wrap !important;
                flex-direction: row !important;
                justify-content: center !important;
                gap: 1rem;
            }
            .fc-toolbar-title {
                font-size: 1.3rem !important;
                text-align: center;
                width: 100%;
            }
            .fc-toolbar-chunk {
                display: flex;
                justify-content: center;
                flex-wrap: wrap;
                gap: 0.5rem;
            }
            /* Mencegah Squeezed (Terpotong) di Mobile Khusus Mode Grid */
            .fc-timegrid-view .fc-scrollgrid, .fc-daygrid-view .fc-scrollgrid {
                min-width: 700px !important;
            }
            .fc-view-harness {
                overflow-x: auto !important;
                padding-bottom: 10px;
                -webkit-overflow-scrolling: touch;
            }
        }

        /* Styling Filter Modal Button & Overlay */
        .filter-btn {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 0.85rem;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 700;
            transition: 0.2s;
            text-align: center;
            width: 100%;
            display: block;
        }
        .filter-btn:hover {
            background: var(--accent-cyan);
            color: #000;
            border-color: var(--accent-cyan);
        }
        #filterPopupOverlay {
            position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(5px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 10001;
        }
        #filterModalCard {
            background: #0b111a;
            width: 90%;
            max-width: 320px;
            border-radius: 12px;
            border: 1px solid rgba(0, 217, 255, 0.3);
            box-shadow: 0 0 40px rgba(0, 217, 255, 0.1);
            padding: 1.5rem;
            position: relative;
        }
    </style>

    <!-- Modal Pilihan Filter View -->
    <div id="filterPopupOverlay" onclick="closeFilterModal()">
        <div id="filterModalCard" onclick="event.stopPropagation()">
            <h3 style="margin-top:0; color: #fff; text-align: center; font-size: 1.1rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 0.75rem; font-weight: 900; letter-spacing: 0.5px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: text-bottom; margin-right: 5px;"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
                {{ $lang === 'id' ? 'FILTER TAMPILAN' : 'VIEW FILTER' }}
            </h3>
            
            <div style="display: flex; flex-direction: column; gap: 0.75rem; margin-top: 1rem;">
                <button class="filter-btn" onclick="changeCalView('dayGridMonth')">{{ $lang === 'id' ? 'Mode Bulanan (Global)' : 'Monthly Mode' }}</button>
                <button class="filter-btn" onclick="changeCalView('timeGridWeek')">{{ $lang === 'id' ? 'Mode Mingguan (Rinci)' : 'Weekly Mode' }}</button>
                <button class="filter-btn" onclick="changeCalView('timeGridDay')">{{ $lang === 'id' ? 'Mode Harian (Fokus)' : 'Daily Mode' }}</button>
                <button class="filter-btn" onclick="changeCalView('listWeek')">{{ $lang === 'id' ? 'Mode Daftar (Ringkas)' : 'List View Mode' }}</button>
            </div>
            
            <button onclick="closeFilterModal()" style="margin-top: 1.5rem; width: 100%; padding: 0.85rem; background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.4); border-radius: 8px; cursor: pointer; transition: 0.3s; font-weight: 900; letter-spacing: 1px; text-transform: uppercase;" onmouseover="this.style.background='rgba(239,68,68,0.2)'" onmouseout="this.style.background='rgba(239,68,68,0.1)'">
                {{ $lang === 'id' ? 'Tutup Overlay' : 'Close Overlay' }}
            </button>
        </div>
    </div>

    <!-- Modal Event Detail Kalender -->
    <div id="eventDetailModal" class="custom-modal">
        <div class="modal-content" style="border-color: #eab308;">
            <svg class="modal-close" onclick="closeModal('eventDetailModal')" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            <h2 style="color: #eab308; font-weight: 800; margin-top: 0; margin-bottom: 1.5rem;">{{ $lang === 'id' ? 'DETAIL AGENDA' : 'AGENDA DETAILS' }}</h2>
            
            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase;">Peminjam / Eksekutor</label>
                <div id="calEventTitle" style="font-weight: 700; color: #fff; font-size: 1.2rem;">-</div>
            </div>
            
            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase;">Jadwal Tenggat</label>
                <div id="calEventTime" style="font-weight: 500; color: #cbd5e1;">-</div>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase;">Keperluan / Catatan</label>
                <div id="calEventDesc" style="font-weight: 500; color: #fff; background: rgba(0,0,0,0.3); padding: 1rem; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); margin-top: 0.5rem;">-</div>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase;">Status Proses</label>
                <div id="calEventStatus" style="font-weight: 800; display: inline-block; padding: 0.4rem 0.8rem; border-radius: 20px; font-size: 0.8rem; margin-top: 0.5rem; text-transform: uppercase;">-</div>
            </div>
            
            <button onclick="closeModal('eventDetailModal')" style="width: 100%; color: #000; background: #eab308; border: none; padding: 1rem; border-radius: 8px; font-weight: 900; letter-spacing: 0.1em; cursor: pointer; transition: 0.3s; box-shadow: 0 0 15px rgba(234, 179, 8, 0.4);">
                TUTUP (CLOSE)
            </button>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('simlab-calendar');
            var rawData = {!! $scheduleEvents !!}; // Injeksi dari controller PHP

            var isMobile = window.innerWidth <= 768;

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: isMobile ? 'listWeek' : 'dayGridMonth',
                locale: '{{ $lang === "id" ? "id" : "en-gb" }}',
                customButtons: {
                    viewFilterBtn: {
                        text: '{{ $lang === "id" ? "Filter Tampilan" : "Filter View" }}',
                        click: function() {
                            document.getElementById('filterPopupOverlay').style.display = 'flex';
                        }
                    }
                },
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: isMobile ? '' : 'viewFilterBtn'
                },
                buttonText: {
                    today: '{{ $lang === "id" ? "Hari Ini" : "Today" }}'
                },
                events: rawData,
                eventClick: function(info) {
                    // Mencegah navigasi url jika ada url di event (meski kita ga pasang)
                    info.jsEvent.preventDefault();

                    const props = info.event.extendedProps;
                    
                    document.getElementById('calEventTitle').innerText = info.event.title;
                    
                    // Formatting Date Time dengan Jam spesifik
                    const options = { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' };
                    const startStr = info.event.start ? info.event.start.toLocaleString('{{ $lang === "id" ? "id-ID" : "en-GB" }}', options) : '-';
                    
                    let endStr = '-';
                    if (info.event.end) {
                        endStr = info.event.end.toLocaleString('{{ $lang === "id" ? "id-ID" : "en-GB" }}', options);
                    }
                    
                    document.getElementById('calEventTime').innerText = startStr + '  sampai  ' + endStr;
                    document.getElementById('calEventDesc').innerText = props.keperluan || 'Tanpa keterangan spesifik.';
                    
                    const statusBadge = document.getElementById('calEventStatus');
                    statusBadge.innerText = props.status;
                    if(props.status === 'dipinjam') {
                        statusBadge.style.color = '#eab308';
                        statusBadge.style.backgroundColor = 'rgba(234, 179, 8, 0.1)';
                        statusBadge.style.border = '1px solid rgba(234, 179, 8, 0.3)';
                    } else if(props.status === 'disetujui') {
                        statusBadge.style.color = '#22c55e';
                        statusBadge.style.backgroundColor = 'rgba(34, 197, 94, 0.1)';
                        statusBadge.style.border = '1px solid rgba(34, 197, 94, 0.3)';
                    }

                    openModal('eventDetailModal');
                }
            });

            calendar.render();
            
            // Siasat re-render calendar jika sidebar di-toggle (karena flex container berubah dimensi)
            window.addEventListener('resize', function(){
                calendar.updateSize();
            });
            setTimeout(() => { calendar.updateSize(); }, 500);

            window.simlabCalendarInstance = calendar;
        });

        function changeCalView(viewName) {
            if(window.simlabCalendarInstance) {
                window.simlabCalendarInstance.changeView(viewName);
            }
            closeFilterModal();
        }

        function closeFilterModal() {
            document.getElementById('filterPopupOverlay').style.display = 'none';
        }
    </script>
    @endpush
