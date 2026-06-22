<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'teacher_id', 'supervisor_id', 'company_name', 'department', 'required_hours'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'teacher_id' => 'integer',
            'supervisor_id' => 'integer',
            'required_hours' => 'integer',
        ];
    }

    public function documents()
    {
        return $this->hasMany(OjtDocument::class, 'student_id');
    }

    public function journals()
    {
        return $this->hasMany(WeeklyJournal::class, 'student_id');
    }

    public function timeLogs()
    {
        return $this->hasMany(TimeLog::class, 'student_id');
    }

    public function evaluations()
    {
        return $this->hasMany(CompetencyEvaluation::class, 'student_id');
    }

    public function hoursCompleted(): float
    {
        return round($this->timeLogs()->approved()->sum('duration_minutes') / 60, 2);
    }

    public function hoursRemaining(): float
    {
        if ($this->required_hours === null) {
            return 0;
        }

        return max(0, $this->required_hours - $this->hoursCompleted());
    }

    public function progressPercentage(): int
    {
        if ($this->required_hours === null || $this->required_hours === 0) {
            return 0;
        }

        return min(100, (int) round($this->hoursCompleted() / $this->required_hours * 100));
    }

    public function hasThreeConsecutiveAbsences(): bool
    {
        $checkedDays = collect();
        $today = now()->startOfDay();

        for ($day = 1; $day <= 3; $day++) {
            $checkedDays->push($today->copy()->subDays($day));
        }

        $loggedDates = $this->timeLogs()
            ->approved()
            ->pluck('date')
            ->map(fn ($date) => Carbon::parse($date)->startOfDay());

        foreach ($checkedDays as $day) {
            if ($loggedDates->contains($day)) {
                return false;
            }
        }

        return true;
    }

    public function teacher()
    {
        return $this->belongsTo(self::class, 'teacher_id');
    }

    public function supervisor()
    {
        return $this->belongsTo(self::class, 'supervisor_id');
    }

    public function supervisedStudents()
    {
        return $this->hasMany(self::class, 'supervisor_id');
    }

    public function coordinatedStudents()
    {
        return $this->hasMany(self::class, 'teacher_id');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    public function isCoordinator(): bool
    {
        return $this->role === 'coordinator';
    }

    public function isSupervisor(): bool
    {
        return $this->role === 'supervisor';
    }

    /**
     * Messaging Feature Relationships
     */
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }
}