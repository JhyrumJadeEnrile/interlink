@extends('layouts.auth')

@section('title', 'InternLink | Register')

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-8">
        <div class="text-center mb-5">
            <h1 class="fw-bold auth-brand">InternLink</h1>
            <p class="text-white-70">Choose the account type you want to register for and start tracking OJT progress.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card auth-card p-4 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <h5 class="text-white">Student</h5>
                                <p class="text-white-50 mb-0">Register to submit logs, track hours, and manage assignments.</p>
                            </div>
                            <div class="icon bg-primary rounded-circle p-3 text-white">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                        </div>
                        <a href="{{ url('/register/student') }}" class="btn btn-primary btn-round w-100">Register</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card auth-card p-4 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <h5 class="text-white">OJT Coordinator</h5>
                                <p class="text-white-50 mb-0">Sign up to manage students, approvals, and placements.</p>
                            </div>
                            <div class="icon bg-success rounded-circle p-3 text-white">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                        </div>
                        <a href="{{ url('/register/coordinator') }}" class="btn btn-success btn-round w-100">Register</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card auth-card p-4 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <h5 class="text-white">Workplace Supervisor</h5>
                                <p class="text-white-50 mb-0">Register to mentor trainees, verify hours, and submit feedback.</p>
                            </div>
                            <div class="icon bg-warning rounded-circle p-3 text-white">
                                <i class="fas fa-briefcase"></i>
                            </div>
                        </div>
                        <a href="{{ url('/register/supervisor') }}" class="btn btn-warning btn-round w-100">Register</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ url('/login') }}" class="text-white-50">Back to login selection</a>
        </div>
    </div>
</div>
@endsection