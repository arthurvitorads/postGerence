<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
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
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Redefinição de Senha')
            ->greeting('Olá!')
            ->line('Você está recebendo este e-mail porque solicitou a redefinição de senha.')
            ->action('Redefinir Senha', $url)
            ->line('Este link de redefinição expira em 60 minutos.')
            ->line('Se você não solicitou, nenhuma ação adicional é necessária.')
            ->salutation('Atenciosamente, Post Gerence');
    }
}
