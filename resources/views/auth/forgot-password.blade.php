@extends('layouts.auth')

@section('title', 'Forgot Password | InternLink')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6 col-xl-5">
        <div class="card auth-card p-4">
            <div class="card-body">
                <div class="mb-4 text-center">
                    <h3 class="text-white">Forgot Password</h3>
                    <p class="text-white-50">Reset your InternLink access by email. Choose your role and we’ll send recovery instructions.</p>
                </div>

                <form>
                    <div class="mb-3">
                        <label class="form-label text-white-75">Account Type</label>
                        <select class="form-control">
                            <option>Student</option>
                            <option>OJT Coordinator</option>
                            <option>Workplace Supervisor</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white-75">Email Address</label>
                        <input type="email" class="form-control" placeholder="you@example.com" />
                    </div>
                    <button type="submit" class="btn btn-info btn-round w-100">Send Password Reset Link</button>
                </form>

                <div class="text-center text-white-50 mt-4">
                    Remembered your password? <a href="{{ url('/login') }}" class="text-white">Back to sign in</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection