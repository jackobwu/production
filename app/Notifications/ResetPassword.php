<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('重置密码')
            ->line('这是一封重置你的登录密码的邮件。')
            ->action('重置密码', url('/password/reset', $this->token))
            ->line('如果你放弃修改密码，忽视本邮件即可');
    }
}
