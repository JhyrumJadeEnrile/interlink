@extends('layouts.app')

@section('title', 'Student Assignments | InternLink')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 text-white">Student Assignments</h2>
            <p class="text-white-50 mb-0">Link students to coordinators and company supervisors.</p>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card bg-secondary bg-opacity-10 border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Coordinator</th>
                            <th>Supervisor</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($students as $student)
                            <tr>
                                <td>
                                    <strong>{{ $student->name }}</strong><br>
                                    <small class="text-muted">{{ $student->email }}</small>
                                </td>
                                <td>
                                    {{ $student->teacher ? $student->teacher->name : 'Not assigned' }}
                                </td>
                                <td>
                                    {{ $student->supervisor ? $student->supervisor->name : 'Not assigned' }}
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('admin.link-student') }}">
                                        @csrf
                                        <input type="hidden" name="student_id" value="{{ $student->id }}">
                                        <div class="row g-2">
                                            <div class="col-md-5">
                                                <select name="teacher_id" class="form-select form-select-sm" required>
                                                    <option value="">Select Coordinator</option>
                                                    @foreach ($teachers as $teacher)
                                                        <option value="{{ $teacher->id }}" {{ $student->teacher_id === $teacher->id ? 'selected' : '' }}>{{ $teacher->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-5">
                                                <select name="supervisor_id" class="form-select form-select-sm" required>
                                                    <option value="">Select Supervisor</option>
                                                    @foreach ($supervisors as $supervisor)
                                                        <option value="{{ $supervisor->id }}" {{ $student->supervisor_id === $supervisor->id ? 'selected' : '' }}>{{ $supervisor->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2 d-grid">
                                                <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-white-50 py-4">
                                    No students available yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
