<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private function authorizeAdmin(): void
    {
        $user = request()->user();

        if (! $user || ! $user->isAdmin()) {
            abort(403);
        }
    }

    public function studentAssignments()
    {
        $this->authorizeAdmin();

        $students = User::where('role', 'student')->with(['teacher', 'supervisor'])->get();
        $teachers = User::where('role', 'coordinator')->get();
        $supervisors = User::where('role', 'supervisor')->get();

        return view('admin.student-assignments', compact('students', 'teachers', 'supervisors'));
    }

    public function linkStudent(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'student_id' => ['required', 'exists:users,id'],
            'teacher_id' => ['required', 'exists:users,id'],
            'supervisor_id' => ['required', 'exists:users,id'],
        ]);

        $student = User::where('role', 'student')->findOrFail($request->student_id);
        $teacher = User::where('role', 'coordinator')->findOrFail($request->teacher_id);
        $supervisor = User::where('role', 'supervisor')->findOrFail($request->supervisor_id);

        $student->teacher_id = $teacher->id;
        $student->supervisor_id = $supervisor->id;
        $student->save();

        return back()->with('success', 'Student assignment updated successfully.');
    }
}
