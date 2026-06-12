@extends('layouts.app')

@section('title', 'Google Maps - Kaiadmin Bootstrap 5 Admin Dashboard')

@section('content')
<div class="page-header">
    <h3 class="fw-bold mb-3">Google Maps</h3>
    <ul class="breadcrumbs mb-3">
        <li class="nav-home"><a href="{{ url('/dashboard') }}"><i class="icon-home"></i></a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Maps</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Google Maps</a></li>
    </ul>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Our Location</div>
            </div>
            <div class="card-body">
                <div id="map" style="width:100%;height:400px; background: #e5e3df;"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function initMap() {
        var myLatLng = {lat: 14.5243, lng: 121.0509}; // Coordinates default
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 14,
            center: myLatLng
        });
        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: 'Workspace Location'
        });
    }
</script>
@endpush