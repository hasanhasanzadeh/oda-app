<?php

namespace App\Notifications;

use App\Models\OtpCode;
use App\Models\User;
use HoomanMirghasemi\Sms\Channels\SmsChannel;
use HoomanMirghasemi\Sms\Facades\Sms;
use HoomanMirghasemi\Sms\Message;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserNotification extends Notification
{
    protected OtpCode $otpCode;
    protected string $message;
    protected string $subject;
    protected string $type;
    /**
     * Create a new notification instance.
     */
    public function __construct($message, $subject = "Notification", $type = "all",OtpCode $otpCode=null)
    {
        $this->message = $message;
        $this->subject = $subject;
        $this->type = $type;
        $this->otpCode = $otpCode;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        $channels = [];

        if ($this->type === 'email' || $this->type === 'all') {
            $channels[] = 'mail';
        }
        if ($this->type === 'sms' || $this->type === 'all') {
            $channels[] = SmsChannel::class;
        }
        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): ?MailMessage
    {
        if ($notifiable->phone){
            return (new MailMessage)
                ->subject($this->subject)
                ->greeting("Hello, " . $notifiable->phone)
                ->line($this->message)
                ->action('View Dashboard', url('/'))
                ->line('Thank you for using our application!');
        }
        return null;
    }

    public function toSms($notifiable)
    {
        if ($notifiable) {
            $phoneNumber = $notifiable->phone;

            $smsMessage = "کد تایید token%";
            $pattern = 'verificationCodeNotification';

            $message = new Message($smsMessage);
            $message->useTemplateIfSupports(
                $pattern,
                [
                    'token1' => $this->message,
                ]
            );
            return Sms::to($phoneNumber)->message($message);
        }

        return null;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->message,
            'subject' => $this->subject,
            'type' => $this->type,
        ];
    }
}
