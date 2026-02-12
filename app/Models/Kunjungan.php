<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\KunjunganStatus;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Kunjungan extends Model
{
    use HasFactory, Notifiable, LogsActivity;

    /**
     * Konfigurasi logging aktivitas untuk model Kunjungan.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable() // Log semua atribut yang ada di $fillable
            ->logOnlyDirty() // Hanya log atribut yang berubah
            ->setDescriptionForEvent(fn(string $eventName) => "Data Kunjungan telah di{$eventName}")
            ->useLogName('kunjungan'); // Nama log kustom
    }

    /**
     * Nama tabel di database (Opsional, jika default 'kunjungans' tidak perlu ditulis)
     */
    protected $table = 'kunjungans';

    /**
     * Daftar kolom yang boleh diisi secara massal (Mass Assignment).
     * Harus sesuai dengan nama kolom di database.
     */
    // PASTIKAN ISINYA SAMA PERSIS SEPERTI INI
    protected $fillable = [
        'profil_pengunjung_id',
        'kode_kunjungan',
        'nomor_antrian_harian',
        'wbp_id',
        'nama_pengunjung',
        'nik_ktp',

        // INI YANG BIKIN ERROR TADI (Harus sesuai nama kolom database)
        'no_wa_pengunjung',   // <--- Jangan tulis 'nomor_hp'
        'email_pengunjung',
        'alamat_pengunjung',  // <--- Jangan tulis 'alamat_lengkap'
        'barang_bawaan',

        'jenis_kelamin',
        'hubungan',
        'tanggal_kunjungan',
        'sesi',
        'foto_ktp',
        'foto_ktp_path',
        'foto_ktp_processed_at',
        'status',
        'qr_token',
        'notification_logs',
        'pengikut_laki',
        'pengikut_perempuan',
        'pengikut_anak',
        'registration_type',
        'visit_started_at',
        'visit_ended_at'
    ];

    protected $dates = [
        'foto_ktp_processed_at'
    ];

    protected $casts = [
        'tanggal_kunjungan' => 'date',
        'visit_started_at' => 'datetime',
        'visit_ended_at' => 'datetime',
        'status' => KunjunganStatus::class,
        'notification_logs' => 'array',
    ];

    /**
     * RELASI KE MODEL WBP
     * Satu Kunjungan tertuju pada Satu WBP.
     */
    public function wbp()
    {
        // belongsTo('ModelTujuan', 'foreign_key_di_tabel_ini')
        return $this->belongsTo(Wbp::class, 'wbp_id');
    }
    public function pengikuts()
    {
        return $this->hasMany(Pengikut::class);
    }

    /**
     * Route notifications for the mail channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return array|string
     */
    public function routeNotificationForMail($notification)
    {
        // Return email address and name...
        return [$this->email_pengunjung => $this->nama_pengunjung];
    }

    /**
     * Update status notifikasi di log terakhir.
     */
    public function updateNotificationLog(string $type, string $status, ?string $reason = null)
    {
        $logs = $this->notification_logs ?? [];
        if (empty($logs)) return;

        // Ambil log terakhir (yang baru saja dibuat oleh Observer)
        $lastIndex = count($logs) - 1;
        
        if (isset($logs[$lastIndex][$type])) {
            $logs[$lastIndex][$type] = $status;
            if ($reason) {
                $logs[$lastIndex][$type . '_reason'] = $reason;
            }
            
            $this->notification_logs = $logs;
            $this->saveQuietly();
        }
    }
}
