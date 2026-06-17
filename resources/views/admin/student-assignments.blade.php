@extends('layouts.app')

@section('title', 'Student Assignments | InternLink')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Student Assignments</h2>
            <p class="text-muted mb-0">Link students to coordinators and company supervisors.</p>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Student</th>
                            <th>Current Coordinator</th>
                            <th>Assign Coordinator</th>
                            <th>Current Supervisor</th>
                            <th>Assign Supervisor</th>
                            <th>Action</th>
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
                                    @if($student->teacher)
                                        <span class="badge bg-success">{{ $student->teacher->name }}</span>
                                    @else
                                        <span class="badge bg-secondary">Not assigned</span>
                                    @endif
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('admin.link-student') }}" id="form-{{ $student->id }}">
                                        @csrf
                                        <input type="hidden" name="student_id" value="{{ $student->id }}">
                                        <select name="teacher_id" class="form-select form-select-sm" required>
                                            <option value="">Select Coordinator</option>
                                            @foreach ($teachers as $teacher)
                                                <option value="{{ $teacher->id }}" {{ $student->teacher_id === $teacher->id ? 'selected' : '' }}>
                                                    {{ $teacher->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                </td>
                                <td>
                                    @if($student->supervisor)
                                        <span class="badge bg-warning text-dark">{{ $student->supervisor->name }}</span>
                                    @else
                                        <span class="badge bg-secondary">Not assigned</span>
                                    @endif
                                </td>
                                <td>
                                        <select name="supervisor_id" class="form-select form-select-sm" required>
                                            <option value="">Select Supervisor</option>
                                            @foreach ($supervisors as $supervisor)
                                                <option value="{{ $supervisor->id }}" {{ $student->supervisor_id === $supervisor->id ? 'selected' : '' }}>
                                                    {{ $supervisor->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                </td>
                                <td>
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fas fa-save"></i> Save
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="fas fa-users fa-2x mb-2 d-block"></i>
                                    No students registered yet.
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