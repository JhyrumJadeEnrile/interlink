<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\SupervisorProfileController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::redirect('/', '/dashboard');

// --- Auth Routes ---
Route::get('/login', fn () => view('auth.role-select'))->name('login');
Route::get('/login/{role}', [AuthController::class, 'showLoginForm'])
    ->where('role', 'student|coordinator|supervisor|admin')
    ->name('login.role');
Route::post('/login/{role}', [AuthController::class, 'login'])
    ->where('role', 'student|coordinator|supervisor|admin');

Route::get('/register', fn () => view('auth.register-select'))->name('register');
Route::get('/register/{role}', [AuthController::class, 'showRegisterForm'])
    ->where('role', 'student|coordinator|supervisor')
    ->name('register.role');
Route::post('/register/{role}', [AuthController::class, 'register'])
    ->where('role', 'student|coordinator|supervisor');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- Protected Routes ---
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', fn () => view('admin.dashboard'))->name('admin.dashboard');

    // --- Added Profile Redirect Route (FIXES THE ERROR) ---
    Route::get('/profile', function () {
        $user = auth()->user();
        if ($user->role === 'student') return redirect()->route('student.profile');
        if ($user->role === 'supervisor') return redirect()->route('supervisor.profile.edit');
        return redirect()->route('admin.dashboard');
    })->name('profile.edit');

    // Admin
    Route::get('/admin/students', [AdminController::class, 'studentAssignments'])->name('admin.student-assignments');
    Route::post('/admin/students/link', [AdminController::class, 'linkStudent'])->name('admin.link-student');

    // Student
    Route::prefix('student')->group(function () {
        Route::get('/documents', [StudentController::class, 'documents'])->name('student.documents');
        Route::post('/documents', [StudentController::class, 'uploadDocument'])->name('student.documents.upload');
        Route::delete('/documents/{id}', [StudentController::class, 'destroyDocument'])->name('student.documents.destroy');

        Route::get('/journals', [StudentController::class, 'journals'])->name('student.journals');
        Route::post('/journals', [StudentController::class, 'storeJournal'])->name('student.journals.store');
        Route::delete('/journals/{id}', [StudentController::class, 'destroyJournal'])->name('student.journals.destroy');

        Route::get('/timelogs', [StudentController::class, 'timelogs'])->name('student.timelogs');
        Route::post('/timelogs', [StudentController::class, 'submitTimeLog'])->name('student.timelogs.store');
        Route::delete('/timelogs/{id}', [StudentController::class, 'destroyTimeLog'])->name('student.timelogs.destroy');
        Route::patch('/timelogs/{id}/timeout', [StudentController::class, 'updateTimeOut'])->name('student.timelogs.timeout');

        Route::get('/profile', [StudentController::class, 'profile'])->name('student.profile');
        Route::put('/profile', [StudentController::class, 'updateProfile'])->name('student.profile.update');
    });

    // Teacher / Coordinator
    Route::prefix('teacher')->group(function () {
        Route::get('/students', [TeacherController::class, 'students'])->name('teacher.students');
        Route::post('/students/required-hours', [TeacherController::class, 'updateRequiredHours'])->name('teacher.required-hours.update');
        Route::get('/approved-logs', [TeacherController::class, 'approvedLogs'])->name('teacher.approved-logs');
        Route::get('/dashboard', [TeacherController::class, 'students'])->name('teacher.dashboard');
        
        // Department Assignment Routes
        Route::get('/assign-department', [TeacherController::class, 'showAssignDepartment'])->name('teacher.assign-department');
        Route::post('/assign-department', [TeacherController::class, 'assignDepartment'])->name('teacher.assign-department.store');
        Route::get('/department-assignments', [TeacherController::class, 'viewDepartmentAssignments'])->name('teacher.department-assignments');
    });

    // Supervisor
    Route::prefix('supervisor')->group(function () {
        Route::get('/timelogs/pending', [SupervisorController::class, 'pendingLogs'])->name('supervisor.timelogs.pending');
        Route::post('/timelogs/{timeLog}/approve', [SupervisorController::class, 'approveLog'])->name('supervisor.timelogs.approve');
        Route::post('/timelogs/{timeLog}/reject', [SupervisorController::class, 'rejectLog'])->name('supervisor.timelogs.reject');
        Route::get('/dashboard', [SupervisorController::class, 'pendingLogs'])->name('supervisor.dashboard');

        Route::get('/profile', [SupervisorProfileController::class, 'edit'])->name('supervisor.profile.edit');
        Route::post('/profile', [SupervisorProfileController::class, 'update'])->name('supervisor.profile.update');
    });

    // --- Chat Engine Routes ---
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/messages/{contact}', [ChatController::class, 'getMessages'])->name('chat.messages');
    Route::post('/chat/send', [ChatController::class, 'store'])->name('chat.store');

    // --- Management & Utility ---
    Route::get('/management/students/create', [AdminController::class, 'createStudent'])->name('students.create');
    Route::post('/management/students/store', [AdminController::class, 'storeStudent'])->name('students.store');

    // Reports
    Route::get('/reports/final', [ReportController::class, 'finalOjtReport'])->name('reports.final');
    Route::get('/reports/final/download', [ReportController::class, 'downloadPdf'])->name('reports.final.download');

    // Other System Pages
    Route::view('/buttons', 'admin.buttons')->name('admin.buttons');
    Route::view('/gridsystem', 'admin.gridsystem')->name('admin.gridsystem');
    Route::view('/panels', 'admin.panels')->name('admin.panels');
    Route::view('/notifications', 'admin.notifications')->name('admin.notifications');
    Route::view('/typography', 'admin.typography')->name('admin.typography');
    Route::view('/sweetalert', 'admin.sweetalert')->name('admin.sweetalert');
    Route::view('/font-awesome', 'admin.font-awesome-icons')->name('admin.font-awesome-icons');
    Route::view('/simple-line', 'admin.simple-line-icons')->name('admin.simple-line-icons');
    Route::view('/avatars', 'admin.avatars')->name('admin.avatars');
    Route::view('/welcome', 'admin.welcome')->name('admin.welcome');
    Route::view('/forgot-password', 'auth.forgot-password')->name('password.request');
    Route::view('/forms', 'admin.forms')->name('admin.forms');
    Route::view('/tables', 'admin.tables')->name('admin.tables');
    Route::view('/datatables', 'admin.datatables')->name('admin.datatables');
    Route::view('/googlemaps', 'admin.googlemaps')->name('admin.googlemaps');
    Route::view('/jsvectormap', 'admin.jsvectormap')->name('admin.jsvectormap');
    Route::view('/charts', 'admin.charts')->name('admin.charts');
    Route::view('/widgets', 'admin.widgets')->name('admin.widgets');
    Route::view('/sparkline', 'admin.sparkline')->name('admin.sparkline');
});
