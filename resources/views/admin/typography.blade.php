@extends('layouts.app')

@section('title', 'Typography - Kaiadmin Bootstrap 5 Admin Dashboard')

@section('content')
<div class="page-header">
    <h3 class="fw-bold mb-3">Typography</h3>
    <ul class="breadcrumbs mb-3">
        <li class="nav-home"><a href="{{ url('/dashboard') }}"><i class="icon-home"></i></a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Base</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Typography</a></li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Headings</h4>
            </div>
            <div class="card-body">
                <h1>H1 Heading</h1>
                <h2>H2 Heading</h2>
                <h3>H3 Heading</h3>
                <h4>H4 Heading</h4>
                <h5>H5 Heading</h5>
                <h6>H6 Heading</h6>
            </div>
        </div>
    </div>
</div>
@endsection