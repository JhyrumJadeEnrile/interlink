@extends('layouts.auth')

@section('title', 'Supervisor Login | InternLink')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6 col-xl-5">
        <div class="card auth-card p-4">
            <div class="card-body">
                <div class="mb-4 text-center">
                    <h3 class="text-white">Supervisor Sign In</h3>
                    <p class="text-white-50">Review trainees, verify hours, and manage company profile details.</p>
                </div>

                <form method="POST" action="{{ route('login.role', ['role' => 'supervisor']) }}">
                    @csrf
                    <p class="text-white-50">No database is required. Continue as a Supervisor to access approval workflows.</p>
                    <button type="submit" class="btn btn-warning btn-round w-100">Continue as Supervisor</button>
                </form>

                <div class="text-center text-white-50 mt-4">
                    New to InternLink? <a href="{{ url('/register/supervisor') }}" class="text-white">Create an account</a>
                </div>
                <div class="text-center mt-3">
                    <a href="{{ url('/login') }}" class="text-white-50">Back to role selection</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection