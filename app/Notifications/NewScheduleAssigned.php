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
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
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
            'message' => "Anda telah ditugaskan untuk mengajar pada {$this->schedule->teaching_date} di Rumah Belajar.",
            'action_url' => url('/volunteer/schedules')
        ];
    }
}
