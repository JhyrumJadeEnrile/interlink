@extends('layouts.app')

@section('title', 'Widgets - Kaiadmin')

@section('content')
<div class="page-header">
  <h3 class="fw-bold mb-3">Widgets</h3>
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
      <a href="#">Widgets</a>
    </li>
  </ul>
</div>

<div class="row">
  <div class="col-md-4">
    <div class="card card-profile">
      <div class="card-header" style="background-image: url('{{ asset('assets/img/blogpost.jpg') }}')">
        <div class="profile-picture">
          <div class="avatar avatar-xl">
            <img src="{{ asset('assets/img/profile.jpg') }}" alt="..." class="avatar-img rounded-circle" />
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="user-profile text-center">
          <div class="name">Hizrian</div>
          <div class="job">Frontend Developer</div>
          <div class="desc">A man who loves web design</div>
          <div class="social-media">
            <a class="btn btn-info btn-twitter btn-sm btn-link" href="#">
              <span class="btn-label justify-content-center"><i class="fab fa-twitter"></i></span>
            </a>
            <a class="btn btn-primary btn-sm btn-link" href="#">
              <span class="btn-label justify-content-center"><i class="fab fa-facebook-f"></i></span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card card-round">
      <div class="card-body pb-0">
        <div class="h1 fw-bold float-end text-danger">-3%</div>
        <h2 class="mb-2">150</h2>
        <p class="text-muted">New Orders</p>
        <div class="pull-in text-center">
          <div id="widgetLineChart2"></div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card card-round">
      <div class="card-body pb-0">
        <div class="h1 fw-bold float-end text-warning">+8%</div>
        <h2 class="mb-2">$4,520</h2>
        <p class="text-muted">Total Earnings</p>
        <div class="pull-in text-center">
          <div id="widgetLineChart3"></div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  $(document).ready(function () {
    $("#widgetLineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
      type: "line",
      height: "70",
      width: "100%",
      lineWidth: "2",
      lineColor: "#f3545d",
      fillColor: "rgba(243, 84, 93, .14)",
    });

    $("#widgetLineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
      type: "line",
      height: "70",
      width: "100%",
      lineWidth: "2",
      lineColor: "#ffa534",
      fillColor: "rgba(255, 165, 52, .14)",
    });
  });
</script>
@endpush