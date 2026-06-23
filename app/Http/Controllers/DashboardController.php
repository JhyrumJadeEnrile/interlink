<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        // Check user role using your application methods
        if ($user->isSupervisor()) {
            // Supervisors handle students assigned directly to them
            $students = User::where('supervisor_id', $user->id)->get();
            return view('supervisor.supervisor_dashboard', compact('students'));
        }

        if ($user->isCoordinator() || $user->isTeacher()) {
            // Teachers/Coordinators track students assigned to their academic group
            $students = User::where('teacher_id', $user->id)->get();
            return view('teacher.dashboard', compact('students'));
        }

        abort(403, 'Unauthorized dashboard view.');
    }
}
