<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'parent_user_id',
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
        'graduated_at',
        'desired_career',
        'consecutive_missed_payments',
    ];

    protected $casts = [
        'birth_date'   => 'date',
        'graduated_at' => 'date',
    ];

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function hasGraduated(): bool
    {
        return $this->graduated_at !== null;
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parentUser()
    {
        return $this->belongsTo(User::class, 'parent_user_id');
    }

    public function fee()
    {
        return $this->hasOne(StudentFee::class)->latestOfMany();
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
