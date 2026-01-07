<?php

use App\Http\Controllers\SurveyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NewsController; // Public News Controller
use App\Http\Controllers\AnnouncementController; // Public Announcement Controller
use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController; // Admin Announcement Controller
use App\Http\Controllers\Admin\NewsController as AdminNewsController; // Admin News Controller
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\Admin\KunjunganController as AdminKunjunganController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\WbpController; // <--- TAMBAHAN: Controller WBP Admin
use App\Http\Controllers\FaqController;
use App\Models\News;
use App\Models\Announcement;
use App\Models\Kunjungan;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Guest\GalleryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =========================================================================
// 1. HALAMAN DEPAN (PUBLIK - PENGUNJUNG)
// =========================================================================
Route::get('/', function () {
    // A. AMBIL BERITA
    $news = News::where('status', 'published')->latest()->take(4)->get();

    // B. AMBIL PENGUMUMAN
    $announcements = Announcement::where('status', 'published')->orderBy('date', 'desc')->take(5)->get();

    return view('welcome', compact('news', 'announcements'));
});

Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');
Route::get('/kontak', [App\Http\Controllers\HomeController::class, 'contact'])->name('contact.index');
Route::post('/kontak', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

Route::post('/survey', [SurveyController::class, 'store'])->name('survey.store');

// Public News Routes
Route::get('/berita', [NewsController::class, 'index'])->name('news.public.index');
Route::get('/berita/{news:slug}', [NewsController::class, 'show'])->name('news.public.show');

// Public Announcement Routes
Route::get('/pengumuman', [AnnouncementController::class, 'index'])->name('announcements.public.index');
Route::get('/pengumuman/{announcement}', [AnnouncementController::class, 'show'])->name('announcements.public.show');


// =========================================================================
// 2. HALAMAN PENDAFTARAN KUNJUNGAN (GUEST)
// =========================================================================
Route::get('/kunjungan/daftar', [KunjunganController::class, 'create'])->name('kunjungan.create');
Route::post('/kunjungan/daftar', [KunjunganController::class, 'store'])->name('kunjungan.store')->middleware('throttle:10,1');
Route::get('/kunjungan/status/{kunjungan}', [KunjunganController::class, 'status'])->name('kunjungan.status');
Route::get('/kunjungan/{kunjungan}/print', [KunjunganController::class, 'printProof'])->name('kunjungan.print');
Route::get('/kunjungan/verify/{kunjungan}', [KunjunganController::class, 'verify'])->name('kunjungan.verify');

// API Routes for Guest Kunjungan
Route::get('/api/kunjungan/{kunjungan}/status', [KunjunganController::class, 'getStatusApi'])->name('kunjungan.status.api');
Route::get('/api/kunjungan/quota', [KunjunganController::class, 'getQuotaStatus'])->name('kunjungan.quota.api');

// API Search WBP (Autocomplete di Form Pendaftaran) <--- TAMBAHAN
Route::get('/api/search-wbp', [KunjunganController::class, 'searchWbp'])->name('api.search.wbp');


// =========================================================================
// 3. AUTHENTICATION ROUTES (CUSTOM)
// =========================================================================
// Kita pakai AuthController custom agar logika cek role dimatikan sementara
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->middleware('throttle:5,1');
});

Route::post('logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// Note: Jika butuh fitur Lupa Password, uncomment baris bawah ini (tapi pakai controller bawaan Breeze)
require __DIR__ . '/auth.php';


// =========================================================================
// 4. HALAMAN ADMIN (WAJIB LOGIN)
// =========================================================================
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {

    // A. DASHBOARD ADMIN
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/api/dashboard/stats', [DashboardController::class, 'getStats'])->name('dashboard.stats');

    // B. CRUD BERITA
    Route::resource('news', AdminNewsController::class);

    // C. CRUD PENGUMUMAN
    Route::resource('announcements', AdminAnnouncementController::class);

    // D. CRUD KUNJUNGAN
    Route::get('kunjungan/verifikasi', [AdminKunjunganController::class, 'showVerificationForm'])->name('admin.kunjungan.verifikasi');
    Route::post('kunjungan/verifikasi', [AdminKunjunganController::class, 'verifyQrCode'])->name('admin.kunjungan.verifikasi.submit');
    Route::get('kunjungan', [AdminKunjunganController::class, 'index'])->name('admin.kunjungan.index');
    Route::get('kunjungan/{kunjungan}', [AdminKunjunganController::class, 'show'])->name('admin.kunjungan.show');
    Route::patch('kunjungan/{kunjungan}', [AdminKunjunganController::class, 'update'])->name('admin.kunjungan.update');
    Route::delete('kunjungan/{kunjungan}', [AdminKunjunganController::class, 'destroy'])->name('admin.kunjungan.destroy');
    Route::post('kunjungan/bulk-update', [AdminKunjunganController::class, 'bulkUpdate'])->name('admin.kunjungan.bulk-update');
    Route::post('kunjungan/bulk-delete', [AdminKunjunganController::class, 'bulkDelete'])->name('admin.kunjungan.bulk-delete');

    // E. CRUD PENGGUNA
    Route::resource('users', AdminUserController::class)->names('admin.users');

    // F. PROFIL ADMIN
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // G. MANAJEMEN WBP & IMPORT EXCEL <--- TAMBAHAN
    Route::resource('wbp', WbpController::class);
    Route::post('wbp/import', [WbpController::class, 'import'])->name('wbp.import');
    Route::get('wbp/{id}/history', [WbpController::class, 'history'])->name('wbp.history');
});

// =========================================================================
// 5. PASSWORD RESET ROUTES
// =========================================================================

// 1. Menampilkan form (Halaman yang ada input emailnya)
Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
    ->name('password.request');

// 2. Memproses pengiriman email (Ini yang dicari oleh error 'password.email')
Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
    ->name('password.email');

// 3. Menampilkan form input password baru
Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
    ->name('password.reset');

// 4. Memproses update password ke database
Route::post('reset-password', [NewPasswordController::class, 'store'])
    ->name('password.update');

// Route Galeri (Bisa diakses publik)
Route::get('/galeri-karya', [GalleryController::class, 'index'])->name('gallery.index');
