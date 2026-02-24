<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Kunjungan;
use App\Models\VisitSchedule;
use App\Models\Wbp;
use App\Enums\KunjunganStatus;
use Illuminate\Support\Facades\Cache;

class RegistrationValidationService
{
    protected QuotaService $quotaService;

    public function __construct(QuotaService $quotaService)
    {
        $this->quotaService = $quotaService;
    }

    /**
     * Memvalidasi form pendaftaran secara menyeluruh (H-N, Kuota, Kode Tahanan, Limit NIK/WBP).
     * Returns an array with ['isValid' => boolean, 'field' => string|null, 'message' => string|null]
     * If valid, returns ['isValid' => true]
     */
    public function validate(array $validatedData): array
    {
        $tanggal = Carbon::parse($validatedData['tanggal_kunjungan']);
        $dateStr = $tanggal->format('Y-m-d');
        
        // Prevent past dates
        if ($tanggal->isPast()) {
            return $this->error('tanggal_kunjungan', 'Tanggal kunjungan tidak boleh di masa lalu.');
        }

        $visitSettings = Cache::rememberForever('visit_settings', function() {
            return \App\Models\VisitSetting::pluck('value', 'key')->toArray();
        });

        // 0.A CEK STATUS DARURAT
        $isEmergencyClosed = ($visitSettings['is_emergency_closed'] ?? '0') == '1';
        if ($isEmergencyClosed) {
            return $this->error('global', 'Mohon maaf, layanan pendaftaran kunjungan sedang ditutup sementara waktu.');
        }

        // 0.B CEK BATAS PENGIKUT
        $maxFollowers = (int) ($visitSettings['max_followers_allowed'] ?? 4);
        $totalFollowers = isset($validatedData['pengikut_nama']) ? count(array_filter($validatedData['pengikut_nama'])) : 0;
        
        if ($totalFollowers > $maxFollowers) {
            return $this->error('pengikut_nama', "Total maksimal rombongan pengikut tidak boleh lebih dari $maxFollowers orang.");
        }

        // 0. CEK BATAS H-N PENDAFTARAN
        $leadTime = (int) ($visitSettings['registration_lead_time'] ?? 1);
        $minDate = Carbon::today()->addDays($leadTime);
        if ($tanggal->lt($minDate)) {
            return $this->error('tanggal_kunjungan', "Pendaftaran untuk tanggal ini sudah ditutup. Minimal pendaftaran adalah $leadTime hari sebelum kunjungan.");
        }

        $sesi = (isset($validatedData['sesi']) && !is_null($validatedData['sesi']) && trim((string)$validatedData['sesi']) !== '') ? strtolower(trim($validatedData['sesi'])) : 'pagi'; 

        // 1. CEK APAKAH HARI TERSEBUT BUKA
        if (!$this->quotaService->isDayOpen($dateStr)) {
            return $this->error('tanggal_kunjungan', 'Layanan kunjungan tidak tersedia (TUTUP) pada hari yang Anda pilih.');
        }

        // 1.B CEK KODE TAHANAN WBP DENGAN JADWAL
        // Use Cache for VisitSchedule if applicable, or query it
        $schedule = Cache::rememberForever('open_schedules', function() {
            return VisitSchedule::where('is_open', true)->get();
        })->where('day_of_week', $tanggal->dayOfWeek)->first();
        
        $wbp = Wbp::find($validatedData['wbp_id']);
        if ($schedule && $wbp && !empty($schedule->allowed_kode_tahanan)) {
            $wbpCode = (string) $wbp->kode_tahanan;
            
            $isAllowed = false;
            foreach ($schedule->allowed_kode_tahanan as $allowed) {
                if (trim($wbpCode) !== '' && str_starts_with(strtoupper(trim($wbpCode)), strtoupper(trim($allowed)))) {
                    $isAllowed = true;
                    break;
                }
            }

            if (!$isAllowed) {
                $allowedFormatted = implode(', ', $schedule->allowed_kode_tahanan);
                if (trim($wbpCode) === '') {
                    return $this->error('tanggal_kunjungan', "WBP ini belum memiliki data Kode Tahanan di sistem, sehingga tidak dapat dikunjungi pada hari {$schedule->day_name} (khusus untuk kode: {$allowedFormatted}). Silakan hubungi admin.");
                }
                return $this->error('tanggal_kunjungan', "WBP dengan kode '{$wbpCode}' tidak diizinkan dikunjungi pada hari {$schedule->day_name}. Hari tersebut khusus untuk kode: {$allowedFormatted}.");
            }
        }

        // 2. CEK KUOTA (Online)
        if (!$this->quotaService->checkAvailability($dateStr, $sesi, 'online')) {
            return $this->error('sesi', 'Mohon maaf, kuota pendaftaran online untuk jadwal ini sudah penuh.');
        }

        // 3. LOGIKA PEMBATASAN DINAMIS (NIK & WBP)
        $limitNik = (int) ($visitSettings['limit_nik_per_week'] ?? 1);
        $limitWbp = (int) ($visitSettings['limit_wbp_per_week'] ?? 1);

        $startWeek = $tanggal->copy()->subDays(6);

        // Cek Batasan WBP
        $wbpVisitCount = Kunjungan::where('wbp_id', $validatedData['wbp_id'])
            ->whereIn('status', [KunjunganStatus::PENDING, KunjunganStatus::APPROVED, KunjunganStatus::COMPLETED])
            ->whereBetween('tanggal_kunjungan', [$startWeek->format('Y-m-d'), $dateStr])
            ->count();

        if ($wbpVisitCount >= $limitWbp) {
            return $this->error('global', "Warga Binaan ini sudah mencapai batas maksimal dikunjungi ($limitWbp kali) dalam seminggu terakhir.");
        }

        // Cek Batasan NIK
        $nikVisitCount = Kunjungan::where('nik_ktp', $validatedData['nik_ktp'])
            ->whereIn('status', [KunjunganStatus::PENDING, KunjunganStatus::APPROVED, KunjunganStatus::COMPLETED])
            ->whereBetween('tanggal_kunjungan', [$startWeek->format('Y-m-d'), $dateStr])
            ->count();

        if ($nikVisitCount >= $limitNik) {
            return $this->error('global', "NIK Anda sudah mencapai batas maksimal melakukan kunjungan ($limitNik kali) dalam seminggu terakhir.");
        }

        return ['isValid' => true];
    }

    private function error(string $field, string $message): array
    {
         return [
             'isValid' => false,
             'field' => $field,
             'message' => $message
         ];
    }
}
