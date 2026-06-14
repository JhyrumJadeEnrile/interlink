<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private const ALLOWED_ROLES = [
        'student',
        'coordinator',
        'supervisor',
        'admin',
    ];

    private function resolveRoleUser(string $role): User
    {
        $defaults = [
            'student' => [
                'name' => 'Student User',
                'email' => 'student@internlink.local',
                'password' => 'password',
            ],
            'coordinator' => [
                'name' => 'Coordinator User',
                'email' => 'coordinator@internlink.local',
                'password' => 'password',
            ],
            'supervisor' => [
                'name' => 'Supervisor User',
                'email' => 'supervisor@internlink.local',
                'password' => 'password',
            ],
            'admin' => [
                'name' => 'Admin User',
                'email' => 'admin@internlink.local',
                'password' => 'password',
            ],
        ];

        $attributes = ['role' => $role];
        $values = $defaults[$role] ?? $defaults['student'];

        if (! empty($values['password'])) {
            $values['password'] = bcrypt($values['password']);
        }

        return User::firstOrCreate($attributes, $values);
    }

    public function showLoginForm(string $role)
    {
        if (! in_array($role, self::ALLOWED_ROLES, true)) {
            abort(404);
        }

        return view("auth.login-{$role}");
    }

    public function login(Request $request, string $role)
    {
        if (! in_array($role, self::ALLOWED_ROLES, true)) {
            abort(404);
        }

        $user = $this->resolveRoleUser($role);
        Auth::login($user);
        $request->session()->put('role', $role);

        return $this->redirectForRole($role);
    }

    public function showRegisterForm(string $role)
    {
        if (! in_array($role, self::ALLOWED_ROLES, true)) {
            abort(404);
        }

        return view("auth.register-{$role}");
    }

    public function register(Request $request, string $role)
    {
        if (! in_array($role, self::ALLOWED_ROLES, true)) {
            abort(404);
        }

        $user = $this->resolveRoleUser($role);
        Auth::login($user);
        $request->session()->put('role', $role);

        return $this->redirectForRole($role);
    }

    private function redirectForRole(string $role)
    {
        return match ($role) {
            'student' => redirect()->route('student.timelogs'),
            'coordinator' => redirect()->route('teacher.students'),
            'supervisor' => redirect()->route('supervisor.timelogs.pending'),
            'admin' => redirect()->route('admin.student-assignments'),
            default => redirect()->route('dashboard'),
        };
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->forget('role');
        $request->session()->invalidate();

        return redirect()->route('login');
    }
}
