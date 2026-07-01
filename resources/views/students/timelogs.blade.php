@extends('layouts.app')

@section('title', 'Time Logs | InternLink')




@push('styles')
<style>
    /* Badge pill for hours */
    .hrs-badge { background:rgba(255,255,255,0.06);color:#ffffff;font-size:12px;padding:5px 12px;border-radius:50px;font-weight:600; }
</style>

@endpush


@section('content')

<div class="page-header">
    <h3 class="fw-bold mb-1">Daily Time Logs</h3>
    <ul class="breadcrumbs mb-3">
        <li class="nav-home"><a href="{{ url('/dashboard') }}"><i class="icon-home"></i></a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">My OJT</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Time Logs</a></li>
    </ul>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
        <i class="fas fa-check-circle"></i><span>{{ session('success') }}</span>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><i class="fas fa-exclamation-triangle me-1"></i> Please fix the following:</strong>
        <ul class="mb-0 mt-1 ps-3">
            @foreach ($errors->all() as $error)<li style="font-size:13px;">{{ $error }}</li>@endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row g-4">

    {{-- ── Progress & logs ── --}}
    <div class="col-lg-12">

        {{-- Progress card --}}
        <div class="card card-round mb-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span style="width:34px;height:34px;border-radius:10px;background:rgba(40,199,111,.12);display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-chart-line" style="color:#28c76f;font-size:14px;"></i>
                    </span>
                    <div>
                        <h6 class="fw-bold mb-0" style="font-size:14px;">OJT Hours Progress</h6>
                        <div style="font-size:10px;color:rgba(220,210,255,0.45);">Updated in real-time</div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-end mb-2">
                    <span style="font-size:12px;color:rgba(220,210,255,0.55);">Approved Hours</span>
                    <div>
                        <span class="fw-bold" style="font-size:22px;color:#28c76f;">{{ number_format($student->hoursCompleted(), 2) }}</span>
                        <span style="font-size:12px;color:rgba(220,210,255,0.45);"> / {{ $student->required_hours ?? 0 }} hrs required</span>
                    </div>
                </div>
                {{-- Pending hours notice --}}
                @php
                    $pendingHours = $student->timeLogs()->where('status', 'pending')->sum('duration_minutes') / 60;
                @endphp
                @if($pendingHours > 0)
                <div class="d-flex align-items-center gap-2 mb-2 px-2 py-1 rounded" style="background:rgba(255,173,70,.08);border:1px solid rgba(255,173,70,.2);">
                    <i class="fas fa-hourglass-half" style="color:#ffad46;font-size:11px;"></i>
                    <span style="font-size:11px;color:rgba(220,210,255,0.55);">
                        <strong style="color:#ffad46;">{{ number_format($pendingHours, 2) }} hrs</strong> pending supervisor approval
                    </span>
                </div>
                @endif

                <div class="progress mb-3" style="height:8px;border-radius:50px;background:rgba(255,255,255,0.06);">
                    <div class="progress-bar bg-success" role="progressbar"
                         style="width:{{ $student->progressPercentage() }}%;border-radius:50px;"
                         aria-valuenow="{{ $student->progressPercentage() }}" aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>

                <div class="row g-2 text-center">
                    <div class="col-6">
                        <div style="background:rgba(255,255,255,0.05);border-radius:8px;padding:10px;">
                            <div style="font-size:10px;text-transform:uppercase;letter-spacing:.06em;color:rgba(220,210,255,0.45);font-weight:600;">Progress</div>
                            <div class="fw-bold" style="font-size:16px;color:#ffffff;margin-top:2px;">{{ $student->progressPercentage() }}%</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div style="background:rgba(255,255,255,0.05);border-radius:8px;padding:10px;">
                            <div style="font-size:10px;text-transform:uppercase;letter-spacing:.06em;color:rgba(220,210,255,0.45);font-weight:600;">Remaining</div>
                            <div class="fw-bold" style="font-size:16px;color:#f25961;margin-top:2px;">{{ number_format($student->hoursRemaining(), 2) }} hrs</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Logs table --}}
        <div class="card card-round">
            <div class="card-header d-flex align-items-center gap-2" style="background:linear-gradient(135deg,rgba(29,122,243,.05),transparent) !important;">
                <span style="width:34px;height:34px;border-radius:10px;background:rgba(29,122,243,.1);display:flex;align-items:center;justify-content:center;box-shadow:0 2px 6px rgba(29,122,243,.15);">
                    <i class="fas fa-history" style="color:#7ac7ff;font-size:14px;"></i>
                </span>
                <div>
                    <span class="card-title mb-0">Recent Logs</span>
                    <div style="font-size:11px;color:rgba(220,210,255,0.45);font-weight:400;">Your submitted time entries</div>
                </div>
                <span class="ms-auto badge rounded-pill border" style="background:rgba(255,255,255,0.05);color:rgba(220,210,255,0.65);font-size:11px;padding:5px 12px;">
                    {{ $timelogs->count() }} {{ Str::plural('entry', $timelogs->count()) }}
                </span>
            </div>
            <div class="card-body p-0">
                @if ($timelogs->isEmpty())
                    <div class="text-center py-5">
                        <div style="width:60px;height:60px;border-radius:50%;background:rgba(255,255,255,0.05);margin:0 auto 14px;display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-calendar-times" style="font-size:22px;color:rgba(220,210,255,0.35);"></i>
                        </div>
                        <h6 class="fw-bold mb-1">No timesheet records</h6>
                        <p class="text-muted mb-0" style="font-size:13px;">Your daily check-ins will appear here after submission.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-head-bg-light align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">Date / Shift</th>
                                    <th>Hours</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                    <th class="pe-4 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($timelogs as $log)
                                <tr>
                                    <td class="ps-4 py-3" style="min-width:160px;">
                                        <div class="fw-bold" style="font-size:13px;color:#ffffff;margin-bottom:6px;">
                                            {{ $log->date->format('M d, Y') }}
                                        </div>
                                        <div class="d-flex align-items-center gap-1" style="font-size:12px;margin-bottom:3px;">
                                            <span style="width:8px;height:8px;border-radius:50%;background:#28c76f;display:inline-block;flex-shrink:0;"></span>
                                            <span style="color:rgba(220,210,255,0.65);font-weight:500;">IN</span>
                                            <span style="color:#ffffff;font-weight:600;margin-left:4px;">
                                                {{ $log->time_in ? \Carbon\Carbon::parse($log->time_in)->format('h:i A') : 'N/A' }}
                                            </span>
                                        </div>
                                        <div class="d-flex align-items-center gap-1" style="font-size:12px;">
                                            <span style="width:8px;height:8px;border-radius:50%;background:#f25961;display:inline-block;flex-shrink:0;"></span>
                                            <span style="color:rgba(220,210,255,0.65);font-weight:500;">OUT</span>
                                            @if($log->time_out)
                                                <span style="color:#ffffff;font-weight:600;margin-left:4px;">
                                                    {{ \Carbon\Carbon::parse($log->time_out)->format('h:i A') }}
                                                </span>
                                            @else
                                                <span class="badge ms-1" style="background:rgba(255,173,70,.15);color:#d97706;font-size:10px;padding:2px 7px;">Pending</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge rounded-pill" style="background:rgba(255,255,255,0.06);color:#ffffff;font-size:11px;padding:5px 10px;">
                                            {{ number_format(abs($log->total_hours), 2) }} hrs
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        @if($log->location)
                                            <div style="max-width:150px;">
                                                <span style="font-size:12px;color:rgba(220,210,255,0.65);display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" title="{{ $log->location }}">
                                                    <i class="fas fa-map-marker-alt text-danger me-1"></i>{{ $log->location }}
                                                </span>
                                                <small style="font-size:10px;color:rgba(220,210,255,0.45);display:block;margin-top:2px;">
                                                    {{ Str::limit($log->location, 30) }}
                                                </small>
                                            </div>
                                        @else
                                            <span style="font-size:12px;color:rgba(220,210,255,0.4);">
                                                <i class="fas fa-minus me-1"></i>Not set
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3">
                                        <span class="badge rounded-pill px-3
                                            @if($log->status === 'approved') bg-success
                                            @elseif($log->status === 'rejected') bg-danger
                                            @else bg-secondary
                                            @endif"
                                            style="font-size:11px;">
                                            {{ ucfirst($log->status) }}
                                        </span>
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        @if($log->status === 'pending')
                                            {{-- Clock Out edit if missing --}}
                                            @if(!$log->time_out)
                                            <button type="button"
                                                    class="btn btn-sm btn-round fw-semibold me-1"
                                                    style="font-size:11px;background:rgba(124,92,255,.1);color:#7c5cff;border:1px solid rgba(124,92,255,.3);padding:4px 10px;"
                                                    onclick="showClockOutModal({{ $log->id }}, '{{ $log->date->format('M d, Y') }}', '{{ $log->time_in ? \Carbon\Carbon::parse($log->time_in)->format('H:i') : '' }}')">
                                                <i class="fas fa-clock me-1"></i>Clock Out
                                            </button>
                                            @endif
                                            <button type="button"
                                                    class="btn btn-sm btn-icon btn-link text-danger"
                                                    title="Delete log"
                                                    onclick="confirmDeleteLog({{ $log->id }}, '{{ $log->date->format('M d, Y') }}')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <form id="delete-log-{{ $log->id }}"
                                                  method="POST"
                                                  action="{{ route('student.timelogs.destroy', $log->id) }}"
                                                  class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @else
                                        <span style="font-size:11px;color:rgba(220,210,255,0.35);">—</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

    </div>{{-- /col --}}
</div>{{-- /row --}}

<style>
</style>

{{-- Clock Out Modal --}}
<div class="modal fade" id="clockOutModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:380px;">
        <div class="modal-content" style="border-radius:14px;border:none;">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold" style="font-size:15px;">
                    <i class="fas fa-clock text-danger me-2"></i>Record Clock-Out
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-2">
                <div id="modal-log-info" class="mb-3 px-3 py-2 rounded" style="background:rgba(255,255,255,0.05);font-size:12px;color:rgba(220,210,255,0.65);"></div>
                <div id="modal-live-clock" class="text-center mb-3" style="font-size:28px;font-weight:700;color:#ffffff;letter-spacing:.02em;"></div>
                <form id="clockout-form" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="time_out" id="modal-timeout-value" />
                    <div class="d-grid gap-2">
                        <button type="button" id="modal-capture-btn"
                                class="btn btn-round fw-semibold"
                                style="height:44px;background:rgba(124,92,255,.1);color:#7c5cff;border:1.5px solid rgba(124,92,255,.3);">
                            <i class="fas fa-fingerprint me-2"></i>Capture Current Time
                        </button>
                        <div id="modal-captured" class="text-center" style="font-size:12px;color:#28c76f;font-weight:600;min-height:18px;"></div>
                        <button type="submit" id="modal-submit-btn" class="btn btn-danger btn-round fw-semibold" style="height:44px;" disabled>
                            <i class="fas fa-sign-out-alt me-2"></i>Confirm Clock-Out
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection