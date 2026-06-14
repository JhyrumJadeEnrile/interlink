@extends('layouts.auth')

@section('title', 'InternLink | Login')

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-8">
        <div class="text-center mb-5">
            <h1 class="fw-bold auth-brand">InternLink</h1>
            <p class="text-white-70">Choose your account type and sign in to the OJT tracking dashboard.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card auth-card p-4 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <h5 class="text-white">Student</h5>
                                <p class="text-white-50 mb-0">Track your hours, submit logs, and view assignments.</p>
                            </div>
                            <div class="icon bg-primary rounded-circle p-3 text-white">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                        </div>
                        <a href="{{ url('/login/student') }}" class="btn btn-primary btn-round w-100 mb-2">Log In</a>
                        <a href="{{ url('/register/student') }}" class="btn btn-outline-light btn-round w-100">Register</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card auth-card p-4 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <h5 class="text-white">OJT Coordinator</h5>
                                <p class="text-white-50 mb-0">Approve student logs, monitor progress, and assign tasks.</p>
                            </div>
                            <div class="icon bg-success rounded-circle p-3 text-white">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                        </div>
                        <a href="{{ url('/login/coordinator') }}" class="btn btn-success btn-round w-100 mb-2">Log In</a>
                        <a href="{{ url('/register/coordinator') }}" class="btn btn-outline-light btn-round w-100">Register</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card auth-card p-4 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <h5 class="text-white">Workplace Supervisor</h5>
                                <p class="text-white-50 mb-0">Review placement details, log feedback, and verify completed hours.</p>
                            </div>
                            <div class="icon bg-warning rounded-circle p-3 text-white">
                                <i class="fas fa-briefcase"></i>
                            </div>
                        </div>
                        <a href="{{ url('/login/supervisor') }}" class="btn btn-warning btn-round w-100 mb-2">Log In</a>
                        <a href="{{ url('/register/supervisor') }}" class="btn btn-outline-light btn-round w-100">Register</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card auth-card p-4 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <h5 class="text-white">Admin</h5>
                                <p class="text-white-50 mb-0">Manage account links, assign supervisors, and configure student relationships.</p>
                            </div>
                            <div class="icon bg-danger rounded-circle p-3 text-white">
                                <i class="fas fa-user-shield"></i>
                            </div>
                        </div>
                        <a href="{{ url('/login/admin') }}" class="btn btn-danger btn-round w-100 mb-2">Log In</a>
                        <a href="{{ url('/login') }}" class="btn btn-outline-light btn-round w-100">Contact your administrator</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ url('/forgot-password') }}" class="text-white-50">Forgot password?</a>
        </div>
    </div>
</div>
@endsection