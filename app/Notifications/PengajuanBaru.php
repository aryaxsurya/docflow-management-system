<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Pengajuan;

class PengajuanBaru extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Pengajuan $pengajuan)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Pengajuan Baru Menunggu Review')
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line('Ada pengajuan dokumen baru yang memerlukan review Anda.')
            ->line('**Judul:** ' . $this->pengajuan->judul)
            ->line('**Dari:** ' . $this->pengajuan->user->name)
            ->line('**Tanggal Berlaku:** ' . $this->pengajuan->tanggal_berlaku->format('d M Y'))
            ->action('Lihat dan Review', url('/reviewer/pengajuan/' . $this->pengajuan->id))
            ->line('Terima kasih atas perhatian Anda.');
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
