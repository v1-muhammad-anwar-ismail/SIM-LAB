<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SystemAdminController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $lang = session('locale', 'id');
        $panelTitle = 'Admin Sistem';

        if ($user->role !== 'admin') {
            return redirect()->route('student.dashboard')->withErrors('Unauthorized action.');
        }

        $tab = $request->get('tab', 'overview');

        // Kalkulasi Notifikasi Radar Merah
        $unreadNotifs = \App\Models\Notifikasi::where('user_id', $user->id)->where('is_read', false)->count();

        // TAB MATA-MATA (OVERVIEW)
        $totalUsers = \App\Models\User::count();
        $totalPeminjaman = \App\Models\Peminjaman::count();
        $activePeminjaman = \App\Models\Peminjaman::whereIn('status', ['menunggu', 'dipinjam'])->count();
        
        $roleDistribution = \App\Models\User::select('role', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
                                ->groupBy('role')->get()->pluck('total', 'role')->toArray();

        // TAB MANAJEMEN POPULASI (USERS)
        $usersList = collect();
        $laboratoriums = collect();
        if ($tab === 'users') {
            $usersList = \App\Models\User::with(['laboratorium', 'laboratorium_jaga'])->orderBy('role')->orderBy('name')->get();
            $laboratoriums = \App\Models\Laboratorium::all();
        }

        // TAB REKAM JEJAK FORENSIK (LOGS)
        $logsList = collect();
        if ($tab === 'logs') {
            $logsList = \App\Models\LogAktivitas::with('user')->orderBy('created_at', 'desc')->paginate(50);
        }

        return view('admin.dashboard.index', compact('user', 'lang', 'panelTitle', 'tab', 'totalUsers', 'totalPeminjaman', 'activePeminjaman', 'roleDistribution', 'usersList', 'logsList', 'unreadNotifs', 'laboratoriums'));
    }

    // ==========================================
    // AKSI EKSEKUSI OLEH ADMIN SISTEM
    // ==========================================

    public function destroyUser(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') return back();

        if (Auth::id() == $id) {
            return back()->with('error', 'Peringatan: Dilarang memusnahkan akun mandiri (Suicide Protection).');
        }

        $targetUser = \App\Models\User::findOrFail($id);
        
        // Peringatan: Karena tabel Peminjaman menggunakan onDelete('cascade'), seluruh riwayat akan hangus!
        \App\Models\LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'MEMUSNAHKAN akun [' . strtoupper($targetUser->role) . '] ' . $targetUser->name . ' (ID: ' . $targetUser->id . ') beserta seluruh garis turunan datanya.'
        ]);

        $targetUser->delete();

        return back()->with('success', 'Eksekusi Berhasil: Entitas tersebut telah dimusnahkan hingga akarnya.');
    }

    public function swapRole(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') return back();

        $request->validate([
            'role' => 'required|in:mahasiswa,asisten,master,dosen,admin',
            'laboratorium_id' => 'nullable|exists:laboratorium,id'
        ]);
        
        $targetUser = \App\Models\User::findOrFail($id);
        $oldRole = $targetUser->role;
        $targetUser->role = $request->role;

        // Jika dia dicabut dari asisten/master, null-kan kepemilikan Lab-nya untuk menghindari cacat sistem
        if (!in_array($request->role, ['asisten', 'master'])) {
            $targetUser->laboratorium_id = null;
        } else {
            if ($request->laboratorium_id) {
                $targetUser->laboratorium_id = $request->laboratorium_id;
            }
        }

        $targetUser->save();

        if ($request->role === 'master' && $request->laboratorium_id) {
            \App\Models\Laboratorium::where('id', $request->laboratorium_id)->update(['master_id' => $targetUser->id]);
        }

        \App\Models\LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'MENGUBAH JABATAN entitas ' . $targetUser->name . ' dari [' . strtoupper($oldRole) . '] menjadi [' . strtoupper($request->role) . '].'
        ]);

        return back()->with('success', 'Mutasi Hierarki selesai. Pengguna tersebut kiri berpangkat ' . strtoupper($request->role));
    }

    public function storeUser(Request $request)
    {
        if (Auth::user()->role !== 'admin') return back();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:mahasiswa,asisten,master,dosen,admin',
            'nomor_induk' => 'nullable|string|max:50',
            'laboratorium_id' => 'nullable|exists:laboratorium,id'
        ]);

        $newUser = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => $request->role,
            'nomor_induk' => $request->nomor_induk,
            'laboratorium_id' => in_array($request->role, ['asisten', 'master']) ? $request->laboratorium_id : null
        ]);

        if ($request->role === 'master' && $request->laboratorium_id) {
            \App\Models\Laboratorium::where('id', $request->laboratorium_id)->update(['master_id' => $newUser->id]);
        }

        \App\Models\LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'MENCIPTAKAN entitas baru: ' . $newUser->name . ' sebagai [' . strtoupper($newUser->role) . '].'
        ]);

        return back()->with('success', 'Kelancaran Pendaftaran Sistem Sukses. Pengguna baru berhasil diinkubasi.');
    }
}
