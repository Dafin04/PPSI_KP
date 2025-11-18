<?php

namespace App\Notifications;

use App\Models\Seminar;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SeminarApprovedNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected Seminar $seminar,
        protected string $status = 'disetujui'
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'seminar_id' => $this->seminar->id,
            'judul' => $this->seminar->judul_seminar,
            'status' => $this->status,
            'pesan' => $this->status === 'disetujui'
                ? 'Pengajuan seminar Anda telah disetujui.'
                : 'Pengajuan seminar memerlukan revisi dari dosen penguji.',
            'tanggal' => now()->toDateTimeString(),
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Status Seminar KP')
            ->line($this->toArray($notifiable)['pesan'])
            ->action('Lihat Seminar', url('/mahasiswa/seminar'));
    }
}
