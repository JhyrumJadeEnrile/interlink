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

                <form>
                    <div class="mb-3">
                        <label class="form-label text-white-75">Supervisor Name</label>
                        <input type="text" class="form-control" placeholder="Morgan Lee" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white-75">Company Email</label>
                        <input type="email" class="form-control" placeholder="supervisor@workplace.com" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white-75">Password</label>
                        <input type="password" class="form-control" placeholder="Create password" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white-75">Confirm Password</label>
                        <input type="password" class="form-control" placeholder="Confirm password" />
                    </div>
                    <button type="submit" class="btn btn-warning btn-round w-100">Register as Supervisor</button>
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