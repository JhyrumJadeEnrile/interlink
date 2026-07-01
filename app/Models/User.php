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

#[Fillable(['name', 'email', 'password', 'role', 'teacher_id', 'supervisor_id', 'company_name', 'department', 'required_hours', 'profile_photo_path'])]
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

    /**
     * Performance Summary metrics (used on the coordinator dashboard).
     */

    // % of weekdays elapsed this week that have an approved time log.
    public function attendancePercentage(): int
    {
        $startOfWeek = now()->startOfWeek(Carbon::MONDAY);
        $today = now()->startOfDay();

        $expectedDays = 0;
        for ($day = $startOfWeek->copy(); $day->lte($today); $day->addDay()) {
            if (! $day->isWeekend()) {
                $expectedDays++;
            }
        }

        if ($expectedDays === 0) {
            return 100;
        }

        $loggedDays = $this->timeLogs()
            ->approved()
            ->whereBetween('date', [$startOfWeek->format('Y-m-d'), $today->format('Y-m-d')])
            ->distinct()
            ->count('date');

        return min(100, (int) round($loggedDays / $expectedDays * 100));
    }

    // % of required OJT documents (Resume, Consent Form, Internship Agreement) submitted.
    public function assignmentsPercentage(): int
    {
        $required = ['Resume', 'Consent Form', 'Internship Agreement'];

        $submitted = $this->documents()
            ->whereIn('document_type', $required)
            ->distinct()
            ->pluck('document_type')
            ->unique()
            ->count();

        return (int) round($submitted / count($required) * 100);
    }

    // % of weekly journal reflections submitted relative to weeks elapsed since joining.
    public function learningGoalPercentage(): int
    {
        $weeksElapsed = max(1, (int) ceil($this->created_at->diffInDays(now()) / 7));
        $journalsSubmitted = $this->journals()->count();

        return min(100, (int) round($journalsSubmitted / $weeksElapsed * 100));
    }

    // Overall Performance Summary score: average of attendance, assignments, and learning goal.
    public function performanceOverall(): int
    {
        return (int) round(($this->attendancePercentage() + $this->assignmentsPercentage() + $this->learningGoalPercentage()) / 3);
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

    /**
     * Department Assignment Relationships
     */
    public function departmentAssignments()
    {
        return $this->hasMany(StudentDepartmentAssignment::class, 'student_id');
    }

    public function supervisedDepartmentAssignments()
    {
        return $this->hasMany(StudentDepartmentAssignment::class, 'supervisor_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    /**
     * Check if student is assigned to a specific supervisor with department
     */
    public function isAssignedToSupervisor($supervisorId): bool
    {
        return StudentDepartmentAssignment::isStudentAssignedToSupervisor($this->id, $supervisorId);
    }

    /**
     * Get assigned department for a specific supervisor
     */
    public function getAssignedDepartment($supervisorId): ?string
    {
        $assignment = $this->departmentAssignments()
            ->where('supervisor_id', $supervisorId)
            ->first();

        return $assignment?->department;
    }
}