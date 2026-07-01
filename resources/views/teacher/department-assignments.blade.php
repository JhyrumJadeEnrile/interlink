@extends('layouts.app')

@section('title', 'Department Assignments | InternLink')

@section('content')
<div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4 justify-content-between">
        <div class="d-flex align-items-center mb-3 mb-md-0">
            <div>
                <h3 class="fw-bold mb-1">Department Assignments</h3>
                <h6 class="op-7 mb-0">Track all student-supervisor-department linkages</h6>
            </div>
        </div>
        <div class="mt-3 mt-md-0">
            <a href="{{ route('teacher.assign-department') }}" class="btn btn-primary btn-round px-4">
                <i class="fa fa-plus me-1"></i> New Assignment
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card card-round">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="card-title mb-0">
                <i class="fas fa-link me-2"></i>Active Assignments
                <span class="badge bg-primary ms-2">{{ $assignments->count() }}</span>
            </h5>
        </div>
        <div class="card-body p-0">
            @if($assignments->isEmpty())
                <div class="text-center py-5">
                    <div style="width:60px;height:60px;border-radius:50%;background:rgba(255,255,255,0.05);margin:0 auto 14px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-inbox" style="font-size:22px;color:rgba(220,210,255,0.35);"></i>
                    </div>
                    <h6 class="fw-bold mb-1">No assignments yet</h6>
                    <p class="text-muted mb-0" style="font-size:13px;">
                        <a href="{{ route('teacher.assign-department') }}" class="text-primary">Create one now</a>
                    </p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-head-bg-light align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">Student</th>
                                <th>Supervisor</th>
                                <th>Company</th>
                                <th>Department</th>
                                <th>Assigned Date</th>
                                <th class="pe-4 text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($assignments as $assignment)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <div style="width:38px;height:38px;border-radius:50%;background:#5867dd;color:#fff;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;flex-shrink:0;">
                                                {{ strtoupper(substr($assignment->student->name, 0, 2)) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold" style="font-size:13px;">{{ $assignment->student->name }}</div>
                                                <div style="font-size:11px;color:rgba(220,210,255,0.45);">{{ $assignment->student->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold" style="font-size:13px;">{{ $assignment->supervisor->name }}</div>
                                        <div style="font-size:11px;color:rgba(220,210,255,0.45);">{{ $assignment->supervisor->email }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info" style="font-size:11px;">{{ $assignment->company->company_name }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success" style="font-size:11px;">{{ $assignment->department }}</span>
                                    </td>
                                    <td>
                                        <div style="font-size:12px;">{{ $assignment->assigned_at->format('M d, Y') }}</div>
                                        <div style="font-size:11px;color:rgba(220,210,255,0.45);">{{ $assignment->assigned_at->format('h:i A') }}</div>
                                    </td>
                                    <td class="pe-4 text-end">
                                        <div class="btn-group" role="group">
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-secondary"
                                                    data-bs-toggle="popover"
                                                    data-bs-content="{{ $assignment->notes ?? 'No notes added' }}"
                                                    title="Assignment Notes">
                                                <i class="fas fa-sticky-note"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        No assignments found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($assignments->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $assignments->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-info bubble-shadow-small">
                                <i class="fas fa-link"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Total Assignments</p>
                                <h4 class="card-title">{{ $assignments->count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap popovers
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl, {
            trigger: 'hover'
        });
    });
});
</script>
@endsection
