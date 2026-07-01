@extends('layouts.app')

@section('title', 'My Profile | InternLink')

@section('content')

<div class="page-header">
    <h3 class="fw-bold mb-1">My Profile</h3>
    <ul class="breadcrumbs mb-3">
        <li class="nav-home"><a href="{{ url('/dashboard') }}"><i class="icon-home"></i></a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">My Profile</a></li>
    </ul>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
    </div>
@endif
@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><i class="fas fa-exclamation-triangle me-1"></i> Please fix the following:</strong>
        <ul class="mb-0 mt-1 ps-3">
            @foreach($errors->all() as $error)<li style="font-size:13px;">{{ $error }}</li>@endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row g-4">

    {{-- Left: Avatar + OJT Info --}}
    <div class="col-lg-4">

        {{-- Profile Photo Card --}}
        <div class="card card-round text-center p-4 mb-4">
            <form method="POST" action="{{ route('profile.photo.update') }}" enctype="multipart/form-data" id="photo-form">
                @csrf
                <div class="position-relative d-inline-block mb-3">
                    @if($student->profile_photo_path)
                        <img src="{{ asset('storage/' . $student->profile_photo_path) }}"
                             id="avatar-preview"
                             style="width:100px;height:100px;border-radius:50%;object-fit:cover;border:3px solid #7c5cff;display:block;">
                        <div id="avatar-initials" style="display:none;"></div>
                    @else
                        <div id="avatar-initials"
                             style="width:100px;height:100px;border-radius:50%;background:#7c5cff;color:#fff;
                                    display:flex;align-items:center;justify-content:center;
                                    font-size:28px;font-weight:700;margin:0 auto;">
                            {{ strtoupper(substr($student->name, 0, 2)) }}
                        </div>
                        <img id="avatar-preview" src=""
                             style="display:none;width:100px;height:100px;border-radius:50%;object-fit:cover;border:3px solid #7c5cff;">
                    @endif

                    <label for="photo-input"
                           style="position:absolute;bottom:0;right:0;width:28px;height:28px;border-radius:50%;
                                  background:#7c5cff;color:#fff;display:flex;align-items:center;
                                  justify-content:center;cursor:pointer;border:2px solid #fff;">
                        <i class="fas fa-camera" style="font-size:11px;"></i>
                    </label>
                    <input type="file" id="photo-input" name="profile_photo" accept="image/*" style="display:none;">
                </div>

                <div class="fw-bold" style="font-size:16px;color:#ffffff;">{{ $student->name }}</div>
                <div style="font-size:12px;color:rgba(220,210,255,0.45);margin-bottom:12px;">{{ $student->email }}</div>

                <button type="submit" id="save-photo-btn"
                        class="btn btn-primary btn-sm btn-round w-100"
                        style="display:none;">
                    <i class="fas fa-save me-1"></i> Save Photo
                </button>
            </form>
        </div>

        {{-- OJT Summary Card --}}
        <div class="card card-round p-4">
            <h6 class="fw-bold mb-3" style="font-size:13px;color:#ffffff;">OJT Summary</h6>
            <div class="d-flex justify-content-between mb-2" style="font-size:13px;">
                <span style="color:rgba(220,210,255,0.55);">Required Hours</span>
                <span class="fw-semibold">{{ $student->required_hours ?? 500 }} hrs</span>
            </div>
            <div class="d-flex justify-content-between mb-2" style="font-size:13px;">
                <span style="color:rgba(220,210,255,0.55);">Completed</span>
                <span class="fw-semibold text-success">{{ number_format($student->hoursCompleted(), 2) }} hrs</span>
            </div>
            <div class="d-flex justify-content-between mb-3" style="font-size:13px;">
                <span style="color:rgba(220,210,255,0.55);">Remaining</span>
                <span class="fw-semibold text-danger">{{ number_format($student->hoursRemaining(), 2) }} hrs</span>
            </div>
            <div class="progress" style="height:6px;border-radius:10px;">
                <div class="progress-bar bg-success"
                     style="width:{{ $student->progressPercentage() }}%;border-radius:10px;"></div>
            </div>
            <div class="text-end mt-1" style="font-size:11px;color:rgba(220,210,255,0.45);">
                {{ $student->progressPercentage() }}% complete
            </div>

            <hr style="border-color:rgba(255,255,255,0.06);">

            <div class="mb-2" style="font-size:13px;">
                <span style="color:rgba(220,210,255,0.55);">Supervisor</span><br>
                <span class="fw-semibold">{{ $student->supervisor->name ?? '—' }}</span>
            </div>
            <div style="font-size:13px;">
                <span style="color:rgba(220,210,255,0.55);">Coordinator</span><br>
                <span class="fw-semibold">{{ $student->teacher->name ?? '—' }}</span>
            </div>
        </div>

    </div>

    {{-- Right: Edit Info --}}
    <div class="col-lg-8">
        <div class="card card-round">
            <div class="card-header d-flex align-items-center gap-2">
                <span style="width:32px;height:32px;border-radius:8px;background:rgba(124,92,255,.12);
                             display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-user-edit" style="color:#7c5cff;font-size:14px;"></i>
                </span>
                <span class="card-title mb-0">Edit Profile Information</span>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('student.profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:12px;color:rgba(220,210,255,0.65);">Full Name</label>
                            <input type="text" name="name" class="form-control" style="height:42px;"
                                   value="{{ old('name', $student->name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:12px;color:rgba(220,210,255,0.65);">Email Address</label>
                            <input type="email" name="email" class="form-control" style="height:42px;"
                                   value="{{ old('email', $student->email) }}" required>
                        </div>
                    </div>

                    <hr style="border-color:rgba(255,255,255,0.06);margin:20px 0;">
                    <p class="fw-semibold mb-3"
                       style="font-size:12px;color:rgba(220,210,255,0.65);text-transform:uppercase;letter-spacing:.05em;">
                        Change Password
                        <span class="fw-normal text-muted">(leave blank to keep current)</span>
                    </p>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold" style="font-size:12px;color:rgba(220,210,255,0.65);">Current Password</label>
                            <input type="password" name="current_password" class="form-control"
                                   style="height:42px;" placeholder="••••••••">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold" style="font-size:12px;color:rgba(220,210,255,0.65);">New Password</label>
                            <input type="password" name="password" class="form-control"
                                   style="height:42px;" placeholder="••••••••">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold" style="font-size:12px;color:rgba(220,210,255,0.65);">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                   style="height:42px;" placeholder="••••••••">
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary btn-round px-4">
                            <i class="fas fa-save me-2"></i>Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
document.getElementById('photo-input').addEventListener('change', function () {
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            var preview  = document.getElementById('avatar-preview');
            var initials = document.getElementById('avatar-initials');
            preview.src = e.target.result;
            preview.style.display = 'block';
            if (initials) initials.style.display = 'none';
            document.getElementById('save-photo-btn').style.display = 'block';
        };
        reader.readAsDataURL(this.files[0]);
    }
});
</script>
@endpush