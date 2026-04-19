<!-- FullCalendar Core & Plugins -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>

<style>
    .schedule-header {
        background: rgba(10, 16, 22, 0.5);
        border: 1px solid var(--panel-border);
        border-radius: 1rem;
        padding: 2rem;
        margin-bottom: 2.5rem;
        border-top: 4px solid var(--accent-cyan);
    }
    
    .schedule-title {
        color: #fff;
        margin-top: 0;
        margin-bottom: 0.5rem;
        font-weight: 900;
        letter-spacing: 1px;
    }
    
    .schedule-subtitle {
        color: var(--text-muted);
        margin: 0;
        font-size: 0.95rem;
    }

    #calendar-container {
        background: rgba(10, 16, 22, 0.5);
        border: 1px solid var(--panel-border);
        border-radius: 1rem;
        padding: 1.5rem;
        color: #e2e8f0;
    }

    .fc-theme-standard td, .fc-theme-standard th {
        border-color: rgba(255, 255, 255, 0.1);
    }
    .fc-theme-standard th {
        background: rgba(10, 16, 22, 0.8) !important;
    }
    .fc-col-header-cell {
        padding: 0.5rem 0 !important;
    }
    .fc-col-header-cell-cushion {
        color: #fff !important;
        font-weight: 800 !important;
        text-transform: uppercase;
        font-size: 0.85rem;
    }
    .fc-scrollgrid {
        border-radius: 4px;
    }
    .fc-day-today {
        background: rgba(0, 217, 255, 0.05) !important;
    }
    /* Event Styling */
    .fc-event {
        cursor: pointer;
        border-radius: 4px;
        border: none;
        padding: 4px 6px;
        font-size: 0.8rem;
        font-weight: 700;
        transition: transform 0.2s, box-shadow 0.2s;
        z-index: 1;
    }
    .fc-event-main {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        text-align: center;
    }
    .fc-event:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 20px rgba(0,0,0,0.8);
        z-index: 9999 !important;
        position: relative;
    }
    /* Tab / Button Styling */
    .fc-button-primary {
        background-color: transparent !important;
        border-color: var(--panel-border) !important;
        color: #fff !important;
    }
    .fc-button-primary:hover {
        background-color: rgba(255, 255, 255, 0.1) !important;
    }
    .fc-button-active {
        background-color: var(--accent-cyan) !important;
        color: #000 !important;
        border-color: var(--accent-cyan) !important;
        font-weight: bold;
    }
    .fc-toolbar-title {
        color: #fff !important;
        font-weight: 800 !important;
    }
    /* List View Override */
    .fc-list-day-cushion {
        background: rgba(255, 255, 255, 0.05) !important;
    }
    .fc-list-day-text, .fc-list-day-side-text {
        color: #00d9ff !important;
        font-weight: 800 !important;
    }
    .fc-list-event:hover td {
        background-color: rgba(255,255,255,0.05) !important;
    }
    .fc-list-event-time {
        color: #cbd5e1 !important;
    }
    .fc-list-event-title, .fc-list-event-title a {
        color: #fff !important;
        font-weight: 700;
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
        .schedule-header {
            padding: 1.25rem;
            margin-bottom: 1.5rem;
        }
        #calendar-container {
            padding: 0.75rem;
        }
        .fc-toolbar-chunk {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        /* Mencegah Squeezed (Terpotong) di Mobile Khusus Mode Grid */
        .fc-timegrid-view .fc-scrollgrid, .fc-daygrid-view .fc-scrollgrid {
            min-width: 700px !important; /* Paksa grid cukup lebar agar teks terbaca */
        }
        .fc-view-harness {
            overflow-x: auto !important;
            padding-bottom: 10px; /* Space untuk scrollbar */
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

    /* Modal Styling for Event Details */
    #eventModalOverlay {
        position: fixed; top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(5px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 10000;
    }
    #eventModalCard {
        background: #0b111a;
        width: 100%;
        max-width: 400px;
        border-radius: 12px;
        border: 1px solid rgba(0, 217, 255, 0.3);
        box-shadow: 0 0 40px rgba(0, 217, 255, 0.1);
        padding: 2rem;
        position: relative;
    }
    .event-info-group {
        margin-bottom: 1rem;
    }
    .event-info-label {
        color: var(--text-muted);
        font-size: 0.75rem;
        text-transform: uppercase;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }
    .event-info-value {
        color: #fff;
        font-weight: 600;
        font-size: 1rem;
    }
</style>

<div class="schedule-header">
    <h1 class="schedule-title">{{ $lang === 'id' ? 'Agregrasi Jadwal Global' : 'Global Schedule Aggregation' }}</h1>
    <p class="schedule-subtitle">{{ $lang === 'id' ? 'Pemantauan lintas-batas untuk keseluruhan reservasi laboratorium sistem UNESA.' : 'Cross-boundary monitoring for all laboratory reservations across the UNESA system.' }}</p>
</div>

<div id="calendar-container">
    <div id="calendar"></div>
</div>

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

<!-- Event Detail Modal -->
<div id="eventModalOverlay" onclick="closeEventModal()">
    <div id="eventModalCard" onclick="event.stopPropagation()">
        <button onclick="closeEventModal()" style="position: absolute; top: 1rem; right: 1rem; background: none; border: none; color: #fff; cursor: pointer;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
        <h3 style="margin-top: 0; color: var(--accent-cyan); border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 0.5rem;">
            {{ $lang === 'id' ? 'Detail Alokasi' : 'Allocation Details' }}
        </h3>
        <div class="event-info-group">
            <div class="event-info-label">{{ $lang === 'id' ? 'Pemohon / Entitas' : 'Applicant / Entity' }}</div>
            <div class="event-info-value" id="eV-pemohon">-</div>
        </div>
        <div class="event-info-group">
            <div class="event-info-label">{{ $lang === 'id' ? 'Titik Lokasi' : 'Location Point' }}</div>
            <div class="event-info-value" id="eV-lokasi">-</div>
        </div>
        <div class="event-info-group">
            <div class="event-info-label">{{ $lang === 'id' ? 'Status Pemantauan' : 'Monitoring Status' }}</div>
            <div class="event-info-value" id="eV-status">-</div>
        </div>
        <div class="event-info-group">
            <div class="event-info-label">{{ $lang === 'id' ? 'Rentang Waktu' : 'Time Frame' }}</div>
            <div class="event-info-value" id="eV-waktu">-</div>
        </div>
        <div style="margin-top: 2rem;">
            <button onclick="closeEventModal()" style="width: 100%; padding: 0.75rem; background: rgba(255,255,255,0.1); color: #fff; border: 1px solid rgba(255,255,255,0.2); border-radius: 6px; cursor: pointer; font-weight: bold; transition:0.3s;" onmouseover="this.style.background='rgba(255,255,255,0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                {{ $lang === 'id' ? 'Tutup Overlay' : 'Close Overlay' }}
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var rawEvents = {!! $scheduleEvents !!};
    
    // Secara otomatis menetapkan view ke "Daftar" jika layar berukuran HP.
    var isMobile = window.innerWidth <= 768;

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: isMobile ? 'listWeek' : 'dayGridMonth',
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
        events: rawEvents,
        eventClick: function(info) {
            info.jsEvent.preventDefault();
            var props = info.event.extendedProps;
            
            document.getElementById('eV-pemohon').innerText = props.pemohon || 'Anonim';
            document.getElementById('eV-lokasi').innerText = props.lokasi || 'Universal';
            document.getElementById('eV-status').innerHTML = '<span style="color:'+info.event.backgroundColor+'">' + (props.status ? props.status.toUpperCase() : '-') + '</span>';
            
            let formatOptions = { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' };
            let start = info.event.start ? info.event.start.toLocaleString('id-ID', formatOptions) : '';
            let end = info.event.end ? info.event.end.toLocaleString('id-ID', formatOptions) : 'Belum ditentukan';
            document.getElementById('eV-waktu').innerText = start + ' - ' + end;
            
            document.getElementById('eventModalOverlay').style.display = 'flex';
        },
        height: 'auto',
        allDaySlot: false,
        slotMinTime: '06:00:00',
        slotMaxTime: '22:00:00',
        expandRows: true
    });

    calendar.render();
    window.calendarInstance = calendar;
});

function changeCalView(viewName) {
    if(window.calendarInstance) {
        window.calendarInstance.changeView(viewName);
    }
    closeFilterModal();
}

function closeFilterModal() {
    document.getElementById('filterPopupOverlay').style.display = 'none';
}

function closeEventModal() {
    document.getElementById('eventModalOverlay').style.display = 'none';
}
</script>
