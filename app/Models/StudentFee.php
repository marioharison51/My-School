<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentFee extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'monthly_amount', 'set_by'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function setBy()
    {
        return $this->belongsTo(User::class, 'set_by');
    }
}
