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
        return view('admin.executive.index');
    }

    public function kunjunganTrend()
    {
        // Monthly Trend
        $monthlyData = Kunjungan::select(
                DB::raw('DATE_FORMAT(tanggal_kunjungan, "%Y-%m") as month'),
                DB::raw('count(*) as count')
            )
            ->where('status', 'approved')
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
            ->where('status', 'approved')
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
        $heatmapData = Kunjungan::select(
                DB::raw('HOUR(created_at) as hour'),
                DB::raw('count(*) as count')
            )
            ->where('status', 'approved')
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
        // Gender
        $genderData = Kunjungan::select('jenis_kelamin', DB::raw('count(*) as count'))
            ->where('status', 'approved')
            ->groupBy('jenis_kelamin')
            ->pluck('count', 'jenis_kelamin');

        // Relationship
        $relationshipData = Kunjungan::select('hubungan', DB::raw('count(*) as count'))
            ->where('status', 'approved')
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
        $totalVisits30d = Kunjungan::where('status', 'approved')
            ->where('tanggal_kunjungan', '>=', Carbon::now()->subDays(30))
            ->count();

        $busiestDay = Kunjungan::select(DB::raw('DAYNAME(tanggal_kunjungan) as day'), DB::raw('count(*) as count'))
            ->where('status', 'approved')
            ->groupBy('day')
            ->orderBy('count', 'desc')
            ->first();

        $busiestHour = Kunjungan::select(DB::raw('HOUR(created_at) as hour'), DB::raw('count(*) as count'))
            ->where('status', 'approved')
            ->groupBy('hour')
            ->orderBy('count', 'desc')
            ->first();

        $topRelationship = Kunjungan::select('hubungan', DB::raw('count(*) as count'))
            ->where('status', 'approved')
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
        $kunjungans = Kunjungan::where('status', 'approved')->get();

        // 1. Age Distribution
        $ageGroups = ['<20' => 0, '20-30' => 0, '30-40' => 0, '40-50' => 0, '50-60' => 0, '>60' => 0];
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

        // 2. Kecamatan Distribution
        $kecamatanCounts = $kunjungans->pluck('alamat_pengunjung')
            ->map(function ($alamat) {
                if (!$alamat) return 'Tidak Diketahui';

                $lowerAlamat = strtolower($alamat);
                $kecamatan = null;

                // Try to find "kecamatan" or "kec."
                $pos = strpos($lowerAlamat, 'kecamatan ');
                if ($pos === false) {
                    $pos = strpos($lowerAlamat, 'kec. ');
                    if ($pos !== false) {
                        $pos += strlen('kec. ');
                    }
                } else {
                    $pos += strlen('kecamatan ');
                }

                if ($pos !== false) {
                    $substring = substr($alamat, $pos);
                    $parts = preg_split('/, | /', $substring, 2, PREG_SPLIT_NO_EMPTY);
                    $kecamatan = trim($parts[0]);
                } else {
                    // Fallback: take the second to last word, assuming address is "..., Kecamatan, Kabupaten"
                    $parts = explode(' ', trim($alamat));
                    if (count($parts) > 1) {
                        $kecamatan = $parts[count($parts) - 2];
                    } else {
                        $kecamatan = end($parts); // a single word address
                    }
                }
                
                return ucfirst(strtolower(trim(str_replace(',', '', $kecamatan))));
            })
            ->countBy()
            ->sortDesc()
            ->take(10);

        return response()->json([
            'age_distribution' => [
                'labels' => array_keys($ageGroups),
                'data' => array_values($ageGroups),
            ],
            'city_distribution' => [ // Keep key as city_distribution for frontend compatibility for now
                'labels' => $kecamatanCounts->keys(),
                'data' => $kecamatanCounts->values(),
            ],
        ]);
    }

    public function getMostVisitedWbp()
    {
        $mostVisitedWbp = Kunjungan::where('status', KunjunganStatus::APPROVED)
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
