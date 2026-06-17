<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    private const ALLOWED_ROLES = [
        'student',
        'coordinator',
        'supervisor',
        'admin',
    ];

    public function showLoginForm(string $role)
    {
        if (!in_array($role, self::ALLOWED_ROLES, true)) {
            abort(404);
        }
        return view("auth.login-{$role}");
    }

    public function login(Request $request, string $role)
    {
        if (!in_array($role, self::ALLOWED_ROLES, true)) {
            abort(404);
        }

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)
                    ->where('role', $role)
                    ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => 'Invalid credentials or wrong role.',
            ]);
        }

        Auth::login($user);
        $request->session()->put('role', $role);

        return $this->redirectForRole($role);
    }

    public function showRegisterForm(string $role)
    {
        if (!in_array($role, self::ALLOWED_ROLES, true)) {
            abort(404);
        }
        return view("auth.register-{$role}");
    }

   public function register(Request $request, string $role)
{
    if (!in_array($role, self::ALLOWED_ROLES, true)) {
        abort(404);
    }

    $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|confirmed',
    ];

    if ($role === 'supervisor') {
        $rules['company_name'] = 'required|string|max:255';
        $rules['department'] = 'required|string|max:255';
    }

    $request->validate($rules);

    $data = [
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $role,
    ];

    if ($role === 'supervisor') {
        $data['company_name'] = $request->company_name;
        $data['department'] = $request->department;
    }

    $user = User::create($data);

    Auth::login($user);
    $request->session()->put('role', $role);

    return $this->redirectForRole($role);
}

    private function redirectForRole(string $role)
    {
        return match ($role) {
            'student' => redirect()->route('student.timelogs'),
            'coordinator' => redirect()->route('teacher.dashboard'),
            'supervisor' => redirect()->route('supervisor.dashboard'),
            'admin' => redirect()->route('admin.student-assignments'),
            default => redirect()->route('admin.dashboard'),
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