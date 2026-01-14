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

        if ($isMonday) {
            $pendaftarPagi = Kunjungan::whereDate('tanggal_kunjungan', $today)->where('sesi', 'pagi')->where('status', KunjunganStatus::APPROVED)->count();
            $kuotaPagi = config('kunjungan.quota_senin_pagi');
            $pendaftarSiang = Kunjungan::whereDate('tanggal_kunjungan', $today)->where('sesi', 'siang')->where('status', KunjunganStatus::APPROVED)->count();
            $kuotaSiang = config('kunjungan.quota_senin_siang');
        } elseif ($isVisitingDay) {
            $pendaftarBiasa = Kunjungan::whereDate('tanggal_kunjungan', $today)->where('status', KunjunganStatus::APPROVED)->count();
            $kuotaBiasa = config('kunjungan.quota_hari_biasa');
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

        if ($isMonday) {
            $pendaftarPagi = Kunjungan::whereDate('tanggal_kunjungan', $today)->where('sesi', 'pagi')->where('status', KunjunganStatus::APPROVED)->count();
            $kuotaPagi = config('kunjungan.quota_senin_pagi');
            $pendaftarSiang = Kunjungan::whereDate('tanggal_kunjungan', $today)->where('sesi', 'siang')->where('status', KunjunganStatus::APPROVED)->count();
            $kuotaSiang = config('kunjungan.quota_senin_siang');
        } elseif ($isVisitingDay) {
            $pendaftarBiasa = Kunjungan::whereDate('tanggal_kunjungan', $today)->where('status', KunjunganStatus::APPROVED)->count();
            $kuotaBiasa = config('kunjungan.quota_hari_biasa');
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
        ]);
    }

    public function rekapitulasi()
    {
        // 1. Visitor Gender Statistics (Primary Visitor)
        $genderCounts = Kunjungan::where('status', KunjunganStatus::APPROVED)
            ->select('jenis_kelamin', DB::raw('count(*) as total'))
            ->groupBy('jenis_kelamin')
            ->pluck('total', 'jenis_kelamin')
            ->all();

        $visitorGender = [
            'Laki-laki' => $genderCounts['Laki-laki'] ?? 0,
            'Perempuan' => $genderCounts['Perempuan'] ?? 0,
        ];

        // 2. Most Visited WBP
        $mostVisitedWbp = Kunjungan::where('status', KunjunganStatus::APPROVED)
            ->join('wbps', 'kunjungans.wbp_id', '=', 'wbps.id')
            ->select('wbps.nama', 'wbps.no_registrasi', 'wbps.blok', 'wbps.kamar', DB::raw('count(kunjungans.wbp_id) as visit_count'))
            ->groupBy('kunjungans.wbp_id', 'wbps.nama', 'wbps.no_registrasi', 'wbps.blok', 'wbps.kamar')
            ->orderBy('visit_count', 'desc')
            ->limit(10)
            ->get();

        // 3. Busiest Visit Sessions
        $sessionCounts = Kunjungan::where('status', KunjunganStatus::APPROVED)
            ->get()
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
}
