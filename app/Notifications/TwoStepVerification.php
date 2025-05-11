<?php

namespace App\Notifications;

use App\Models\OTP;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TwoStepVerification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $otp;
    public function __construct(OTP $otp)
    {
        $this->otp = $otp;
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
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(config('app.name') . ' - OTP Code')
            ->greeting('Hello')
            ->line('The introduction to the notification.')
            ->line('['.config('app.name').'] Your OTP Code is '.$this->otp->code . '. Do not share this code with anyone.' );
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
