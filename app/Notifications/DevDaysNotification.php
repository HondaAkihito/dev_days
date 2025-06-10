<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Log;

class DevDaysNotification extends Notification
{
    use Queueable;

    public $name;
    public $days;

    public function __construct($name, $days)
    {
        $this->name = $name;
        $this->days = $days;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        Log::info('DevDays通知：' . $this->name . ' さんへ ' . $this->days . '日 経過');

        return (new MailMessage)
            ->subject('DevDaysの経過日数のお知らせ')
            ->markdown('emails.devdays', [
                'name' => $this->name,
                'days' => $this->days,
            ]);
    }
}