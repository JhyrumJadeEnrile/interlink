<?php

namespace App\Http\Controllers;

use App\Models\FirestoreUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class FirestoreAuthController extends Controller
{
    private const ALLOWED_ROLES = [
        'student',
        'coordinator',
        'supervisor',
        'admin',
    ];

    /**
     * Show login form for a specific role
     */
    public function showLoginForm(string $role)
    {
        if (!in_array($role, self::ALLOWED_ROLES, true)) {
            abort(404);
        }
        return view("auth.firestore-login-{$role}");
    }

    /**
     * Handle login with Firestore
     */
    public function login(Request $request, string $role)
    {
        if (!in_array($role, self::ALLOWED_ROLES, true)) {
            abort(404);
        }

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        try {
            // Find user by email and role in Firestore
            $user = FirestoreUser::findByEmailAndRole($request->email, $role);

            if (!$user || !$user->verifyPassword($request->password)) {
                throw ValidationException::withMessages([
                    'email' => 'Invalid credentials or wrong role.',
                ]);
            }

            // Store user info in session
            $request->session()->put('user', [
                'id' => $user->getId(),
                'name' => $user->name,
                'email' => $user->email,
                'role' => $role,
                'authenticated' => true,
            ]);

            return $this->redirectForRole($role);

        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'email' => 'An error occurred: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Show registration form for a specific role
     */
    public function showRegisterForm(string $role)
    {
        if (!in_array($role, self::ALLOWED_ROLES, true)) {
            abort(404);
        }
        return view("auth.firestore-register-{$role}");
    }

    /**
     * Handle registration with Firestore
     */
    public function register(Request $request, string $role)
    {
        if (!in_array($role, self::ALLOWED_ROLES, true)) {
            abort(404);
        }

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ];

        if ($role === 'supervisor') {
            $rules['company_name'] = 'required|string|max:255';
            $rules['department'] = 'required|string|max:255';
        }

        $request->validate($rules);

        try {
            // Check if user already exists
            $existingUser = FirestoreUser::findByEmail($request->email);

            if ($existingUser) {
                throw ValidationException::withMessages([
                    'email' => 'Email already registered.',
                ]);
            }

            // Prepare user data
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'role' => $role,
                'phone' => $request->input('phone', ''),
            ];

            if ($role === 'supervisor') {
                $data['company_name'] = $request->company_name;
                $data['department'] = $request->department;
            }

            // Create user in Firestore
            $user = FirestoreUser::create($data);

            // Store user info in session
            $request->session()->put('user', [
                'id' => $user->getId(),
                'name' => $user->name,
                'email' => $user->email,
                'role' => $role,
                'authenticated' => true,
            ]);

            return $this->redirectForRole($role);

        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'email' => 'Registration failed: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        $request->session()->forget('user');
        $request->session()->flush();

        return redirect('/');
    }

    /**
     * Redirect based on role
     */
    private function redirectForRole(string $role)
    {
        $redirects = [
            'student' => '/student/dashboard',
            'coordinator' => '/coordinator/dashboard',
            'supervisor' => '/supervisor/dashboard',
            'admin' => '/admin/dashboard',
        ];

        return redirect($redirects[$role] ?? '/');
    }

    /**
     * Get current authenticated user from session
     */
    public static function getCurrentUser(Request $request)
    {
        $userData = $request->session()->get('user');

        if ($userData && isset($userData['id'])) {
            return FirestoreUser::find($userData['id']);
        }

        return null;
    }

    /**
     * Check if user is authenticated
     */
    public static function isAuthenticated(Request $request): bool
    {
        $user = $request->session()->get('user');
        return isset($user['authenticated']) && $user['authenticated'] === true;
    }
}
