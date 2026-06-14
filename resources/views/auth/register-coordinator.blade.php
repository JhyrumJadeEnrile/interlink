@extends('layouts.auth')

@section('title', 'Coordinator Register | InternLink')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6 col-xl-5">
        <div class="card auth-card p-4">
            <div class="card-body">
                <div class="mb-4 text-center">
                    <h3 class="text-white">Coordinator Registration</h3>
                    <p class="text-white-50">Sign up to manage students, approvals, and OJT flow.</p>
                </div>

                <form method="POST" action="{{ route('register.role', ['role' => 'coordinator']) }}">
                    @csrf
                    <p class="text-white-50">No database registration is required. Continue as a Coordinator to use teacher workflows.</p>
                    <button type="submit" class="btn btn-success btn-round w-100">Continue as Coordinator</button>
                </form>

                <div class="text-center text-white-50 mt-4">
                    Already have an account? <a href="{{ url('/login/coordinator') }}" class="text-white">Sign in</a>
                </div>
                <div class="text-center mt-3">
                    <a href="{{ url('/login') }}" class="text-white-50">Back to role selection</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection