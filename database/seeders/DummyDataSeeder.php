<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;
use App\Models\Announcement;
use App\Models\Survey;
use App\Models\ProfilPengunjung;
use App\Models\Kunjungan;
use App\Models\Wbp;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. News (50)
        News::factory(50)->create();
        $this->command->info('Berhasil membuat 50 Berita.');

        // 2. Announcement (50)
        Announcement::factory(50)->create();
        $this->command->info('Berhasil membuat 50 Pengumuman.');

        // 3. Survey (50)
        Survey::factory(50)->create();
        $this->command->info('Berhasil membuat 50 Survey IKM.');

        // 4. ProfilPengunjung (50)
        $profiles = ProfilPengunjung::factory(50)->create();
        $this->command->info('Berhasil membuat 50 Profil Pengunjung (Database Pengunjung).');

        // 5. Kunjungan (50) - Linked to Profiles
        // We create 50 visits, linking each to one of the created profiles.
        // We also create some WBPs to link to (let's say 20 WBPs recycled, or just 1 per visit).
        // To be safe and realistic, let's create 20 WBPs first.
        $wbps = Wbp::factory(20)->create();

        foreach ($profiles as $index => $profile) {
            Kunjungan::factory()->create([
                'profil_pengunjung_id' => $profile->id,
                'wbp_id' => $wbps->random()->id,
                
                // Sync data snapshot
                'nama_pengunjung' => $profile->nama,
                'nik_ktp' => $profile->nik,
                'no_wa_pengunjung' => $profile->nomor_hp,
                'email_pengunjung' => $profile->email,
                'alamat_pengunjung' => $profile->alamat,
                'jenis_kelamin' => ($profile->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan'),
                
                // Randomize dates to create a history
                'tanggal_kunjungan' => now()->subDays(rand(0, 60)),
            ]);
        }
        $this->command->info('Berhasil membuat 50 Kunjungan (terhubung dengan Pengunjung & WBP).');
    }
}
