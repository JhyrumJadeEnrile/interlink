@extends('layouts.app')

@section('title', 'Student Requirements | InternLink')

@section('content')
<div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4 justify-content-between">
        <div>
            <h3 class="fw-bold mb-1">Student Required Hours</h3>
            <h6 class="op-7 mb-0">Set and monitor required internship hours for each trainee.</h6>
        </div>
        <div class="mt-3 mt-md-0">
            <a href="{{ route('teacher.assign-department') }}" class="btn btn-primary btn-round px-4">
                <i class="fa fa-plus me-1"></i> Assign Department
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
        <div class="card-header">
            <h5 class="card-title">
                <i class="fas fa-users me-2"></i>Student Roster with Department Assignments
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background:rgba(255,255,255,0.05);">
                        <tr>
                            <th class="ps-4">Student</th>
                            <th>Department</th>
                            <th>Supervisor</th>
                            <th>Completed</th>
                            <th>Required</th>
                            <th>Progress</th>
                            <th class="pe-4 text-end">Update Hours</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                            <tr>
                                <td class="ps-4 py-3">
                                    <div>
                                        <div class="fw-bold" style="font-size:13px;">{{ $student->name }}</div>
                                        <div style="font-size:11px;color:rgba(220,210,255,0.45);">{{ $student->email }}</div>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $assignment = $student->departmentAssignments->first();
                                    @endphp
                                    @if($assignment)
                                        <span class="badge bg-success" style="font-size:11px;">
                                            <i class="fas fa-check-circle me-1"></i>{{ $assignment->department }}
                                        </span>
                                    @else
                                        <span class="badge bg-warning text-dark" style="font-size:11px;">
                                            <i class="fas fa-exclamation-triangle me-1"></i>Not Assigned
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div style="font-size:13px;">{{ optional($student->supervisor)->name ?? 'Unassigned' }}</div>
                                    <div style="font-size:11px;color:rgba(220,210,255,0.45);">{{ optional($student->supervisor)->email ?? '' }}</div>
                                </td>
                                <td>
                                    <div class="fw-semibold" style="font-size:13px;">{{ number_format($student->hoursCompleted(), 2) }} hrs</div>
                                </td>
                                <td>
                                    <div class="fw-semibold" style="font-size:13px;">{{ $student->required_hours ?? '-' }}</div>
                                </td>
                                <td>
                                    <div class="progress progress-sm mb-2" style="height:6px;">
                                        <div class="progress-bar bg-success" role="progressbar" 
                                             style="width: {{ $student->progressPercentage() }}%;" 
                                             aria-valuenow="{{ $student->progressPercentage() }}" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100"></div>
                                    </div>
                                    <small style="font-size:11px;">{{ $student->progressPercentage() }}%</small>
                                </td>
                                <td class="pe-4 text-end">
                                    <form method="POST" action="{{ route('teacher.required-hours.update') }}" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="student_id" value="{{ $student->id }}" />
                                        <div class="input-group input-group-sm" style="width:120px;">
                                            <input type="number" 
                                                   name="required_hours" 
                                                   class="form-control form-control-sm" 
                                                   min="1" 
                                                   value="{{ $student->required_hours ?? '' }}" 
                                                   placeholder="Hours" 
                                                   required />
                                            <button class="btn btn-success btn-sm" type="submit">
                                                <i class="fas fa-save"></i>
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    No students assigned to you yet
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Info Card -->
    <div class="card card-round mt-4" style="background:rgba(40,199,111,.08);border-color:rgba(40,199,111,.2);">
        <div class="card-body p-3">
            <div class="d-flex align-items-start gap-3">
                <i class="fas fa-lightbulb text-success mt-1" style="font-size:16px;"></i>
                <div style="font-size:12px;color:rgba(220,210,255,0.65);">
                    <strong>Department Assignment Status:</strong> Students marked as "Not Assigned" cannot submit time logs yet. Use the "Assign Department" button above to link them to a supervisor and department.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
