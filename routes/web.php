<?php

use App\Http\Controllers\SurveyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NewsController; // Public News
use App\Http\Controllers\AnnouncementController; // Public Announcement
use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController; // Admin Announcement
use App\Http\Controllers\Admin\NewsController as AdminNewsController; // Admin News
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KunjunganController; // Public Kunjungan
use App\Http\Controllers\Admin\KunjunganController as AdminKunjunganController; // Admin Kunjungan
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\WbpController; // Admin WBP (Import & Manajemen)
use App\Http\Controllers\Admin\AntrianController;
use App\Http\Controllers\FaqController;
use App\Models\News;
use App\Models\Announcement;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Guest\GalleryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| File routing utama untuk aplikasi Lapas Kelas IIB Jombang.
| Mencakup: Halaman Publik, Pendaftaran Kunjungan, Auth, dan Admin Panel.
|
*/

// =========================================================================
// 1. HALAMAN DEPAN (PUBLIK - PENGUNJUNG)
// =========================================================================
Route::get('/', function () {
    // Ambil Berita & Pengumuman Terbaru untuk Landing Page
    $news = News::where('status', 'published')->latest()->take(4)->get();
    $announcements = Announcement::where('status', 'published')->orderBy('date', 'desc')->take(5)->get();

    return view('welcome', compact('news', 'announcements'));
});

// Halaman Statis Publik
Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');
Route::get('/kontak', [App\Http\Controllers\HomeController::class, 'contact'])->name('contact.index');
Route::post('/kontak', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');
Route::post('/survey', [SurveyController::class, 'store'])->name('survey.store');
Route::get('/galeri-karya', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/profil', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile.index');
Route::get('/live-antrian', [App\Http\Controllers\HomeController::class, 'liveAntrian'])->name('live.antrian');
Route::get('/live-antrian', [App\Http\Controllers\HomeController::class, 'liveAntrian'])->name('live.antrian');

// Berita & Pengumuman (Publik)
Route::get('/berita', [NewsController::class, 'index'])->name('news.public.index');
Route::get('/berita/{news:slug}', [NewsController::class, 'show'])->name('news.public.show');
Route::get('/pengumuman', [AnnouncementController::class, 'index'])->name('announcements.public.index');
Route::get('/pengumuman/{announcement}', [AnnouncementController::class, 'show'])->name('announcements.public.show');


// =========================================================================
// 2. SISTEM PENDAFTARAN KUNJUNGAN (GUEST)
// =========================================================================
Route::get('/kunjungan/daftar', [KunjunganController::class, 'create'])->name('kunjungan.create');
Route::post('/kunjungan/daftar', [KunjunganController::class, 'store'])->name('kunjungan.store')->middleware('throttle:10,1');
Route::get('/kunjungan/status/{kunjungan}', [KunjunganController::class, 'status'])->name('kunjungan.status');
Route::get('/kunjungan/{kunjungan}/print', [KunjunganController::class, 'printProof'])->name('kunjungan.print');
Route::get('/kunjungan/verify/{kunjungan}', [KunjunganController::class, 'verify'])->name('kunjungan.verify');

// API Routes (Dipakai AJAX di Frontend)
Route::get('/api/kunjungan/{kunjungan}/status', [KunjunganController::class, 'getStatusApi'])->name('kunjungan.status.api');
Route::get('/api/kunjungan/quota', [KunjunganController::class, 'getQuotaStatus'])->name('kunjungan.quota.api');

// [PENTING] API Search WBP untuk Select2 di Formulir Pendaftaran
// Route ini mencari data WBP agar sinkron dengan database admin
Route::get('/api/search-wbp', [KunjunganController::class, 'searchWbp'])->name('api.search.wbp');

// API PUBLIK UNTUK ANTRIAN
Route::get('/api/antrian/status', [App\Http\Controllers\Admin\AntrianController::class, 'getStatus'])->name('api.antrian.status');


// =========================================================================
// 3. AUTHENTICATION (LOGIN/LOGOUT/RESET PASS)
// =========================================================================
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->middleware('throttle:5,1');

    // Reset Password Routes
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.update');
});

Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


// =========================================================================
// 5. USER AREA (RIWAYAT KUNJUNGAN, ETC)
// =========================================================================
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/kunjungan/riwayat', [KunjunganController::class, 'riwayat'])->name('kunjungan.riwayat');
});


// =========================================================================
// 4. ADMIN PANEL (DASHBOARD & MANAJEMEN)
// =========================================================================
// Semua route di dalam grup ini wajib LOGIN dan punya role ADMIN
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {

    // A. DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/rekapitulasi', [DashboardController::class, 'rekapitulasi'])->name('admin.rekapitulasi');
    Route::get('/api/dashboard/stats', [DashboardController::class, 'getStats'])->name('dashboard.stats');
    
    // I. MANAJEMEN ANTRIAN
    Route::post('/antrian/panggil', [AntrianController::class, 'panggil'])->name('admin.antrian.panggil');
    Route::post('/antrian/reset', [AntrianController::class, 'reset'])->name('admin.antrian.reset');
    Route::get('/antrian/status', [AntrianController::class, 'getStatus'])->name('admin.antrian.status');

    // B. MANAJEMEN DATA WBP (WARGA BINAAN)
    Route::post('wbp/import', [WbpController::class, 'import'])->name('admin.wbp.import');
    Route::get('wbp/{wbp}/history', [WbpController::class, 'history'])->name('admin.wbp.history');
    Route::resource('wbp', WbpController::class)->names('admin.wbp');

    // C. MANAJEMEN KUNJUNGAN (VERIFIKASI & LAPORAN)
    Route::get('kunjungan/kalender', [AdminKunjunganController::class, 'kalender'])->name('admin.kunjungan.kalender');
    Route::get('api/kunjungan/kalender', [AdminKunjunganController::class, 'kalenderData'])->name('admin.api.kunjungan.kalender');
    Route::get('kunjungan/export', [\App\Http\Controllers\Admin\KunjunganController::class, 'export'])->name('admin.kunjungan.export');
    Route::get('kunjungan/verifikasi', [AdminKunjunganController::class, 'showVerificationForm'])->name('admin.kunjungan.verifikasi');
    Route::post('kunjungan/verifikasi', [AdminKunjunganController::class, 'verifyQrCode'])->name('admin.kunjungan.verifikasi.submit');
    Route::post('kunjungan/bulk-update', [AdminKunjunganController::class, 'bulkUpdate'])->name('admin.kunjungan.bulk-update');
    Route::post('kunjungan/bulk-delete', [AdminKunjunganController::class, 'bulkDelete'])->name('admin.kunjungan.bulk-delete');
    Route::resource('kunjungan', AdminKunjunganController::class, ['names' => 'admin.kunjungan']);

    // D. KELOLA KONTEN (BERITA & PENGUMUMAN)
    Route::resource('news', AdminNewsController::class);
    Route::resource('announcements', AdminAnnouncementController::class);

    // E. MANAJEMEN USER (ADMIN & PETUGAS)
    Route::resource('users', AdminUserController::class)->names('admin.users');

    // G. MANAJEMEN SURVEY IKM
    Route::resource('surveys', \App\Http\Controllers\Admin\SurveyController::class)->names('admin.surveys')->only(['index', 'destroy']);

    // H. MANAJEMEN PENGUNJUNG
    Route::get('pengunjung', [\App\Http\Controllers\Admin\VisitorController::class, 'index'])->name('admin.visitors.index');

    // F. PROFIL ADMIN
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Load auth routes bawaan Laravel Breeze (opsional, jika ada konflik bisa dikomentari)
// require __DIR__ . '/auth.php';