@extends('layouts.auth')

@section('title', 'OJT Coordinator Login | InternLink')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6 col-xl-5">
        <div class="card auth-card p-4">
            <div class="card-body">
                <div class="mb-4 text-center">
                    <h3 class="text-white">Coordinator Sign In</h3>
                    <p class="text-white-50">Manage student placements, approvals, and performance.</p>
                </div>

                <form method="POST" action="{{ route('login.role', ['role' => 'coordinator']) }}">
                    @csrf
                    <p class="text-white-50">No database is required. Continue as a Coordinator to access teacher workflows.</p>
                    <button type="submit" class="btn btn-success btn-round w-100">Continue as Coordinator</button>
                </form>

                <div class="text-center text-white-50 mt-4">
                    Need an account? <a href="{{ url('/register/coordinator') }}" class="text-white">Register here</a>
                </div>
                <div class="text-center mt-3">
                    <a href="{{ url('/login') }}" class="text-white-50">Back to role selection</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection