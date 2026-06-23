@extends('layouts.app')

@section('title', 'Academic Adviser Dashboard | InternLink')

@section('content')
<div class="page-inner">
    <!-- 🌟 UPDATED: Added alignment wrappers to push the button cleanly to the far right -->
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4 justify-content-between">
        <div class="d-flex align-items-center mb-3 mb-md-0">
            <!-- Profile Photo Upload Section -->
            <div class="avatar avatar-xl position-relative me-3 group">
                <img src="{{ Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : 'https://via.placeholder.com/100' }}" alt="Profile Photo" class="avatar-img rounded-circle border border-2 border-primary" style="width: 70px; height: 70px; object-fit: cover;">
                <form action="{{ route('profile.photo.update') }}" method="POST" enctype="multipart/form-data" class="position-absolute bottom-0 end-0 m-0">
                    @csrf
                    <label for="teacherPhotoInput" class="btn btn-primary btn-sm btn-round p-1 d-flex align-items-center justify-content-center shadow-sm" style="width: 26px; height: 26px; cursor: pointer; border-radius: 50%;">
                        <i class="fas fa-camera" style="font-size: 11px;"></i>
                    </label>
                    <input type="file" id="teacherPhotoInput" name="profile_photo" class="d-none" onchange="this.form.submit()">
                </form>
            </div>
            <div>
                <h3 class="fw-bold mb-1">Academic Adviser Dashboard</h3>
                <h6 class="op-7 mb-0">Monitor student curriculum internship hours and weekly journal compliance logs.</h6>
            </div>
        </div>

        <!-- 🌟 ADDED: Shared creation page action button link -->
        <div class="mt-3 mt-md-0">
            <a href="{{ route('students.create') }}" class="btn btn-primary btn-round px-4">
                <i class="fa fa-plus me-1"></i> Add Student
            </a>
        </div>
    </div>

    @php
        $studentCount = $students->count();
        $totalHoursSum = 0;
        foreach($students as $student) {
            $totalHoursSum += $student->timeLogs->where('status', 'approved')->sum('hours');
        }
        $avgProgress = $studentCount > 0 ? round((($totalHoursSum / $studentCount) / 500) * 100) : 0;
    @endphp

    {{-- Academic Evaluation Metrics --}}
    <div class="row">
        <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-info bubble-shadow-small"><i class="fas fa-user-graduate"></i></div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Assigned OJT Students</p>
                                <h4 class="card-title">{{ $studentCount }} Registered</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-success bubble-shadow-small"><i class="fas fa-check-double"></i></div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Total Validated Hours</p>
                                <h4 class="card-title">{{ number_format($totalHoursSum) }} Accumulative</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-primary bubble-shadow-small"><i class="fas fa-graduation-cap"></i></div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Class Syllabus Progress</p>
                                <h4 class="card-title">{{ $avgProgress }}% Avg Rate</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Student Compliance Table Modules --}}
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card card-round">
                <div class="card-header"><div class="card-title">Academic Student Roster Compliance Table</div></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Student Name</th>
                                    <th>Coordinator</th>
                                    <th>Completed Hours</th>
                                    <th>Required Hours</th>
                                    <th>Progress</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                <tr>
                                    <td><strong>{{ $student->name }}</strong></td>
                                    <td>{{ $student->coordinator->name ?? 'N/A' }}</td>
                                    @php
                                        $approvedHours = $student->timeLogs->where('status', 'approved')->sum('hours');
                                        $requiredHours = $student->required_hours ?? 500;
                                        $percentage = min(($approvedHours / max($requiredHours, 1)) * 100, 100);
                                    @endphp
                                    <td>{{ $approvedHours }} hrs</td>
                                    <td>{{ $requiredHours }} hrs</td>
                                    <td>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percentage }}%;"></div>
                                        </div>
                                        <small>{{ round($percentage) }}%</small>
                                    </td>
                                    <td>
                                        <span class="badge {{ $percentage >= 75 ? 'bg-success' : ($percentage >= 50 ? 'bg-warning' : 'bg-danger') }}">
                                            {{ $percentage >= 75 ? 'On Track' : ($percentage >= 50 ? 'At Risk' : 'Behind') }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
