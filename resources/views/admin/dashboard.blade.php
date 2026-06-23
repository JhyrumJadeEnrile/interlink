@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Dashboard</h3>
            <h6 class="op-7 mb-2">Professional student hours analytics and learning performance.</h6>
        </div>
        <div class="ms-md-auto py-2 py-md-0">
            <a href="#" class="btn btn-label-info btn-round me-2">Manage</a>
            <!-- 🌟 BINAGO: Pinalitan ang href mula sa # papunta sa totoong route link na may window.location bypass -->
            <a href="{{ route('students.create') }}"
               onclick="window.location.href='{{ route('students.create') }}'; return true;"
               class="btn btn-primary btn-round">
                Add Student
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-primary bubble-shadow-small">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Total Hours</p>
                                <h4 class="card-title">2,520</h4>
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
                            <div class="icon-big text-center icon-info bubble-shadow-small">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Active Students</p>
                                <h4 class="card-title">24</h4>
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
                            <div class="icon-big text-center icon-success bubble-shadow-small">
                                <i class="fas fa-chart-line"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Average Hours</p>
                                <h4 class="card-title">315</h4>
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
                            <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Top Student</p>
                                <h4 class="card-title">Mia</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">Student Hours</div>
                        <div class="card-tools">
                            <a href="#" class="btn btn-label-success btn-round btn-sm me-2">
                                <span class="btn-label"><i class="fa fa-download"></i></span>
                                Export
                            </a>
                            <a href="#" class="btn btn-label-info btn-round btn-sm">
                                <span class="btn-label"><i class="fa fa-print"></i></span>
                                Print
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="min-height: 420px;">
                        <canvas id="studentHoursChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-primary card-round">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">Performance Summary</div>
                    </div>
                    <div class="card-category">This week</div>
                </div>
                <div class="card-body pb-0">
                    <div class="mb-4 mt-2">
                        <h1>92%</h1>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>Attendance</div>
                                <div><strong>95%</strong></div>
                            </div>
                            <div class="progress progress-sm mt-2">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 95%;" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>Assignments</div>
                                <div><strong>88%</strong></div>
                            </div>
                            <div class="progress progress-sm mt-2">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 88%;" aria-valuenow="88" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>Learning Goal</div>
                                <div><strong>75%</strong></div>
                            </div>
                            <div class="progress progress-sm mt-2">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-round">
                <div class="card-body pb-0">
                    <div class="h1 fw-bold float-end text-primary">+8%</div>
                    <h2 class="mb-2">Weekly Growth</h2>
                    <p class="text-muted">Hours increased compared to last week.</p>
                    <div class="pull-in sparkline-fix">
                        <div id="lineSparkline"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Status Overview -->
    <div class="row mt-3">
        <div class="col-sm-6 col-md-2">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="text-center">
                        <div class="icon-big text-center icon-success bubble-shadow-small mb-2">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <p class="card-category text-success">On Track</p>
                        <h4 class="card-title">18</h4>
                        <small class="text-muted">75% completion</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-2">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="text-center">
                        <div class="icon-big text-center icon-warning bubble-shadow-small mb-2">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <p class="card-category text-warning">At Risk</p>
                        <h4 class="card-title">4</h4>
                        <small class="text-muted">50-74% completion</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-2">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="text-center">
                        <div class="icon-big text-center icon-danger bubble-shadow-small mb-2">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <p class="card-category text-danger">Behind</p>
                        <h4 class="card-title">2</h4>
                        <small class="text-muted">&lt;50% completion</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-2">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="text-center">
                        <div class="icon-big text-center icon-info bubble-shadow-small mb-2">
                            <i class="fas fa-check-double"></i>
                        </div>
                        <p class="card-category text-info">Completed</p>
                        <h4 class="card-title">0</h4>
                        <small class="text-muted">100% completion</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-2">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="text-center">
                        <div class="icon-big text-center icon-secondary bubble-shadow-small mb-2">
                            <i class="fas fa-users"></i>
                        </div>
                        <p class="card-category text-secondary">Total Students</p>
                        <h4 class="card-title">24</h4>
                        <small class="text-muted">Active</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-2">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="text-center">
                        <div class="icon-big text-center icon-primary bubble-shadow-small mb-2">
                            <i class="fas fa-percentage"></i>
                        </div>
                        <p class="card-category text-primary">Avg. Progress</p>
                        <h4 class="card-title">79%</h4>
                        <small class="text-muted">Class average</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Comparison Chart -->
    <div class="row mt-3">
        <div class="col-md-6">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-title">Progress Distribution</div>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="min-height: 300px;">
                        <canvas id="progressDistributionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-title">Completion Timeline</div>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="min-height: 300px;">
                        <canvas id="completionTimelineChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Progress Table -->
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">Student Progress Tracking</div>
                        <div class="card-tools">
                            <div class="form-group form-inline">
                                <input type="text" class="form-control form-control-sm" placeholder="Search student..." />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped text-white">
                            <thead>
                                <tr>
                                    <th>Student Name</th>
                                    <th>Coordinator</th>
                                    <th>Completed Hours</th>
                                    <th>Required Hours</th>
                                    <th>Progress</th>
                                    <th>Status</th>
                                    <th>Days Remaining</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Mason Garcia</strong></td>
                                    <td>Ms. Johnson</td>
                                    <td>500 hrs</td>
                                    <td>500 hrs</td>
                                    <td>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <small>100%</small>
                                    </td>
                                    <td><span class="badge bg-success">Completed</span></td>
                                    <td><small class="text-success">✓ Finished</small></td>
                                </tr>
                                <tr>
                                    <td><strong>Liam Wilson</strong></td>
                                    <td>Mr. Smith</td>
                                    <td>450 hrs</td>
                                    <td>500 hrs</td>
                                    <td>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 90%;" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <small>90%</small>
                                    </td>
                                    <td><span class="badge bg-success">On Track</span></td>
                                    <td><small>12 days</small></td>
                                </tr>
                                <tr>
                                    <td><strong>Emma Johnson</strong></td>
                                    <td>Ms. Davis</td>
                                    <td>420 hrs</td>
                                    <td>500 hrs</td>
                                    <td>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 84%;" aria-valuenow="84" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <small>84%</small>
                                    </td>
                                    <td><span class="badge bg-success">On Track</span></td>
                                    <td><small>18 days</small></td>
                                </tr>
                                <tr>
                                    <td><strong>Ava Anderson</strong></td>
                                    <td>Mr. Taylor</td>
                                    <td>410 hrs</td>
                                    <td>500 hrs</td>
                                    <td>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 82%;" aria-valuenow="82" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <small>82%</small>
                                    </td>
                                    <td><span class="badge bg-success">On Track</span></td>
                                    <td><small>21 days</small></td>
                                </tr>
                                <tr>
                                    <td><strong>Noah Davis</strong></td>
                                    <td>Ms. Johnson</td>
                                    <td>390 hrs</td>
                                    <td>500 hrs</td>
                                    <td>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 78%;" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <small>78%</small>
                                    </td>
                                    <td><span class="badge bg-success">On Track</span></td>
                                    <td><small>24 days</small></td>
                                </tr>
                                <tr>
                                    <td><strong>Sophia Martinez</strong></td>
                                    <td>Mr. Brown</td>
                                    <td>320 hrs</td>
                                    <td>500 hrs</td>
                                    <td>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 64%;" aria-valuenow="64" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <small>64%</small>
                                    </td>
                                    <td><span class="badge bg-warning">At Risk</span></td>
                                    <td><small class="text-warning">⚠ 35 days</small></td>
                                </tr>
                                <tr>
                                    <td><strong>Olivia Brown</strong></td>
                                    <td>Ms. Wilson</td>
                                    <td>280 hrs</td>
                                    <td>500 hrs</td>
                                    <td>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 56%;" aria-valuenow="56" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <small>56%</small>
                                    </td>
                                    <td><span class="badge bg-danger">Behind</span></td>
                                    <td><small class="text-danger">⚠ 45 days</small></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alerts Section -->
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-title">Progress Alerts & Recommendations</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-white mb-3"><i class="fas fa-exclamation-circle text-danger me-2"></i> Critical Alerts</h6>
                            <div class="alert alert-danger alert-with-icon" data-notify="container">
                                <span data-notify="icon" class="notify-icon fas fa-exclamation-triangle"></span>
                                <span data-notify="message">
                                    <b>Olivia Brown</b> is 45 days behind schedule (56% completion). Immediate intervention recommended.
                                </span>
                            </div>
                            <div class="alert alert-warning alert-with-icon" data-notify="container">
                                <span data-notify="icon" class="notify-icon fas fa-clock"></span>
                                <span data-notify="message">
                                    <b>Sophia Martinez</b> showing low activity. Last submission 3 days ago.
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-white mb-3"><i class="fas fa-star text-success me-2"></i> Positive Highlights</h6>
                            <div class="alert alert-success alert-with-icon" data-notify="container">
                                <span data-notify="icon" class="notify-icon fas fa-check-circle"></span>
                                <span data-notify="message">
                                    <b>Mason Garcia</b> completed all required hours! (100% completion)
                                </span>
                            </div>
                            <div class="alert alert-info alert-with-icon" data-notify="container">
                                <span data-notify="icon" class="notify-icon fas fa-chart-line"></span>
                                <span data-notify="message">
                                    Class average progress improved by 8% this week. On target for completion by end of program.
                                </span>
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
    document.addEventListener('DOMContentLoaded', function () {
        // Student Hours Chart
        var studentCanvas = document.getElementById('studentHoursChart');
        if (studentCanvas) {
            new Chart(studentCanvas, {
                type: 'bar',
                data: {
                    labels: ['Ava', 'Noah', 'Liam', 'Emma', 'Sophia', 'Mason', 'Olivia'],
                    datasets: [{
                        label: 'Hours',
                        data: [380, 460, 310, 480, 390, 500, 330],
                        backgroundColor: [
                            'rgba(29, 122, 243, 0.85)',
                            'rgba(40, 199, 111, 0.85)',
                            'rgba(255, 166, 51, 0.85)',
                            'rgba(233, 77, 95, 0.85)',
                            'rgba(102, 102, 255, 0.85)',
                            'rgba(172, 60, 247, 0.85)',
                            'rgba(0, 194, 206, 0.85)'
                        ],
                        borderColor: [
                            'rgba(29, 122, 243, 1)',
                            'rgba(40, 199, 111, 1)',
                            'rgba(255, 166, 51, 1)',
                            'rgba(233, 77, 95, 1)',
                            'rgba(102, 102, 255, 1)',
                            'rgba(172, 60, 247, 1)',
                            'rgba(0, 194, 206, 1)'
                        ],
                        borderWidth: 1,
                        maxBarThickness: 48
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            min: 0,
                            max: 500,
                            ticks: {
                                stepSize: 100
                            },
                            title: {
                                display: true,
                                text: 'Hours'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Students'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y + ' hours';
                                }
                            }
                        }
                    }
                }
            });
        }

        // Progress Distribution Chart (Doughnut)
        var progressDistributionCanvas = document.getElementById('progressDistributionChart');
        if (progressDistributionCanvas) {
            new Chart(progressDistributionCanvas, {
                type: 'doughnut',
                data: {
                    labels: ['On Track (75%+)', 'At Risk (50-74%)', 'Behind (<50%)', 'Completed'],
                    datasets: [{
                        data: [18, 4, 2, 0],
                        backgroundColor: [
                            'rgba(40, 199, 111, 0.85)',
                            'rgba(255, 166, 51, 0.85)',
                            'rgba(233, 77, 95, 0.85)',
                            'rgba(29, 122, 243, 0.85)'
                        ],
                        borderColor: [
                            'rgba(40, 199, 111, 1)',
                            'rgba(255, 166, 51, 1)',
                            'rgba(233, 77, 95, 1)',
                            'rgba(29, 122, 243, 1)'
                        ],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 15,
                                font: {
                                    size: 12
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': ' + context.parsed + ' students';
                                }
                            }
                        }
                    }
                }
            });
        }

        // Completion Timeline Chart (Line)
        var completionTimelineCanvas = document.getElementById('completionTimelineChart');
        if (completionTimelineCanvas) {
            new Chart(completionTimelineCanvas, {
                type: 'line',
                data: {
                    labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6', 'Week 7', 'Week 8'],
                    datasets: [{
                        label: 'Class Average Completion %',
                        data: [15, 28, 42, 55, 65, 72, 78, 79],
                        borderColor: 'rgba(29, 122, 243, 1)',
                        backgroundColor: 'rgba(29, 122, 243, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 5,
                        pointBackgroundColor: 'rgba(29, 122, 243, 1)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointHoverRadius: 7
                    },
                    {
                        label: 'Target Progress Line',
                        data: [12.5, 25, 37.5, 50, 62.5, 75, 87.5, 100],
                        borderColor: 'rgba(40, 199, 111, 0.7)',
                        backgroundColor: 'rgba(40, 199, 111, 0)',
                        borderWidth: 2,
                        borderDash: [5, 5],
                        fill: false,
                        tension: 0.4,
                        pointRadius: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            min: 0,
                            max: 100,
                            ticks: {
                                stepSize: 20,
                                suffix: '%'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                padding: 15
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.parsed.y + '%';
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
