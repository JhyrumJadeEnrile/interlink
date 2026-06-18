@extends('layouts.app')

@section('title', 'Time Logs | InternLink')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Daily Time Logs</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="#">
                        <i class="icon-home text-primary"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">My OJT</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Time Logs</a>
                </li>
            </ul>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong class="d-block mb-1"><i class="fas fa-exclamation-triangle me-2"></i> Action Required:</strong>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-5">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">
                                <i class="fas fa-clock text-warning me-2"></i>Log Time
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('student.timelogs.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group px-0 py-2">
                                <label class="fw-semibold">Date</label>
                                <input type="date" name="date" class="form-control kai-input" value="{{ old('date', now()->format('Y-m-d')) }}" required />
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group px-0 py-2">
                                        <label class="fw-semibold">Time In</label>
                                        <input type="datetime-local" name="time_in" class="form-control kai-input" value="{{ old('time_in') }}" required />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group px-0 py-2">
                                        <label class="fw-semibold">Time Out <span class="text-muted small fw-normal">(Optional)</span></label>
                                        <input type="datetime-local" name="time_out" class="form-control kai-input" value="{{ old('time_out') }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group px-0 py-2">
                                        <label class="fw-semibold">GPS Latitude</label>
                                        <input type="text" name="latitude" class="form-control kai-input" value="{{ old('latitude') }}" placeholder="12.345678" />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group px-0 py-2">
                                        <label class="fw-semibold">GPS Longitude</label>
                                        <input type="text" name="longitude" class="form-control kai-input" value="{{ old('longitude') }}" placeholder="121.123456" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group px-0 py-2">
                                <label class="fw-semibold">Photo Attachment</label>
                                <div class="custom-kai-file-input position-relative border rounded p-3 text-center bg-light transition-all">
                                    <i class="fas fa-camera fs-3 text-muted mb-2 d-block"></i>
                                    <span id="file-chosen-text" class="text-secondary small d-block text-truncate fw-medium">Attach proof / workspace image</span>
                                    <input type="file" name="photo" class="position-absolute top-0 start-0 w-100 h-100 opacity-0 cursor-pointer" accept="image/*" id="file-native-input" />
                                </div>
                            </div>

                            <div class="py-2 mt-2">
                                <button type="submit" class="btn btn-warning btn-round text-dark fw-bold w-100">
                                    <i class="fas fa-sign-in-alt me-2"></i>Submit Time Log
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card card-round card-progress-layout mb-4 shadow-sm border border-secondary border-opacity-10">
                    <div class="card-body p-4">
                        <h6 class="fw-bold text-dark mb-3"><i class="fas fa-chart-line text-success me-2"></i>OJT Hours Progress</h6>

                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-secondary small">Total Completed Hours</span>
                            <span class="h5 fw-bold text-success mb-0">{{ number_format($student->hoursCompleted(), 2) }} <span class="fs-xs fw-normal text-muted">/ {{ $student->required_hours ?? '0' }} hrs</span></span>
                        </div>

                        <div class="progress progress-sm mb-3 bg-light rounded-pill" style="height: 10px;">
                            <div class="progress-bar bg-success rounded-pill" role="progressbar"
                                style="width: {{ $student->progressPercentage() }}%;"
                                aria-valuenow="{{ $student->progressPercentage() }}"
                                aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>

                        <div class="row text-center bg-light rounded p-2 g-2">
                            <div class="col-6 border-end border-2 border-white">
                                <div class="text-muted small-text uppercase mb-0">Progress Percentage</div>
                                <strong class="text-dark">{{ $student->progressPercentage() }}%</strong>
                            </div>
                            <div class="col-6">
                                <div class="text-muted small-text uppercase mb-0">Remaining Balance</div>
                                <strong class="text-danger">{{ number_format($student->hoursRemaining(), 2) }} hrs</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-title"><i class="fas fa-history text-primary me-2"></i>Recent Logs Registry</div>
                    </div>
                    <div class="card-body p-0">
                        @if ($timelogs->isEmpty())
                            <div class="text-center py-5">
                                <div class="avatar avatar-lg mb-3 mx-auto bg-light rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="fas fa-calendar-times text-muted fs-4"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-1">No timesheet records</h6>
                                <p class="text-muted small px-4 mb-0">Your daily check-ins and time cards will appear tabulated here.</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-head-bg-light align-middle mb-0 custom-logs-table">
                                    <thead>
                                        <tr>
                                            <th class="ps-4">Date / Shifts</th>
                                            <th>Metrics</th>
                                            <th>Location Status</th>
                                            <th class="pe-4 text-end">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($timelogs as $log)
                                            <tr class="border-bottom border-light">
                                                <td class="ps-4 py-3">
                                                    <div class="fw-bold text-dark">{{ $log->date->format('M d, Y') }}</div>
                                                    <div class="text-muted small mt-0.5">
                                                        <i class="far fa-clock text-success small"></i> {{ $log->time_in ? \Carbon\Carbon::parse($log->time_in)->format('h:i A') : 'N/A' }}
                                                        <span class="mx-1 text-light">|</span>
                                                        <i class="far fa-clock text-danger small"></i> {{ $log->time_out ? \Carbon\Carbon::parse($log->time_out)->format('h:i A') : 'Active Shift' }}
                                                    </div>
                                                </td>
                                                <td class="py-3">
                                                    <span class="badge bg-light text-dark border fw-bold px-2 py-1 rounded">
                                                        {{ number_format($log->total_hours, 2) }} hrs
                                                    </span>
                                                </td>
                                                <td class="py-3">
                                                    @if($log->latitude && $log->longitude)
                                                        <span class="text-secondary small d-block text-truncate max-w-140" title="Lat: {{ $log->latitude }}, Long: {{ $log->longitude }}">
                                                            <i class="fas fa-map-marker-alt text-danger me-1 small"></i> Verified GPS
                                                        </span>
                                                    @else
                                                        <span class="text-muted small"><i class="fas fa-ban me-1 small"></i> No GPS Location</span>
                                                    @endif
                                                </td>
                                                <td class="pe-4 py-3 text-end">
                                                    <span class="badge rounded-pill px-3 py-1 fw-bold fs-xs
                                                        {{ $log->status === 'approved' ? 'bg-success text-white' : ($log->status === 'rejected' ? 'bg-danger text-white' : 'bg-secondary text-white') }}">
                                                        {{ ucfirst($log->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .cursor-pointer { cursor: pointer; }
    .transition-all { transition: all 0.2s ease-in-out; }
    .max-w-140 { max-width: 140px; }
    .fs-xs { font-size: 0.7rem; }
    .small-text { font-size: 0.65rem; font-weight: 700; letter-spacing: 0.04em; }

    .kai-input {
        border-color: #ebedf2 !important;
        height: 40px !important;
    }
    .kai-input:focus {
        border-color: #ffad46 !important; /* Warning context line focus color matches button */
    }

    .custom-kai-file-input {
        border: 1px dashed #ebedf2 !important;
    }
    .custom-kai-file-input:hover {
        border-color: #ffad46 !important;
        background-color: #fffdfa !important;
    }
    .custom-kai-file-input:hover i {
        color: #ffad46 !important;
    }

    .custom-logs-table tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.008);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('file-native-input');
        const fileText = document.getElementById('file-chosen-text');
        const iconWrapper = fileInput?.previousElementSibling?.previousElementSibling;

        if(fileInput && fileText) {
            fileInput.addEventListener('change', function() {
                if(this.files && this.files.length > 0) {
                    fileText.textContent = "Attached: " + this.files[0].name;
                    fileText.className = "text-warning small d-block text-truncate fw-bold";
                    if(iconWrapper) iconWrapper.className = "fas fa-images fs-3 text-warning mb-2 d-block";
                } else {
                    fileText.textContent = "Attach proof / workspace image";
                    fileText.className = "text-secondary small d-block text-truncate fw-medium";
                    if(iconWrapper) iconWrapper.className = "fas fa-camera fs-3 text-muted mb-2 d-block";
                }
            });
        }
    });
</script>
@endsection
