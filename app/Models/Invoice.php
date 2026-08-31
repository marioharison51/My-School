<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'period_month', 'due_date', 'amount',
        'status', 'payment_id', 'reminder_before_sent_at', 'reminder_late_sent_at',
    ];

    protected $casts = [
        'period_month' => 'date',
        'due_date'     => 'date',
        'amount'       => 'decimal:2',
        'reminder_before_sent_at' => 'datetime',
        'reminder_late_sent_at'   => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'paid' => 'Payée',
            'late' => 'En retard',
            default => 'En attente',
        };
    }

    public function statusColor(): string
    {
        return match ($this->status) {
            'paid' => 'green',
            'late' => 'red',
            default => 'amber',
        };
    }
}
