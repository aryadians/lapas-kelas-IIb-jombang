<?php

namespace App\Services;

use App\Models\Kunjungan;
use App\Models\Pengikut;
use App\Models\ProfilPengunjung;
use App\Services\ImageService;
use App\Enums\KunjunganStatus;
use App\Jobs\SendWhatsAppPendingNotification;
use App\Mail\KunjunganStatusMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class KunjunganService
{
    /**
     * Handle the registration of a new Kunjungan.
     *
     * @param array $data Validated data from request
     * @param \Illuminate\Http\UploadedFile|null $fileKtp
     * @param array|null $filesPengikut
     * @param int $nomorAntrian
     * @return Kunjungan
     * @throws \Exception
     */
    public function storeRegistration(array $data, $fileKtp, $filesPengikut, int $nomorAntrian)
    {
        return DB::transaction(function () use ($data, $fileKtp, $filesPengikut, $nomorAntrian) {
            
            // 1. Process Main KTP Image
            $fotoKtpBase64 = null;
            if ($fileKtp) {
                $compressed = ImageService::compressUploadedFile($fileKtp, 1200, 80);
                $fotoKtpBase64 = 'data:image/jpeg;base64,' . base64_encode($compressed);
            }

            // 2. Update/Create Profil Pengunjung
            $profil = ProfilPengunjung::updateOrCreate(
                ['nik' => $data['nik_ktp']],
                [
                    'nama'          => $data['nama_pengunjung'],
                    'nomor_hp'      => $data['nomor_hp'],
                    'email'         => $data['email_pengunjung'],
                    'alamat'        => $data['alamat_lengkap'],
                    'jenis_kelamin' => $data['jenis_kelamin'],
                    'image'         => $fotoKtpBase64,
                ]
            );

            // 3. Generate Kode Kunjungan
            $kodeKunjungan = $this->generateUniqueCode();

            // 4. Create Kunjungan Record
            $kunjungan = Kunjungan::create([
                'profil_pengunjung_id' => $profil->id,
                'wbp_id'               => $data['wbp_id'],
                'kode_kunjungan'       => $kodeKunjungan,
                'nomor_antrian_harian' => $nomorAntrian,
                'tanggal_kunjungan'    => $data['tanggal_kunjungan'],
                'sesi'                 => $data['sesi'] ?? null,
                'hubungan'             => $data['hubungan'],
                'barang_bawaan'        => $data['barang_bawaan'] ?? null,
                'jumlah_pengikut'      => isset($data['pengikut_nama']) ? count($data['pengikut_nama']) : 0,
                'status'               => KunjunganStatus::PENDING,
                'qr_token'             => Str::uuid(),
                'preferred_notification_channel' => 'both',
                
                // Redundant fields for backward compatibility/history
                'nama_pengunjung'   => $data['nama_pengunjung'],
                'nik_ktp'           => $data['nik_ktp'],
                'nomor_hp'          => $data['nomor_hp'],
                'email_pengunjung'  => $data['email_pengunjung'],
                'alamat_lengkap'    => $data['alamat_lengkap'],
                'jenis_kelamin'     => $data['jenis_kelamin'],
                'no_wa_pengunjung'  => $data['nomor_hp'],
                'alamat_pengunjung' => $data['alamat_lengkap'],
                
                'foto_ktp'              => $fotoKtpBase64,
                'foto_ktp_path'         => null, // We use Base64 now
                'foto_ktp_processed_at' => $fotoKtpBase64 ? now() : null,
            ]);

            // 5. Process Pengikut
            if (isset($data['pengikut_nama']) && is_array($data['pengikut_nama'])) {
                foreach ($data['pengikut_nama'] as $index => $nama) {
                    if (!empty($nama)) {
                        $fotoPengikutBase64 = null;
                        
                        if (isset($filesPengikut[$index])) {
                             $fileP = $filesPengikut[$index];
                             $compressedP = ImageService::compressUploadedFile($fileP, 1000, 80);
                             $fotoPengikutBase64 = 'data:image/jpeg;base64,' . base64_encode($compressedP);
                        }

                        Pengikut::create([
                            'kunjungan_id'  => $kunjungan->id,
                            'nama'          => $nama,
                            'nik'           => $data['pengikut_nik'][$index] ?? null,
                            'hubungan'      => $data['pengikut_hubungan'][$index] ?? null,
                            'barang_bawaan' => null,
                            'foto_ktp'      => $fotoPengikutBase64,
                            'foto_ktp_path' => null,
                            'foto_ktp_processed_at' => $fotoPengikutBase64 ? now() : null,
                        ]);
                    }
                }
            }

            // 6. Generate QR Code & Store as Base64 in barcode column
            $qrCodePath = $this->generateQrCode($kunjungan);
            
            // Simpan QR Code Base64 ke kolom barcode
            try {
                $qrBase64 = 'data:image/png;base64,' . base64_encode(QrCode::format('png')->size(400)->margin(2)->generate($kunjungan->qr_token));
                $kunjungan->update(['barcode' => $qrBase64]);
                
                // Juga update di ProfilPengunjung jika diinginkan (sesuai instruksi yang menyebut profil_pengunjung juga simpan barcode)
                $profil->update(['barcode' => $qrBase64]);
            } catch (\Exception $e) {
                Log::error("Failed to generate Base64 QR: " . $e->getMessage());
            }

            // 7. Dispatch Notifications
            $this->dispatchNotifications($kunjungan, $qrCodePath);

            return $kunjungan;
        });
    }

    private function generateUniqueCode()
    {
        do {
            $code = 'VIS-' . strtoupper(Str::random(6));
        } while (Kunjungan::where('kode_kunjungan', $code)->exists());
        return $code;
    }

    private function generateQrCode($kunjungan)
    {
        // Ensure directory exists (Local Only - needs refactor for S3 later)
        $path = storage_path('app/public/qrcodes');
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        $qrCodePath = 'qrcodes/' . $kunjungan->id . '.png';
        try {
            // Try generating PNG locally (Requires Imagick)
            $qrContent = QrCode::format('png')->size(400)->margin(2)->color(0, 0, 0)->backgroundColor(255, 255, 255)->generate($kunjungan->qr_token);
            Storage::disk('public')->put($qrCodePath, $qrContent);
        } catch (\Exception $e) {
            Log::warning("Local PNG QR generation failed, attempting API fallback: " . $e->getMessage());
            
            try {
                // Fallback to External API for PNG (Email-friendly)
                $apiUrl = "https://api.qrserver.com/v1/create-qr-code/?size=400x400&data=" . urlencode($kunjungan->qr_token);
                $qrContent = file_get_contents($apiUrl);
                
                if ($qrContent) {
                    Storage::disk('public')->put($qrCodePath, $qrContent);
                } else {
                    throw new \Exception("Empty response from QR API");
                }
            } catch (\Exception $apiEx) {
                Log::error("QR API Fallback failed: " . $apiEx->getMessage());
                
                // Final fallback to SVG
                $qrContent = QrCode::format('svg')->size(400)->margin(2)->generate($kunjungan->qr_token);
                $qrCodePath = 'qrcodes/' . $kunjungan->id . '.svg';
                Storage::disk('public')->put($qrCodePath, $qrContent);
            }
        }

        return $qrCodePath;
    }

    private function dispatchNotifications($kunjungan, $qrCodePath)
    {
        // 1. WA Notification
        try {
            // Use URL for public access
            $qrUrl = Storage::disk('public')->url($qrCodePath);
            SendWhatsAppPendingNotification::dispatch($kunjungan, $qrUrl);
        } catch (\Exception $e) {
            Log::error('KunjunganService: Failed to dispatch WA: ' . $e->getMessage());
        }

        // 2. Email Notification
        try {
            // Use Path for attachment
            $fullQrPath = Storage::disk('public')->path($qrCodePath);
            Mail::to($kunjungan->email_pengunjung)->send(new KunjunganStatusMail($kunjungan, $fullQrPath));
        } catch (\Exception $e) {
            Log::error('KunjunganService: Failed to dispatch Email: ' . $e->getMessage());
        }
    }
}
