<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DosenController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $lang = session('locale', 'id');
        $panelTitle = $lang === 'id' ? 'Dosen' : 'Lecturer';

        if ($user->role !== 'dosen') {
            return redirect()->route('student.dashboard')->withErrors('Unauthorized action.');
        }
        $tab = $request->get('tab', 'overview');

        // Menarik data esensial untuk modal "Booking Cepat"
        $alats = \App\Models\Alat::with(['laboratorium.master', 'laboratorium.aslabs'])
                    ->where('kondisi', 'baik')->where('stok', '>', 0)
                    ->orderBy('nama_alat')->get()
                    ->filter(function($alat) { return $alat->available_stok > 0; });
        
        $labs = \App\Models\Laboratorium::orderBy('nama_lab')->get();
        $semuaAlat = $alats->values(); // alias untuk dropdown pengajuan

        // Metriks Global Dosen (Observer Level)
        $pendingPeminjaman = \App\Models\Peminjaman::where('status', 'menunggu')->count();
        $monitoringAktif = \App\Models\Peminjaman::where('status', 'dipinjam')->count();
        $totalLaporan = \App\Models\Peminjaman::count();
        $peringatanSistem = \App\Models\Notifikasi::where('user_id', $user->id)->where('is_read', false)->count();

        // 5 Aktivitas Terbaru Secara Global
        $recentPeminjaman = \App\Models\Peminjaman::with(['user', 'laboratorium'])
                                ->latest()
                                ->take(5)
                                ->get();
                                
        $scheduleEvents = '[]';
        if ($tab === 'schedule') {
            $eventsQuery = \App\Models\Peminjaman::whereIn('status', ['menunggu', 'disetujui', 'dipinjam'])
                                ->with(['user', 'laboratorium'])
                                ->get();
            $eventsResponse = [];
            foreach($eventsQuery as $p) {
                $color = '#22c55e'; // default success / disetujui / dipinjam
                if($p->status === 'menunggu') $color = '#eab308'; // warning
                
                $eventsResponse[] = [
                    'id' => $p->id,
                    'title' => '['.strtoupper($p->status).'] ' . ($p->user->name ?? 'Anonim'),
                    'start' => \Carbon\Carbon::parse($p->tanggal_mulai)->toIso8601String(),
                    'end' => \Carbon\Carbon::parse($p->tanggal_selesai)->toIso8601String(),
                    'color' => $color,
                    'extendedProps' => [
                        'status' => $p->status,
                        'lokasi' => $p->laboratorium->nama_lab ?? 'Universal',
                        'pemohon' => $p->user->name ?? 'Anonim',
                        'jenis' => $p->jenis_peminjaman
                    ]
                ];
            }
            $scheduleEvents = json_encode($eventsResponse);
        }

        $liveLabs = null;
        $liveSessions = null;
        $alatRisks = null;
        $availableAlats = null;
        
        if ($tab === 'monitoring') {
            $liveLabs = \App\Models\Laboratorium::with(['master', 'aslabs'])->withCount(['peminjaman as active_sessions' => function ($query) {
                $query->where('status', 'dipinjam');
            }])->get();
            
            $liveSessions = \App\Models\Peminjaman::with(['user', 'laboratorium', 'detailPeminjaman.alat'])
                            ->whereIn('status', ['menunggu', 'disetujui', 'dipinjam'])
                            ->orderBy('updated_at', 'desc')
                            ->get();
            
            $semuaAset = \App\Models\Alat::with(['laboratorium'])->get();
            
            $alatRisks = $semuaAset->filter(function($alat) {
                                $isRisky = $alat->kondisi === 'rusak' || $alat->stok <= 5;
                                $isLowAvail = isset($alat->available_stok) && $alat->available_stok <= 2;
                                return $isRisky || $isLowAvail;
                            })->take(8);
            
            $availableAlats = $semuaAset->filter(function($alat) {
                                return $alat->kondisi === 'baik' && (!isset($alat->available_stok) || $alat->available_stok > 0);
                            });
        }
        
        $chartBulanLabels = '[]';
        $chartBulanData = '[]';
        $chartTipeData = '[]';
        $chartStatusData = '[]';
        
        if ($tab === 'analytics') {
            // 1. Data Tren 6 Bulan Terakhir
            $sixMonthsAgo = \Carbon\Carbon::now()->subMonths(5)->startOfMonth();
            $monthlyData = \App\Models\Peminjaman::where('created_at', '>=', $sixMonthsAgo)
                            ->selectRaw("TO_CHAR(created_at, 'YYYY-MM') as month, count(*) as count")
                            ->groupBy('month')
                            ->orderBy('month', 'asc')
                            ->get()
                            ->keyBy('month');
            
            $labels = [];
            $dataCount = [];
            
            for ($i = 5; $i >= 0; $i--) {
                $monthStr = \Carbon\Carbon::now()->subMonths($i)->format('Y-m');
                $monthDisplay = \Carbon\Carbon::now()->subMonths($i)->format('M Y');
                $labels[] = $monthDisplay;
                $dataCount[] = isset($monthlyData[$monthStr]) ? $monthlyData[$monthStr]->count : 0;
            }
            $chartBulanLabels = json_encode($labels);
            $chartBulanData = json_encode($dataCount);
            
            // 2. Data Rasio Tipe
            $alatCount = \App\Models\Peminjaman::where('jenis_peminjaman', 'alat')->count();
            $ruangCount = \App\Models\Peminjaman::where('jenis_peminjaman', 'ruang')->count();
            $chartTipeData = json_encode([$alatCount, $ruangCount]);
            
            // 3. Data Distribusi Status
            $statusDisetujui = \App\Models\Peminjaman::whereIn('status', ['disetujui', 'dipinjam', 'selesai'])->count();
            $statusMenunggu = \App\Models\Peminjaman::where('status', 'menunggu')->count();
            $statusDitolak = \App\Models\Peminjaman::where('status', 'ditolak')->count();
            $chartStatusData = json_encode([$statusDisetujui, $statusMenunggu, $statusDitolak]);
        }
        
        $riwayatPeminjaman = collect();
        if ($tab === 'riwayat') {
            // Eager loading super cepat NFR-01 menghindari iterasi query loop mematikan
            $riwayatPeminjaman = \App\Models\Peminjaman::with(['user', 'laboratorium', 'detailPeminjaman.alat'])
                            ->orderBy('created_at', 'desc')
                            ->get();
        }

        return view('dosen.dashboard.index', compact(
            'user', 'lang', 'panelTitle', 'tab', 
            'alats', 'labs', 'semuaAlat',
            'pendingPeminjaman', 'monitoringAktif', 'totalLaporan', 'peringatanSistem', 'recentPeminjaman',
            'scheduleEvents', 'liveLabs', 'liveSessions', 'alatRisks', 'availableAlats',
            'chartBulanLabels', 'chartBulanData', 'chartTipeData', 'chartStatusData', 'riwayatPeminjaman'
        ));
        
    }
}
