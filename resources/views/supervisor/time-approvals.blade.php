@extends('layouts.app')

@section('title', 'Time Log Approvals | InternLink')

@section('content')

<div class="page-header">
    <h3 class="fw-bold mb-1">Time Log Approvals</h3>
    <ul class="breadcrumbs mb-3">
        <li class="nav-home"><a href="{{ url('/dashboard') }}"><i class="icon-home"></i></a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Supervisor</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Pending Logs</a></li>
    </ul>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
        <i class="fas fa-check-circle"></i><span>{{ session('success') }}</span>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
    </div>
@endif

@if ($logs->isEmpty())
    <div class="card card-round">
        <div class="card-body text-center py-5">
            <div style="width:60px;height:60px;border-radius:50%;background:#f4f5f7;margin:0 auto 14px;display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-clipboard-check" style="font-size:22px;color:#ccc;"></i>
            </div>
            <h6 class="fw-bold mb-1">No pending time logs</h6>
            <p class="text-muted mb-0" style="font-size:13px;">All student submissions have been reviewed. Check back later.</p>
        </div>
    </div>
@else
    <div class="d-flex align-items-center gap-2 mb-3">
        <span style="width:34px;height:34px;border-radius:10px;background:rgba(255,173,70,.15);display:flex;align-items:center;justify-content:center;">
            <i class="fas fa-hourglass-half" style="color:#ffad46;font-size:15px;"></i>
        </span>
        <div>
            <span class="fw-bold" style="font-size:14px;color:#1a1a2e;">Pending for Review</span>
            <span class="ms-2 badge rounded-pill border" style="background:#f4f5f7;color:#555;font-size:11px;padding:4px 10px;">
                {{ $logs->count() }} {{ Str::plural('log', $logs->count()) }}
            </span>
        </div>
    </div>

    <div class="d-flex flex-column gap-3">
        @foreach ($logs as $log)
        <div class="card card-round">
            {{-- Card Header --}}
            <div class="card-header d-flex align-items-center gap-3" style="background:linear-gradient(135deg,rgba(88,103,221,.04),transparent) !important;">
                <div style="width:40px;height:40px;border-radius:50%;background:#5867dd;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;color:#fff;flex-shrink:0;">
                    {{ strtoupper(substr($log->student->name, 0, 2)) }}
                </div>
                <div class="flex-grow-1">
                    <div class="fw-bold" style="font-size:14px;color:#1a1a2e;">{{ $log->student->name }}</div>
                    <div style="font-size:11px;color:#aaa;">{{ $log->student->email }}</div>
                </div>
                <div class="text-end">
                    <div class="fw-semibold" style="font-size:13px;color:#1a1a2e;">{{ $log->date->format('M d, Y') }}</div>
                    <div style="font-size:11px;color:#aaa;">
                        <span style="color:#28c76f;">● IN</span>
                        {{ $log->time_in ? \Carbon\Carbon::parse($log->time_in)->format('h:i A') : 'N/A' }}
                        <span class="mx-1">·</span>
                        <span style="color:#f25961;">● OUT</span>
                        {{ $log->time_out ? \Carbon\Carbon::parse($log->time_out)->format('h:i A') : 'Active' }}
                    </div>
                </div>
                <div style="flex-shrink:0;">
                    <span class="badge rounded-pill bg-warning text-dark px-3" style="font-size:11px;">Pending</span>
                </div>
            </div>

            <div class="card-body">
                {{-- Log Details --}}
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <div style="background:#f4f5f7;border-radius:10px;padding:12px 16px;text-align:center;">
                            <div style="font-size:10px;text-transform:uppercase;letter-spacing:.06em;color:#aaa;font-weight:600;">Duration</div>
                            <div class="fw-bold" style="font-size:18px;color:#1a1a2e;margin-top:4px;">{{ number_format($log->total_hours, 2) }} <span style="font-size:11px;font-weight:400;color:#aaa;">hrs</span></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div style="background:#f4f5f7;border-radius:10px;padding:12px 16px;text-align:center;">
                            <div style="font-size:10px;text-transform:uppercase;letter-spacing:.06em;color:#aaa;font-weight:600;">Location</div>
                            <div class="fw-semibold" style="font-size:12px;color:#1a1a2e;margin-top:4px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" title="{{ $log->location ?? 'Not set' }}">
                                @if($log->location)
                                    <i class="fas fa-map-marker-alt text-danger me-1" style="font-size:11px;"></i>{{ Str::limit($log->location, 20) }}
                                @else
                                    <span style="color:#ccc;">Not set</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div style="background:#f4f5f7;border-radius:10px;padding:12px 16px;text-align:center;">
                            <div style="font-size:10px;text-transform:uppercase;letter-spacing:.06em;color:#aaa;font-weight:600;">Photo</div>
                            <div style="margin-top:4px;">
                                @if($log->photo_path)
                                    <a href="{{ asset('storage/' . $log->photo_path) }}" target="_blank"
                                       style="font-size:12px;color:#5867dd;font-weight:600;text-decoration:none;">
                                        <i class="fas fa-image me-1"></i>View Photo
                                    </a>
                                @else
                                    <span style="font-size:12px;color:#ccc;">No photo</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div style="background:#f4f5f7;border-radius:10px;padding:12px 16px;text-align:center;">
                            <div style="font-size:10px;text-transform:uppercase;letter-spacing:.06em;color:#aaa;font-weight:600;">Submitted</div>
                            <div class="fw-semibold" style="font-size:12px;color:#1a1a2e;margin-top:4px;">{{ $log->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </div>

                {{-- Approve / Reject Forms --}}
                <div class="row g-3">
                    {{-- Approve --}}
                    <div class="col-md-6">
                        <div style="border:1px solid rgba(40,199,111,.2);border-radius:10px;padding:16px;background:rgba(40,199,111,.03);">
                            <div class="fw-semibold mb-3 d-flex align-items-center gap-2" style="font-size:13px;color:#1a1a2e;">
                                <i class="fas fa-check-circle text-success"></i> Approve Log
                            </div>
                            <form method="POST" action="{{ route('supervisor.timelogs.approve', $log) }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-semibold" style="font-size:12px;color:#555;">Your Signature <span class="text-danger">*</span></label>
                                    <input type="text" name="supervisor_signature" class="form-control" style="height:40px;" placeholder="Type your full name" required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold" style="font-size:12px;color:#555;">Notes <span class="fw-normal text-muted">(optional)</span></label>
                                    <textarea name="supervisor_notes" class="form-control" rows="2" style="font-size:13px;resize:none;" placeholder="Add remarks..."></textarea>
                                </div>
                                @if($log->time_out)
                                <button type="submit" class="btn btn-success btn-round w-100 fw-semibold" style="height:40px;">
                                    <i class="fas fa-check me-2"></i>Approve
                                </button>
                                @else
                                <div class="d-flex align-items-center gap-2 justify-content-center py-2 rounded"
                                     style="background:rgba(255,173,70,.1);border:1px solid rgba(255,173,70,.3);font-size:12px;color:#d97706;">
                                    <i class="fas fa-hourglass-half"></i>
                                    Waiting for student to clock out
                                </div>
                                @endif
                            </form>
                        </div>
                    </div>

                    {{-- Reject --}}
                    <div class="col-md-6">
                        <div style="border:1px solid rgba(242,89,97,.2);border-radius:10px;padding:16px;background:rgba(242,89,97,.03);">
                            <div class="fw-semibold mb-3 d-flex align-items-center gap-2" style="font-size:13px;color:#1a1a2e;">
                                <i class="fas fa-times-circle text-danger"></i> Reject Log
                            </div>
                            <form method="POST" action="{{ route('supervisor.timelogs.reject', $log) }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-semibold" style="font-size:12px;color:#555;">Rejection Reason <span class="text-danger">*</span></label>
                                    <textarea name="supervisor_notes" class="form-control" rows="4" style="font-size:13px;resize:none;" placeholder="Explain why this log is being rejected..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-danger btn-round w-100 fw-semibold" style="height:40px;">
                                    <i class="fas fa-times me-2"></i>Reject
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif

@endsection