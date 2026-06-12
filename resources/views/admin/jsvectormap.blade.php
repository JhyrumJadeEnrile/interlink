@extends('layouts.app')

@section('title', 'Jsvectormap - Kaiadmin Bootstrap 5 Admin Dashboard')

@section('content')
<div class="page-header">
    <h3 class="fw-bold mb-3">Vector Maps</h3>
    <ul class="breadcrumbs mb-3">
        <li class="nav-home"><a href="{{ url('/dashboard') }}"><i class="icon-home"></i></a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Maps</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">JSVectorMap</a></li>
    </ul>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">World Map</div>
            </div>
            <div class="card-body">
                <div id="world-map" style="height: 450px;"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    var world_map = new jsVectorMap({
        selector: "#world-map",
        map: "world",
        zoomOnScroll: false,
        regionStyle: {
            hover: { fill: "#435ebe" },
        },
        markers: [
            { name: "Indonesia", coords: [-6.229728, 106.6894311], style: { fill: "#435ebe" } },
            { name: "United States", coords: [38.8936708, -77.1546604], style: { fill: "#28ab55" } }
        ],
    });
</script>
@endpush