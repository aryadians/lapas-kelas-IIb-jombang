<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Enums\KunjunganStatus;

class ExecutiveDashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $isMonday = $today->isMonday();
        $isVisitingDay = $today->isTuesday() || $today->isWednesday() || $today->isThursday();
        
        $pendaftarPagi = $kuotaPagi = $pendaftarSiang = $kuotaSiang = $pendaftarBiasa = $kuotaBiasa = null;
        $pendaftarOfflinePagi = $kuotaOfflinePagi = $pendaftarOfflineSiang = $kuotaOfflineSiang = $pendaftarOfflineBiasa = $kuotaOfflineBiasa = null;
        $pendaftarOfflineTotal = 0;
        $kuotaOfflineTotal = 0;

        $scheduleToday = \App\Models\VisitSchedule::where('day_of_week', $today->dayOfWeek)->first();

        $validStatuses = [
            KunjunganStatus::APPROVED, KunjunganStatus::CALLED, 
            KunjunganStatus::IN_PROGRESS, KunjunganStatus::COMPLETED
        ];

        if ($isMonday && $scheduleToday && $scheduleToday->is_open) {
            // Online
            $pendaftarPagi = Kunjungan::whereDate('tanggal_kunjungan', $today)->where('sesi', 'pagi')->whereIn('status', $validStatuses)->where('registration_type', 'online')->count();
            $kuotaPagi = $scheduleToday->quota_online_morning;
            $pendaftarSiang = Kunjungan::whereDate('tanggal_kunjungan', $today)->where('sesi', 'siang')->whereIn('status', $validStatuses)->where('registration_type', 'online')->count();
            $kuotaSiang = $scheduleToday->quota_online_afternoon;
            
            // Offline
            $pendaftarOfflinePagi = Kunjungan::whereDate('tanggal_kunjungan', $today)->where('sesi', 'pagi')->whereIn('status', $validStatuses)->where('registration_type', 'offline')->count();
            $kuotaOfflinePagi = $scheduleToday->quota_offline_morning;
            $pendaftarOfflineSiang = Kunjungan::whereDate('tanggal_kunjungan', $today)->where('sesi', 'siang')->whereIn('status', $validStatuses)->where('registration_type', 'offline')->count();
            $kuotaOfflineSiang = $scheduleToday->quota_offline_afternoon;

            $pendaftarOfflineTotal = $pendaftarOfflinePagi + $pendaftarOfflineSiang;
            $kuotaOfflineTotal = $kuotaOfflinePagi + $kuotaOfflineSiang;

        } elseif ($isVisitingDay && $scheduleToday && $scheduleToday->is_open) {
            // Online
            $pendaftarBiasa = Kunjungan::whereDate('tanggal_kunjungan', $today)->whereIn('status', $validStatuses)->where('registration_type', 'online')->count();
            $kuotaBiasa = $scheduleToday->quota_online_morning; 
            
            // Offline
            $pendaftarOfflineBiasa = Kunjungan::whereDate('tanggal_kunjungan', $today)->whereIn('status', $validStatuses)->where('registration_type', 'offline')->count();
            $kuotaOfflineBiasa = $scheduleToday->quota_offline_morning; 

            $pendaftarOfflineTotal = $pendaftarOfflineBiasa;
            $kuotaOfflineTotal = $kuotaOfflineBiasa;
        }

        return view('admin.executive.index', compact(
            'isMonday',
            'isVisitingDay',
            'scheduleToday',
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
            'kuotaOfflineTotal'
        ));
    }

    public function kunjunganTrend()
    {
        $validStatuses = ['approved', 'called', 'in_progress', 'completed'];

        // Monthly Trend
        $monthlyData = Kunjungan::select(
                DB::raw('DATE_FORMAT(tanggal_kunjungan, "%Y-%m") as month'),
                DB::raw('count(*) as count')
            )
            ->whereIn('status', $validStatuses)
            ->where('tanggal_kunjungan', '>=', Carbon::now()->subYear())
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get()
            ->pluck('count', 'month');

        $monthlyLabels = [];
        $monthlyValues = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthKey = $month->format('Y-m');
            $monthlyLabels[] = $month->format('M Y');
            $monthlyValues[] = $monthlyData[$monthKey] ?? 0;
        }

        // Daily Trend (Last 30 days)
        $dailyData = Kunjungan::select(
                DB::raw('DATE(tanggal_kunjungan) as day'),
                DB::raw('count(*) as count')
            )
            ->whereIn('status', $validStatuses)
            ->where('tanggal_kunjungan', '>=', Carbon::now()->subDays(30))
            ->groupBy('day')
            ->orderBy('day', 'asc')
            ->get()
            ->pluck('count', 'day');

        $dailyLabels = [];
        $dailyValues = [];
        for ($i = 29; $i >= 0; $i--) {
            $day = Carbon::now()->subDays($i);
            $dayKey = $day->format('Y-m-d');
            $dailyLabels[] = $day->format('d M');
            $dailyValues[] = $dailyData[$dayKey] ?? 0;
        }

        return response()->json([
            'monthly' => [
                'labels' => $monthlyLabels,
                'data' => $monthlyValues,
            ],
            'daily' => [
                'labels' => $dailyLabels,
                'data' => $dailyValues,
            ],
        ]);
    }

    public function kunjunganHeatmap()
    {
        $validStatuses = ['approved', 'called', 'in_progress', 'completed'];
        $heatmapData = Kunjungan::select(
                DB::raw('HOUR(created_at) as hour'),
                DB::raw('count(*) as count')
            )
            ->whereIn('status', $validStatuses)
            ->groupBy('hour')
            ->orderBy('hour', 'asc')
            ->pluck('count', 'hour');

        $labels = [];
        $data = [];
        for ($i = 0; $i < 24; $i++) {
            $labels[] = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00';
            $data[] = $heatmapData[$i] ?? 0;
        }

        return response()->json(['labels' => $labels, 'data' => $data]);
    }

    public function demographics()
    {
        $validStatuses = ['approved', 'called', 'in_progress', 'completed'];

        // Gender
        $genderData = Kunjungan::select('jenis_kelamin', DB::raw('count(*) as count'))
            ->whereIn('status', $validStatuses)
            ->groupBy('jenis_kelamin')
            ->pluck('count', 'jenis_kelamin');

        // Relationship
        $relationshipData = Kunjungan::select('hubungan', DB::raw('count(*) as count'))
            ->whereIn('status', $validStatuses)
            ->groupBy('hubungan')
            ->pluck('count', 'hubungan');

        return response()->json([
            'gender' => [
                'labels' => $genderData->keys(),
                'data' => $genderData->values(),
            ],
            'relationship' => [
                'labels' => $relationshipData->keys(),
                'data' => $relationshipData->values(),
            ],
        ]);
    }

    public function getKpis()
    {
        $validStatuses = ['approved', 'called', 'in_progress', 'completed'];

        $totalVisits30d = Kunjungan::whereIn('status', $validStatuses)
            ->where('tanggal_kunjungan', '>=', Carbon::now()->subDays(30))
            ->count();

        $busiestDay = Kunjungan::select(DB::raw('DAYNAME(tanggal_kunjungan) as day'), DB::raw('count(*) as count'))
            ->whereIn('status', $validStatuses)
            ->groupBy('day')
            ->orderBy('count', 'desc')
            ->first();

        $busiestHour = Kunjungan::select(DB::raw('HOUR(created_at) as hour'), DB::raw('count(*) as count'))
            ->whereIn('status', $validStatuses)
            ->groupBy('hour')
            ->orderBy('count', 'desc')
            ->first();

        $topRelationship = Kunjungan::select('hubungan', DB::raw('count(*) as count'))
            ->whereIn('status', $validStatuses)
            ->groupBy('hubungan')
            ->orderBy('count', 'desc')
            ->first();
        
        $dayTranslations = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
        ];

        return response()->json([
            'total_visits_30d' => $totalVisits30d,
            'busiest_day' => $busiestDay ? $dayTranslations[$busiestDay->day] : 'N/A',
            'busiest_hour' => $busiestHour ? str_pad($busiestHour->hour, 2, '0', STR_PAD_LEFT) . ':00' : 'N/A',
            'top_relationship' => $topRelationship ? $topRelationship->hubungan : 'N/A',
        ]);
    }

    public function getVisitorDemographics()
    {
        $validStatuses = ['approved', 'called', 'in_progress', 'completed'];
        $kunjungans = Kunjungan::whereIn('status', $validStatuses)->get(['nik_ktp', 'alamat_pengunjung']);

        // 1. Age Distribution
        $ageGroups = ['< 20' => 0, '20–30' => 0, '30–40' => 0, '40–50' => 0, '50–60' => 0, '> 60' => 0];
        foreach ($kunjungans as $k) {
            $age = $this->getAgeFromNik($k->nik_ktp);
            if ($age !== null) {
                if ($age < 20)       $ageGroups['< 20']++;
                elseif ($age <= 30)  $ageGroups['20–30']++;
                elseif ($age <= 40)  $ageGroups['30–40']++;
                elseif ($age <= 50)  $ageGroups['40–50']++;
                elseif ($age <= 60)  $ageGroups['50–60']++;
                else                 $ageGroups['> 60']++;
            }
        }

        // 2. Kecamatan Distribution — Parsing dengan regex kuat
        $kecamatanCounts = $kunjungans->pluck('alamat_pengunjung')
            ->map(function ($alamat) {
                if (!$alamat) return 'Tidak Diketahui';

                // Coba tangkap: "Kec. Xxx", "Kecamatan Xxx", "Kec Xxx" (inkl. multi-kata)
                if (preg_match('/\bKec(?:amatan)?[.\s]+([A-Za-z\s]+?)(?:\s*[,\/\n]|$)/i', $alamat, $m)) {
                    $kec = trim(preg_replace('/\s+/', ' ', $m[1]));
                    // Batas max 3 kata untuk kecamatan
                    $words = explode(' ', $kec);
                    $kec = implode(' ', array_slice($words, 0, 3));
                    return 'Kec. ' . ucwords(strtolower($kec));
                }

                return 'Tidak Teridentifikasi';
            })
            ->countBy()
            ->sortDesc()
            ->take(10);

        // 3. Desa/Kelurahan Distribution — Parsing dengan regex kuat
        $desaCounts = $kunjungans->pluck('alamat_pengunjung')
            ->map(function ($alamat) {
                if (!$alamat) return 'Tidak Diketahui';

                // Coba tangkap: "Desa Xxx", "Kel. Xxx", "Kelurahan Xxx", "Ds. Xxx"
                if (preg_match('/\b(?:Desa|Ds\.?|Kel(?:urahan)?\.?)[.\s]+([A-Za-z\s]+?)(?:\s*[,\/\n]|$)/i', $alamat, $m)) {
                    $desa = trim(preg_replace('/\s+/', ' ', $m[1]));
                    $words = explode(' ', $desa);
                    $desa = implode(' ', array_slice($words, 0, 3));

                    // Tentukan prefix
                    $prefix = preg_match('/\bKel/i', $m[0]) ? 'Kel. ' : 'Ds. ';
                    return $prefix . ucwords(strtolower($desa));
                }

                return 'Tidak Teridentifikasi';
            })
            ->countBy()
            ->sortDesc()
            ->take(10);

        // Hitung total untuk persentase
        $totalKecamatan = $kecamatanCounts->sum();
        $totalDesa      = $desaCounts->sum();

        return response()->json([
            'age_distribution' => [
                'labels' => array_keys($ageGroups),
                'data'   => array_values($ageGroups),
            ],
            'city_distribution' => [
                'labels'     => $kecamatanCounts->keys()->values(),
                'data'       => $kecamatanCounts->values()->values(),
                'total'      => $totalKecamatan,
            ],
            'village_distribution' => [
                'labels'     => $desaCounts->keys()->values(),
                'data'       => $desaCounts->values()->values(),
                'total'      => $totalDesa,
            ],
        ]);
    }


    public function getMostVisitedWbp()
    {
        $validStatuses = [
            KunjunganStatus::APPROVED, KunjunganStatus::CALLED, 
            KunjunganStatus::IN_PROGRESS, KunjunganStatus::COMPLETED
        ];

        $mostVisitedWbp = Kunjungan::whereIn('status', $validStatuses)
            ->join('wbps', 'kunjungans.wbp_id', '=', 'wbps.id')
            ->select('wbps.nama', 'wbps.no_registrasi', 'wbps.blok', 'wbps.kamar', DB::raw('count(kunjungans.wbp_id) as visit_count'))
            ->groupBy('kunjungans.wbp_id', 'wbps.nama', 'wbps.no_registrasi', 'wbps.blok', 'wbps.kamar')
            ->orderBy('visit_count', 'desc')
            ->limit(10)
            ->get();

        return response()->json($mostVisitedWbp);
    }
    
    private function getAgeFromNik($nik)
    {
        if (strlen($nik) !== 16) return null;
        $day = (int) substr($nik, 6, 2);
        $month = (int) substr($nik, 8, 2);
        $year = (int) substr($nik, 10, 2);
        if ($day > 40) $day -= 40;
        $currentYear = (int) date('y');
        $birthYear = $year > $currentYear ? '19' . $year : '20' . str_pad($year, 2, '0', STR_PAD_LEFT);
        try {
            return Carbon::createFromDate($birthYear, $month, $day)->age;
        } catch (\Exception $e) {
            return null;
        }
    }
}
