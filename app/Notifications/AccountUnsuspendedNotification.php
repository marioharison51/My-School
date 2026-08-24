<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class AccountUnsuspendedNotification extends Notification
{
    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'type'    => 'account_unsuspended',
            'message' => "Compte réactivé. Les dates d'examens restent masquées jusqu'à régularisation.",
        ];
    }
}
