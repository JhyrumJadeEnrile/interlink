<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of students and their current OJT linkages/assignments.
     */
    public function studentAssignments()
    {
        $students    = User::where('role', 'student')->get();
        $supervisors = User::where('role', 'supervisor')->get();
        $teachers    = User::where('role', 'coordinator')->orWhere('role', 'teacher')->get();

        return view('admin.student-assignments', compact('students', 'supervisors', 'teachers'));
    }

    /**
     * Link/Assign a student to a supervisor or teacher/coordinator.
     */
    public function linkStudent(Request $request)
    {
        $request->validate([
            'student_id'    => 'required|exists:users,id',
            'teacher_id'    => 'required|exists:users,id',
            'supervisor_id' => 'required|exists:users,id',
        ]);

        $student = User::where('id', $request->student_id)->where('role', 'student')->firstOrFail();
        $student->update([
            'teacher_id'    => $request->teacher_id,
            'supervisor_id' => $request->supervisor_id,
        ]);

        return redirect()->route('admin.student-assignments')->with('success', 'Student assigned successfully.');
    }

    /**
     * Display the separate standalone registration page view for an OJT student.
     */
    public function createStudent()
    {
        // 🌟 UPDATED: Uses $teachers to maintain exact consistency with your Blade loops
        $teachers = User::where('role', 'coordinator')->orWhere('role', 'teacher')->get();
        $supervisors = User::where('role', 'supervisor')->get();

        // 🛠️ INAYOS DITO: Pinalitan mula 'admin.students.create' tungo sa tamang folder na 'students.create'
        return view('students.create', compact('teachers', 'supervisors'));
    }

    /**
     * Store a newly initialized OJT student record into the user registry database table.
     */
    public function storeStudent(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'required_hours' => 'nullable|integer|min:1',
        ]);

        // Safely map and write new user model properties
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'student', // Automatically flags account architecture status
            'required_hours' => $request->required_hours ?? 500, // Safe fallback threshold
        ]);

        // ⭐ UPDATED: DYNAMIC REDIRECT BASED ON WHO IS LOGGED IN
        $user = Auth::user();

        if ($user->role === 'teacher' || $user->role === 'coordinator') {
            return redirect()->route('teacher.dashboard')->with('success', 'New OJT student registered successfully.');
        } elseif ($user->role === 'supervisor') {
            return redirect()->route('supervisor.dashboard')->with('success', 'New OJT student registered successfully.');
        }

        // Default fallback destination for Admin users
        return redirect()->route('admin.student-assignments')->with('success', 'New OJT student registered successfully.');
    }
}