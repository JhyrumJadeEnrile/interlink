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
            <a href="#" class="btn btn-primary btn-round">Add Student</a>
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
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
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
    });
</script>
@endpush