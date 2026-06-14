@extends('layouts.auth')

@section('title', 'Student Login | InternLink')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6 col-xl-5">
        <div class="card auth-card p-4">
            <div class="card-body">
                <div class="mb-4 text-center">
                    <h3 class="text-white">Student Sign In</h3>
                    <p class="text-white-50">Access your training logs and assigned supervisor information.</p>
                </div>

                <form method="POST" action="{{ route('login.role', ['role' => 'student']) }}">
                    @csrf
                    <p class="text-white-50">No database is required. Continue as a Student to access the student workflow.</p>
                    <button type="submit" class="btn btn-primary btn-round w-100">Continue as Student</button>
                </form>

                <div class="text-center text-white-50 mt-4">
                    Don’t have an account? <a href="{{ url('/register/student') }}" class="text-white">Register now</a>
                </div>
                <div class="text-center mt-3">
                    <a href="{{ url('/login') }}" class="text-white-50">Back to role selection</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection