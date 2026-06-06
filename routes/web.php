<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\PublicController;

Route::get('/', [PublicController::class, 'indexHome'])->name('public.home');
Route::get('/about', [PublicController::class, 'indexAbout'])->name('public.about');
Route::get('/schedule', [PublicController::class, 'indexCatalog'])->name('public.schedule');
Route::get('/detail/{type}/{id}', [PublicController::class, 'showDetail'])->name('public.detail');
Route::post('/intent/booking', [PublicController::class, 'intentBooking'])->name('public.intent');

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['id', 'en'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
});



Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/otp/verify', [AuthController::class, 'showOtp'])->name('otp.verify');
    Route::post('/otp/verify', [AuthController::class, 'verifyOtp']);
    Route::post('/otp/resend', [AuthController::class, 'resendOtp'])->name('otp.resend');

    // Forgot Password & Reset Routes
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot.password');
    Route::post('/forgot-password', [AuthController::class, 'sendResetOtp']);
    Route::get('/reset-password', [AuthController::class, 'showResetPassword'])->name('reset.password');
    Route::post('/reset-password', [AuthController::class, 'updatePasswordWithOtp']);

});

// Google OAuth Routes (Terbuka untuk Guest dan Auth/Tautkan Akun)
Route::get('/auth/google', [AuthController::class, 'googleRedirect'])->name('google.login');
Route::get('/auth/google/callback', [AuthController::class, 'googleCallback']);

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::delete('/auth/google/unlink', [AuthController::class, 'unlinkGoogle'])->name('auth.google.unlink');
    
    // Notification Route
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    
    // Student Routes
    Route::prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [StudentController::class, 'index'])->name('dashboard');
        // Route for editing profile (Avatar, Name, Bio)
        Route::put('/dashboard/profile', [StudentController::class, 'updateProfile'])->name('profile.update');
        // Route for password change
        Route::post('/dashboard/password', [StudentController::class, 'updatePassword'])->name('password.update');
        // Route for pengajuan
        Route::post('/dashboard/pengajuan', [StudentController::class, 'storePengajuan'])->name('pengajuan.store');
        // Route for batal pengajuan
        Route::post('/dashboard/peminjaman/{id}/cancel', [StudentController::class, 'cancelPeminjaman'])->name('peminjaman.cancel');
    });
    // 1. Otoritas Master Lab (Kepala Lab)
    Route::prefix('master')->name('master.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\MasterController::class, 'index'])->name('dashboard');
        Route::post('/dashboard/approvals/{id}', [\App\Http\Controllers\MasterController::class, 'processApproval'])->name('approvals.process');
        Route::post('/dashboard/inventory', [\App\Http\Controllers\MasterController::class, 'storeAlat'])->name('inventory.store');
        Route::put('/dashboard/inventory/{id}', [\App\Http\Controllers\MasterController::class, 'updateAlat'])->name('inventory.update');
        Route::delete('/dashboard/inventory/{id}', [\App\Http\Controllers\MasterController::class, 'destroyAlat'])->name('inventory.destroy');
        Route::post('/dashboard/laboratories', [\App\Http\Controllers\MasterController::class, 'storeLab'])->name('laboratories.store');
        Route::put('/dashboard/laboratories/{id}', [\App\Http\Controllers\MasterController::class, 'updateLab'])->name('laboratories.update');
        Route::delete('/dashboard/laboratories/{id}', [\App\Http\Controllers\MasterController::class, 'destroyLab'])->name('laboratories.destroy');
        
        // HRM Aslab Routes
        Route::post('/dashboard/aslab/update-max/{lab_id}', [\App\Http\Controllers\MasterController::class, 'updateMaxAslab'])->name('aslab.updateMax');
        Route::post('/dashboard/aslab/search', [\App\Http\Controllers\MasterController::class, 'searchMahasiswaForAslab'])->name('aslab.search');
        Route::post('/dashboard/aslab/{id}/hire', [\App\Http\Controllers\MasterController::class, 'hireAslab'])->name('aslab.hire');
        Route::post('/dashboard/aslab/{id}/fire/{lab_id}', [\App\Http\Controllers\MasterController::class, 'fireAslab'])->name('aslab.fire');
        
        // Perbaikan Aset
        Route::post('/dashboard/maintenance/{id}/repair', [\App\Http\Controllers\MasterController::class, 'repairAsset'])->name('maintenance.repair');
    });

    // 2. Otoritas Super Admin Sistem
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\SystemAdminController::class, 'index'])->name('dashboard');
        
        // Operasional Entitas User
        Route::post('/dashboard/users/create', [\App\Http\Controllers\SystemAdminController::class, 'storeUser'])->name('users.store');
        Route::post('/dashboard/users/{id}/swap', [\App\Http\Controllers\SystemAdminController::class, 'swapRole'])->name('users.swap');
        Route::delete('/dashboard/users/{id}', [\App\Http\Controllers\SystemAdminController::class, 'destroyUser'])->name('users.destroy');
    });

    // 3. Otoritas Asisten Lab
    Route::prefix('asisten')->name('asisten.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\AsistenController::class, 'index'])->name('dashboard');
        
        // Peminjaman (ACC/Tolak)
        Route::post('/dashboard/approvals/{id}', [\App\Http\Controllers\AsistenController::class, 'processApproval'])->name('approvals.process');
        
        // Pengembalian & Penyerahan (Verifikasi)
        Route::post('/dashboard/returns/{id}/handover', [\App\Http\Controllers\AsistenController::class, 'processHandover'])->name('returns.handover');
        Route::post('/dashboard/returns/{id}', [\App\Http\Controllers\AsistenController::class, 'processReturn'])->name('returns.process');
        
        // Gudang Inventaris CRUD
        Route::post('/dashboard/inventory', [\App\Http\Controllers\AsistenController::class, 'storeAlat'])->name('inventory.store');
        Route::put('/dashboard/inventory/{id}', [\App\Http\Controllers\AsistenController::class, 'updateAlat'])->name('inventory.update');
        Route::delete('/dashboard/inventory/{id}', [\App\Http\Controllers\AsistenController::class, 'destroyAlat'])->name('inventory.destroy');

        // Perbaikan Aset
        Route::post('/dashboard/maintenance/{id}/repair', [\App\Http\Controllers\AsistenController::class, 'repairAsset'])->name('maintenance.repair');
    });

    // 4. Otoritas Dosen Pendamping
    Route::prefix('dosen')->name('dosen.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\DosenController::class, 'index'])->name('dashboard');
    });
});
