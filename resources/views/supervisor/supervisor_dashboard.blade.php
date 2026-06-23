@extends('layouts.app')

@section('title', 'Supervisor Dashboard | InternLink')

@section('content')
<div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4 justify-content-between">
        <div class="d-flex align-items-center mb-3 mb-md-0">
            <!-- Profile Photo Upload Section -->
            <div class="avatar avatar-xl position-relative me-3 group">
                <img src="{{ Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : 'https://via.placeholder.com/100' }}" alt="Profile Photo" class="avatar-img rounded-circle border border-2 border-primary" style="width: 70px; height: 70px; object-fit: cover;">
                <form action="{{ route('profile.photo.update') }}" method="POST" enctype="multipart/form-data" class="position-absolute bottom-0 end-0 m-0">
                    @csrf
                    <label for="supervisorPhotoInput" class="btn btn-primary btn-sm btn-round p-1 d-flex align-items-center justify-content-center shadow-sm" style="width: 26px; height: 26px; cursor: pointer; border-radius: 50%;">
                        <i class="fas fa-camera" style="font-size: 11px;"></i>
                    </label>
                    <input type="file" id="supervisorPhotoInput" name="profile_photo" class="d-none" onchange="this.form.submit()">
                </form>
            </div>
            <div>
                <h3 class="fw-bold mb-1">Supervisor Dashboard</h3>
                <h6 class="op-7 mb-0">Track and review your company trainees' hours and deployment logs.</h6>
            </div>
        </div>

        <!-- 🌟 BINAGO: May kasama nang window.location onclick para lumaktaw sa theme blocks -->
        <div class="mt-3 mt-md-0">
            <a href="{{ route('students.create') }}"
               onclick="window.location.href='{{ route('students.create') }}'; return true;"
               class="btn btn-primary btn-round px-4">
                <i class="fa fa-plus me-1"></i> Add Student
            </a>
        </div>
    </div>

    @php
        $activeCount = $students->count();
        $totalHours = 0;
        $onTrackCount = 0;
        $atRiskCount = 0;
        $behindCount = 0;
        $completedCount = 0;

        foreach($students as $student) {
            $completed = $student->timeLogs->where('status', 'approved')->sum('hours');
            $required = $student->required_hours ?? 500;
            $totalHours += $completed;

            $pct = ($completed / max($required, 1)) * 100;
            if($pct >= 100) $completedCount++;
            elseif($pct >= 75) $onTrackCount++;
            elseif($pct >= 50) $atRiskCount++;
            else $behindCount++;
        }

        $avgHours = $activeCount > 0 ? round($totalHours / $activeCount) : 0;
        $avgProgress = $activeCount > 0 ? round(($totalHours / ($activeCount * 500)) * 100) : 0;
    @endphp

    {{-- Metrics Grid --}}
    <div class="row">
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-primary bubble-shadow-small"><i class="fas fa-clock"></i></div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Total Hours Rendered</p>
                                <h4 class="card-title">{{ number_format($totalHours) }} hrs</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-info bubble-shadow-small"><i class="fas fa-users"></i></div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Managed Trainees</p>
                                <h4 class="card-title">{{ $activeCount }} Active</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-success bubble-shadow-small"><i class="fas fa-chart-line"></i></div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Average Hours</p>
                                <h4 class="card-title">{{ $avgHours }} hrs</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-secondary bubble-shadow-small"><i class="fas fa-percentage"></i></div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Avg. Progress Rate</p>
                                <h4 class="card-title">{{ $avgProgress }}%</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Block --}}
    <div class="row">
        <div class="col-md-8">
            <div class="card card-round">
                <div class="card-header"><div class="card-title">Trainee Hours Breakdown</div></div>
                <div class="card-body">
                    <div class="chart-container" style="min-height: 380px;">
                        <canvas id="studentHoursChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-round">
                <div class="card-header"><div class="card-title">Progress Distribution</div></div>
                <div class="card-body">
                    <div class="chart-container" style="min-height: 380px;">
                        <canvas id="progressDistributionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Dynamic Datatable --}}
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card card-round">
                <div class="card-header"><div class="card-title">Trainee Operational Progress Tracker</div></div>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const labels = {!! json_encode($students->pluck('name')) !!};
        const hoursData = {!! json_encode($students->map(fn($s) => $s->timeLogs->where('status', 'approved')->sum('hours'))) !!};

        const ctxBar = document.getElementById('studentHoursChart');
        if(ctxBar) {
            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Rendered Hours',
                        data: hoursData,
                        backgroundColor: 'rgba(29, 122, 243, 0.85)',
                        borderColor: 'rgba(29, 122, 243, 1)',
                        borderWidth: 1
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });
        }

        const ctxDoughnut = document.getElementById('progressDistributionChart');
        if(ctxDoughnut) {
            new Chart(ctxDoughnut, {
                type: 'doughnut',
                data: {
                    labels: ['On Track', 'At Risk', 'Behind', 'Completed'],
                    datasets: [{
                        data: [{{ $onTrackCount }}, {{ $atRiskCount }}, {{ $behindCount }}, {{ $completedCount }}],
                        backgroundColor: ['#28c76f', '#ffa633', '#e94d5f', '#6861ce']
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });
        }
    });
</script>
@endpush
