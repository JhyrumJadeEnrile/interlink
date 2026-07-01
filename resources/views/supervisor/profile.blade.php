@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3 text-white">Company Profile</h3>
                <h6 class="op-7 mb-2 text-white">Manage your supervisor settings and company information.</h6>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <!-- Sidebar: Profile Overview with Camera Overlay -->
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body text-center p-4">
                        <form action="{{ route('supervisor.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="position-relative d-inline-block">
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

                            <h3 class="fw-bold mt-3">{{ $supervisor->name ?? 'Supervisor' }}</h3>
                            <p class="text-muted">{{ '@' . strtolower(str_replace(' ', '', $supervisor->name ?? 'user')) }}</p>

                            <hr>

                            <!-- Form Inputs -->
                            <div class="text-start">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Company Name</label>
                                    <input type="text" name="company_name" class="form-control"
                                           value="{{ old('company_name', $supervisor->company_name ?? '') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Department</label>
                                    <input type="text" name="department" class="form-control"
                                           value="{{ old('department', $supervisor->department ?? '') }}">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-round w-100 mt-3">
                                Save Changes
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Panel: Future Chat/Updates -->
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header border-bottom">
                        <h4 class="card-title text-primary"><i class="fas fa-comments me-2"></i>Recent Activity</h4>
                    </div>
                    <div class="card-body p-4" id="chat-box">
                        <!-- AJAX messages will appear here -->
                        <p class="text-muted">Loading activities...</p>
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
            avatar.classList.remove('bg-primary');
        }
    };

    // 2. Example AJAX Fetch for Activity/Messages
    $(document).ready(function() {
        let contactId = 1; // Replace with dynamic ID
        $.ajax({
            url: '/chat/messages/' + contactId,
            type: 'GET',
            success: function(messages) {
                let chatBox = $('#chat-box');
                chatBox.empty();
                // Add your rendering logic here
                chatBox.append('<p class="text-muted">No new activities found.</p>');
            },
            error: function(xhr) {
                console.log("Error loading activity:", xhr.responseText);
            }
        });
    });
</script>
@endpush
