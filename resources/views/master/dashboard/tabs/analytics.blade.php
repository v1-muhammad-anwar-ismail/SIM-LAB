    <div class="welcome-banner" style="margin-bottom: 2rem;">
        <div class="status-badge" style="background: rgba(168, 85, 247, 0.1); color: #a855f7; border-color: rgba(168, 85, 247, 0.3);">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
            {{ $lang === 'id' ? 'Kecerdasan Data' : 'Data Intelligence' }}
        </div>
        <h1 class="welcome-title">{{ $lang === 'id' ? 'Analitik Operasional' : 'Operational Analytics' }}</h1>
        <p class="welcome-subtitle">
            {{ $lang === 'id' ? 'Visualisasi data mendalam untuk mengamati tren sirkulasi peminjaman aset, beban stasiun laboratorium, dan kesehatan inventarisasi global.' : 'In-depth data visualization to observe asset lending circulation trends, laboratory station loads, and global inventory health.' }}
        </p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-bottom: 1.5rem;">
        <!-- Grafik Distribusi Kondisi Aset -->
        <div style="background: rgba(10, 16, 22, 0.5); border: 1px solid var(--panel-border); border-radius: 1rem; padding: 1.5rem;">
            <h3 style="font-size: 1.1rem; font-weight: 800; margin-top: 0; margin-bottom: 1.5rem; color: #fff; display: flex; align-items: center; gap: 0.5rem;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--accent-cyan)" stroke-width="2"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path><path d="M22 12A10 10 0 0 0 12 2v10z"></path></svg>
                {{ $lang === 'id' ? 'Kesehatan Inventaris Global' : 'Global Inventory Health' }}
            </h3>
            <div id="inventoryHealthChart" style="min-height: 250px; display: flex; justify-content: center; align-items: center;"></div>
        </div>

        <!-- Grafik Beban Laboratorium -->
        <div style="background: rgba(10, 16, 22, 0.5); border: 1px solid var(--panel-border); border-radius: 1rem; padding: 1.5rem;">
            <h3 style="font-size: 1.1rem; font-weight: 800; margin-top: 0; margin-bottom: 1.5rem; color: #fff; display: flex; align-items: center; gap: 0.5rem;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#a855f7" stroke-width="2"><rect x="18" y="3" width="4" height="18"></rect><rect x="10" y="8" width="4" height="13"></rect><rect x="2" y="13" width="4" height="8"></rect></svg>
                {{ $lang === 'id' ? 'Kapasitas Aset per Lab' : 'Asset Capacity per Lab' }}
            </h3>
            <div id="laboratoryLoadChart" style="min-height: 250px; display: flex; justify-content: center; align-items: center;"></div>
        </div>
    </div>

    <!-- Grafik Intensitas Peminjaman (Area Chart) -->
    <div style="background: rgba(10, 16, 22, 0.5); border: 1px solid var(--panel-border); border-radius: 1rem; padding: 1.5rem;">
        <h3 style="font-size: 1.1rem; font-weight: 800; margin-top: 0; margin-bottom: 1.5rem; color: #fff; display: flex; align-items: center; gap: 0.5rem;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
            {{ $lang === 'id' ? 'Sirkulasi Transaksi (30 Hari)' : 'Transaction Circulation (30 Days)' }}
        </h3>
        <div id="loanIntensityChart" style="min-height: 300px;"></div>
    </div>

    <!-- Injection Data via JS -->
    <script id="analyticsData" type="application/json">
        {!! $analyticsDataString ?? '{}' !!}
    </script>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(() => {
                const dataRaw = document.getElementById('analyticsData').textContent;
                let chartsData = {};
                try {
                    chartsData = JSON.parse(dataRaw);
                } catch(e) {
                    console.error("Data analitik gagal diparse", e);
                }

                // 1. Chart Kesehatan (Doughnut)
                if(chartsData.kondisi && chartsData.kondisi.length == 2) {
                    var optionsHealth = {
                        series: chartsData.kondisi,
                        chart: { type: 'donut', height: 280, background: 'transparent' },
                        labels: ["{{ $lang === 'id' ? 'Layak & Beraksi' : 'Fit & Active' }}", "{{ $lang === 'id' ? 'Kritis / Rusak' : 'Critical / Broken' }}"],
                        colors: ['#00d9ff', '#ef4444'],
                        stroke: { show: true, colors: ['#02040a'], width: 2 },
                        dataLabels: { enabled: false },
                        plotOptions: {
                            pie: {
                                donut: { size: '75%', labels: { show: true, name: { color: '#cbd5e1' }, value: { color: '#fff', fontSize: '24px', fontWeight: 800 } } }
                            }
                        },
                        theme: { mode: 'dark' },
                        legend: { position: 'bottom', labels: { colors: '#cbd5e1' } }
                    };
                    new ApexCharts(document.querySelector("#inventoryHealthChart"), optionsHealth).render();
                } else {
                    document.getElementById('inventoryHealthChart').innerHTML = '<span style="color:var(--text-muted)">{{ $lang === "id" ? "Data Insufficient" : "Data Insufficient" }}</span>';
                }

                // 2. Chart Kapasitas Alat Lab (Bar)
                if(chartsData.barData && chartsData.barLabels) {
                    var optionsLoad = {
                        series: [{ name: 'Aset Fisik', data: chartsData.barData }],
                        chart: { type: 'bar', height: 280, toolbar: { show: false }, background: 'transparent' },
                        colors: ['#a855f7'],
                        plotOptions: { bar: { borderRadius: 4, horizontal: true, distributed: true } },
                        dataLabels: { enabled: true, style: { colors: ['#fff'] } },
                        xaxis: { categories: chartsData.barLabels, labels: { style: { colors: '#cbd5e1' } }, axisBorder: { show: false } },
                        yaxis: { labels: { style: { colors: '#cbd5e1', fontWeight: 600 } } },
                        grid: { borderColor: 'rgba(255,255,255,0.05)', strokeDashArray: 4 },
                        theme: { mode: 'dark' },
                        legend: { show: false }
                    };
                    new ApexCharts(document.querySelector("#laboratoryLoadChart"), optionsLoad).render();
                } else {
                    document.getElementById('laboratoryLoadChart').innerHTML = '<span style="color:var(--text-muted)">{{ $lang === "id" ? "Data Insufficient" : "Data Insufficient" }}</span>';
                }

                // 3. Chart Intensitas (Area)
                if(chartsData.lineDates && chartsData.lineCounts) {
                    var optionsIntensity = {
                        series: [{ name: 'Volume Peminjaman', data: chartsData.lineCounts }],
                        chart: { type: 'area', height: 320, toolbar: { show: false }, background: 'transparent',
                                 animations: { enabled: true, easing: 'easeinout', speed: 800 } },
                        colors: ['#22c55e'],
                        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05, stops: [0, 100] } },
                        dataLabels: { enabled: false },
                        stroke: { curve: 'smooth', width: 3 },
                        xaxis: { categories: chartsData.lineDates, labels: { style: { colors: '#cbd5e1' } }, axisBorder: { show: false }, axisTicks: { show: false } },
                        yaxis: { labels: { style: { colors: '#cbd5e1', fontWeight: 600 } } },
                        grid: { borderColor: 'rgba(255,255,255,0.05)', strokeDashArray: 4, xaxis: { lines: { show: true } }, yaxis: { lines: { show: true } } },
                        theme: { mode: 'dark' },
                        tooltip: { theme: 'dark' }
                    };
                    new ApexCharts(document.querySelector("#loanIntensityChart"), optionsIntensity).render();
                } else {
                    document.getElementById('loanIntensityChart').innerHTML = '<span style="color:var(--text-muted)">{{ $lang === "id" ? "Data Insufficient" : "Data Insufficient" }}</span>';
                }
            }, 100);
        });
    </script>
    @endpush
