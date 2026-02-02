<?php

use Illuminate\Support\Facades\Route;
use Spatie\Activitylog\Models\Activity;

// Controllers - Public / Guest
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\DisplayController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\Guest\GalleryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

// Controllers - Auth
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;

// Controllers - Admin
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExecutiveDashboardController;
use App\Http\Controllers\Admin\AntrianController;
use App\Http\Controllers\Admin\QueueController;
use App\Http\Controllers\Admin\WbpController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\KunjunganController as AdminKunjunganController;
use App\Http\Controllers\Admin\VisitorController as AdminVisitorController;
use App\Http\Controllers\Admin\SurveyController as AdminSurveyController;

// Models
use App\Models\News;
use App\Models\Announcement;

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
    // Gunakan Cache untuk meningkatkan performa halaman utama
    $news = Cache::remember('homepage_news', 3600, function() {
        return News::where('status', 'published')->latest()->take(4)->get();
    });

    $announcements = Cache::remember('homepage_announcements', 3600, function() {
        return Announcement::where('status', 'published')->orderBy('date', 'desc')->take(5)->get();
    });

    return view('welcome', compact('news', 'announcements'));
});

// Halaman Statis Publik
Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');
Route::get('/kontak', [HomeController::class, 'contact'])->name('contact.index');
Route::post('/kontak', [ContactController::class, 'store'])->name('contact.store');

// Route untuk Survey IKM
Route::get('/survei/isi', [SurveyController::class, 'create'])->name('survey.create');
Route::post('/survei/simpan', [SurveyController::class, 'store'])->name('survey.store');

// Galeri & Profil
Route::get('/galeri-karya', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/profil', [HomeController::class, 'profile'])->name('profile.index');

// Fitur Informasi Realtime Publik
Route::get('/live-antrian', [HomeController::class, 'liveAntrian'])->name('live.antrian');
Route::get('/papan-pengumuman', [HomeController::class, 'papanPengumuman'])->name('papan.pengumuman');

// Halaman Display Antrian Publik (TV Ruang Tunggu)
Route::get('/display-antrian', [DisplayController::class, 'antrian'])->name('display.antrian');

// Berita & Pengumuman (Publik)
Route::get('/berita', [NewsController::class, 'index'])->name('news.public.index');
Route::get('/berita/{news:slug}', [NewsController::class, 'show'])->name('news.public.show');
Route::get('/pengumuman', [AnnouncementController::class, 'index'])->name('announcements.public.index');
Route::get('/pengumuman/{announcement}', [AnnouncementController::class, 'show'])->name('announcements.public.show');

// Produk & Galeri Karya (Publik)
Route::get('/produk', [ProductController::class, 'index'])->name('products.index');
Route::get('/produk/{product}', [ProductController::class, 'show'])->name('products.show');


// =========================================================================
// 2. SISTEM PENDAFTARAN KUNJUNGAN (GUEST)
// =========================================================================
Route::get('/kunjungan/daftar', [KunjunganController::class, 'create'])->name('kunjungan.create');
Route::post('/kunjungan/daftar', [KunjunganController::class, 'store'])->name('kunjungan.store')->middleware('throttle:10,1');

// Status & Tiket Kunjungan
Route::get('/kunjungan/status/{kunjungan}', [KunjunganController::class, 'status'])->name('kunjungan.status');
Route::get('/kunjungan/{kunjungan}/print', [KunjunganController::class, 'printProof'])->name('kunjungan.print');
Route::get('/kunjungan/verify/{kunjungan}', [KunjunganController::class, 'verify'])->name('kunjungan.verify');

// Halaman Cek Status Tanpa ID (Form Pencarian)
Route::get('/kunjungan/cek-status', [KunjunganController::class, 'status'])->name('kunjungan.cek_status');

// API Routes (Dipakai AJAX di Frontend)
Route::get('/api/kunjungan/{kunjungan}/status', [KunjunganController::class, 'getStatusApi'])->name('kunjungan.status.api');
Route::get('/api/kunjungan/quota', [KunjunganController::class, 'getQuotaStatus'])->name('kunjungan.quota.api');
Route::get('/api/profil-by-nik/{nik}', [KunjunganController::class, 'findProfilByNik'])->name('api.profil.by-nik');

// [PENTING] API Search WBP untuk Select2 di Formulir Pendaftaran
Route::get('/api/search-wbp', [KunjunganController::class, 'searchWbp'])->name('api.search.wbp');

// API PUBLIK UNTUK ANTRIAN
Route::get('/api/antrian/status', [AntrianController::class, 'getStatus'])->name('api.antrian.status');


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
// 4. USER AREA (RIWAYAT KUNJUNGAN, ETC)
// =========================================================================
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/kunjungan/riwayat', [KunjunganController::class, 'riwayat'])->name('kunjungan.riwayat');

    // Profil Pengunjung (akses oleh pengguna ter-autentikasi)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes for managing followers (pengikut)
    Route::get('/profile/pengikut', [ProfileController::class, 'pengikut'])->name('profile.pengikut');
    Route::post('/profile/pengikut', [ProfileController::class, 'storePengikut'])->name('profile.pengikut.store');
    Route::delete('/profile/pengikut/{id}', [ProfileController::class, 'destroyPengikut'])->name('profile.pengikut.destroy');
});


// =========================================================================
// 5. ADMIN PANEL (DASHBOARD & MANAJEMEN)
// =========================================================================
// Semua route di dalam grup ini wajib LOGIN dan punya role ADMIN/SUPERADMIN
Route::middleware(['auth', 'verified', 'role:admin,superadmin'])->group(function () {

    // A. DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Executive Dashboard
    Route::get('/dashboard/executive', [ExecutiveDashboardController::class, 'index'])->name('admin.dashboard.executive');
    Route::get('/api/executive/kunjungan-trend', [ExecutiveDashboardController::class, 'kunjunganTrend'])->name('api.executive.kunjungan-trend');
    Route::get('/api/executive/kunjungan-heatmap', [ExecutiveDashboardController::class, 'kunjunganHeatmap'])->name('api.executive.kunjungan-heatmap');
    Route::get('/api/executive/demographics', [ExecutiveDashboardController::class, 'demographics'])->name('api.executive.demographics');
    Route::get('/api/executive/kpis', [ExecutiveDashboardController::class, 'getKpis'])->name('api.executive.kpis');
    Route::get('/api/executive/visitor-demographics', [ExecutiveDashboardController::class, 'getVisitorDemographics'])->name('api.executive.visitor-demographics');
    Route::get('/api/executive/most-visited-wbp', [ExecutiveDashboardController::class, 'getMostVisitedWbp'])->name('api.executive.most-visited-wbp');

    Route::get('/rekapitulasi', [DashboardController::class, 'rekapitulasi'])->name('admin.rekapitulasi');
    Route::get('/rekapitulasi/demografi', [DashboardController::class, 'demografi'])->name('admin.rekapitulasi.demografi');
    Route::get('/rekapitulasi/barang-bawaan', [DashboardController::class, 'barangBawaan'])->name('admin.rekapitulasi.barang_bawaan');
    Route::get('/api/dashboard/stats', [DashboardController::class, 'getStats'])->name('dashboard.stats');

    // Log Aktivitas
    Route::get('/activity-logs', [DashboardController::class, 'activityLogs'])->name('admin.activity_logs.index');
    Route::post('/activity-logs/reset', [DashboardController::class, 'resetActivityLogs'])->name('admin.activity_logs.reset');

    // I. MANAJEMEN ANTRIAN
    Route::post('/antrian/panggil', [AntrianController::class, 'panggil'])->name('admin.antrian.panggil');
    Route::post('/antrian/reset', [AntrianController::class, 'reset'])->name('admin.antrian.reset');
    Route::get('/antrian/status', [AntrianController::class, 'getStatus'])->name('admin.antrian.status');

    // J. MANAJEMEN ANTRIAN KUNJUNGAN (REALTIME)
    Route::get('/antrian/kontrol', [QueueController::class, 'index'])->name('admin.antrian.kontrol');
    Route::get('/api/admin/antrian/state', [QueueController::class, 'getState'])->name('admin.api.antrian.state');
    Route::post('/api/admin/antrian/{kunjungan}/start', [QueueController::class, 'start'])->name('admin.api.antrian.start');
    Route::post('/api/admin/antrian/{kunjungan}/finish', [QueueController::class, 'finish'])->name('admin.api.antrian.finish');

    // B. MANAJEMEN DATA WBP (WARGA BINAAN)
    Route::post('wbp/import', [WbpController::class, 'import'])->name('admin.wbp.import');
    Route::get('wbp/{wbp}/history', [WbpController::class, 'history'])->name('admin.wbp.history');
    Route::resource('wbp', WbpController::class)->names('admin.wbp');

    // C. MANAJEMEN KUNJUNGAN (VERIFIKASI & LAPORAN)
    Route::get('kunjungan/kalender', [AdminKunjunganController::class, 'kalender'])->name('admin.kunjungan.kalender');
    Route::get('api/kunjungan/kalender', [AdminKunjunganController::class, 'kalenderData'])->name('admin.api.kunjungan.kalender');
    Route::get('kunjungan/export', [AdminKunjunganController::class, 'export'])->name('admin.kunjungan.export');
    Route::get('kunjungan/verifikasi', [AdminKunjunganController::class, 'showVerificationForm'])->name('admin.kunjungan.verifikasi');
    Route::post('kunjungan/verifikasi', [AdminKunjunganController::class, 'verifyQrCode'])->name('admin.kunjungan.verifikasi.submit');
    Route::post('kunjungan/bulk-update', [AdminKunjunganController::class, 'bulkUpdate'])->name('admin.kunjungan.bulk-update');
    Route::post('kunjungan/bulk-delete', [AdminKunjunganController::class, 'bulkDelete'])->name('admin.kunjungan.bulk-delete');

    // --> PENDAFTARAN OFFLINE OLEH ADMIN <--
    Route::get('kunjungan/create-offline', [AdminKunjunganController::class, 'createOffline'])->name('admin.kunjungan.createOffline');
    Route::post('kunjungan/create-offline', [AdminKunjunganController::class, 'storeOffline'])->name('admin.kunjungan.storeOffline');
    Route::get('kunjungan/offline/success/{kunjungan}', [AdminKunjunganController::class, 'offlineSuccess'])->name('admin.kunjungan.offline.success');

    Route::resource('kunjungan', AdminKunjunganController::class, ['names' => 'admin.kunjungan']);

    // D. KELOLA KONTEN (BERITA & PENGUMUMAN)
    Route::resource('news', AdminNewsController::class);
    Route::resource('announcements', AdminAnnouncementController::class);

    // MANAJEMEN PRODUK
    Route::resource('products', AdminProductController::class)->names('admin.products');

    // E. MANAJEMEN USER (ADMIN & PETUGAS)
    Route::resource('users', AdminUserController::class)->names('admin.users');

    // G. MANAJEMEN SURVEY IKM
    Route::resource('surveys', AdminSurveyController::class)->names('admin.surveys')->only(['index', 'destroy']);

    // H. MANAJEMEN PENGUNJUNG
    Route::get('pengunjung', [AdminVisitorController::class, 'index'])->name('admin.visitors.index');
});

// Load auth routes bawaan Laravel Breeze
require __DIR__ . '/auth.php';
