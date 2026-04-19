<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notifikasi;
// Import Model Lainya Nanti Jika Perlu 
use App\Models\Peminjaman;
use App\Models\User;
use App\Models\Alat;
use App\Models\Laboratorium;
use Illuminate\Support\Facades\Validator;

class MasterController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $lang = session('locale', 'id');

        $pendingPeminjaman = 0;
        $monitoringAktif = 0;
        $totalLaporan = 0;
        $peringatanSistem = 0;
        $recentPeminjaman = collect();
        
        // Komponen Data Modul Laboratorium
        $laboratoriesList = collect();
        $listMasters = collect();
        
        // Komponen Data Modul Inventaris
        $inventoryList = collect();
        $laboratoriums = collect();
        $totAlat = 0;
        $totBaik = 0;
        $totRusak = 0;
        
        // Komponen Tambahan Log
        $riwayatList = null;
        $maintenanceList = null;

        // Komponen Data Modul Analytics
        $analyticsDataString = '{}';

        // RBAC Filter Data
        if ($user->role === 'admin') {
            $totalPengguna = User::count();
            $panelTitle = $lang === 'id' ? 'Sistem' : 'System';
        } elseif ($user->role === 'master') {
            $panelTitle = $lang === 'id' ? 'Master Lab' : 'Lab Master';
            
            // Pengisian Data Metriks Dinamis Khusus Master
            if ($request->query('tab', 'overview') === 'overview') {
                $labIdsTemp = Laboratorium::where('master_id', $user->id)->pluck('id');
                $pendingPeminjaman = Peminjaman::where('status', 'menunggu')->whereIn('laboratorium_id', $labIdsTemp)->count();
                $monitoringAktif = Peminjaman::where('status', 'dipinjam')->whereIn('laboratorium_id', $labIdsTemp)->count();
                $totalLaporan = Peminjaman::count(); 
                $peringatanSistem = Notifikasi::where('user_id', $user->id)->where('is_read', false)->count();
                
                $labIds = Laboratorium::where('master_id', $user->id)->pluck('id');
                
                $recentPeminjaman = Peminjaman::where('status', 'menunggu')
                                        ->whereIn('laboratorium_id', $labIds)
                                        ->with(['user', 'laboratorium'])
                                        ->oldest()
                                        ->take(5)
                                        ->get();
            } elseif ($request->query('tab') === 'approvals') {
                $labIds = Laboratorium::where('master_id', $user->id)->pluck('id');
                $approvalsList = Peminjaman::where('status', 'menunggu')
                                        ->whereIn('laboratorium_id', $labIds)
                                        ->with(['user', 'laboratorium', 'detailPeminjaman.alat'])
                                        ->oldest()
                                        ->get();
            } elseif ($request->query('tab') === 'inventory') {
                $inventoryList = Alat::with('laboratorium')->orderBy('kode_alat', 'asc')->get();
                $laboratoriums = Laboratorium::all();
                
                $totAlat = $inventoryList->sum('stok');
                $totBaik = $inventoryList->where('kondisi', 'baik')->sum('stok');
                $totRusak = $inventoryList->where('kondisi', 'rusak')->sum('stok');
            } elseif ($request->query('tab') === 'laboratories') {
                $laboratoriesList = Laboratorium::withCount('alat')->with('master')->get();
                $listMasters = User::where('role', 'master')->get();
            } elseif ($request->query('tab') === 'analytics') {
                // 1. Kondisi Aset (Doughnut)
                $kondisiBaik = Alat::where('kondisi', 'baik')->sum('stok');
                // Asumsi rusak adalah record fisik tanpa sum stok, atau jika punya stok: sum('stok')
                $kondisiRusak = Alat::where('kondisi', 'rusak')->sum('stok'); 
                
                // 2. Aset Per Lab (Bar)
                $labs = Laboratorium::withCount('alat')->get();
                $labNames = $labs->pluck('nama_lab')->toArray();
                $labCounts = $labs->pluck('alat_count')->toArray();

                // 3. Peminjaman 30 hari terakhir (Line/Area)
                $peminjamanHarian = Peminjaman::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                    ->where('created_at', '>=', now()->subDays(30))
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get();
                
                $tanggalPinjam = $peminjamanHarian->pluck('date')->toArray();
                $jumlahPinjam = $peminjamanHarian->pluck('count')->toArray();

                $analyticsDataString = json_encode([
                    'kondisi' => [$kondisiBaik, $kondisiRusak],
                    'barLabels' => $labNames,
                    'barData' => $labCounts,
                    'lineDates' => $tanggalPinjam,
                    'lineCounts' => $jumlahPinjam
                ]);
            } elseif ($request->query('tab') === 'aslab_management') {
                // Modul Manajemen Aslab untuk Seluruh Lab
                $myLaboratoria = Laboratorium::where('master_id', $user->id)->get();
                $allActiveAslabs = [];
                foreach ($myLaboratoria as $mLab) {
                    $allActiveAslabs[$mLab->id] = User::where('role', 'asisten')->where('laboratorium_id', $mLab->id)->get();
                }
            } elseif ($request->query('tab') === 'riwayat') {
                $labIds = Laboratorium::where('master_id', $user->id)->pluck('id');
                $riwayatList = Peminjaman::whereIn('status', ['dikembalikan', 'ditolak', 'batal'])
                                        ->whereIn('laboratorium_id', $labIds)
                                        ->with(['user', 'laboratorium', 'detailPeminjaman.alat', 'approval.approver'])
                                        ->orderBy('updated_at', 'desc')
                                        ->get();
            } elseif ($request->query('tab') === 'maintenance') {
                $labIds = Laboratorium::where('master_id', $user->id)->pluck('id');
                $maintenanceList = Alat::whereIn('laboratorium_id', $labIds)
                                       ->where('kondisi', 'rusak')
                                       ->get();
            } elseif ($request->query('tab') === 'schedule') {
                $labIds = Laboratorium::where('master_id', $user->id)->pluck('id');
                $eventsQuery = Peminjaman::whereIn('status', ['menunggu', 'disetujui', 'dipinjam'])
                                    ->whereIn('laboratorium_id', $labIds)
                                    ->with(['user', 'laboratorium'])
                                    ->get();
                $eventsResponse = [];
                foreach($eventsQuery as $p) {
                    $color = '#22c55e'; 
                    if($p->status === 'menunggu') $color = '#eab308'; 
                    
                    $eventsResponse[] = [
                        'id' => $p->id,
                        'title' => '['.strtoupper($p->status).'] ' . ($p->user->name ?? 'Anonim'),
                        'start' => \Carbon\Carbon::parse($p->tanggal_mulai)->toIso8601String(),
                        'end' => \Carbon\Carbon::parse($p->tanggal_selesai)->toIso8601String(),
                        'color' => $color,
                        'extendedProps' => [
                            'status' => $p->status,
                            'lokasi' => $p->laboratorium->nama_lab ?? '-',
                            'pemohon' => $p->user->name ?? 'Anonim',
                            'keperluan' => $p->detailPeminjaman->first()->keperluan ?? ''
                        ]
                    ];
                }
                $scheduleEvents = json_encode($eventsResponse);
            }
        } elseif ($user->role === 'asisten') {
            $panelTitle = $lang === 'id' ? 'Asisten' : 'Assistant';
        } elseif ($user->role === 'dosen') {
            $panelTitle = $lang === 'id' ? 'Dosen' : 'Lecturer';
        } else {
            // Failsafe if accessed incorrectly
            return redirect()->route('student.dashboard');
        }


        // Ambil Data Notifikasi untuk Header (Universal)
        $unreadNotifs = Notifikasi::where('user_id', $user->id)
                                  ->where('is_read', false)
                                  ->count();

        // Tangani Request Tab Navigation
        $tab = $request->query('tab', 'overview');

        $approvalsList = $approvalsList ?? collect();

        $myLaboratoria = $myLaboratoria ?? collect();
        $allActiveAslabs = $allActiveAslabs ?? [];
        $scheduleEvents = $scheduleEvents ?? '[]';

        return view('master.dashboard.index', compact(
            'user', 'lang', 'panelTitle', 'unreadNotifs', 'tab',
            'pendingPeminjaman', 'monitoringAktif', 'totalLaporan', 'peringatanSistem', 'recentPeminjaman', 'approvalsList',
            'inventoryList', 'laboratoriums', 'totAlat', 'totBaik', 'totRusak',
            'laboratoriesList', 'listMasters', 'analyticsDataString', 'myLaboratoria', 'allActiveAslabs',
            'riwayatList', 'maintenanceList', 'scheduleEvents'
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

        if ($user->role === 'master') {
            if ($request->action === 'approve') {
                $peminjaman->status = 'disetujui';
                $peminjaman->save();

                // Rekam ke tabel approval pivot
                \App\Models\Approval::create([
                    'peminjaman_id' => $peminjaman->id,
                    'approver_id' => $user->id,
                    'status_approval' => 'disetujui',
                    'catatan' => $request->catatan ?? 'Sistem: Disetujui Master Lab'
                ]);

                // Notifikasi Sistem
                Notifikasi::create([
                    'user_id' => $peminjaman->user_id,
                    'judul' => 'system_alert',
                    'pesan' => 'Pengajuan Peminjaman Lab Anda telah disetujui sepenuhnya oleh Master Lab. Catatan: ' . ($request->catatan ?? 'Tidak Ada')
                ]);

                // Simulasi Kirim Email Jika Diinginkan
                try {
                    \Illuminate\Support\Facades\Mail::raw('Selamat! Pengajuan Peminjaman Anda telah Disetujui oleh Master Laboratorium.', function($msg) use ($peminjaman) {
                        $msg->to($peminjaman->user->email)->subject('Pemberitahuan Sistem SIM-LAB: Persetujuan Pengajuan');
                    });
                } catch (\Exception $e) {
                    // Log fail jika email error (tidak wajib)
                }

                $msg = $lang === 'id' ? 'Pengajuan berhasil disetujui!' : 'Request successfully approved!';
                return back()->with('success', $msg);
            } else {
                $peminjaman->status = 'ditolak';
                $peminjaman->save();

                \App\Models\Approval::create([
                    'peminjaman_id' => $peminjaman->id,
                    'approver_id' => $user->id,
                    'status_approval' => 'ditolak',
                    'catatan' => $request->catatan ?? 'Sistem: Ditolak Master Lab'
                ]);

                Notifikasi::create([
                    'user_id' => $peminjaman->user_id,
                    'judul' => 'system_alert',
                    'pesan' => 'Maaf, Pengajuan Peminjaman Lab Anda DITOLAK oleh Master Lab dengan catatan: ' . ($request->catatan ?? 'Tidak Ada')
                ]);

                try {
                    \Illuminate\Support\Facades\Mail::raw('Maaf, Pengajuan Peminjaman Alat/Ruang Anda ditolak oleh Master Laboratorium dengan alasan: ' . ($request->catatan ?? 'Tidak ada Catatan Tambahan'), function($msg) use ($peminjaman) {
                        $msg->to($peminjaman->user->email)->subject('Pemberitahuan Sistem SIM-LAB: Penolakan Pengajuan');
                    });
                } catch (\Exception $e) {}

                $msg = $lang === 'id' ? 'Pengajuan berhasil ditolak!' : 'Request successfully rejected!';
                return back()->with('success', $msg);
            }
        }

        return back()->withErrors('Unauthorize action.');
    }

    // ============================================
    // MODUL CRUD MANAJEMEN INVENTARIS (ALAT)
    // ============================================
    
    public function storeAlat(Request $request)
    {
        $lang = session('locale', 'id');
        $validator = Validator::make($request->all(), [
            'kode_alat' => 'required|string|unique:alat,kode_alat',
            'nama_alat' => 'required|string|max:255',
            'jenis_aset' => 'required|in:lab,pribadi',
            'laboratorium_id' => 'nullable|exists:laboratorium,id',
            'stok' => 'required|integer|min:1',
            'kondisi' => 'required|in:baik,rusak,perbaikan',
            'fotos.*' => 'nullable|image|max:20480'
        ]);

        if ($validator->fails()) {
            return redirect()->route('master.dashboard', ['tab' => 'inventory'])
                             ->withErrors($validator)
                             ->withInput();
        }

        $data = $request->except('fotos');
        if ($request->hasFile('fotos')) {
            $fotos = [];
            foreach ($request->file('fotos') as $file) {
                $fotos[] = $this->uploadAndConvertToWebp($file);
            }
            $data['fotos'] = $fotos;
        }

        Alat::create($data);

        return redirect()->route('master.dashboard', ['tab' => 'inventory'])->with('success', $lang === 'id' ? 'Aset baru berhasil dicatat ke sistem.' : 'New asset successfully recorded into the system.');
    }

    public function updateAlat(Request $request, $id)
    {
        $lang = session('locale', 'id');
        $alat = Alat::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'kode_alat' => 'required|string|unique:alat,kode_alat,' . $id,
            'nama_alat' => 'required|string|max:255',
            'jenis_aset' => 'required|in:lab,pribadi',
            'laboratorium_id' => 'nullable|exists:laboratorium,id',
            'stok' => 'required|integer|min:0',
            'kondisi' => 'required|in:baik,rusak,perbaikan',
            'fotos.*' => 'nullable|image|max:20480'
        ]);

        if ($validator->fails()) {
            return redirect()->route('master.dashboard', ['tab' => 'inventory'])
                             ->withErrors($validator)
                             ->withInput();
        }

        $data = $request->except('fotos');
        if ($request->hasFile('fotos')) {
            // Delete old from storage
            if ($alat->fotos && is_array($alat->fotos)) {
                foreach($alat->fotos as $old) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($old);
                }
            }

            $fotos = [];
            foreach ($request->file('fotos') as $file) {
                $fotos[] = $this->uploadAndConvertToWebp($file);
            }
            $data['fotos'] = $fotos;
        }

        $alat->update($data);

        return redirect()->route('master.dashboard', ['tab' => 'inventory'])->with('success', $lang === 'id' ? 'Informasi aset berhasil diperbarui.' : 'Asset information successfully updated.');
    }

    public function destroyAlat($id)
    {
        $lang = session('locale', 'id');
        $alat = Alat::findOrFail($id);
        $alat->delete();

        return redirect()->route('master.dashboard', ['tab' => 'inventory'])->with('success', $lang === 'id' ? 'Rekaman aset berhasil diberangus dari basis data.' : 'Asset record successfully eradicated from the database.');
    }

    // ============================================
    // MODUL CRUD MANAJEMEN DATA LABORATORIUM
    // ============================================

    public function storeLab(Request $request)
    {
        $lang = session('locale', 'id');
        $validator = Validator::make($request->all(), [
            'nama_lab' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'master_id' => 'nullable|exists:users,id',
            'fotos.*' => 'nullable|image|max:20480'
        ]);

        if ($validator->fails()) {
            return redirect()->route('master.dashboard', ['tab' => 'laboratories'])
                             ->withErrors($validator)
                             ->withInput();
        }

        $data = $request->except('fotos');
        if ($request->hasFile('fotos')) {
            $fotos = [];
            foreach ($request->file('fotos') as $file) {
                $fotos[] = $this->uploadAndConvertToWebp($file);
            }
            $data['fotos'] = $fotos;
        }

        Laboratorium::create($data);

        return redirect()->route('master.dashboard', ['tab' => 'laboratories'])->with('success', $lang === 'id' ? 'Ruang Laboratorium baru berhasil diaktifkan dalam sistem.' : 'New Laboratory room successfully activated in the system.');
    }

    public function updateLab(Request $request, $id)
    {
        $lang = session('locale', 'id');
        $lab = Laboratorium::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_lab' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'master_id' => 'nullable|exists:users,id',
            'fotos.*' => 'nullable|image|max:20480'
        ]);

        if ($validator->fails()) {
            return redirect()->route('master.dashboard', ['tab' => 'laboratories'])
                             ->withErrors($validator)
                             ->withInput();
        }

        $data = $request->except('fotos');
        if ($request->hasFile('fotos')) {
            // Delete old from storage
            if ($lab->fotos && is_array($lab->fotos)) {
                foreach($lab->fotos as $old) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($old);
                }
            }

            $fotos = [];
            foreach ($request->file('fotos') as $file) {
                $fotos[] = $this->uploadAndConvertToWebp($file);
            }
            $data['fotos'] = $fotos;
        }

        $lab->update($data);

        return redirect()->route('master.dashboard', ['tab' => 'laboratories'])->with('success', $lang === 'id' ? 'Konfigurasi Laboratorium berhasil diperbarui.' : 'Laboratory configuration successfully updated.');
    }

    public function destroyLab($id)
    {
        $lang = session('locale', 'id');
        $lab = Laboratorium::findOrFail($id);

        if ($lab->alat()->count() > 0) {
            return redirect()->route('master.dashboard', ['tab' => 'laboratories'])->withErrors($lang === 'id' ? 'Gagal menghancurkan Lab! Relokasikan/Hapus seluruh aset di dalamnya terlebih dahulu.' : 'Failed to destroy Lab! Relocate/Delete all assets inside it first.');
        }

        $lab->delete();

        return redirect()->route('master.dashboard', ['tab' => 'laboratories'])->with('success', $lang === 'id' ? 'Laboratorium berhasil dibumihanguskan secara permanen.' : 'Laboratory successfully permanently annihilated.');
    }

    private function uploadAndConvertToWebp($file)
    {
        $filename = \Illuminate\Support\Str::random(40) . '.webp';
        $path = 'uploads/fotos/' . $filename;
        $fullPath = storage_path('app/public/' . $path);

        if (!file_exists(storage_path('app/public/uploads/fotos'))) {
            mkdir(storage_path('app/public/uploads/fotos'), 0755, true);
        }

        $extension = strtolower($file->getClientOriginalExtension());
        $image = null;

        if (in_array($extension, ['jpg', 'jpeg'])) {
            $image = @imagecreatefromjpeg($file->getRealPath());
        } elseif ($extension === 'png') {
            $image = @imagecreatefrompng($file->getRealPath());
            if ($image) {
                imagepalettetotruecolor($image);
                imagealphablending($image, true);
                imagesavealpha($image, true);
            }
        } elseif ($extension === 'webp') {
            return $file->storeAs('uploads/fotos', $filename, 'public');
        } else {
            return $file->store('uploads/fotos', 'public');
        }

        if ($image) {
            imagewebp($image, $fullPath, 80); // Compress to 80% WebP
            imagedestroy($image);
            return $path;
        }

        return $file->store('uploads/fotos', 'public');
    }

    public function updateMaxAslab(Request $request, $lab_id)
    {
        $user = Auth::user();
        $lab = Laboratorium::where('master_id', $user->id)->where('id', $lab_id)->firstOrFail();
        
        $request->validate(['max_aslab' => 'required|integer|min:1|max:25']);
        $lab->update(['max_aslab' => $request->max_aslab]);

        return response()->json(['status' => 'success']);
    }

    public function searchMahasiswaForAslab(Request $request)
    {
        $keyword = $request->input('keyword');
        if (!$keyword) return response()->json(['status' => 'error', 'message' => 'Empty keyword.']);

        $master_id = Auth::id();
        $myLaboratoria = Laboratorium::where('master_id', $master_id)->get();
        if ($myLaboratoria->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'LOCKED: Anda tidak memimpin lab apapun.']);
        }

        $mahasiswa = User::where(function($q) use ($keyword) {
            $q->where('nomor_induk', 'LIKE', "%{$keyword}%")
              ->orWhere('name', 'LIKE', "%{$keyword}%")
              ->orWhere('email', 'LIKE', "%{$keyword}%");
        })->whereIn('role', ['mahasiswa', 'asisten'])
          ->limit(5)->get();

        if ($mahasiswa->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'Mahasiswa tidak ditemukan.']);
        }

        $html = '';
        foreach($mahasiswa as $m) {
            $lang = session('locale', 'id');
            $isAlreadyAslab = $m->role === 'asisten';
            $btnText = $lang === 'id' ? 'REKRUT' : 'HIRE';
            $opacity = $isAlreadyAslab ? '0.5' : '1';
            $btnColor = $isAlreadyAslab ? '#475569' : '#10b981'; 
            
            $statusText = '';
            if ($isAlreadyAslab) {
                $statusText = '<span style="color:#ef4444; font-size:0.7rem; font-weight:bold;">ALREADY HIRED / ASLAB AKTIF</span>';
            }

            $formRoute = route('master.aslab.hire', ['id' => $m->id]);
            $csrf = csrf_field();
            
            $avatarSrc = '';
            if ($m->avatar) {
                if (filter_var($m->avatar, FILTER_VALIDATE_URL) || str_starts_with($m->avatar, '/storage/')) {
                    $avatarSrc = $m->avatar;
                } else {
                    $avatarSrc = \Illuminate\Support\Facades\Storage::url($m->avatar);
                }
            }
            $avatarHtml = $m->avatar ? '<img src="'. $avatarSrc .'" style="width:100%; height:100%; object-fit:cover;">' : '<span style="font-weight:900; color:var(--accent-cyan);">'. strtoupper(substr($m->name, 0, 1)) .'</span>';

            $selOptions = '';
            foreach($myLaboratoria as $labOpt) {
                $selOptions .= "<option value='{$labOpt->id}' style='background:#101820; color:#fff;'>{$labOpt->nama_lab}</option>";
            }

            $html .= "
            <div style='background:rgba(255,255,255,0.02); border:1px solid rgba(255,255,255,0.05); padding:1rem; border-radius:8px; margin-bottom:0.5rem; display:flex; justify-content:space-between; align-items:center; opacity:{$opacity}; flex-wrap:wrap; gap:1rem;'>
                <div style='display:flex; align-items:center; gap:1rem; flex-grow:1;'>
                    <div style='width:40px; height:40px; border-radius:50%; background:rgba(0,217,255,0.1); display:flex; justify-content:center; align-items:center; overflow:hidden; flex-shrink:0;'>{$avatarHtml}</div>
                    <div>
                        <strong style='color:#fff; display:block;'>{$m->name}</strong>
                        <span style='color:var(--text-muted); font-size:0.75rem; font-family:monospace;'>{$m->email}</span>
                        <div>{$statusText}</div>
                    </div>
                </div>
                ".(!$isAlreadyAslab ? "
                <form action='{$formRoute}' method='POST' style='display:flex; gap:0.5rem; flex-wrap:nowrap;'>
                    {$csrf}
                    <div style='position:relative;'>
                        <select name='lab_id' style='appearance:none; -webkit-appearance:none; background:rgba(20,30,40,0.8); color:#fff; border:1px solid rgba(0,217,255,0.3); border-radius:0.5rem; padding:0.5rem 2rem 0.5rem 1rem; font-size:0.8rem; outline:none; cursor:pointer; height:100%; box-shadow:0 2px 10px rgba(0,0,0,0.2); font-weight:600;' required>
                            <option value='' disabled selected style='background:#0a1016; color:var(--text-muted);'>Pilih Lab...</option>
                            {$selOptions}
                        </select>
                        <svg width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='var(--accent-cyan)' stroke-width='2' style='position:absolute; right:0.8rem; top:50%; transform:translateY(-50%); pointer-events:none;'><polyline points='6 9 12 15 18 9'></polyline></svg>
                    </div>
                    <button type='submit' style='margin:0; padding:0.5rem 1.2rem; border-radius:8px; width:auto; font-size:0.75rem; font-weight:800; letter-spacing:1px; background:linear-gradient(135deg, #10b981, #059669); color:#fff; border:none; box-shadow:0 4px 15px rgba(16,185,129,0.3); cursor:pointer; transition:all 0.3s ease; text-transform:uppercase;'>{$btnText}</button>
                </form>
                " : "")."
            </div>
            ";
        }

        return response()->json(['status' => 'success', 'html' => $html]);
    }

    public function hireAslab(Request $request, $id)
    {
        $request->validate(['lab_id' => 'required|exists:laboratorium,id']);
        $master = Auth::user();
        $lab = Laboratorium::where('master_id', $master->id)->where('id', $request->lab_id)->firstOrFail();
        
        $activeCount = User::where('role', 'asisten')->where('laboratorium_id', $lab->id)->count();
        if ($activeCount >= $lab->max_aslab) {
            return back()->with('error', 'Kapasitas asisten laboratorium sudah penuh sesuai batas formasi (' . $lab->max_aslab . ').');
        }

        $calon = User::findOrFail($id);
        if ($calon->role === 'asisten') {
             return back()->with('error', 'Mahasiswa tersebut sudah menjabat sebagai asisten laboratorium.');
        }

        $calon->update([
            'role' => 'asisten',
            'laboratorium_id' => $lab->id
        ]);

        return back()->with('success', 'Mahasiswa berhasil diangkat menjadi Asisten Laboratorium.');
    }

    public function fireAslab($id, $lab_id)
    {
        $master = Auth::user();
        $lab = Laboratorium::where('master_id', $master->id)->where('id', $lab_id)->firstOrFail();
        
        $aslab = User::where('id', $id)->where('laboratorium_id', $lab->id)->firstOrFail();
        
        $aslab->update([
            'role' => 'mahasiswa',
            'laboratorium_id' => null
        ]);

        return back()->with('success', 'Asisten berhasil dipecat dan dikembalikan ke status mahasiswa.');
    }

    public function repairAsset(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->role !== 'master') return abort(403);

        $request->validate([
            'repair_mode' => 'required|in:partial,all',
            'jumlah' => 'nullable|integer|min:1'
        ]);

        $alatRusak = Alat::where('kondisi', 'rusak')->findOrFail($id);
        
        // Pengecekan otoritas lab master
        $labIds = Laboratorium::where('master_id', $user->id)->pluck('id')->toArray();
        if (!in_array($alatRusak->laboratorium_id, $labIds)) return abort(403);
        
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
            'aktivitas' => "MASTER LAB: Memulihkan $repairCount unit aset $originalKode secara paksa dari sistem maintenance."
        ]);

        return redirect()->back()->with('success', session('locale') === 'id' ? "Otoritas Master Lab: $repairCount Unit dikembalikan ke sirkulasi normal!" : "Master Lab Authority: $repairCount Units restored!");
    }
}
