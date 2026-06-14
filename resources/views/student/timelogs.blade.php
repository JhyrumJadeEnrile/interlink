@extends('layouts.app')

@section('title', 'Time Logs | InternLink')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <h3 class="fw-bold mb-3">Daily Time Logs</h3>
        <p class="text-white-50">Record your time-in/time-out, capture workplace location, and attach supporting photos.</p>
    </div>

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

    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Log Time</div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('student.timelogs.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label text-white-75">Date</label>
                            <input type="date" name="date" class="form-control" value="{{ old('date', now()->format('Y-m-d')) }}" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-white-75">Time In</label>
                            <input type="datetime-local" name="time_in" class="form-control" value="{{ old('time_in') }}" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-white-75">Time Out</label>
                            <input type="datetime-local" name="time_out" class="form-control" value="{{ old('time_out') }}" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-white-75">GPS Latitude</label>
                            <input type="text" name="latitude" class="form-control" value="{{ old('latitude') }}" placeholder="12.345678" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-white-75">GPS Longitude</label>
                            <input type="text" name="longitude" class="form-control" value="{{ old('longitude') }}" placeholder="121.123456" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-white-75">Photo Attachment</label>
                            <input type="file" name="photo" class="form-control" accept="image/*" />
                        </div>
                        <button type="submit" class="btn btn-warning btn-round w-100">Submit Time Log</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Progress Tracker</div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Completed Hours</span>
                            <strong>{{ number_format($student->hoursCompleted(), 2) }} hrs</strong>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $student->progressPercentage() }}%;" aria-valuenow="{{ $student->progressPercentage() }}" aria-valuemin="0" aria-valuemax="100">{{ $student->progressPercentage() }}%</div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Required Hours</span>
                            <strong>{{ $student->required_hours ?? 'Not set' }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Remaining Hours</span>
                            <strong>{{ number_format($student->hoursRemaining(), 2) }} hrs</strong>
                        </div>
                    </div>

                    <h5 class="mb-3">Recent Time Logs</h5>
                    @if ($timelogs->isEmpty())
                        <div class="text-white-50">No time logs submitted yet.</div>
                    @else
                        <div class="list-group">
                            @foreach ($timelogs as $log)
                                <div class="list-group-item bg-transparent border-0 py-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div>
                                            <strong>{{ $log->date->format('M d, Y') }}</strong>
                                            <div class="text-white-50">Status: {{ ucfirst($log->status) }}</div>
                                        </div>
                                        <span class="badge bg-{{ $log->status === 'approved' ? 'success' : ($log->status === 'rejected' ? 'danger' : 'secondary') }}">{{ ucfirst($log->status) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <small>Rendered: {{ number_format($log->total_hours, 2) }} hrs</small>
                                        <small>{{ $log->latitude && $log->longitude ? "GPS: {$log->latitude}, {$log->longitude}" : 'No GPS data' }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
