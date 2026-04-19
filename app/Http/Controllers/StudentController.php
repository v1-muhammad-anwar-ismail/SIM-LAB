<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Peminjaman; // Jika ada

class StudentController extends Controller
{


    public function index(Request $request)
    {
        if (Auth::user()->role !== 'mahasiswa') {
            return redirect('/')->with('error', 'Akses Ditolak. Halaman ini khusus Mahasiswa.');
        }

        $user = Auth::user();
        $tab = $request->query('tab', 'overview');

        // Logika metrik untuk Mahasiswa (Data asli)
        $activeLoans = \App\Models\Peminjaman::where('user_id', $user->id)->where('status', 'dipinjam')->count();
        $pendingRequests = \App\Models\Peminjaman::where('user_id', $user->id)->where('status', 'menunggu')->count();
        $completedLoans = \App\Models\Peminjaman::where('user_id', $user->id)->where('status', 'dikembalikan')->count();
        $lateReturns = \App\Models\Peminjaman::where('user_id', $user->id)->where('status', 'dipinjam')->where('tanggal_selesai', '<', now())->count();

        $alats = collect();
        $labs = collect();
        $semuaAlat = collect();
        $riwayats = collect();
        $recentLoans = collect();
        $scheduleEvents = '[]';

        if ($tab === 'ketersediaan') {
            $alats = \App\Models\Alat::with(['laboratorium.master', 'laboratorium.aslabs'])->where('kondisi', 'baik')->orderBy('nama_alat')->get()
                        ->filter(function($alat) { return $alat->available_stok > 0; });
            $labs = \App\Models\Laboratorium::with(['master', 'aslabs'])->orderBy('nama_lab')->get();
        } elseif ($tab === 'pengajuan') {
            $labs = \App\Models\Laboratorium::all();
            $semuaAlat = \App\Models\Alat::with(['laboratorium.master', 'laboratorium.aslabs'])->where('stok', '>', 0)->where('kondisi', 'baik')->orderBy('nama_alat')->get()
                            ->filter(function($alat) { return $alat->available_stok > 0; })->values();
            
            // Siapkan Agenda Bentrok untuk UI
            $eventsQuery = \App\Models\Peminjaman::whereIn('status', ['menunggu', 'disetujui', 'dipinjam'])
                                ->with('user')
                                ->get();
            $eventsResponse = [];
            foreach($eventsQuery as $p) {
                // Konversi tanggal agar konsisten dibaca UTC / lokal ISO
                $tglMulai = \Carbon\Carbon::parse($p->tanggal_mulai)->toIso8601String();
                $tglSelesai = \Carbon\Carbon::parse($p->tanggal_selesai)->toIso8601String();
                
                $eventsResponse[] = [
                    'id' => $p->id,
                    'lab_id' => $p->laboratorium_id,
                    'title' => 'Telah di-book: ' . ($p->user->name ?? 'Anonim'),
                    'start' => $tglMulai,
                    'end' => $tglSelesai,
                    'jenis' => $p->jenis_peminjaman
                ];
            }
            $scheduleEvents = json_encode($eventsResponse);

        } elseif ($tab === 'riwayat') {
            $riwayats = \App\Models\Peminjaman::with(['laboratorium', 'detailPeminjaman.alat'])->where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        } elseif ($tab === 'overview') {
            $recentLoans = \App\Models\Peminjaman::with('laboratorium')->where('user_id', $user->id)->orderBy('created_at', 'desc')->take(3)->get();
        }

        // Ambil data notifikasi
        $notifikasis = \App\Models\Notifikasi::where('user_id', $user->id)->orderBy('created_at', 'desc')->take(10)->get();
        $unreadNotifs = $notifikasis->where('is_read', false)->count();

        return view('student.dashboard.index', compact('user', 'tab', 'activeLoans', 'pendingRequests', 'completedLoans', 'lateReturns', 'alats', 'labs', 'semuaAlat', 'riwayats', 'recentLoans', 'notifikasis', 'unreadNotifs', 'scheduleEvents'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:150',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480', // Maks 20MB
        ]);

        $user->name = $request->name;
        $user->bio = $request->bio; 

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $extension = strtolower($file->getClientOriginalExtension());
            $storageDir = storage_path('app/public/avatars');
            
            // Pastikan folder avatars ada
            if (!file_exists($storageDir)) {
                mkdir($storageDir, 0755, true);
            }

            if ($extension === 'gif') {
                // Jika file berupa GIF, pindahkan langsung secara as-is agar animasinya tidak mati
                $filename = uniqid('avatar_') . '_' . time() . '.gif';
                $file->move($storageDir, $filename);
            } else {
                // Jika JPG/PNG, eksekusi Kompresi Cyberpunk: Konversi ke . WEBP
                $image = imagecreatefromstring(file_get_contents($file->getRealPath()));
                
                // Mengatasi transparansi untuk PNG
                imagepalettetotruecolor($image);
                imagealphablending($image, true);
                imagesavealpha($image, true);

                $filename = uniqid('avatar_') . '_' . time() . '.webp';
                imagewebp($image, $storageDir . '/' . $filename, 85);
                imagedestroy($image);
            }

            $user->avatar = '/storage/avatars/' . $filename;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil sistem berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'currentPassword' => 'required|string',
            'newPassword' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->currentPassword, $user->password)) {
            return back()->with('error', 'Kata sandi saat ini tidak valid!');
        }

        $user->password = Hash::make($request->newPassword);
        $user->save();

        return back()->with('success', 'Sandi keamanan berhasil diperbarui!');
    }

    public function storePengajuan(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'jenis_peminjaman' => 'required|in:alat,ruang',
            'laboratorium_id' => 'required|exists:laboratorium,id',
            'tujuan_peminjaman' => 'required|string|max:1000',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            
            // Validasi baris alat komprehensif jika milih pinjam alat
            'alat_id' => 'required_if:jenis_peminjaman,alat|array',
            'alat_id.*' => 'exists:alat,id',
            'jumlah' => 'required_if:jenis_peminjaman,alat|array',
            'jumlah.*' => 'integer|min:1'
        ]);

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            $startReq = \Carbon\Carbon::parse($request->tanggal_mulai);
            $endReq = \Carbon\Carbon::parse($request->tanggal_selesai);

            // Validasi Blokade Overlap untuk PINJAM RUANGAN
            if ($request->jenis_peminjaman === 'ruang') {
                $bentrokRuang = \App\Models\Peminjaman::where('laboratorium_id', $request->laboratorium_id)
                    ->lockForUpdate()
                    ->where('jenis_peminjaman', 'ruang')
                    ->whereIn('status', ['menunggu', 'disetujui', 'dipinjam'])
                    ->where(function($q) use ($startReq, $endReq) {
                        $q->where('tanggal_mulai', '<', $endReq)
                          ->where('tanggal_selesai', '>', $startReq);
                    })->first();
                
                if ($bentrokRuang) {
                    throw new \Exception("Maaf, rentang waktu yang Anda minta bertabrakan dengan sesi reservasi ruangan milik orang lain (Bentrok terdeteksi pada: {$bentrokRuang->tanggal_mulai} s.d {$bentrokRuang->tanggal_selesai}). Harap pilih jam operasional atau hari lain di kalender.");
                }
            }

            // 1. Simpan Peminjaman Induk
            $peminjaman = new \App\Models\Peminjaman();
            $peminjaman->user_id = $user->id;
            $peminjaman->jenis_peminjaman = $request->jenis_peminjaman;
            $peminjaman->laboratorium_id = $request->laboratorium_id;
            $peminjaman->tujuan_peminjaman = $request->tujuan_peminjaman;
            $peminjaman->tanggal_mulai = $request->tanggal_mulai;
            $peminjaman->tanggal_selesai = $request->tanggal_selesai;
            $peminjaman->status = 'menunggu';
            $peminjaman->save();

            // 2. Simpan Detail jika pinjam alat
            if ($request->jenis_peminjaman === 'alat' && $request->has('alat_id')) {
                $alatIds = $request->alat_id;
                $jumlahs = $request->jumlah;

                // Memastikan kedua porsi array simetris
                if(count($alatIds) === count($jumlahs)){
                    for ($i = 0; $i < count($alatIds); $i++) {
                        $idAlat = $alatIds[$i];
                        $qty = $jumlahs[$i];

                        // Proteksi Ganda anti Race-Condition dengan Time-Bound Locking
                        $alatCheck = \App\Models\Alat::lockForUpdate()->find($idAlat);
                        
                        // Hitung keramaian alat ini berdasar Intersection Waktu
                        $overlapQty = \App\Models\DetailPeminjaman::where('alat_id', $idAlat)
                            ->whereHas('peminjaman', function($q) use ($startReq, $endReq) {
                                $q->whereIn('status', ['menunggu', 'disetujui', 'dipinjam'])
                                  ->where('tanggal_mulai', '<', $endReq)
                                  ->where('tanggal_selesai', '>', $startReq);
                            })->sum('jumlah');
                            
                        $sisaBerjalan = $alatCheck->stok - $overlapQty;

                        if ($sisaBerjalan < $qty) {
                            throw new \Exception("Mohon maaf, pada rentang jam/tanggal tersebut barang '{$alatCheck->nama_alat}' terdeteksi berbenturan (Overbooked) dengan peminjam lain. (Tersedia slot aman di jam tsb: $sisaBerjalan, Diminta: $qty)");
                        }

                        // Relasikan Detail Peminjaman Master-Child
                        $detail = new \App\Models\DetailPeminjaman();
                        $detail->peminjaman_id = $peminjaman->id;
                        $detail->alat_id = $idAlat;
                        $detail->jumlah = $qty;
                        $detail->save();
                    }
                }
            }
            // 3. Tembakkan Notifikasi ke Semua Aslab di Lab Terkait
            $aslabList = \App\Models\User::where('role', 'asisten')->where('laboratorium_id', $peminjaman->laboratorium_id)->get();
            foreach($aslabList as $aslab) {
                \App\Models\Notifikasi::create([
                    'user_id' => $aslab->id,
                    'judul' => 'system_alert',
                    'pesan' => 'PENGAJUAN BARU: Mahasiswa ' . $user->name . ' mengajukan peminjaman (Resi #REQ-' . str_pad($peminjaman->id, 5, '0', STR_PAD_LEFT) . '). Segera periksa daftar persetujuan (Approvals)!'
                ]);
            }
            
            // 4. Tembakkan Notifikasi ke Master Lab (Penanggung Jawab Wilayah)
            $labTerkait = \App\Models\Laboratorium::find($peminjaman->laboratorium_id);
            if ($labTerkait && $labTerkait->master_id) {
                \App\Models\Notifikasi::create([
                    'user_id' => $labTerkait->master_id,
                    'judul' => 'system_alert',
                    'pesan' => 'PENGAJUAN BARU (MASTER): Terdapat pengajuan izin peminjaman (Resi #REQ-' . str_pad($peminjaman->id, 5, '0', STR_PAD_LEFT) . ') oleh ' . $user->name . ' di area kekuasaan lab Anda. Otorisasi dibutuhkan!'
                ]);
            }

            \Illuminate\Support\Facades\DB::commit();
            
            // Dinamis Routing: Agar Dosen yang submit Booking Darurat tidak terlempar ke layout Mahasiswa
            $targetRoute = $user->role === 'dosen' ? 'dosen.dashboard' : 'student.dashboard';
            
            return redirect()->route($targetRoute, ['tab' => 'riwayat'])->with('success', 'Formulir Pengajuan berhasi diserahkan ke sistem. Riwayat akan dicatat dan ditunggu verifikasinya.');

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return back()->with('error', 'Gagal memproses pengajuan: ' . $e->getMessage());
        }
    }

    public function cancelPeminjaman(Request $request, $id)
    {
        $user = Auth::user();
        $peminjaman = \App\Models\Peminjaman::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        if ($peminjaman->status !== 'menunggu') {
            return back()->with('error', 'Sistem Peringatan: Pengajuan tidak dapat dibatalkan karena sudah dalam proses (' . $peminjaman->status . ').');
        }

        $peminjaman->status = 'batal';
        $peminjaman->save();

        \App\Models\LogAktivitas::create([
            'user_id' => $user->id,
            'aktivitas' => 'Membatalkan secara mandiri pengajuan peminjaman #' . $peminjaman->id
        ]);

        \App\Models\Notifikasi::create([
            'user_id' => $user->id,
            'judul' => 'system_alert',
            'pesan' => 'PEMBATALAN SUKSES: Pengajuan peminjaman Anda (Resi #REQ-' . str_pad($peminjaman->id, 5, '0', STR_PAD_LEFT) . ') telah berhasil dibatalkan.'
        ]);

        return back()->with('success', 'Pengajuan peminjaman berhasil dibatalkan.');
    }
}
