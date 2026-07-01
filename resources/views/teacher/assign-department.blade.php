@extends('layouts.app')

@section('title', 'Assign Student to Department | InternLink')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <h3 class="fw-bold mb-1">Assign Students to Department</h3>
        <p class="text-white-50">Link students to supervisors and assign them to specific departments and companies.</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><i class="fas fa-exclamation-triangle me-1"></i> Please fix the following:</strong>
            <ul class="mb-0 mt-2 ps-3">
                @foreach ($errors->all() as $error)
                    <li style="font-size:13px;">{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card card-round">
                <div class="card-header d-flex align-items-center gap-2" style="background:linear-gradient(135deg,rgba(88,103,221,.04),transparent) !important;">
                    <span style="width:34px;height:34px;border-radius:10px;background:rgba(88,103,221,.1);display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-link" style="color:#5867dd;font-size:14px;"></i>
                    </span>
                    <div>
                        <h6 class="fw-bold mb-0" style="font-size:14px;">Department Assignment Form</h6>
                        <div style="font-size:11px;color:rgba(220,210,255,0.45);">Assign students to supervisors and departments</div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('teacher.assign-department.store') }}">
                        @csrf

                        <!-- Student Selection -->
                        <div class="mb-4">
                            <label for="student_id" class="form-label fw-bold">
                                <i class="fas fa-graduation-cap text-primary me-2"></i>Select Student
                            </label>
                            <select name="student_id" id="student_id" class="form-control form-control-lg @error('student_id') is-invalid @enderror" required>
                                <option value="">-- Choose a student --</option>
                                @forelse($students as $student)
                                    <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                        {{ $student->name }} ({{ $student->email }})
                                    </option>
                                @empty
                                    <option value="" disabled>No students assigned to you</option>
                                @endforelse
                            </select>
                            @error('student_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Supervisor Selection -->
                        <div class="mb-4">
                            <label for="supervisor_id" class="form-label fw-bold">
                                <i class="fas fa-user-tie text-info me-2"></i>Assign to Supervisor
                            </label>
                            <select name="supervisor_id" id="supervisor_id" class="form-control form-control-lg @error('supervisor_id') is-invalid @enderror" required>
                                <option value="">-- Choose a supervisor --</option>
                                @forelse($supervisors as $supervisor)
                                    <option value="{{ $supervisor->id }}" {{ old('supervisor_id') == $supervisor->id ? 'selected' : '' }}>
                                        {{ $supervisor->name }} 
                                        @if($supervisor->company_name)
                                            ({{ $supervisor->company_name }})
                                        @endif
                                    </option>
                                @empty
                                    <option value="" disabled>No supervisors available</option>
                                @endforelse
                            </select>
                            @error('supervisor_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Company Selection -->
                        <div class="mb-4">
                            <label for="company_id" class="form-label fw-bold">
                                <i class="fas fa-building text-success me-2"></i>Select Company
                            </label>
                            <select name="company_id" id="company_id" class="form-control form-control-lg @error('company_id') is-invalid @enderror" required>
                                <option value="">-- Choose a company --</option>
                                @forelse($companies as $company)
                                    <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                        {{ $company->company_name }}
                                        @if($company->address)
                                            ({{ Str::limit($company->address, 30) }})
                                        @endif
                                    </option>
                                @empty
                                    <option value="" disabled>No companies available</option>
                                @endforelse
                            </select>
                            @error('company_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Department Input -->
                        <div class="mb-4">
                            <label for="department" class="form-label fw-bold">
                                <i class="fas fa-sitemap text-warning me-2"></i>Department Name
                            </label>
                            <input type="text" 
                                   name="department" 
                                   id="department" 
                                   class="form-control form-control-lg @error('department') is-invalid @enderror"
                                   placeholder="e.g., Information Technology, Human Resources, Finance"
                                   value="{{ old('department') }}"
                                   required>
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-info-circle me-1"></i>Specify the department where the student will be deployed
                            </small>
                            @error('department')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div class="mb-4">
                            <label for="notes" class="form-label fw-bold">
                                <i class="fas fa-sticky-note text-secondary me-2"></i>Notes (Optional)
                            </label>
                            <textarea name="notes" 
                                      id="notes" 
                                      class="form-control @error('notes') is-invalid @enderror"
                                      rows="3"
                                      placeholder="Add any additional notes about this assignment..."
                                      maxlength="1000">{{ old('notes') }}</textarea>
                            <small class="text-muted d-block mt-2">Max 1000 characters</small>
                            @error('notes')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Info Alert -->
                        <div class="alert alert-info mb-4" style="background:rgba(29,122,243,.08);border-color:rgba(29,122,243,.2);">
                            <i class="fas fa-lightbulb text-info me-2"></i>
                            <strong>Note:</strong> This assignment will:
                            <ul class="mb-0 mt-2 ps-3">
                                <li>Link the student to the selected supervisor</li>
                                <li>Assign the student to the specified department</li>
                                <li>Be immediately visible to both the student and supervisor</li>
                                <li>Enable the student to submit time logs in the system</li>
                                <li>Allow only this student to time in/out under this supervisor</li>
                            </ul>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg flex-grow-1">
                                <i class="fas fa-check-circle me-2"></i>Assign to Department
                            </button>
                            <a href="{{ route('teacher.dashboard') }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>Back
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Quick Reference -->
            <div class="card card-round mt-4" style="background:rgba(255,255,255,0.03);">
                <div class="card-body p-3">
                    <h6 class="fw-bold mb-3" style="font-size:12px;color:rgba(220,210,255,0.65);">
                        <i class="fas fa-lightbulb me-2"></i>QUICK REFERENCE
                    </h6>
                    <div style="font-size:12px;color:rgba(220,210,255,0.55);line-height:1.8;">
                        <strong>Multiple Departments:</strong> A student can be assigned to different departments under different supervisors simultaneously.<br>
                        <strong>Authorization:</strong> Only the student's assigned supervisor can approve their time logs.<br>
                        <strong>Time In/Out:</strong> Students can only submit time logs if they have an active department assignment.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
