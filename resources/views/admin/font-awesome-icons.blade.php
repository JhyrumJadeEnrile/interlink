@extends('layouts.app')

@section('title', 'Font Awesome - Kaiadmin Bootstrap 5 Admin Dashboard')

@section('content')
<div class="page-header">
    <h3 class="fw-bold mb-3">Font Awesome Icons</h3>
    <ul class="breadcrumbs mb-3">
        <li class="nav-home"><a href="{{ url('/dashboard') }}"><i class="icon-home"></i></a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Icons</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Font Awesome</a></li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Solid Icons</h4>
            </div>
            <div class="card-body">
                <div class="row demo-icon-list" id="row-demo-icon">
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    var iconClass = ["fas fa-address-book", "fas fa-address-card", "fas fa-adjust", "fas fa-align-center", "fas fa-align-justify", "fas fa-align-left", "fas fa-anchor", "fas fa-archive"];
    for (var i = 0; i < iconClass.length; i++) {
        $("#row-demo-icon").append('<div class="col-md-3 col-sm-4"><div class="demo-icon"><div class="preview-icon"><i class="' + iconClass[i] + '"></i></div><div class="name-icon">' + iconClass[i] + '</div></div></div>');
    }
</script>
@endpush