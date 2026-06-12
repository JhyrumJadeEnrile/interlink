@extends('layouts.app')

@section('title', 'Grid System - Kaiadmin Bootstrap 5 Admin Dashboard')

@section('content')
<div class="page-header">
    <h3 class="fw-bold mb-3">Grid System</h3>
    <ul class="breadcrumbs mb-3">
        <li class="nav-home">
            <a href="{{ url('/dashboard') }}">
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
            <a href="#">Grid System</a>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Base Grid System</h4>
            </div>
            <div class="card-body">
                <div class="row show-grid">
                    <div class="col-md-1"><span>.col-md-1</span></div>
                    <div class="col-md-1"><span>.col-md-1</span></div>
                    <div class="col-md-1"><span>.col-md-1</span></div>
                    <div class="col-md-1"><span>.col-md-1</span></div>
                    <div class="col-md-1"><span>.col-md-1</span></div>
                    <div class="col-md-1"><span>.col-md-1</span></div>
                    <div class="col-md-1"><span>.col-md-1</span></div>
                    <div class="col-md-1"><span>.col-md-1</span></div>
                    <div class="col-md-1"><span>.col-md-1</span></div>
                    <div class="col-md-1"><span>.col-md-1</span></div>
                    <div class="col-md-1"><span>.col-md-1</span></div>
                    <div class="col-md-1"><span>.col-md-1</span></div>
                </div>
                <div class="row show-grid">
                    <div class="col-md-8"><span>.col-md-8</span></div>
                    <div class="col-md-4"><span>.col-md-4</span></div>
                </div>
                <div class="row show-grid">
                    <div class="col-md-4"><span>.col-md-4</span></div>
                    <div class="col-md-4"><span>.col-md-4</span></div>
                    <div class="col-md-4"><span>.col-md-4</span></div>
                </div>
                <div class="row show-grid">
                    <div class="col-md-6"><span>.col-md-6</span></div>
                    <div class="col-md-6"><span>.col-md-6</span></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection