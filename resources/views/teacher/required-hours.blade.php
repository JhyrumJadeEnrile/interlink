@extends('layouts.app')

@section('title', 'Student Requirements | InternLink')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <h3 class="fw-bold mb-3">Student Required Hours</h3>
        <p class="text-white-50">Set and monitor required internship hours for each trainee.</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-borderless table-hover text-white">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Coordinator</th>
                            <th>Supervisor</th>
                            <th>Completed</th>
                            <th>Required</th>
                            <th>Progress</th>
                            <th>Update</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td>{{ $student->name }}<br><small class="text-muted">{{ $student->email }}</small></td>
                                <td>{{ optional($student->teacher)->name ?? 'Unassigned' }}</td>
                                <td>{{ optional($student->supervisor)->name ?? 'Unassigned' }}</td>
                                <td>{{ number_format($student->hoursCompleted(), 2) }} hrs</td>
                                <td>{{ $student->required_hours ?? 'Not set' }}</td>
                                <td>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: {{ $student->progressPercentage() }}%;" aria-valuenow="{{ $student->progressPercentage() }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <small>{{ $student->progressPercentage() }}%</small>
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('teacher.required-hours.update') }}">
                                        @csrf
                                        <input type="hidden" name="student_id" value="{{ $student->id }}" />
                                        <div class="input-group input-group-sm">
                                            <input type="number" name="required_hours" class="form-control" min="1" value="{{ $student->required_hours ?? '' }}" placeholder="Hours" required />
                                            <button class="btn btn-success btn-sm" type="submit">Save</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
