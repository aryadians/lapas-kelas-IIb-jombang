<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Wbp;
use Carbon\Carbon;

use Illuminate\Foundation\Testing\RefreshDatabase;

class UploadValidationTest extends TestCase
{
    use RefreshDatabase;
    public function test_foto_ktp_exceeding_2mb_is_rejected()
    {
        Storage::fake('public');

        $wbp = Wbp::create(['nama' => 'Test WBP', 'no_registrasi' => 'A001']);

        $file = UploadedFile::fake()->image('ktp.jpg')->size(3000); // 3MB

        $response = $this->post(route('kunjungan.store'), [
            'nama_pengunjung' => 'Budi Santoso',
            'nik_ktp' => '1234567890123456',
            'nomor_hp' => '081234567890',
            'email_pengunjung' => 'budi@example.com',
            'alamat_lengkap' => 'Jl. Contoh No.1',
            'jenis_kelamin' => 'Laki-laki',
            'foto_ktp' => $file,
            'wbp_id' => $wbp->id,
            'tanggal_kunjungan' => Carbon::now()->addDays(2)->format('Y-m-d'),
            'preferred_notification_channel' => 'email',
        ]);

        $response->assertSessionHasErrors(['foto_ktp']);
    }
}
