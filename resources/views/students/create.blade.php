@extends('layouts.app')

@section('title', 'Add New OJT Student')

@section('content')
<div class="page-inner">
    <div class="page-header mb-4">
        <h3 class="fw-bold text-primary"><i class="fas fa-user-plus me-2"></i>Register New Trainee</h3>
    </div>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card card-round shadow" style="border-top: 5px solid #1d7af3;">
                <div class="card-body p-5">

                    <form method="POST" action="{{ route('students.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label text-muted fw-bold">Full Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white"><i class="fas fa-user"></i></span>
                                <input type="text" name="name" class="form-control" placeholder="Juan A. Dela Cruz" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted fw-bold">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-info text-white"><i class="fas fa-envelope"></i></span>
                                <input type="email" name="email" class="form-control" placeholder="student@school.edu.ph" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted fw-bold">Required OJT Hours</label>
                            <div class="input-group">
                                <span class="input-group-text bg-success text-white"><i class="fas fa-clock"></i></span>
                                <input type="number" name="required_hours" class="form-control" value="500">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label text-muted fw-bold">Password</label>
                                <input type="password" name="password" class="form-control border-primary" placeholder="••••••••" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label text-muted fw-bold">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control border-success" placeholder="••••••••" required>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-3">
                            <button type="submit" class="btn btn-primary btn-lg btn-round shadow-sm">
                                <i class="fas fa-paper-plane me-2"></i> Submit Registration
                            </button>
                            <a href="{{ url('/dashboard') }}" class="btn btn-light btn-round">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
