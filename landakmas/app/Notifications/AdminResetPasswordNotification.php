<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminResetPasswordNotification extends Notification
{
    public function __construct(protected string $token)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Dikirim ke email admin yang bersangkutan (bukan admin lain),
     * karena $notifiable di sini adalah instance Admin yang memicu
     * reset (lihat Password::broker('admins')->sendResetLink()).
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = route('admin.reset-password.show', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ]);

        return (new MailMessage)
            ->subject('Reset Kata Sandi Admin LANDAKMAS')
            ->greeting('Halo, ' . ($notifiable->nama ?? 'Admin'))
            ->line('Kami menerima permintaan untuk mengatur ulang kata sandi akun admin LANDAKMAS Anda.')
            ->action('Atur Ulang Kata Sandi', $url)
            ->line('Tautan ini akan kedaluwarsa dalam 60 menit.')
            ->line('Jika Anda tidak meminta reset kata sandi, abaikan email ini.');
    }
}
