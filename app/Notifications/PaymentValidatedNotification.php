<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class PaymentValidatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Payment $payment) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'type'       => 'payment_validated',
            'payment_id' => $this->payment->id,
            'message'    => 'Paiement de ' . number_format($this->payment->amount, 0, ',', ' ') . ' Ar validé.',
        ];
    }
}
