<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class AccountPermanentlyBlockedNotification extends Notification
{
    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'type'    => 'account_permanently_blocked',
            'message' => "Compte bloqué suite à 3 impayés consécutifs. Contactez l'administrateur pour le déblocage.",
        ];
    }
}
