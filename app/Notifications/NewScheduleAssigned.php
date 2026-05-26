<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewScheduleAssigned extends Notification
{
    use Queueable;

    public $schedule;

    /**
     * Create a new notification instance.
     */
    public function __construct($schedule)
    {
        $this->schedule = $schedule;
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
        return (new MailMessage)
            ->subject('Tugas Mengajar Baru - Malang Mengajar')
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Anda telah ditugaskan untuk mengajar pada jadwal baru:')
            ->line('• Mata Pelajaran: ' . $this->schedule->subject)
            ->line('• Rumah Belajar: ' . ($this->schedule->learningHome->name ?? '-'))
            ->line('• Tanggal: ' . ($this->schedule->schedule_date ? $this->schedule->schedule_date->translatedFormat('l, d F Y') : '-'))
            ->line('• Jam: ' . $this->schedule->start_time . ' - ' . $this->schedule->end_time . ' WIB')
            ->action('Lihat Jadwal Saya', url('/volunteer/schedules'))
            ->line('Terima kasih atas dedikasi dan kontribusi Anda bagi pendidikan anak-anak di Malang!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Tugas Mengajar Baru',
            'message' => "Anda telah ditugaskan untuk mengajar {$this->schedule->subject} di " . ($this->schedule->learningHome->name ?? 'Rumah Belajar') . " pada " . ($this->schedule->schedule_date ? $this->schedule->schedule_date->translatedFormat('d F Y') : ''),
            'action_url' => url('/volunteer/schedules')
        ];
    }
}
