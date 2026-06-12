@extends('layouts.app')

@section('title', 'Simple Line Icons - Kaiadmin Bootstrap 5 Admin Dashboard')

@section('content')
<div class="page-header">
    <h3 class="fw-bold mb-3">Simple Line Icons</h3>
    <ul class="breadcrumbs mb-3">
        <li class="nav-home"><a href="{{ url('/dashboard') }}"><i class="icon-home"></i></a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Icons</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Simple Line Icons</a></li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">List of Simple Line Icons</h4>
            </div>
            <div class="card-body">
                <div class="row demo-icon-list" id="row-simple-line-icon">
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    var lineIcons = ["icon-user", "icon-people", "icon-user-female", "icon-user-follow", "icon-user-unfollow", "icon-login", "icon-logout", "icon-home", "icon-grid", "icon-settings"];
    for (var i = 0; i < lineIcons.length; i++) {
        $("#row-simple-line-icon").append('<div class="col-md-3 col-sm-4"><div class="demo-icon"><div class="preview-icon"><i class="' + lineIcons[i] + '"></i></div><div class="name-icon">' + lineIcons[i] + '</div></div></div>');
    }
</script>
@endpush