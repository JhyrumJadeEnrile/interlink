@extends('layouts.app')

@section('title', 'Supervisor Profile | InternLink')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card bg-secondary bg-opacity-10 border-0">
                <div class="card-body">
                    <h3 class="mb-3 text-white">Company Profile</h3>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('supervisor.profile.update') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label text-white-75">Supervisor Name</label>
                            <input type="text" class="form-control" value="{{ old('name', $supervisor->name) }}" readonly />
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-white-75">Company Email</label>
                            <input type="email" class="form-control" value="{{ old('email', $supervisor->email) }}" readonly />
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-white-75">Company Name</label>
                            <input type="text" name="company_name" value="{{ old('company_name', $supervisor->company_name) }}" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-white-75">Department</label>
                            <input type="text" name="department" value="{{ old('department', $supervisor->department) }}" class="form-control" />
                        </div>
                        <button type="submit" class="btn btn-warning btn-round">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
