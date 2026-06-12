@extends('layouts.auth')

@section('title', 'Supervisor Login | InternLink')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6 col-xl-5">
        <div class="card auth-card p-4">
            <div class="card-body">
                <div class="mb-4 text-center">
                    <h3 class="text-white">Supervisor Sign In</h3>
                    <p class="text-white-50">Review trainees, verify hours, and give workplace feedback.</p>
                </div>

                <form>
                    <div class="mb-3">
                        <label class="form-label text-white-75">Company Email</label>
                        <input type="email" class="form-control" placeholder="supervisor@company.com" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white-75">Password</label>
                        <input type="password" class="form-control" placeholder="Enter password" />
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check text-white-75">
                            <input class="form-check-input" type="checkbox" id="rememberSupervisor" />
                            <label class="form-check-label" for="rememberSupervisor">Remember this device</label>
                        </div>
                        <a href="{{ url('/forgot-password') }}" class="text-white-75">Forgot password?</a>
                    </div>
                    <button type="submit" class="btn btn-warning btn-round w-100">Sign In as Supervisor</button>
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