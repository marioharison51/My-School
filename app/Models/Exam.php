<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'term',
        'exam_date',
        'max_score',
    ];

    protected $casts = [
        'exam_date' => 'date',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }
}
