@extends('layouts.auth')

@section('title', 'Supervisor Register | InternLink')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6 col-xl-5">
        <div class="card auth-card p-4">
            <div class="card-body">
                <div class="mb-4 text-center">
                    <h3 class="text-white">Supervisor Registration</h3>
                    <p class="text-white-50">Register to supervise trainees and verify workplace hours.</p>
                </div>

                <form method="POST" action="{{ route('register.role', ['role' => 'supervisor']) }}">
                    @csrf
                    <p class="text-white-50">No database registration is required. Continue as a Supervisor to use approval workflows.</p>
                    <button type="submit" class="btn btn-warning btn-round w-100">Continue as Supervisor</button>
                </form>

                <div class="text-center text-white-50 mt-4">
                    Already registered? <a href="{{ url('/login/supervisor') }}" class="text-white">Sign in</a>
                </div>
                <div class="text-center mt-3">
                    <a href="{{ url('/login') }}" class="text-white-50">Back to role selection</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection