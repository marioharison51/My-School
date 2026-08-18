<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'last_name',
        'first_name',
        'birth_date',
        'birth_place',
        'father_name',
        'father_job',
        'mother_name',
        'mother_job',
        'parent_phone',
        'parent_email',
        'address',
        'previous_school',
        'previous_class',
        'current_class',
        'desired_career',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}