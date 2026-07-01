@extends('layouts.app')

@section('title', 'Supervisor Profile | InternLink')

@section('content')
<div class="container-fluid">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3 text-white">Company Profile & Department Assignment</h3>
                <h6 class="op-7 mb-2 text-white">Manage your supervisor settings, company information, and department assignment.</h6>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
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
            <!-- Sidebar: Profile Overview with Camera Overlay -->
            <div class="col-md-4">
                <div class="card card-round shadow">
                    <div class="card-body text-center p-4">
                        <form action="{{ route('supervisor.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="position-relative d-inline-block mb-3">
                                <!-- Avatar -->
                                <div class="avatar avatar-xxl">
                                    @if(!empty($supervisor->profile_photo_path))
                                        <img src="{{ asset('storage/' . $supervisor->profile_photo_path) }}"
                                             alt="Profile" class="avatar-img rounded-circle border border-white shadow" id="currentAvatar" style="width: 100px; height: 100px; object-fit: cover;">
                                    @else
                                        <div class="avatar-img rounded-circle bg-primary d-flex align-items-center justify-content-center text-white"
                                             style="width: 100px; height: 100px; font-size: 2rem;" id="currentAvatar">
                                            {{ strtoupper(substr($supervisor->name ?? 'S', 0, 1)) }}
                                        </div>
                                    @endif
                                </div>

                                <!-- Camera Icon Overlay -->
                                <label for="photoInput" class="position-absolute bottom-0 end-0 bg-white rounded-circle shadow p-2"
                                       style="cursor: pointer; border: 2px solid #fff; z-index: 10;">
                                    <i class="fas fa-camera text-primary"></i>
                                </label>

                                <!-- Hidden File Input -->
                                <input type="file" name="profile_photo" id="photoInput" class="d-none" accept="image/*">
                            </div>

                            <h3 class="fw-bold mt-2">{{ $supervisor->name ?? 'Supervisor' }}</h3>
                            <p class="text-muted mb-3">{{ $supervisor->email }}</p>

                            <div class="alert alert-info" style="background:rgba(29,122,243,.08);border-color:rgba(29,122,243,.2);font-size:12px;">
                                <i class="fas fa-info-circle me-1"></i>
                                Complete your profile to enable students to submit time logs in your assigned department.
                            </div>

                            <hr>

                            <!-- Form Inputs -->
                            <div class="text-start">
                                <!-- Company Selection -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold d-flex align-items-center gap-2">
                                        <i class="fas fa-building text-success"></i>Select Company
                                    </label>
                                    <select name="company_id" class="form-control form-control-lg @error('company_id') is-invalid @enderror">
                                        <option value="">-- Choose your company --</option>
                                        @forelse($companies as $company)
                                            <option value="{{ $company->id }}" {{ old('company_id', $supervisor->company_id) == $company->id ? 'selected' : '' }}>
                                                {{ $company->company_name }}
                                                @if($company->address)
                                                    ({{ Str::limit($company->address, 20) }})
                                                @endif
                                            </option>
                                        @empty
                                            <option value="" disabled>No companies available</option>
                                        @endforelse
                                    </select>
                                    @error('company_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted d-block mt-1">
                                        Or enter company name manually if not listed
                                    </small>
                                </div>

                                <!-- Manual Company Name (fallback) -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Company Name (if not in list)
                                    </label>
                                    <input type="text" name="company_name" class="form-control"
                                           placeholder="Enter company name"
                                           value="{{ old('company_name', $supervisor->company_name ?? '') }}">
                                    <small class="text-muted d-block mt-1">
                                        Leave empty if you selected a company above
                                    </small>
                                </div>

                                <!-- Department Assignment (Required) -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold d-flex align-items-center gap-2">
                                        <i class="fas fa-sitemap text-warning"></i>Department <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           name="department" 
                                           class="form-control form-control-lg @error('department') is-invalid @enderror"
                                           placeholder="e.g., IT Department, HR, Finance, Operations"
                                           value="{{ old('department', $supervisor->department ?? '') }}"
                                           required>
                                    @error('department')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted d-block mt-1">
                                        This identifies your department. Students will be assigned to this department.
                                    </small>
                                </div>
                            </div>

                            <div class="alert alert-success mt-3" style="background:rgba(40,199,111,.08);border-color:rgba(40,199,111,.2);font-size:12px;">
                                <i class="fas fa-lightbulb me-1"></i>
                                <strong>When you save:</strong>
                                <ul class="mb-0 mt-2 ps-3">
                                    <li>Your department assignment will be updated</li>
                                    <li>All students assigned to you will be notified</li>
                                    <li>Students can then submit time logs</li>
                                </ul>
                            </div>

                            <button type="submit" class="btn btn-primary btn-round w-100 mt-3">
                                <i class="fas fa-save me-2"></i>Save Profile Changes
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Panel: Status & Assigned Students -->
            <div class="col-md-8">
                <div class="card card-round shadow">
                    <div class="card-header border-bottom d-flex align-items-center gap-2" style="background:linear-gradient(135deg,rgba(88,103,221,.04),transparent) !important;">
                        <span style="width:34px;height:34px;border-radius:10px;background:rgba(88,103,221,.1);display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-user-check" style="color:#5867dd;font-size:14px;"></i>
                        </span>
                        <h4 class="card-title mb-0">Your Profile Status</h4>
                    </div>
                    <div class="card-body p-4">
                        <!-- Status Grid -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div style="background:rgba(255,255,255,0.05);border-radius:10px;padding:16px;border-left:3px solid #5867dd;">
                                    <div style="font-size:11px;text-transform:uppercase;color:rgba(220,210,255,0.55);margin-bottom:6px;">
                                        <i class="fas fa-user me-1"></i>Supervisor Name
                                    </div>
                                    <div class="fw-bold" style="font-size:14px;color:#ffffff;">
                                        {{ $supervisor->name ?? 'Not set' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div style="background:rgba(255,255,255,0.05);border-radius:10px;padding:16px;border-left:3px solid {{ $supervisor->department ? '#28c76f' : '#f25961' }};">
                                    <div style="font-size:11px;text-transform:uppercase;color:rgba(220,210,255,0.55);margin-bottom:6px;">
                                        <i class="fas fa-sitemap me-1"></i>Department
                                    </div>
                                    <div class="fw-bold" style="font-size:14px;color:#ffffff;">
                                        @if($supervisor->department)
                                            <span class="badge bg-success">{{ $supervisor->department }}</span>
                                        @else
                                            <span class="badge bg-danger">Not set</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div style="background:rgba(255,255,255,0.05);border-radius:10px;padding:16px;border-left:3px solid {{ $supervisor->company_name ? '#7c5cff' : '#f25961' }};">
                                    <div style="font-size:11px;text-transform:uppercase;color:rgba(220,210,255,0.55);margin-bottom:6px;">
                                        <i class="fas fa-building me-1"></i>Company
                                    </div>
                                    <div class="fw-bold" style="font-size:14px;color:#ffffff;">
                                        {{ $supervisor->company_name ?? 'Not set' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div style="background:rgba(255,255,255,0.05);border-radius:10px;padding:16px;border-left:3px solid #ffad46;">
                                    <div style="font-size:11px;text-transform:uppercase;color:rgba(220,210,255,0.55);margin-bottom:6px;">
                                        <i class="fas fa-user-graduate me-1"></i>Assigned Students
                                    </div>
                                    <div class="fw-bold" style="font-size:14px;color:#ffffff;">
                                        {{ $supervisor->supervisedStudents()->count() }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Info Alert -->
                        <div class="alert alert-warning" style="background:rgba(255,173,70,.08);border-color:rgba(255,173,70,.2);font-size:12px;">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            <strong>Important:</strong> Ensure all fields are completed for students to successfully submit time logs. The department you assign here will be visible to all your assigned students.
                        </div>

                        <!-- Quick Reference -->
                        <div style="background:rgba(255,255,255,0.02);border-radius:8px;padding:12px;border-left:3px solid rgba(168,140,255,0.3);">
                            <h6 class="fw-bold mb-2" style="font-size:12px;color:rgba(220,210,255,0.65);">
                                <i class="fas fa-info-circle me-1"></i>How it works:
                            </h6>
                            <div style="font-size:11px;color:rgba(220,210,255,0.55);line-height:1.7;">
                                1. Complete your profile with company and department information<br>
                                2. Teachers assign students to your department<br>
                                3. Students can then submit time logs for your review<br>
                                4. Approve or reject time logs from your dashboard
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // 1. Live Avatar Preview
    document.getElementById('photoInput').onchange = function (evt) {
        const [file] = this.files;
        if (file) {
            const avatar = document.getElementById('currentAvatar');
            avatar.src = URL.createObjectURL(file);
            if (avatar.classList.contains('bg-primary')) {
                avatar.classList.remove('bg-primary');
            }
        }
    };
</script>
@endpush
