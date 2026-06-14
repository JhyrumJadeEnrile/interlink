@extends('layouts.auth')

@section('title', 'Admin Login | InternLink')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6 col-xl-5">
        <div class="card auth-card p-4">
            <div class="card-body">
                <div class="mb-4 text-center">
                    <h3 class="text-white">Admin Login</h3>
                    <p class="text-white-50">Sign in as Admin to manage student assignments and supervisor profiles.</p>
                </div>

                <form method="POST" action="{{ route('login.role', ['role' => 'admin']) }}">
                    @csrf
                    <p class="text-white-50">No database is required. Continue as Admin to access the admin student assignment area.</p>
                    <button type="submit" class="btn btn-success btn-round w-100">Continue as Admin</button>
                </form>

                <div class="text-center mt-3">
                    <a href="{{ url('/login') }}" class="text-white-50">Back to role selection</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
