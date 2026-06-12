@extends('layouts.app')

@section('title', 'Avatars - Kaiadmin Bootstrap 5 Admin Dashboard')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <h3 class="fw-bold mb-3">Avatars</h3>
        <ul class="breadcrumbs mb-3">
            <li class="nav-home"><a href="{{ url('/dashboard') }}"><i class="icon-home"></i></a></li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Base</a></li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Avatars</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Sizing</h4>
                </div>
                <div class="card-body">
                    <div class="demo d-flex flex-wrap gap-3">
                        <div class="avatar avatar-xxl">
                            <img src="{{ asset('assets/img/jm_denis.jpg') }}" alt="..." class="avatar-img rounded-circle">
                        </div>
                        <div class="avatar avatar-xl">
                            <img src="{{ asset('assets/img/jm_denis.jpg') }}" alt="..." class="avatar-img rounded-circle">
                        </div>
                        <div class="avatar avatar-lg">
                            <img src="{{ asset('assets/img/jm_denis.jpg') }}" alt="..." class="avatar-img rounded-circle">
                        </div>
                        <div class="avatar">
                            <img src="{{ asset('assets/img/jm_denis.jpg') }}" alt="..." class="avatar-img rounded-circle">
                        </div>
                        <div class="avatar avatar-sm">
                            <img src="{{ asset('assets/img/jm_denis.jpg') }}" alt="..." class="avatar-img rounded-circle">
                        </div>
                        <div class="avatar avatar-xs">
                            <img src="{{ asset('assets/img/jm_denis.jpg') }}" alt="..." class="avatar-img rounded-circle">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Status Indicator</h4>
                </div>
                <div class="card-body">
                    <div class="demo d-flex gap-3 align-items-center">
                        <div class="avatar avatar-online">
                            <img src="{{ asset('assets/img/jm_denis.jpg') }}" alt="..." class="avatar-img rounded-circle">
                        </div>
                        <div class="avatar avatar-offline">
                            <img src="{{ asset('assets/img/jm_denis.jpg') }}" alt="..." class="avatar-img rounded-circle">
                        </div>
                        <div class="avatar avatar-away">
                            <img src="{{ asset('assets/img/jm_denis.jpg') }}" alt="..." class="avatar-img rounded-circle">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Shape</h4>
                </div>
                <div class="card-body">
                    <div class="demo d-flex gap-3 align-items-center">
                        <div class="avatar">
                            <img src="{{ asset('assets/img/jm_denis.jpg') }}" alt="..." class="avatar-img rounded">
                        </div>
                        <div class="avatar">
                            <img src="{{ asset('assets/img/jm_denis.jpg') }}" alt="..." class="avatar-img rounded-circle">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Group</h4>
                </div>
                <div class="card-body">
                    <div class="demo">
                        <div class="avatar-group">
                            <div class="avatar">
                                <img src="{{ asset('assets/img/jm_denis.jpg') }}" alt="..." class="avatar-img rounded-circle border border-white">
                            </div>
                            <div class="avatar">
                                <img src="{{ asset('assets/img/chadengle.jpg') }}" alt="..." class="avatar-img rounded-circle border border-white">
                            </div>
                            <div class="avatar">
                                <img src="{{ asset('assets/img/mlane.jpg') }}" alt="..." class="avatar-img rounded-circle border border-white">
                            </div>
                            <div class="avatar">
                                <span class="avatar-title rounded-circle border border-white">CF</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection