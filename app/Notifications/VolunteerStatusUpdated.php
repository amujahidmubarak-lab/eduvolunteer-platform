<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VolunteerStatusUpdated extends Notification
{
    use Queueable;

    public $status;

    /**
     * Create a new notification instance.
     */
    public function __construct($status)
    {
        $this->status = $status;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $statusText = $this->status === 'approved' ? 'DISETUJUI' : ($this->status === 'rejected' ? 'DITOLAK' : 'DIPERBARUI');
        
        $message = (new MailMessage)
            ->subject('Pembaruan Status Akun - Malang Mengajar')
            ->greeting('Halo, ' . $notifiable->name . '!');

        if ($this->status === 'approved') {
            $message->line('Selamat! Pendaftaran Anda sebagai relawan Malang Mengajar telah disetujui oleh Admin.')
                    ->line('Sekarang Anda dapat masuk ke Dashboard untuk melihat jadwal mengajar yang ditugaskan.')
                    ->action('Buka Dashboard', url('/volunteer/dashboard'));
        } elseif ($this->status === 'rejected') {
            $message->line('Mohon maaf, pendaftaran Anda sebagai relawan Malang Mengajar belum dapat disetujui saat ini.')
                    ->line('Terima kasih banyak atas minat Anda untuk berpartisipasi.');
        } else {
            $message->line("Status pendaftaran relawan Anda telah diperbarui menjadi: " . strtoupper($this->status));
        }

        return $message->line('Terima kasih atas perhatian Anda!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $statusText = $this->status === 'approved' ? 'disetujui' : ($this->status === 'rejected' ? 'ditolak' : 'diperbarui');
        
        return [
            'title' => 'Pembaruan Status Akun',
            'message' => "Status pendaftaran relawan Anda telah $statusText oleh Admin.",
            'action_url' => url('/volunteer/dashboard')
        ];
    }
}
