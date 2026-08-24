<?php

namespace App\Notifications;

use App\Models\Invoice;
use Illuminate\Notifications\Notification;

class PaymentOverdueReminder extends Notification
{
    public function __construct(public Invoice $invoice) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'type'       => 'payment_overdue_reminder',
            'invoice_id' => $this->invoice->id,
            'message'    => "Retard de paiement pour l'écolage de " . $this->invoice->period_month->format('m/Y')
                . " (échéance dépassée depuis 3 jours).",
        ];
    }
}
