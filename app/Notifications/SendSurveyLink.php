<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Kunjungan;

class SendSurveyLink extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $surveyUrl = route('surveys.create', ['token' => $notifiable->qr_token]);

        return (new MailMessage)
                    ->subject('Survei Kepuasan Layanan Kunjungan Lapas Jombang')
                    ->greeting('Halo ' . $notifiable->nama_pemohon . ',')
                    ->line('Terima kasih atas kunjungan Anda di Lapas Kelas IIB Jombang. Kunjungan Anda telah selesai.')
                    ->line('Kami mohon kesediaan Anda untuk mengisi survei kepuasan layanan kami melalui tautan di bawah ini. Partisipasi Anda sangat berarti untuk perbaikan layanan kami.')
                    ->action('Isi Survei Sekarang', $surveyUrl)
                    ->line('Terima kasih atas waktu dan perhatian Anda.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
