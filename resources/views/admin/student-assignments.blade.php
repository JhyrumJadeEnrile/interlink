@extends('layouts.app')

@section('title', 'Student Assignments | InternLink')

@section('content')

<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h3 class="fw-bold mb-1">Student Assignments</h3>
        <ul class="breadcrumbs mb-3">
            <li class="nav-home"><a href="{{ url('/dashboard') }}"><i class="icon-home"></i></a></li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Admin</a></li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Student Assignments</a></li>
        </ul>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
        <i class="fas fa-check-circle"></i><span>{{ session('success') }}</span>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card card-round">
    <div class="card-header d-flex align-items-center gap-2">
        <span style="width:32px;height:32px;border-radius:8px;background:rgba(88,103,221,.12);display:flex;align-items:center;justify-content:center;">
            <i class="fas fa-user-tag" style="color:#5867dd;font-size:14px;"></i>
        </span>
        <span class="card-title mb-0">Link Students to Coordinators &amp; Supervisors</span>
        <span class="ms-auto badge rounded-pill border" style="background:#f4f5f7;color:#555;font-size:11px;padding:5px 12px;">
            {{ $students->count() }} {{ Str::plural('student', $students->count()) }}
        </span>
    </div>
    <div class="card-body p-0">

        @forelse ($students as $student)
        <div class="assignment-row px-4 py-3 border-bottom border-light">
            <div class="row align-items-center g-3">

                {{-- Student info --}}
                <div class="col-md-3">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width:36px;height:36px;border-radius:50%;background:#5867dd;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:600;color:#fff;flex-shrink:0;">
                            {{ strtoupper(substr($student->name, 0, 2)) }}
                        </div>
                        <div>
                            <div class="fw-semibold" style="font-size:13px;color:#1a1a2e;">{{ $student->name }}</div>
                            <div style="font-size:11px;color:#aaa;">{{ $student->email }}</div>
                        </div>
                    </div>
                </div>

                {{-- Current assignments --}}
                <div class="col-md-2">
                    <div style="font-size:10px;text-transform:uppercase;letter-spacing:.06em;color:#aaa;font-weight:600;margin-bottom:4px;">Coordinator</div>
                    @if($student->teacher)
                        <span class="badge bg-success rounded-pill px-2" style="font-size:11px;">{{ $student->teacher->name }}</span>
                    @else
                        <span class="badge bg-secondary rounded-pill px-2" style="font-size:11px;">Unassigned</span>
                    @endif
                </div>
                <div class="col-md-2">
                    <div style="font-size:10px;text-transform:uppercase;letter-spacing:.06em;color:#aaa;font-weight:600;margin-bottom:4px;">Supervisor</div>
                    @if($student->supervisor)
                        <span class="badge bg-warning text-dark rounded-pill px-2" style="font-size:11px;">{{ $student->supervisor->name }}</span>
                    @else
                        <span class="badge bg-secondary rounded-pill px-2" style="font-size:11px;">Unassigned</span>
                    @endif
                </div>

                {{-- Assignment form --}}
                <div class="col-md-5">
                    <form method="POST" action="{{ route('admin.link-student') }}" class="d-flex align-items-center gap-2">
                        @csrf
                        <input type="hidden" name="student_id" value="{{ $student->id }}">

                        <select name="teacher_id" class="form-select form-select-sm" style="font-size:12px;" required>
                            <option value="">Coordinator…</option>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ $student->teacher_id === $teacher->id ? 'selected' : '' }}>
                                    {{ $teacher->name }}
                                </option>
                            @endforeach
                        </select>

                        <select name="supervisor_id" class="form-select form-select-sm" style="font-size:12px;" required>
                            <option value="">Supervisor…</option>
                            @foreach ($supervisors as $supervisor)
                                <option value="{{ $supervisor->id }}" {{ $student->supervisor_id === $supervisor->id ? 'selected' : '' }}>
                                    {{ $supervisor->name }}
                                </option>
                            @endforeach
                        </select>

                        <button type="submit" class="btn btn-primary btn-sm btn-round px-3 flex-shrink-0" title="Save assignment">
                            <i class="fas fa-save me-1"></i>Save
                        </button>
                    </form>
                </div>

            </div>
        </div>
        @empty
        <div class="text-center py-5">
            <div style="width:60px;height:60px;border-radius:50%;background:#f4f5f7;margin:0 auto 14px;display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-users" style="font-size:22px;color:#ccc;"></i>
            </div>
            <h6 class="fw-bold mb-1">No students registered yet</h6>
            <p class="text-muted mb-0" style="font-size:13px;">Students will appear here once they register on the platform.</p>
        </div>
        @endforelse

    </div>
</div>

<style>
    .assignment-row:last-child { border-bottom: none !important; }
    .assignment-row:hover { background: rgba(88,103,221,.02); }
    .form-select-sm { height: 34px !important; border-radius: 8px !important; }
</style>
@endsection