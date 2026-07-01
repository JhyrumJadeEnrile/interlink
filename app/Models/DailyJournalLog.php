<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyJournalLog extends Model
{
    use HasFactory;

    protected $table = 'daily_journal_logs';

    protected $fillable = [
        'student_id',
        'date',
        'hours_rendered',
        'tasks_done',
        'status',
        'supervisor_remarks',
    ];

    protected $casts = [
        'date' => 'date',
        'hours_rendered' => 'integer',
    ];

    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', self::STATUS_REJECTED);
    }
}
