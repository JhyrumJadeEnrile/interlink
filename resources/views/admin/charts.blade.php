@extends('layouts.app')

@section('title', 'Charts - Kaiadmin Bootstrap 5 Admin Dashboard')

@section('content')
<div class="page-header">
    <h3 class="fw-bold mb-3">Chart.js</h3>
    <ul class="breadcrumbs mb-3">
        <li class="nav-home"><a href="{{ url('/dashboard') }}"><i class="icon-home"></i></a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Charts</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Chart.js</a></li>
    </ul>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Line Chart</div>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="lineChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Bar Chart</div>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="barChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    var lineChart = document.getElementById('lineChart').getContext('2d'),
        barChart = document.getElementById('barChart').getContext('2d');

    var myLineChart = new Chart(lineChart, {
        type: 'line',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
            datasets: [{
                label: "Active Users",
                borderColor: "#1d7af3",
                pointBorderColor: "#FFF",
                pointBackgroundColor: "#1d7af3",
                pointBorderWidth: 2,
                pointHoverRadius: 4,
                pointHoverBorderWidth: 1,
                pointRadius: 4,
                backgroundColor: 'transparent',
                fill: true,
                borderWidth: 2,
                data: [542, 480, 430, 550, 530, 453]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    var myBarChart = new Chart(barChart, {
        type: 'bar',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
            datasets: [{
                label: "Enrollments",
                backgroundColor: '#1d7af3',
                borderColor: '#1d7af3',
                data: [3, 2, 9, 5, 4, 6],
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
        }
    });
</script>
@endpush