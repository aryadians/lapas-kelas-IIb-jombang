<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Notification;
use App\Models\Kunjungan;
use App\Enums\KunjunganStatus;
use App\Mail\KunjunganStatusMail;
use App\Jobs\SendWhatsAppApprovedNotification;
use App\Jobs\SendWhatsAppRejectedNotification;
use App\Jobs\SendWhatsAppCompletedNotification;
use App\Notifications\SendSurveyLink;

class KunjunganObserverTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_only_when_preference_email_on_approved()
    {
        Mail::fake();
        Bus::fake();
        Notification::fake();

        $kunjungan = Kunjungan::factory()->create([
            'status' => KunjunganStatus::PENDING,
            'preferred_notification_channel' => 'email',
        ]);

        $kunjungan->status = KunjunganStatus::APPROVED;
        $kunjungan->save();

        Mail::assertQueued(KunjunganStatusMail::class, function ($mail) use ($kunjungan) {
            return $mail->kunjungan->id === $kunjungan->id;
        });

        Bus::assertNotDispatched(SendWhatsAppApprovedNotification::class);
    }

    public function test_whatsapp_only_when_preference_whatsapp_on_approved()
    {
        Mail::fake();
        Bus::fake();
        Notification::fake();

        $kunjungan = Kunjungan::factory()->create([
            'status' => KunjunganStatus::PENDING,
            'preferred_notification_channel' => 'whatsapp',
        ]);

        $kunjungan->status = KunjunganStatus::APPROVED;
        $kunjungan->save();

        Bus::assertDispatched(SendWhatsAppApprovedNotification::class);

        Mail::assertNotQueued(KunjunganStatusMail::class);
    }

    public function test_both_when_preference_both_on_approved()
    {
        Mail::fake();
        Bus::fake();
        Notification::fake();

        $kunjungan = Kunjungan::factory()->create([
            'status' => KunjunganStatus::PENDING,
            'preferred_notification_channel' => 'both',
        ]);

        $kunjungan->status = KunjunganStatus::APPROVED;
        $kunjungan->save();

        Mail::assertQueued(KunjunganStatusMail::class, function ($mail) use ($kunjungan) {
            return $mail->kunjungan->id === $kunjungan->id;
        });

        Bus::assertDispatched(SendWhatsAppApprovedNotification::class);
    }

    public function test_completed_sends_survey_and_dispatches_whatsapp_when_preference_whatsapp()
    {
        Mail::fake();
        Bus::fake();
        Notification::fake();

        $k1 = Kunjungan::factory()->create([
            'status' => KunjunganStatus::PENDING,
            'preferred_notification_channel' => 'whatsapp',
        ]);

        $k1->status = KunjunganStatus::COMPLETED;
        $k1->save();

        Notification::assertSentTo($k1, SendSurveyLink::class);
        Bus::assertDispatched(SendWhatsAppCompletedNotification::class);
        Mail::assertNotQueued(KunjunganStatusMail::class);
    }

    public function test_completed_sends_survey_and_queues_email_when_preference_email()
    {
        Mail::fake();
        Bus::fake();
        Notification::fake();

        $k2 = Kunjungan::factory()->create([
            'status' => KunjunganStatus::PENDING,
            'preferred_notification_channel' => 'email',
        ]);

        $k2->status = KunjunganStatus::COMPLETED;
        $k2->save();

        Notification::assertSentTo($k2, SendSurveyLink::class);
        Mail::assertQueued(KunjunganStatusMail::class, function ($mail) use ($k2) {
            return $mail->kunjungan->id === $k2->id;
        });
        Bus::assertNotDispatched(SendWhatsAppCompletedNotification::class);
    }
}
