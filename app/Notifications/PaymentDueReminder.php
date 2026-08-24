<?php

namespace App\Notifications;

use App\Models\Invoice;
use Illuminate\Notifications\Notification;

class PaymentDueReminder extends Notification
{
    public function __construct(public Invoice $invoice) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'type'       => 'payment_due_reminder',
            'invoice_id' => $this->invoice->id,
            'message'    => "L'écolage de " . $this->invoice->period_month->format('m/Y')
                . " arrive à échéance le " . $this->invoice->due_date->format('d/m/Y') . '.',
        ];
    }
}
