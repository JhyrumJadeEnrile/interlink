@extends('layouts.app')

@section('title', 'Time Log Approvals | InternLink')

@section('content')
<div class="page-inner">
    <!-- 🌟 BINAGO: Ginawang flex row para magkatabi ang Title at ang Add Student Button -->
    <div class="page-header d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="fw-bold mb-1">Time Log Approvals</h3>
            <p class="text-white-50 mb-0">Review and sign student daily time logs for accuracy.</p>
        </div>

        <!-- 🌟 IPINESTE: Dito nakalagay ang tamang button link natin -->
        <div>
            <a href="{{ route('students.create') }}" class="btn btn-primary btn-round px-4">
                <i class="fa fa-plus me-1"></i> Add Student
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($logs->isEmpty())
        <div class="card">
            <div class="card-body text-white-50">No pending time logs available for approval.</div>
        </div>
    @else
        @foreach ($logs as $log)
            <div class="card mb-3">
                <div class="card-header">
                    <div class="card-title">{{ $log->student->name }} &mdash; {{ $log->date->format('M d, Y') }}</div>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Duration:</strong> {{ number_format($log->total_hours, 2) }} hrs</p>
                    <p class="mb-2"><strong>Location:</strong> {{ $log->latitude ? "{$log->latitude}, {$log->longitude}" : 'N/A' }}</p>
                    <p class="mb-2"><strong>Photo:</strong>
                        @if ($log->photo_path)
                            <a href="{{ asset('storage/' . $log->photo_path) }}" target="_blank">View</a>
                        @else
                            <span class="text-muted">No photo attached</span>
                        @endif
                    </p>

                    <div class="row">
                        <div class="col-md-6">
                            <form method="POST" action="{{ route('supervisor.timelogs.approve', $log) }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label text-white-75">Supervisor Signature</label>
                                    <input type="text" name="supervisor_signature" class="form-control" placeholder="Your name" required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-white-75">Notes (optional)</label>
                                    <textarea name="supervisor_notes" class="form-control" rows="3"></textarea>
                                </div>
                                <button type="submit" class="btn btn-success btn-round">Approve</button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <form method="POST" action="{{ route('supervisor.timelogs.reject', $log) }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label text-white-75">Rejection Reason</label>
                                    <textarea name="supervisor_notes" class="form-control" rows="5" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-danger btn-round">Reject</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
