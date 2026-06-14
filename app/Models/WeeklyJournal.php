<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklyJournal extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'week_start',
        'content',
    ];

    protected $casts = [
        'week_start' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
