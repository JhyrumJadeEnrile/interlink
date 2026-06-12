@extends('layouts.app')

@section('title', 'Buttons - Kaiadmin Bootstrap 5 Admin Dashboard')

@section('content')
<div class="page-header">
    <h3 class="fw-bold mb-3">Buttons</h3>
    <ul class="breadcrumbs mb-3">
        <li class="nav-home">
            <a href="{{ route('admin.dashboard') }}">
                <i class="icon-home"></i>
            </a>
        </li>
        <li class="separator">
            <i class="icon-arrow-right"></i>
        </li>
        <li class="nav-item">
            <a href="#">Base</a>
        </li>
        <li class="separator">
            <i class="icon-arrow-right"></i>
        </li>
        <li class="nav-item">
            <a href="#">Buttons</a>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Button Colors</h4>
            </div>
            <div class="card-body">
                <p class="demo">
                    <button class="btn btn-default">Default</button>
                    <button class="btn btn-primary">Primary</button>
                    <button class="btn btn-secondary">Secondary</button>
                    <button class="btn btn-info">Info</button>
                    <button class="btn btn-success">Success</button>
                    <button class="btn btn-warning">Warning</button>
                    <button class="btn btn-danger">Danger</button>
                    <button class="btn btn-link">Link</button>
                </p>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Button Sizing</h4>
            </div>
            <div class="card-body">
                <p class="demo">
                    <button class="btn btn-primary btn-lg">Large</button>
                    <button class="btn btn-primary">Normal</button>
                    <button class="btn btn-primary btn-sm">Small</button>
                    <button class="btn btn-primary btn-xs">Extra Small</button>
                </p>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Button Style</h4>
            </div>
            <div class="card-body">
                <p class="demo">
                    <button class="btn btn-primary btn-border">Border</button>
                    <button class="btn btn-primary btn-round">Round</button>
                    <button class="btn btn-primary btn-border btn-round">Border Round</button>
                    <button class="btn btn-primary btn-link">Link</button>
                </p>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Button States</h4>
            </div>
            <div class="card-body">
                <p class="demo">
                    <button class="btn btn-primary" disabled="disabled">Disabled</button>
                    <button class="btn btn-primary active">Active</button>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection