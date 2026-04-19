<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Peminjaman;
use App\Models\Alat;
use App\Models\Laboratorium;
use App\Models\Notifikasi;
use App\Models\DetailPeminjaman;
use Illuminate\Support\Facades\Storage;

class AsistenController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $lang = session('locale', 'id');
        $panelTitle = $lang === 'id' ? 'Asisten' : 'Assistant';

        if ($user->role !== 'asisten') {
            return redirect()->route('student.dashboard')->withErrors('Unauthorized action.');
        }

        // Ambil Data Notifikasi untuk Header (Universal)
        $unreadNotifs = Notifikasi::where('user_id', $user->id)
                                  ->where('is_read', false)
                                  ->count();

        // Tangani Request Tab Navigation
        $tab = $request->query('tab', 'overview');

        // Parameter Khusus Asisten
        $laboratorium = $user->laboratorium_jaga; // Karena di tabel users ada laboratorium_id

        $approvalsList = collect();
        $returnsList = collect();
        $inventoryList = collect();
        $scheduleEvents = '[]';
        $pendingPeminjaman = 0;
        $monitoringAktif = 0;
        $totalLaporan = 0;
        $peringatanSistem = $unreadNotifs;
        $recentPeminjaman = collect();
        $totAlat = 0;
        $totBaik = 0;
        $totRusak = 0;

        // Inisialisasi daftar list untuk mencegah undefined saat ganti tab
        $approvalsList = null;
        $readyList = null;
        $returnsList = null;
        $inventoryList = collect();
        $riwayatList = null;
        $maintenanceList = null;

        if ($laboratorium) {
            $totalLaporan = Peminjaman::where('laboratorium_id', $laboratorium->id)->count();
            $inventoryList = Alat::where('laboratorium_id', $laboratorium->id)->get();
            $totAlat = $inventoryList->sum('stok');
            $totBaik = $inventoryList->where('kondisi', 'baik')->sum('stok');
            $totRusak = $inventoryList->where('kondisi', 'rusak')->sum('stok');
            
            if ($tab === 'overview') {
                $pendingPeminjaman = Peminjaman::where('status', 'menunggu')->where('laboratorium_id', $laboratorium->id)->count();
                $monitoringAktif = Peminjaman::where('status', 'dipinjam')->where('laboratorium_id', $laboratorium->id)->count();
                $recentPeminjaman = Peminjaman::where('status', 'menunggu')
                                        ->where('laboratorium_id', $laboratorium->id)
                                        ->with(['user', 'laboratorium'])
                                        ->oldest()
                                        ->take(5)
                                        ->get();
            } elseif ($tab === 'approvals') {
                $approvalsList = Peminjaman::where('status', 'menunggu')
                                        ->where('laboratorium_id', $laboratorium->id)
                                        ->with(['user', 'laboratorium', 'detailPeminjaman.alat'])
                                        ->oldest()
                                        ->get();
            } elseif ($tab === 'returns') {
                $readyList = Peminjaman::where('status', 'disetujui')
                                        ->where('laboratorium_id', $laboratorium->id)
                                        ->with(['user', 'laboratorium', 'detailPeminjaman.alat'])
                                        ->oldest()
                                        ->get();
                $returnsList = Peminjaman::where('status', 'dipinjam')
                                        ->where('laboratorium_id', $laboratorium->id)
                                        ->with(['user', 'laboratorium', 'detailPeminjaman.alat'])
                                        ->oldest()
                                        ->get();
            } elseif ($tab === 'inventory') {
                $inventoryList = Alat::with('laboratorium')->where('laboratorium_id', $laboratorium->id)->orderBy('kode_alat', 'asc')->get();
            } elseif ($tab === 'schedule') {
                $eventsResponse = [];
                $eventsQuery = Peminjaman::whereIn('status', ['disetujui', 'dipinjam'])
                                    ->where('laboratorium_id', $laboratorium->id)
                                    ->with('user')
                                    ->get();
                foreach($eventsQuery as $p) {
                    $eventsResponse[] = [
                        'title' => 'Pinjam: ' . ($p->user->name ?? 'Anonim'),
                        'start' => \Carbon\Carbon::parse($p->tanggal_mulai)->toIso8601String(),
                        'end' => \Carbon\Carbon::parse($p->tanggal_selesai)->toIso8601String(),
                        'color' => $p->status === 'dipinjam' ? '#eab308' : '#22c55e',
                        'display' => 'block',
                        'textColor' => '#000000',
                        'extendedProps' => [
                            'keperluan' => $p->keperluan,
                            'status' => $p->status,
                            'user_id' => $p->user_id
                        ]
                    ];
                }
                $scheduleEvents = json_encode($eventsResponse);
            } elseif ($tab === 'riwayat') {
                $riwayatList = Peminjaman::whereIn('status', ['dikembalikan', 'ditolak', 'batal'])
                                        ->where('laboratorium_id', $laboratorium->id)
                                        ->with(['user', 'laboratorium', 'detailPeminjaman.alat', 'approval.approver'])
                                        ->orderBy('updated_at', 'desc')
                                        ->get();
            } elseif ($tab === 'maintenance') {
                $maintenanceList = Alat::where('laboratorium_id', $laboratorium->id)
                                       ->where('kondisi', 'rusak')
                                       ->get();
            }
        }

        return view('asisten.dashboard.index', compact(
            'user', 'lang', 'panelTitle', 'unreadNotifs', 'tab',
            'pendingPeminjaman', 'monitoringAktif', 'peringatanSistem', 'recentPeminjaman', 'totalLaporan',
            'approvalsList', 'readyList', 'returnsList', 'inventoryList', 'scheduleEvents', 'laboratorium',
            'totAlat', 'totBaik', 'totRusak', 'riwayatList', 'maintenanceList'
        ));
    }

    public function processApproval(Request $request, $id)
    {
        $user = Auth::user();
        $lang = session('locale', 'id');

        $request->validate([
            'action' => 'required|in:approve,reject',
            'catatan' => 'nullable|string'
        ]);

        $peminjaman = Peminjaman::findOrFail($id);

        if ($user->role === 'asisten' && $peminjaman->laboratorium_id === $user->laboratorium_id) {
            if ($request->action === 'approve') {
                $peminjaman->status = 'disetujui';
                $peminjaman->save();

                \App\Models\Approval::create([
                    'peminjaman_id' => $peminjaman->id,
                    'approver_id' => $user->id,
                    'status_approval' => 'disetujui',
                    'catatan' => $request->catatan ?? 'Sistem: Disetujui Aslab'
                ]);

                Notifikasi::create([
                    'user_id' => $peminjaman->user_id,
                    'judul' => 'system_alert',
                    'pesan' => 'Pengajuan Peminjaman Lab Anda telah disetujui oleh Asisten Lab. Catatan: ' . ($request->catatan ?? 'Tidak ada')
                ]);

            } else {
                $peminjaman->status = 'ditolak';
                $peminjaman->save();

                \App\Models\Approval::create([
                    'peminjaman_id' => $peminjaman->id,
                    'approver_id' => $user->id,
                    'status_approval' => 'ditolak',
                    'catatan' => $request->catatan ?? 'Sistem: Ditolak Aslab'
                ]);

                Notifikasi::create([
                    'user_id' => $peminjaman->user_id,
                    'judul' => 'system_alert',
                    'pesan' => 'Mohon maaf, Pengajuan Peminjaman Lab Anda ditolak oleh Asisten Lab dengan alasan: ' . ($request->catatan ?? 'Tidak Ada')
                ]);
            }

            return redirect()->back()->with('success', $lang === 'id' ? 'Keputusan berhasil dieksekusi.' : 'Decision executed successfully.');
        }

        return redirect()->back()->withErrors('Unauthorized action.');
    }

    public function processHandover(Request $request, $id)
    {
        $user = Auth::user();
        $lang = session('locale', 'id');

        $peminjaman = Peminjaman::findOrFail($id);

        if ($user->role === 'asisten' && $peminjaman->laboratorium_id === $user->laboratorium_id) {
            $peminjaman->status = 'dipinjam';
            // Set waktu aktual penarikan barang
            // Jika ada kolom waktu_mulai yang sebenarnya, set di sini
            $peminjaman->save();

            \App\Models\LogAktivitas::create([
                'user_id' => $user->id,
                'aktivitas' => 'Melakukan serah-terima peminjaman #' . $peminjaman->id . ' kepada mahasiswa.'
            ]);

            Notifikasi::create([
                'user_id' => $peminjaman->user_id,
                'judul' => 'system_alert',
                'pesan' => 'Status Berjalan: Barang/Sesi Lab Anda telah diserahkan (Handover). Harap patuhi tenggat waktu peminjaman!'
            ]);

            return redirect()->back()->with('success', $lang === 'id' ? 'Barang resmi dialihkan ke Peminjam.' : 'Asset officially handed over to Borrower.');
        }

        return redirect()->back()->withErrors('Unauthorized action.');
    }

    public function processReturn(Request $request, $id)
    {
        $user = Auth::user();
        $lang = session('locale', 'id');

        $request->validate([
            'catatan_kondisi' => 'nullable|string',
            'laporan_rusak' => 'nullable|boolean'
        ]);

        $peminjaman = Peminjaman::findOrFail($id);

        if ($user->role === 'asisten' && $peminjaman->laboratorium_id === $user->laboratorium_id) {
            $peminjaman->status = 'dikembalikan';
            $peminjaman->save();

            \App\Models\LogAktivitas::create([
                'user_id' => $user->id,
                'aktivitas' => 'Menyelesaikan peminjaman #' . $peminjaman->id . ' dan memvalidasi barang masuk.'
            ]);

            // Skenario 1: Jika barang rusak
            if ($request->boolean('laporan_rusak') || $request->laporan_rusak == '1') {
                Notifikasi::create([
                    'user_id' => $peminjaman->user_id,
                    'judul' => 'system_alert',
                    'pesan' => 'PENGEMBALIAN BERMASALAH (DENDA): Asisten melaporkan kerusakan barang pinjaman Anda. (Catatan: ' . ($request->catatan_kondisi ?? '-') . '). Silakan lapor ke Master Lab!'
                ]);

                // Menembak notifikasi langsung ke Master Lab terkait
                $masterLabId = $peminjaman->laboratorium->master_id ?? null;
                if ($masterLabId) {
                    Notifikasi::create([
                        'user_id' => $masterLabId,
                        'judul' => 'system_alert',
                        'pesan' => 'LAPORAN KERUSAKAN: Aslab Anda baru saja menandai aset yang rusak/hilang pada Resi #REQ-' . str_pad($peminjaman->id, 5, '0', STR_PAD_LEFT) . ' yang dikembalikan oleh ' . ($peminjaman->user->name ?? 'Mahasiswa') . '.'
                    ]);
                }

                // Update kondisi alat: downstok yang rusak & create duplikat alat rusak / deduct stock
                foreach($peminjaman->detailPeminjaman as $det) {
                    if ($det->alat) {
                       $alatId = $det->alat_id;
                       $rusakCount = $det->jumlah;
                       // Untuk kemudahan simulasi (sesuai SRS), kita asumsikan status alat turun stok secara generik
                       // Karena di table kita tidak track serial number, kita buat record ALAT baru copyan tapi KONDISI=RUSAK jika belum ada
                       $kodeAlatRusak = $det->alat->kode_alat . '-RSK';
                       $existingRusak = Alat::where('kode_alat', $kodeAlatRusak)->first();
                       if ($existingRusak) {
                           $existingRusak->stok += $rusakCount;
                           $existingRusak->save();
                       } else {
                           Alat::create([
                               'laboratorium_id' => $det->alat->laboratorium_id,
                               'kode_alat' => $kodeAlatRusak,
                               'nama_alat' => $det->alat->nama_alat . ' (RUSAK/HILANG)',
                               'jenis_aset' => $det->alat->jenis_aset,
                               'kondisi' => 'rusak',
                               'stok' => $rusakCount,
                               'deskripsi' => 'Alat pecah/dikembalikan rusak dari Peminjaman #' . $peminjaman->id
                           ]);
                       }
                       // Potong stok alat yang aslinya (baik)
                       $det->alat->stok = max(0, $det->alat->stok - $rusakCount);
                       $det->alat->save();
                    }
                }
            } else {
                // Skenario 2: Jika Overdue (Terlambat) -> Peringatan Tegas Sanksi Keterlambatan
                if (\Carbon\Carbon::now()->isAfter(\Carbon\Carbon::parse($peminjaman->tanggal_selesai))) {
                     Notifikasi::create([
                        'user_id' => $peminjaman->user_id,
                        'judul' => 'system_alert',
                        'pesan' => 'PELANGGARAN TENGGAT: Peminjaman Anda diselesaikan, namun terekam terlambat. Akumulasi sanksi dapat menyebabkan Drop-Out pinjaman.'
                    ]);
                } else {
                     Notifikasi::create([
                        'user_id' => $peminjaman->user_id,
                        'judul' => 'system_alert',
                        'pesan' => 'Peminjaman Lab Anda telah dinyatakan selesai dan divalidasi aman (Sukses) oleh Asisten Lab.'
                    ]);
                }
            }

            return redirect()->back()->with('success', $lang === 'id' ? 'Peminjaman tuntas diverifikasi.' : 'Loan completely verified.');
        }

        return redirect()->back()->withErrors('Unauthorized action.');
    }

    // CRUD Inventaris Alat untuk Asisten Lab
    public function storeAlat(Request $request) {
        $user = Auth::user();
        if ($user->role !== 'asisten' || !$user->laboratorium_id) {
            return redirect()->back()->withErrors('Akses Ditolak.');
        }

        $request->validate([
            'kode_alat' => 'required|string|unique:alats,kode_alat',
            'nama_alat' => 'required|string',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|integer|min:0',
            'kondisi' => 'required|in:baik,rusak',
            // ... (handling foto_alat)
        ]);

        Alat::create([
            'laboratorium_id' => $user->laboratorium_id,
            'kode_alat' => $request->kode_alat,
            'nama_alat' => $request->nama_alat,
            'deskripsi' => $request->deskripsi,
            'stok' => $request->stok,
            'kondisi' => $request->kondisi,
            'jenis_aset' => $request->jenis_aset ?? 'lab',
        ]);

        return redirect()->back()->with('success', session('locale') === 'en' ? 'Asset added securely.' : 'Aset berhasil diinkorporasi.');
    }

    public function updateAlat(Request $request, $id) {
        $user = Auth::user();
        $alat = Alat::findOrFail($id);

        if ($user->role !== 'asisten' || $user->laboratorium_id !== $alat->laboratorium_id) {
            return redirect()->back()->withErrors('Akses Ditolak.');
        }

        $request->validate([
            'nama_alat' => 'required|string',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|integer|min:0',
            'kondisi' => 'required|in:baik,rusak',
        ]);

        $alat->update([
            'nama_alat' => $request->nama_alat,
            'deskripsi' => $request->deskripsi,
            'stok' => $request->stok,
            'kondisi' => $request->kondisi,
            'jenis_aset' => $request->jenis_aset ?? 'lab',
        ]);

        return redirect()->back()->with('success', session('locale') === 'en' ? 'Asset updated.' : 'Aset berhasil di-patch.');
    }

    public function destroyAlat($id) {
        $user = Auth::user();
        $alat = Alat::findOrFail($id);
        
        if ($user->role !== 'asisten' || $user->laboratorium_id !== $alat->laboratorium_id) {
            return redirect()->back()->withErrors('Akses Ditolak.');
        }

        $alat->delete();
        return redirect()->back()->with('success', session('locale') === 'en' ? 'Asset deleted.' : 'Aset dieliminasi.');
    }

    public function repairAsset(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->role !== 'asisten') return abort(403);

        $request->validate([
            'repair_mode' => 'required|in:partial,all',
            'jumlah' => 'nullable|integer|min:1'
        ]);

        $alatRusak = Alat::where('kondisi', 'rusak')->findOrFail($id);
        if ($alatRusak->laboratorium_id !== $user->laboratorium_jaga->id) return abort(403);
        
        $repairCount = $request->repair_mode === 'all' ? $alatRusak->stok : $request->jumlah;
        if (!$repairCount || $repairCount <= 0) $repairCount = 1;
        if ($repairCount > $alatRusak->stok) $repairCount = $alatRusak->stok;

        $originalKode = str_replace('-RSK', '', $alatRusak->kode_alat);
        $alatAsli = Alat::where('kode_alat', $originalKode)->first();

        if ($alatAsli) {
            $alatAsli->stok += $repairCount;
            $alatAsli->save();
        } else {
            Alat::create([
                'laboratorium_id' => $alatRusak->laboratorium_id,
                'kode_alat' => $originalKode,
                'nama_alat' => str_replace(' (RUSAK/HILANG)', '', $alatRusak->nama_alat),
                'jenis_aset' => $alatRusak->jenis_aset,
                'kondisi' => 'baik',
                'stok' => $repairCount
            ]);
        }

        $alatRusak->stok -= $repairCount;
        if ($alatRusak->stok <= 0) {
            $alatRusak->delete();
        } else {
            $alatRusak->save();
        }

        \App\Models\LogAktivitas::create([
            'user_id' => $user->id,
            'aktivitas' => "Memulihkan $repairCount unit aset $originalKode masuk ke fasilitas perbaikan sukses."
        ]);

        return redirect()->back()->with('success', session('locale') === 'id' ? "Sistem Maintenance Berhasil: $repairCount Unit dikembalikan staminanya dan pindah ke sirkulasi normal!" : "Maintenance System Success: $repairCount Units restored back to main circulation!");
    }
}
