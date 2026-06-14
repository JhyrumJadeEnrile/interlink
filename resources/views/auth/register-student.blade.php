@extends('layouts.auth')

@section('title', 'Student Register | InternLink')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6 col-xl-5">
        <div class="card auth-card p-4">
            <div class="card-body">
                <div class="mb-4 text-center">
                    <h3 class="text-white">Student Registration</h3>
                    <p class="text-white-50">Create your InternLink account to start logging OJT hours.</p>
                </div>

                <form method="POST" action="{{ route('register.role', ['role' => 'student']) }}">
                    @csrf
                    <p class="text-white-50">No database registration is required. Continue as a Student to use the student workflow.</p>
                    <button type="submit" class="btn btn-primary btn-round w-100">Continue as Student</button>
                </form>

                <div class="text-center text-white-50 mt-4">
                    Already registered? <a href="{{ url('/login/student') }}" class="text-white">Sign in</a>
                </div>
                <div class="text-center mt-3">
                    <a href="{{ url('/login') }}" class="text-white-50">Back to role selection</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection