@extends('layouts.app')

@section('title', 'Final OJT Report | InternLink')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <h3 class="fw-bold mb-3">Final OJT Report</h3>
        <p class="text-white-50">Summary of total hours and journal submissions for internship completion.</p>
    </div>

    @if (session('warning'))
        <div class="alert alert-warning">{{ session('warning') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="text-white">Students Completed Required Hours</h5>
            <p class="text-white-50 mb-0">{{ $completed->count() }} completed, {{ $pending->count() }} pending.</p>
        </div>
        <div>
            <a href="{{ route('reports.final.download') }}" class="btn btn-primary btn-round">Download PDF</a>
        </div>
    </div>

    <div class="row">
        @foreach ($students as $student)
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="card-title">{{ $student->name }}</div>
                        <span class="badge bg-{{ $student->hoursCompleted() >= ($student->required_hours ?? 0) ? 'success' : 'warning' }}">
                            {{ $student->required_hours ? ($student->hoursCompleted() >= $student->required_hours ? 'Complete' : 'In Progress') : 'Unassigned' }}
                        </span>
                    </div>
                    <div class="card-body">
                        <p><strong>Total Hours:</strong> {{ number_format($student->hoursCompleted(), 2) }} hrs</p>
                        <p><strong>Required Hours:</strong> {{ $student->required_hours ?? 'Not set' }}</p>
                        <p><strong>Journal Entries:</strong> {{ $student->journals->count() }}</p>
                        <p><strong>Approved Time Logs:</strong> {{ $student->timeLogs()->approved()->count() }}</p>
                        <p><strong>Supervisor:</strong> {{ optional($student->supervisor)->name ?? 'Unassigned' }}</p>
                        <p><strong>Teacher:</strong> {{ optional($student->teacher)->name ?? 'Unassigned' }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
