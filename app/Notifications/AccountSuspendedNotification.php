<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class AccountSuspendedNotification extends Notification
{
    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'type'    => 'account_suspended',
            'message' => 'Compte suspendu pour retard de paiement.',
        ];
    }
}
