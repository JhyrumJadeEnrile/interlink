@extends('layouts.app')

@section('title', 'Sparkline - Kaiadmin Bootstrap 5 Admin Dashboard')

@section('content')
<div class="page-header">
    <h3 class="fw-bold mb-3">Sparkline</h3>
    <ul class="breadcrumbs mb-3">
        <li class="nav-home"><a href="{{ url('/dashboard') }}"><i class="icon-home"></i></a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Charts</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Sparkline</a></li>
    </ul>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Line Sparkline</div>
            </div>
            <div class="card-body text-center">
                <div id="lineChart"></div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Bar Sparkline</div>
            </div>
            <div class="card-body text-center">
                <div id="barChart"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $("#lineChart").sparkline([102, 109, 120, 99, 110, 80, 87, 74], {
        type: "line",
        height: "100",
        width: "250",
        lineWidth: "2",
        lineColor: "#177dff",
        fillColor: "rgba(23, 125, 255, 0.2)",
    });

    $("#barChart").sparkline([102, 109, 120, 99, 110, 80, 87, 74], {
        type: "bar",
        height: "100",
        barWidth: 9,
        barSpacing: 10,
        barColor: "#177dff",
    });
</script>
@endpush