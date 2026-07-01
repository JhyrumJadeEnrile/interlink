<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentDepartmentAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'supervisor_id',
        'company_id',
        'department',
        'notes',
        'assigned_at',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    /**
     * Check if a student is authorized to submit time logs under a specific supervisor
     */
    public static function isStudentAssignedToSupervisor($studentId, $supervisorId): bool
    {
        return self::where('student_id', $studentId)
            ->where('supervisor_id', $supervisorId)
            ->exists();
    }

    /**
     * Get all students assigned to a supervisor in a specific department
     */
    public static function getStudentsByDepartment($supervisorId, $department)
    {
        return self::where('supervisor_id', $supervisorId)
            ->where('department', $department)
            ->with('student')
            ->get();
    }
}
