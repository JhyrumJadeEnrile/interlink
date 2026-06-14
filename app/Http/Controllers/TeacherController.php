<?php

namespace App\Http\Controllers;

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
            ->with(['teacher', 'supervisor', 'timeLogs'])
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
}
