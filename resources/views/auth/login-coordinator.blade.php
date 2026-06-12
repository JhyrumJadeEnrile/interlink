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

                <form>
                    <div class="mb-3">
                        <label class="form-label text-white-75">Work Email</label>
                        <input type="email" class="form-control" placeholder="coordinator@internlink.com" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white-75">Password</label>
                        <input type="password" class="form-control" placeholder="Enter password" />
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check text-white-75">
                            <input class="form-check-input" type="checkbox" id="rememberCoordinator" />
                            <label class="form-check-label" for="rememberCoordinator">Keep me signed in</label>
                        </div>
                        <a href="{{ url('/forgot-password') }}" class="text-white-75">Forgot password?</a>
                    </div>
                    <button type="submit" class="btn btn-success btn-round w-100">Sign In as Coordinator</button>
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