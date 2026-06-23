<?php

// Example Routes for Firestore Authentication
// Add these to your routes/web.php file

use App\Http\Controllers\FirestoreAuthController;

// Firestore Authentication Routes
Route::get('/firestore/login/{role}', [FirestoreAuthController::class, 'showLoginForm'])->name('firestore.login');
Route::post('/firestore/login/{role}', [FirestoreAuthController::class, 'login'])->name('firestore.login.post');

Route::get('/firestore/register/{role}', [FirestoreAuthController::class, 'showRegisterForm'])->name('firestore.register');
Route::post('/firestore/register/{role}', [FirestoreAuthController::class, 'register'])->name('firestore.register.post');

Route::post('/firestore/logout', [FirestoreAuthController::class, 'logout'])->name('firestore.logout');

// Protected Firestore Routes (requires authentication)
Route::middleware(['firestore-authenticated'])->group(function () {
    Route::get('/student/dashboard', function () {
        // Use: FirestoreAuthController::getCurrentUser($request) to get current user
    })->name('student.dashboard');

    Route::get('/coordinator/dashboard', function () {
        // Coordinator dashboard
    })->name('coordinator.dashboard');

    Route::get('/supervisor/dashboard', function () {
        // Supervisor dashboard
    })->name('supervisor.dashboard');

    Route::get('/admin/dashboard', function () {
        // Admin dashboard
    })->name('admin.dashboard');
});

// API Example Routes
Route::prefix('api/firestore')->group(function () {
    // Get all users
    Route::get('/users', function () {
        $users = \App\Models\FirestoreUser::all();
        return response()->json($users);
    });

    // Get user by email
    Route::get('/users/{email}', function ($email) {
        $user = \App\Models\FirestoreUser::findByEmail($email);
        return response()->json($user?->toArray());
    });

    // Get users by role
    Route::get('/users/role/{role}', function ($role) {
        $users = \App\Models\FirestoreUser::findByRole($role);
        return response()->json(array_map(fn($u) => $u->toArray(), $users));
    });
});
