<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Announcement;
use App\Models\Kunjungan;
use App\Models\User;
use App\Models\Survey;
use App\Enums\KunjunganStatus;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity; // Tambahkan ini
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        // Data Statistik Umum
        $totalNews = News::count();
        $totalAnnouncements = Announcement::count();
        $totalUsers = User::count();
        $latestNews = News::latest()->take(5)->get();
        
        // Data Kunjungan
        $totalPendingKunjungans = Kunjungan::where('status', KunjunganStatus::PENDING)->count();
        $totalApprovedKunjungans = Kunjungan::where('status', KunjunganStatus::APPROVED)->count(); // Add this line
        $totalApprovedToday = Kunjungan::where('status', KunjunganStatus::APPROVED)->whereDate('updated_at', Carbon::today())->count();
        $totalRejectedKunjungans = Kunjungan::where('status', KunjunganStatus::REJECTED)->count();
        $totalKunjungans = Kunjungan::count();
        $pendingKunjungans = Kunjungan::where('status', KunjunganStatus::PENDING)->latest()->take(5)->get();

        // Data Kuota Harian untuk Tampilan Dashboard
        $today = Carbon::today();
        $isMonday = $today->isMonday();
        $isVisitingDay = $today->isTuesday() || $today->isWednesday() || $today->isThursday();
        
        $pendaftarPagi = $kuotaPagi = $pendaftarSiang = $kuotaSiang = $pendaftarBiasa = $kuotaBiasa = null;
        $pendaftarOfflinePagi = $kuotaOfflinePagi = $pendaftarOfflineSiang = $kuotaOfflineSiang = $pendaftarOfflineBiasa = $kuotaOfflineBiasa = null;
        $pendaftarOfflineTotal = 0;
        $kuotaOfflineTotal = 0;

        if ($isMonday) {
            // Online
            $pendaftarPagi = Kunjungan::whereDate('tanggal_kunjungan', $today)->where('sesi', 'pagi')->where('status', KunjunganStatus::APPROVED)->where('registration_type', 'online')->count();
            $kuotaPagi = config('kunjungan.quota_senin_pagi');
            $pendaftarSiang = Kunjungan::whereDate('tanggal_kunjungan', $today)->where('sesi', 'siang')->where('status', KunjunganStatus::APPROVED)->where('registration_type', 'online')->count();
            $kuotaSiang = config('kunjungan.quota_senin_siang');
            
            // Offline
            $pendaftarOfflinePagi = Kunjungan::whereDate('tanggal_kunjungan', $today)->where('sesi', 'pagi')->where('status', KunjunganStatus::APPROVED)->where('registration_type', 'offline')->count();
            $kuotaOfflinePagi = config('kunjungan.quota_offline_senin_pagi');
            $pendaftarOfflineSiang = Kunjungan::whereDate('tanggal_kunjungan', $today)->where('sesi', 'siang')->where('status', KunjunganStatus::APPROVED)->where('registration_type', 'offline')->count();
            $kuotaOfflineSiang = config('kunjungan.quota_offline_senin_siang');

            $pendaftarOfflineTotal = $pendaftarOfflinePagi + $pendaftarOfflineSiang;
            $kuotaOfflineTotal = $kuotaOfflinePagi + $kuotaOfflineSiang;

        } elseif ($isVisitingDay) {
            // Online
            $pendaftarBiasa = Kunjungan::whereDate('tanggal_kunjungan', $today)->where('status', KunjunganStatus::APPROVED)->where('registration_type', 'online')->count();
            $kuotaBiasa = config('kunjungan.quota_hari_biasa');
            
            // Offline
            $pendaftarOfflineBiasa = Kunjungan::whereDate('tanggal_kunjungan', $today)->where('status', KunjunganStatus::APPROVED)->where('registration_type', 'offline')->count();
            $kuotaOfflineBiasa = config('kunjungan.quota_offline_hari_biasa');

            $pendaftarOfflineTotal = $pendaftarOfflineBiasa;
            $kuotaOfflineTotal = $kuotaOfflineBiasa;
        }

        // Data untuk Chart Kunjungan 7 Hari Terakhir
        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartLabels[] = $date->translatedFormat('D, j M'); // Format: Sen, 22 Des
            $chartData[] = Kunjungan::where('status', KunjunganStatus::APPROVED)
                                      ->whereDate('updated_at', $date)
                                      ->count();
        }

        // Data for Chart Kunjungan per Status
        $chartKunjunganStatusLabels = ['Menunggu Persetujuan', 'Disetujui', 'Ditolak'];
        $chartKunjunganStatusData = [
            $totalPendingKunjungans,
            $totalApprovedKunjungans,
            $totalRejectedKunjungans,
        ];

        // Data for Monthly Visits Chart
        $monthlyVisitsData = Kunjungan::select(
                DB::raw('DATE_FORMAT(tanggal_kunjungan, "%m") as month'),
                DB::raw('count(*) as count')
            )
            ->whereYear('tanggal_kunjungan', date('Y'))
            ->groupBy('month')
            ->orderBy('month', 'ASC')
            ->get()
            ->pluck('count', 'month')->all();

        $monthlyVisitsLabels = [];
        $monthlyVisits = [];
        for ($i = 1; $i <= 12; $i++) {
            $month = date('m', mktime(0, 0, 0, $i, 1));
            $monthlyVisitsLabels[] = date('F', mktime(0, 0, 0, $i, 1));
            $monthlyVisits[] = $monthlyVisitsData[$month] ?? 0;
        }

        // Data for Monthly New Users Chart
        $monthlyUsersData = User::select(
                DB::raw('DATE_FORMAT(created_at, "%m") as month'),
                DB::raw('count(*) as count')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month', 'ASC')
            ->get()
            ->pluck('count', 'month')->all();
        
        $monthlyUsersLabels = [];
        $monthlyUsers = [];
        for ($i = 1; $i <= 12; $i++) {
            $month = date('m', mktime(0, 0, 0, $i, 1));
            $monthlyUsersLabels[] = date('F', mktime(0, 0, 0, $i, 1));
            $monthlyUsers[] = $monthlyUsersData[$month] ?? 0;
        }

        // Data for Survey Ratings Chart
        $surveyRatingsData = Survey::select('rating', DB::raw('count(*) as count'))
            ->groupBy('rating')
            ->pluck('count', 'rating')->all();
            
        $surveyRatingsLabels = ['Buruk', 'Cukup', 'Baik', 'Sangat Baik'];
        $surveyRatings = [
            $surveyRatingsData[1] ?? 0,
            $surveyRatingsData[2] ?? 0,
            $surveyRatingsData[3] ?? 0,
            $surveyRatingsData[4] ?? 0,
        ];

        return view('admin.dashboard', compact(
            'totalNews', 
            'totalAnnouncements', 
            'totalUsers', 
            'latestNews',
            'totalPendingKunjungans',
            'totalApprovedKunjungans',
            'totalApprovedToday',
            'totalRejectedKunjungans',
            'totalKunjungans',
            'pendingKunjungans',
            'isMonday',
            'isVisitingDay',
            'pendaftarPagi',
            'kuotaPagi',
            'pendaftarSiang',
            'kuotaSiang',
            'pendaftarBiasa',
            'kuotaBiasa',
            'pendaftarOfflinePagi',
            'kuotaOfflinePagi',
            'pendaftarOfflineSiang',
            'kuotaOfflineSiang',
            'pendaftarOfflineBiasa',
            'kuotaOfflineBiasa',
            'pendaftarOfflineTotal',
            'kuotaOfflineTotal',
            'chartLabels',
            'chartData',
            'chartKunjunganStatusLabels',
            'chartKunjunganStatusData',
            'monthlyVisitsLabels',
            'monthlyVisits',
            'monthlyUsersLabels',
            'monthlyUsers',
            'surveyRatingsLabels',
            'surveyRatings'
        ));
    }

    public function getStats()
    {
        // Real-time stats
        $totalPendingKunjungans = Kunjungan::where('status', KunjunganStatus::PENDING)->count();
        $totalApprovedKunjungans = Kunjungan::where('status', KunjunganStatus::APPROVED)->count();
        $totalApprovedToday = Kunjungan::where('status', KunjunganStatus::APPROVED)->whereDate('updated_at', Carbon::today())->count();
        $totalRejectedKunjungans = Kunjungan::where('status', KunjunganStatus::REJECTED)->count();
        $totalKunjungans = Kunjungan::count();
        $totalNews = News::count();
        $totalAnnouncements = Announcement::count();
        $totalUsers = User::count();

        // Quota data
        $today = Carbon::today();
        $isMonday = $today->isMonday();
        $isVisitingDay = $today->isTuesday() || $today->isWednesday() || $today->isThursday();
        
        $pendaftarPagi = $kuotaPagi = $pendaftarSiang = $kuotaSiang = $pendaftarBiasa = $kuotaBiasa = null;
        $pendaftarOfflinePagi = $kuotaOfflinePagi = $pendaftarOfflineSiang = $kuotaOfflineSiang = $pendaftarOfflineBiasa = $kuotaOfflineBiasa = null;
        $pendaftarOfflineTotal = 0;
        $kuotaOfflineTotal = 0;

        if ($isMonday) {
            // Online
            $pendaftarPagi = Kunjungan::whereDate('tanggal_kunjungan', $today)->where('sesi', 'pagi')->where('status', KunjunganStatus::APPROVED)->where('registration_type', 'online')->count();
            $kuotaPagi = config('kunjungan.quota_senin_pagi');
            $pendaftarSiang = Kunjungan::whereDate('tanggal_kunjungan', $today)->where('sesi', 'siang')->where('status', KunjunganStatus::APPROVED)->where('registration_type', 'online')->count();
            $kuotaSiang = config('kunjungan.quota_senin_siang');

            // Offline
            $pendaftarOfflinePagi = Kunjungan::whereDate('tanggal_kunjungan', $today)->where('sesi', 'pagi')->where('status', KunjunganStatus::APPROVED)->where('registration_type', 'offline')->count();
            $kuotaOfflinePagi = config('kunjungan.quota_offline_senin_pagi');
            $pendaftarOfflineSiang = Kunjungan::whereDate('tanggal_kunjungan', $today)->where('sesi', 'siang')->where('status', KunjunganStatus::APPROVED)->where('registration_type', 'offline')->count();
            $kuotaOfflineSiang = config('kunjungan.quota_offline_senin_siang');

            $pendaftarOfflineTotal = $pendaftarOfflinePagi + $pendaftarOfflineSiang;
            $kuotaOfflineTotal = $kuotaOfflinePagi + $kuotaOfflineSiang;

        } elseif ($isVisitingDay) {
            // Online
            $pendaftarBiasa = Kunjungan::whereDate('tanggal_kunjungan', $today)->where('status', KunjunganStatus::APPROVED)->where('registration_type', 'online')->count();
            $kuotaBiasa = config('kunjungan.quota_hari_biasa');
            
            // Offline
            $pendaftarOfflineBiasa = Kunjungan::whereDate('tanggal_kunjungan', $today)->where('status', KunjunganStatus::APPROVED)->where('registration_type', 'offline')->count();
            $kuotaOfflineBiasa = config('kunjungan.quota_offline_hari_biasa');

            $pendaftarOfflineTotal = $pendaftarOfflineBiasa;
            $kuotaOfflineTotal = $kuotaOfflineBiasa;
        }

        return response()->json([
            'totalPendingKunjungans' => $totalPendingKunjungans,
            'totalApprovedKunjungans' => $totalApprovedKunjungans,
            'totalApprovedToday' => $totalApprovedToday,
            'totalRejectedKunjungans' => $totalRejectedKunjungans,
            'totalKunjungans' => $totalKunjungans,
            'totalNews' => $totalNews,
            'totalAnnouncements' => $totalAnnouncements,
            'totalUsers' => $totalUsers,
            'isMonday' => $isMonday,
            'isVisitingDay' => $isVisitingDay,
            'pendaftarPagi' => $pendaftarPagi,
            'kuotaPagi' => $kuotaPagi,
            'pendaftarSiang' => $pendaftarSiang,
            'kuotaSiang' => $kuotaSiang,
            'pendaftarBiasa' => $pendaftarBiasa,
            'kuotaBiasa' => $kuotaBiasa,
            'pendaftarOfflinePagi' => $pendaftarOfflinePagi,
            'kuotaOfflinePagi' => $kuotaOfflinePagi,
            'pendaftarOfflineSiang' => $pendaftarOfflineSiang,
            'kuotaOfflineSiang' => $kuotaOfflineSiang,
            'pendaftarOfflineBiasa' => $pendaftarOfflineBiasa,
            'kuotaOfflineBiasa' => $kuotaOfflineBiasa,
            'pendaftarOfflineTotal' => $pendaftarOfflineTotal,
            'kuotaOfflineTotal' => $kuotaOfflineTotal,
        ]);
    }

    public function rekapitulasi(Request $request)
    {
        $registrationType = $request->input('registration_type', 'all');

        // 1. Visitor Gender Statistics (Primary Visitor)
        $genderCountsQuery = Kunjungan::where('status', KunjunganStatus::APPROVED)
            ->when($registrationType !== 'all', function ($query) use ($registrationType) {
                return $query->where('registration_type', $registrationType);
            });

        $genderCounts = $genderCountsQuery->select('jenis_kelamin', DB::raw('count(*) as total'))
            ->groupBy('jenis_kelamin')
            ->pluck('total', 'jenis_kelamin')
            ->all();

        $visitorGender = [
            'Laki-laki' => $genderCounts['Laki-laki'] ?? 0,
            'Perempuan' => $genderCounts['Perempuan'] ?? 0,
        ];

        // 2. Most Visited WBP
        $mostVisitedWbpQuery = Kunjungan::where('status', KunjunganStatus::APPROVED)
            ->when($registrationType !== 'all', function ($query) use ($registrationType) {
                return $query->where('registration_type', $registrationType);
            });
        
        $mostVisitedWbp = $mostVisitedWbpQuery->join('wbps', 'kunjungans.wbp_id', '=', 'wbps.id')
            ->select('wbps.nama', 'wbps.no_registrasi', 'wbps.blok', 'wbps.kamar', DB::raw('count(kunjungans.wbp_id) as visit_count'))
            ->groupBy('kunjungans.wbp_id', 'wbps.nama', 'wbps.no_registrasi', 'wbps.blok', 'wbps.kamar')
            ->orderBy('visit_count', 'desc')
            ->limit(10)
            ->get();

        // 3. Busiest Visit Sessions
        $sessionCountsQuery = Kunjungan::where('status', KunjunganStatus::APPROVED)
            ->when($registrationType !== 'all', function ($query) use ($registrationType) {
                return $query->where('registration_type', $registrationType);
            });

        $sessionCounts = $sessionCountsQuery->get()
            ->mapToGroups(function ($item) {
                // Use Carbon for reliable day translation
                $dayName = Carbon::parse($item->tanggal_kunjungan)->getTranslatedDayName();
                $session = ucfirst($item->sesi);
                return ["$dayName ($session)" => 1];
            })
            ->map(function ($group) {
                return $group->count();
            })
            ->sortDesc();

        return view('admin.rekapitulasi.index', compact('visitorGender', 'mostVisitedWbp', 'sessionCounts'));
    }

    public function demografi(Request $request)
    {
        $kunjungans = Kunjungan::where('status', KunjunganStatus::APPROVED)->get();

        // 1. Age Distribution
        $ageGroups = [
            '<20' => 0,
            '20-30' => 0,
            '30-40' => 0,
            '40-50' => 0,
            '50-60' => 0,
            '>60' => 0,
        ];

        foreach ($kunjungans as $kunjungan) {
            $age = $this->getAgeFromNik($kunjungan->nik_ktp);
            if ($age !== null) {
                if ($age < 20) $ageGroups['<20']++;
                elseif ($age <= 30) $ageGroups['20-30']++;
                elseif ($age <= 40) $ageGroups['30-40']++;
                elseif ($age <= 50) $ageGroups['40-50']++;
                elseif ($age <= 60) $ageGroups['50-60']++;
                else $ageGroups['>60']++;
            }
        }

        // 2. Gender Distribution
        $genderCounts = $kunjungans->groupBy('jenis_kelamin')->map->count();
        $visitorGender = [
            'Laki-laki' => $genderCounts['Laki-laki'] ?? 0,
            'Perempuan' => $genderCounts['Perempuan'] ?? 0,
        ];

        // 3. City Distribution
        $cityCounts = $kunjungans->pluck('alamat_pengunjung')
            ->map(function ($alamat) {
                $parts = explode(' ', $alamat);
                return trim(end($parts));
            })
            ->countBy()
            ->sortDesc()
            ->take(10);

        return view('admin.rekapitulasi.demografi', compact('ageGroups', 'visitorGender', 'cityCounts'));
    }

    private function getAgeFromNik($nik)
    {
        if (strlen($nik) !== 16) {
            return null;
        }

        $day = (int) substr($nik, 6, 2);
        $month = (int) substr($nik, 8, 2);
        $year = (int) substr($nik, 10, 2);

        if ($day > 40) {
            $day -= 40;
        }

        $currentYear = (int) date('y');
        $birthYear = $year > $currentYear ? '19' . $year : '20' . str_pad($year, 2, '0', STR_PAD_LEFT);

        try {
            $birthDate = Carbon::createFromDate($birthYear, $month, $day);
            return $birthDate->age;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function barangBawaan(Request $request)
    {
        $itemCounts = Kunjungan::where('status', KunjunganStatus::APPROVED)
            ->whereNotNull('barang_bawaan')
            ->where('barang_bawaan', '!=', '')
            ->get()
            ->pluck('barang_bawaan')
            ->flatMap(function ($itemString) {
                return array_map('trim', explode(',', strtolower($itemString)));
            })
            ->countBy()
            ->sortDesc()
            ->take(20);

        return view('admin.rekapitulasi.barang_bawaan', compact('itemCounts'));
    }

    /**
     * Menampilkan daftar log aktivitas.
     */
    public function activityLogs(Request $request)
    {
        $activityLogs = Activity::with('causer', 'subject') // eager load causer dan subject
            ->latest() // Urutkan dari yang terbaru
            ->paginate(20); // Paginate 20 item per halaman

        return view('admin.activity_logs.index', compact('activityLogs'));
    }

    /**
     * Menghapus SEMUA log aktivitas sistem.
     */
    public function resetActivityLogs()
    {
        Activity::query()->truncate();

        return redirect()->route('admin.activity_logs.index')->with('success', 'Semua log aktivitas berhasil dihapus!');
    }

    /**
     * Menghapus log aktivitas yang lebih dari 1 bulan (30 hari).
     */
    public function deleteOldActivityLogs()
    {
        $deleted = Activity::where('created_at', '<', now()->subMonth())->delete();

        return redirect()->route('admin.activity_logs.index')
            ->with('success', "Log aktivitas lebih dari 1 bulan berhasil dihapus ({$deleted} entri).");
    }
}

