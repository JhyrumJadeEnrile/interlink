<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\StudentDepartmentAssignment;
use App\Models\TimeLog;
use App\Models\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    private function authorizeTeacher(): void
    {
        $user = request()->user();

        if (! $user || ! $user->isCoordinator()) {
            abort(403);
        }
    }

    public function students(Request $request)
    {
        $this->authorizeTeacher();

        $students = User::where('role', 'student')
            ->with(['teacher', 'supervisor', 'timeLogs', 'departmentAssignments'])
            ->get();

        return view('teacher.required-hours', compact('students'));
    }

    public function updateRequiredHours(Request $request)
    {
        $this->authorizeTeacher();

        $validated = $request->validate([
            'student_id' => ['required', 'exists:users,id'],
            'required_hours' => ['required', 'integer', 'min:1'],
        ]);

        $student = User::where('role', 'student')->findOrFail($validated['student_id']);
        $student->required_hours = $validated['required_hours'];
        $student->save();

        return back()->with('success', 'Required hours updated for the student.');
    }

    public function approvedLogs(Request $request)
    {
        $this->authorizeTeacher();

        $logs = TimeLog::approved()
            ->with(['student', 'supervisor'])
            ->latest('date')
            ->get();

        $absentStudents = User::where('role', 'student')
            ->get()
            ->filter(fn (User $student) => $student->hasThreeConsecutiveAbsences());

        return view('teacher.approved-logs', compact('logs', 'absentStudents'));
    }

    /**
     * Show form to assign student to department and company
     */
    public function showAssignDepartment(Request $request)
    {
        $this->authorizeTeacher();

        $students = User::where('role', 'student')
            ->where('teacher_id', $request->user()->id)
            ->with(['supervisor', 'departmentAssignments'])
            ->get();

        $companies = Company::all();
        $supervisors = User::where('role', 'supervisor')->get();

        return view('teacher.assign-department', compact('students', 'companies', 'supervisors'));
    }

    /**
     * Assign student to a specific department under a supervisor
     */
    public function assignDepartment(Request $request)
    {
        $this->authorizeTeacher();

        $validated = $request->validate([
            'student_id' => ['required', 'exists:users,id', 'integer'],
            'supervisor_id' => ['required', 'exists:users,id', 'integer'],
            'company_id' => ['required', 'exists:companies,id', 'integer'],
            'department' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $student = User::where('role', 'student')->findOrFail($validated['student_id']);

        // Verify student belongs to this teacher
        if ($student->teacher_id !== $request->user()->id) {
            abort(403, 'You can only assign your own students.');
        }

        $supervisor = User::where('role', 'supervisor')->findOrFail($validated['supervisor_id']);
        $company = Company::findOrFail($validated['company_id']);

        // Update or create the assignment
        StudentDepartmentAssignment::updateOrCreate(
            [
                'student_id' => $student->id,
                'supervisor_id' => $supervisor->id,
                'company_id' => $company->id,
            ],
            [
                'department' => $validated['department'],
                'notes' => $validated['notes'] ?? null,
                'assigned_at' => now(),
            ]
        );

        // Update student's supervisor and company info
        $student->update([
            'supervisor_id' => $supervisor->id,
            'company_id' => $company->id,
            'company_name' => $company->company_name,
            'department' => $validated['department'],
        ]);

        return back()->with('success', 'Student assigned to department successfully. Assignment visible to student and supervisor.');
    }

    /**
     * View all department assignments
     */
    public function viewDepartmentAssignments(Request $request)
    {
        $this->authorizeTeacher();

        $assignments = StudentDepartmentAssignment::whereHas('student', function ($query) use ($request) {
            $query->where('teacher_id', $request->user()->id);
        })
            ->with(['student', 'supervisor', 'company'])
            ->latest('assigned_at')
            ->paginate(15);

        return view('teacher.department-assignments', compact('assignments'));
    }
}
