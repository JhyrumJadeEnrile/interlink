@extends('layouts.app')

@section('title', 'Approved Logs | InternLink')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <h3 class="fw-bold mb-3">Approved Time Logs</h3>
        <p class="text-white-50">Review approved student logs and monitor any attendance alerts.</p>
    </div>

    @if ($absentStudents->isNotEmpty())
        <div class="alert alert-warning">
            <strong>Attendance Alert:</strong>
            {{ $absentStudents->count() }} student(s) have not submitted approved logs for three consecutive days.
        </div>
    @endif

    @if ($logs->isEmpty())
        <div class="card">
            <div class="card-body text-white-50">No approved time logs found.</div>
        </div>
    @else
        @foreach ($logs as $log)
            <div class="card mb-3">
                <div class="card-header">
                    <h4 class="card-title mb-0">{{ $log->student->name }} - {{ $log->date->format('M d, Y') }}</h4>
                </div>
                <div class="card-body">
                    <p><strong>Duration:</strong> {{ number_format($log->total_hours, 2) }} hrs</p>
                    <p><strong>Supervisor:</strong> {{ optional($log->supervisor)->name ?? 'Unassigned' }}</p>
                    <p><strong>Signature:</strong> {{ $log->supervisor_signature ?? 'N/A' }}</p>
                    <p><strong>Notes:</strong> {{ $log->supervisor_notes ?? 'None' }}</p>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
