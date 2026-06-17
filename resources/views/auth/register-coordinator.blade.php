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

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register.role', ['role' => 'coordinator']) }}">
                    @csrf

                    <div class="mb-3">
                        <label class="text-white-50">Full Name</label>
                        <input type="text" name="name" class="form-control"
                               value="{{ old('name') }}"
                               placeholder="Enter your full name" required>
                    </div>

                    <div class="mb-3">
                        <label class="text-white-50">Email Address</label>
                        <input type="email" name="email" class="form-control"
                               value="{{ old('email') }}"
                               placeholder="Enter your email" required>
                    </div>

                    <div class="mb-3">
                        <label class="text-white-50">Password</label>
                        <input type="password" name="password" class="form-control"
                               placeholder="Minimum 8 characters" required>
                    </div>

                    <div class="mb-4">
                        <label class="text-white-50">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control"
                               placeholder="Re-enter your password" required>
                    </div>

                    <button type="submit" class="btn btn-success btn-round w-100">
                        Create Coordinator Account
                    </button>
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