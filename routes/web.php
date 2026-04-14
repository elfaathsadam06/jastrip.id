<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerTranskripsiController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GoogleSpeechController;
use App\Http\Controllers\TranskriptorController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;

/*
|--------------------------------------------------------------------------
| PUBLIC PAGE
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => view('jastrip'))->name('home');


/*
|--------------------------------------------------------------------------
| AUTH (GUEST ONLY)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');

    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');

    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');
});


/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| CUSTOMER AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:customer'])
    ->group(function () {

    Route::get('/dashboard', [CustomerController::class, 'dashboard'])
        ->name('customer.dashboard');

    // 📌 Halaman daftar pesanan
    Route::get('/orders', [CustomerController::class, 'orders'])
        ->name('customer.orders');

    // 📌 Lihat transkripsi
    Route::get('/orders/{id}/transcript', [CustomerController::class, 'showTranscript'])
        ->name('customer.transcript');

    // 📌 Download Word
    Route::get('/orders/{id}/transcript/word', [CustomerController::class, 'downloadWord'])
        ->name('customer.transcript.word');

    // 📌 Download PDF
    Route::get('/orders/{id}/transcript/pdf', [CustomerController::class, 'downloadPdf'])
        ->name('customer.transcript.pdf');

    // Pemesanan
    Route::get('/pemesanan', [PemesananController::class, 'create'])
        ->name('pemesanan.create');

    Route::post('/pemesanan', [PemesananController::class, 'store'])
        ->name('pemesanan.store');

    // tampilkan halaman pembayaran
    Route::get('/payment/{id}', [PembayaranController::class, 'pay'])
        ->name('payment.pay');

    // upload bukti pembayaran
    Route::post('/payment/{id}', [PembayaranController::class, 'uploadPayment'])
        ->name('payment.upload');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::post('/profile/update', [ProfileController::class, 'update'])
        ->name('profile.update');
});

/*
|--------------------------------------------------------------------------
| Customer Transkripsi Controller
|--------------------------------------------------------------------------
*/
    Route::middleware(['auth', 'role:customer'])
        ->prefix('customer')
        ->name('customer.')
        ->group(function () {

        // DETAIL VERIFIKASI TRANSKRIPTOR
        Route::get('/transkripsi/{pesanan}',
            [CustomerTranskripsiController::class, 'detail'])
            ->name('transkripsi.detail');

        // DOWNLOAD WORD
        Route::get('/transkripsi/{pesanan}/word',
            [CustomerTranskripsiController::class, 'downloadWord'])
            ->name('transcript.word');

        // DOWNLOAD PDF
        Route::get('/transkripsi/{pesanan}/pdf',
            [CustomerTranskripsiController::class, 'downloadPdf'])
            ->name('transcript.pdf');
    });

/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','role:admin'])->prefix('admin')->group(function () {

    Route::get('/dashboard',[AdminController::class,'index'])
        ->name('admin.dashboard');

    Route::get('/users', [AdminController::class, 'users'])
        ->name('admin.users');

    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])
        ->name('admin.users.edit');

    Route::put('/users/{id}', [AdminController::class, 'updateUser'])
        ->name('admin.users.update');

    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])
        ->name('admin.users.delete');

    Route::get('/pesanan',[AdminController::class,'pesananIndex'])
        ->name('admin.pesanan.index');

    Route::get('/pesanan/{id}',[AdminController::class,'pesananDetail'])
        ->name('admin.pesanan.detail');

    Route::post('/pesanan/{id}/proses-ai',    [AdminController::class,'prosesTranskripsi'])
        ->name('admin.transkripsi.proses');

    Route::post('/pesanan/{id}/kirim-transkriptor',    [AdminController::class,'kirimKeTranskriptor'])
        ->name('admin.pesanan.kirim');

    Route::get('/pembayaran',[AdminController::class,'pembayaranIndex'])
        ->name('pembayaran.index');

    Route::get('/pembayaran/{id}',[AdminController::class,'pembayaranDetail'])
        ->name('pembayaran.detail');

    Route::post('/pembayaran/{id}/approve',[AdminController::class,'approvePayment'])
        ->name('pembayaran.approve');

    Route::post('/pembayaran/{id}/reject',[AdminController::class,'rejectPayment'])
        ->name('pembayaran.reject');
});

/*
|--------------------------------------------------------------------------
| TRANSKRIPTOR
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:transkriptor'])
    ->prefix('transkriptor')
    ->name('transkriptor.')
    ->group(function () {

    /* ================= DASHBOARD ================= */
    Route::get('/dashboard', [TranskriptorController::class, 'dashboard'])
        ->name('dashboard');

    /* ================= TASK LIST ================= */
    Route::get('/tasks', [TranskriptorController::class, 'tasks'])
        ->name('tasks.index');

    /* ================= LIHAT DETAIL TASK ================= */
    Route::get('/tasks/{pesanan}', [TranskriptorController::class, 'show'])
        ->name('tasks.show');

    /* ================= KERJAKAN / EDIT HASIL ================= */
    Route::get('/tasks/{pesanan}/edit', [TranskriptorController::class, 'edit'])
        ->name('tasks.edit');

    /* ================= SIMPAN HASIL VERIFIKASI ================= */
    Route::post('/tasks/{pesanan}', [TranskriptorController::class, 'update'])
        ->name('tasks.update');

    /* ================= UNDUH AUDIO ================= */
    Route::get('/tasks/{pesanan}/download-audio', [TranskriptorController::class, 'downloadAudio'])
        ->name('tasks.audio');

    /* ================= DOWNLOAD WORD HASIL AI ================= */
    Route::get('/tasks/{pesanan}/download-word', [TranskriptorController::class, 'downloadWord'])
        ->name('tasks.word');
});

/*
|--------------------------------------------------------------------------
| OWNER
|--------------------------------------------------------------------------
*/
Route::prefix('owner')->middleware(['auth','role:owner'])->group(function() {

    Route::get('/dashboard', [OwnerController::class,'dashboard'])->name('owner.dashboard');

    // Admin
    Route::get('/admins', [OwnerController::class,'admins'])->name('owner.admins');
    Route::post('/admins', [OwnerController::class,'storeAdmin'])->name('owner.admins.store');
    Route::get('/admins/{id}/edit', [OwnerController::class,'editAdmin'])->name('owner.admins.edit');
    Route::put('/admins/{id}', [OwnerController::class,'updateAdmin'])->name('owner.admins.update');
    Route::post('/admins/{id}/reset', [OwnerController::class,'resetAdminPassword'])->name('owner.admins.reset');
    Route::delete('/admins/{id}', [OwnerController::class,'deleteAdmin'])->name('owner.admins.delete');

    // Transkriptor
    Route::get('/transkriptors', [OwnerController::class,'transkriptors'])
        ->name('owner.transkriptors');

    // CREATE
    Route::post('/transkriptors', [OwnerController::class,'storeTranskriptor'])
        ->name('owner.transkriptors.store');

    // EDIT FORM
    Route::get('/transkriptors/{id}/edit', [OwnerController::class,'editTranskriptor'])
        ->name('owner.transkriptors.edit');

    // UPDATE DATA + PASSWORD (OPSIONAL)
    Route::put('/transkriptors/{id}', [OwnerController::class,'updateTranskriptor'])
        ->name('owner.transkriptors.update');

    // RESET PASSWORD KHUSUS (OPSIONAL FITUR TERPISAH)
    Route::post('/transkriptors/{id}/reset-password',
        [OwnerController::class,'resetTranskriptorPassword'])
        ->name('owner.transkriptors.reset');

    // DELETE
    Route::delete('/transkriptors/{id}', [OwnerController::class,'deleteTranskriptor'])
        ->name('owner.transkriptors.delete');

    // Reports
    Route::get('/reports', [OwnerController::class,'reports'])->name('owner.reports');

    // Settings
    Route::get('/settings', [OwnerController::class,'settings'])->name('owner.settings');
    Route::post('/settings', [OwnerController::class,'updateSettings'])->name('owner.settings.update');
});


