<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TardinessRecord extends Model
{
    protected $fillable = [
        'student_id',
        'recorded_by',
        'occurred_at',
        'note',
    ];

    protected $casts = [
        'occurred_at' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
