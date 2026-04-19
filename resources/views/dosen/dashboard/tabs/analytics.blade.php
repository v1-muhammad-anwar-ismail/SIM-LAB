<!-- Chart.js via CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

<style>
    .analytics-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .print-btn {
        background: #1e293b;
        color: #fff;
        border: 1px solid #334155;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: bold;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: 0.3s;
    }
    .print-btn:hover {
        background: #334155;
        border-color: #475569;
    }
    .chart-container {
        background: rgba(10, 16, 22, 0.9);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 1.5rem;
        position: relative;
    }
    .chart-box {
        width: 100%;
        height: 350px;
    }
    .chart-box.small {
        height: 250px;
    }
    .chart-title {
        color: #cbd5e1;
        font-weight: bold;
        margin-bottom: 1rem;
        text-align: center;
        font-size: 1.1rem;
    }
    
    .dashboard-charts {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .dashboard-charts-bottom {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .print-kop {
        display: none;
    }

    @media print {
        @page { size: A4 portrait; margin: 15mm; }
        
        /* Reset paksa dimensi fisik ke area kertas A4 */
        html, body, #app, .main-content, .content-wrapper, main {
            width: 100% !important;
            min-width: 0 !important;
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            background: #fff !important;
            overflow: visible !important;
        }

        .sidebar, .navbar, .top-bar, .hunter-top-bar, nav, header, footer, .welcome-banner, .dosen-tabs, .dashboard-tabs, .tab-buttons {
            display: none !important;
        }

        .analytics-print-area {
            position: relative !important;
            left: auto !important;
            top: auto !important;
            width: 100% !important;
            background: #fff !important;
            color: #000 !important;
            border: none !important; /* Buang border raksasa yang terpotong antar halaman */
            padding: 0 !important;
            box-sizing: border-box !important;
        }

        .no-print {
            display: none !important;
        }

        /* HEADER RESMI / KOP */
        .print-kop {
            display: block !important;
            text-align: center;
            border-bottom: 2px dashed #000;
            padding-bottom: 1rem;
            margin-bottom: 1.5rem;
            color: #000 !important;
        }

        .chart-container {
            background: #fff !important;
            border: none !important; /* Dihapus agar tidak meninggalkan garis canggung yang tak selaras dengan sumbu XY diagram */
            border-radius: 0 !important;
            box-shadow: none !important;
            break-inside: avoid;
            page-break-inside: avoid;
            margin-bottom: 3rem !important; /* Ditambah drastis supaya elemen bawah tidak memotong sumbu X atasnya */
            width: 100% !important;
            box-sizing: border-box;
        }
        
        .chart-title {
            color: #000 !important;
            border-bottom: 1px solid #ccc;
            padding-bottom: 0.5rem;
        }

        .dashboard-charts-bottom {
            display: block !important; /* Bertumpuk vertikal */
        }

        .chart-box {
            height: 250px !important;
            width: 95% !important; /* Diperkecil menjadi 95% agar ada margin aman di tepi kanan kertas A4 */
            max-width: 95% !important;
            margin: 0 auto !important;
            position: relative;
        }
        .chart-box.small {
            height: 220px !important;
            width: 95% !important;
            max-width: 95% !important;
            margin: 0 auto !important;
            position: relative;
        }
        .chart-box canvas {
            width: 100% !important;
            max-width: 100% !important;
            height: 100% !important;
            max-height: 100% !important;
        }

        .print-explanation {
            display: block !important;
            margin-top: 2rem;
            page-break-inside: auto;
        }

        /* Paksa Print Warna */
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;
        }
    }
</style>

<div class="analytics-print-area">
    <!-- KOP RESMI CUMA MUNCUL SAAT PRINT -->
    <div class="print-kop">
        <h2 style="margin: 0; font-size: 1.5rem; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; color:#000;">
            {{ $lang === 'id' ? 'BUKTI ANALITIK TRANSAKSI SIM-LAB' : 'SIM-LAB ANALYTIC TRANSACTION RECEIPT' }}
        </h2>
        <div style="font-size: 0.95rem; margin-top: 0.75rem; color:#000; line-height: 1.6;">
            <strong>Penanggung Jawab:</strong> {{ $user->name }} ({{ $user->nomor_induk ?? $user->id }})<br>
            <strong>ID Evaluasi:</strong> #EVAL-{{ strtoupper(substr(md5(time()), 0, 8)) }}<br>
            <strong>Dicetak pada:</strong> {{ \Carbon\Carbon::now()->format('d M Y - H:i:s') }}
        </div>
    </div>

    <!-- TAMPILAN NORMAL (DISEMBUNYIKAN SAAT PRINT) -->
    <div class="analytics-header no-print">
        <h2 style="margin: 0; color: #fff; font-size: 1.8rem; font-weight: 800;">
            {{ $lang === 'id' ? 'Laporan Analitik Penggunaan' : 'Usage Analytics Report' }}
        </h2>
        <button onclick="window.print()" class="print-btn" title="Cetak ke PDF">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
            {{ $lang === 'id' ? 'Cetak Laporan Akademis (PDF)' : 'Print Academic Report (PDF)' }}
        </button>
    </div>

    <div class="dashboard-charts">
        <!-- 1. BAR CHART: Tren Bulanan -->
        <div class="chart-container">
            <h3 class="chart-title">{{ $lang === 'id' ? 'Tren Frekuensi Peminjaman (6 Bulan Terakhir)' : 'Borrowing Frequency Trend (Last 6 Months)' }}</h3>
            <div class="chart-box">
                <canvas id="trendChart"></canvas>
            </div>
        </div>
    </div>

    <div class="dashboard-charts-bottom">
        <!-- 2. DOUGHNUT CHART: Rasio Tipe Ruang VS Alat -->
        <div class="chart-container">
            <h3 class="chart-title">{{ $lang === 'id' ? 'Rasio Fokus Penugasan (Ruang vs Alat)' : 'Focus Assignment Ratio (Room vs Tool)' }}</h3>
            <div class="chart-box small">
                <canvas id="typeChart"></canvas>
            </div>
        </div>

        <!-- 3. PIE CHART: Distribusi Status -->
        <div class="chart-container">
            <h3 class="chart-title">{{ $lang === 'id' ? 'Distribusi Eksekusi Status Pengajuan' : 'Request Status Execution Distribution' }}</h3>
            <div class="chart-box small">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    <!-- PENJELASAN DESKRIPTIF (Informasi Ekstra Dinamis) -->
    @php
        $tipeDataArray = json_decode($chartTipeData, true);
        $totalTipe = array_sum($tipeDataArray);
        $persenAlat = $totalTipe > 0 ? round(($tipeDataArray[0] / $totalTipe) * 100) : 0;
        $persenRuang = $totalTipe > 0 ? round(($tipeDataArray[1] / $totalTipe) * 100) : 0;
        
        $statusDataArray = json_decode($chartStatusData, true);
        $totalStatus = array_sum($statusDataArray);
        $persenDisetujui = $totalStatus > 0 ? round(($statusDataArray[0] / $totalStatus) * 100) : 0;
        $persenMenunggu = $totalStatus > 0 ? round(($statusDataArray[1] / $totalStatus) * 100) : 0;
        $persenDitolak = $totalStatus > 0 ? round(($statusDataArray[2] / $totalStatus) * 100) : 0;
    @endphp
    
    <div class="print-explanation" style="display: none; padding: 1.5rem; background: rgba(0, 217, 255, 0.05); border: 1px solid rgba(0, 217, 255, 0.2); border-radius: 8px; margin-top: 2rem;">
        <h3 style="color: var(--accent-cyan); font-weight: 800; font-size: 1.1rem; margin-top: 0; margin-bottom: 1rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 0.5rem; color: #000 !important; border-bottom-color: #ccc !important;">
            {{ $lang === 'id' ? 'Catatan Keterangan Laporan (Glosa)' : 'Report Glossary & Notes' }}
        </h3>
        <ul style="color: var(--text-muted); font-size: 0.85rem; padding-left: 1.2rem; margin: 0; line-height: 1.6; color: #000 !important;">
            <li style="margin-bottom: 0.5rem;">
                <strong style="color: #fff; color: #000 !important;">Tren Frekuensi Peminjaman:</strong> 
                Menunjukkan intensistas penggunaan lab dalam kurun 6 bulan terakhir. Fluktuasi batang ke atas mengindikasikan masa padat karya riset/observasi.
            </li>
            <li style="margin-bottom: 0.5rem;">
                <strong style="color: #fff; color: #000 !important;">Rasio Fokus Penugasan (Ruang {{ $persenRuang }}%, Alat {{ $persenAlat }}%):</strong> 
                Menggambarkan proporsi persentase alat cetak/fasilitas yang menjadi target utama mahasiswa. Data dinamis saat ini memperlihatkan kecenderungan target mengarah ke penyewaan {{ $persenAlat > 50 ? 'Aset Alat Portabel' : 'Laboratorium Fisik (Ruang)' }}.
            </li>
            <li>
                <strong style="color: #fff; color: #000 !important;">Distribusi Eksekusi Status (Disetujui {{ $persenDisetujui }}%, Menunggu {{ $persenMenunggu }}%, Ditolak {{ $persenDitolak }}%):</strong> 
                Mengukur efisiensi kerja Master Lab. {{ $persenMenunggu >= $persenDisetujui ? 'Peringatan! Antrean menumpuk dan mendominasi sistem, validasi Aslab terpantau berjalan lambat.' : 'Sirkulasi bersih. Laju verifikasi pengajuan berjalan lancar melebihi hambatan birokrasi.' }}
            </li>
        </ul>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Daftarkan Plugin Datalabels global
    Chart.register(ChartDataLabels);

    // Styling Global untuk ChartJS (Tema Gelap Formal tapi bisa terbaca saat print putih)
    Chart.defaults.color = '#000000'; // Paksa ke warna hitam tegas
    Chart.defaults.font.family = 'Inter, sans-serif';
    Chart.defaults.font.weight = 'bold';

    // 1. CHART TREN BULANAN (BAR)
    const ctxTrend = document.getElementById('trendChart').getContext('2d');
    new Chart(ctxTrend, {
        type: 'bar', // Bar lebih mudah dibaca untuk laporan instansi
        data: {
            labels: {!! $chartBulanLabels !!},
            datasets: [{
                label: '{{ $lang === 'id' ? "Total Tiket Pengajuan" : "Total Request Tickets" }}',
                data: {!! $chartBulanData !!},
                backgroundColor: 'rgba(54, 162, 235, 0.7)', // Biru Korporat Resmi
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            layout: { padding: { bottom: 20, right: 30 } }, // Mengamankan tempat sumbu X dan memberi ruang pilar Bulan terakhir agar aman
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 },
                    grid: { color: 'rgba(255, 255, 255, 0.05)' }
                },
                x: {
                    grid: { color: 'rgba(255, 255, 255, 0.05)' }
                }
            },
            plugins: {
                legend: { display: false },
                datalabels: {
                    display: function(context) { return context.dataset.data[context.dataIndex] > 0; },
                    color: '#000',
                    anchor: 'end',
                    align: 'top',
                    font: { weight: 'bold', size: 14 }
                }
            }
        }
    });

    // 2. CHART RASIO TIPE (DOUGHNUT)
    const ctxType = document.getElementById('typeChart').getContext('2d');
    new Chart(ctxType, {
        type: 'doughnut',
        data: {
            labels: ['{{ $lang === 'id' ? "Aset Alat" : "Tools" }}', '{{ $lang === 'id' ? "Ruang Lab" : "Lab Rooms" }}'],
            datasets: [{
                data: {!! $chartTipeData !!},
                backgroundColor: [
                    'rgba(54, 162, 235, 0.8)',   // Biru
                    'rgba(148, 163, 184, 0.8)'   // Abu-abu resmi
                ],
                borderColor: '#0f172a',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '60%',
            plugins: {
                legend: { position: 'bottom', labels: { color: '#000' } },
                datalabels: {
                    color: '#fff',
                    font: { weight: 'bold', size: 14 },
                    formatter: (value, ctx) => {
                        let sum = 0;
                        let dataArr = ctx.chart.data.datasets[0].data;
                        dataArr.map(data => { sum += data; });
                        if(sum === 0) return '0%';
                        let percentage = (value*100 / sum).toFixed(0)+"%";
                        return percentage;
                    }
                }
            }
        }
    });

    // 3. CHART DISTRIBUSI STATUS (PIE)
    const ctxStatus = document.getElementById('statusChart').getContext('2d');
    new Chart(ctxStatus, {
        type: 'pie',
        data: {
            labels: ['{{ $lang === 'id' ? "Disetujui/Berjalan" : "Approved/Running" }}', '{{ $lang === 'id' ? "Menunggu Antrean" : "Pending Queue" }}', '{{ $lang === 'id' ? "Ditolak/Batal" : "Rejected/Canceled" }}'],
            datasets: [{
                data: {!! $chartStatusData !!},
                backgroundColor: [
                    'rgba(34, 197, 94, 0.8)',    // Hijau Sukses Standar
                    'rgba(234, 179, 8, 0.8)',    // Kuning Menunggu
                    'rgba(239, 68, 68, 0.8)'     // Merah Ditolak
                ],
                borderColor: '#0f172a',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { color: '#000' } },
                datalabels: {
                    color: '#fff',
                    font: { weight: 'bold', size: 14, textStrokeColor: '#000', textStrokeWidth: 1 },
                    formatter: (value, ctx) => {
                        let sum = 0;
                        let dataArr = ctx.chart.data.datasets[0].data;
                        dataArr.map(data => { sum += data; });
                        if(sum === 0) return '0%';
                        let percentage = (value*100 / sum).toFixed(0)+"%";
                        return percentage;
                    }
                }
            }
        }
    });
});
</script>
