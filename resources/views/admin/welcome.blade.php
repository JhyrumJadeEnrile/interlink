@extends('layouts.app')

@section('title', 'Welcome - Kaiadmin Bootstrap 5 Admin Dashboard')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <h2 class="fw-bold mb-2">Welcome to Kaiadmin</h2>
        <p class="text-muted mb-4">A clean, professional admin dashboard template adapted for your Laravel app.</p>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card card-round">
                <div class="card-body">
                    <h4 class="card-title">Get started quickly</h4>
                    <p class="card-category text-muted">Use the navigation to explore dashboard features, avatars, widgets, and more.</p>
                    <div class="d-flex gap-2 flex-wrap mt-4">
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-round">Open Dashboard</a>
                        <a href="{{ route('admin.avatars') }}" class="btn btn-outline-primary btn-round">View Avatars</a>
                        <a href="{{ route('admin.widgets') }}" class="btn btn-outline-secondary btn-round">Widget Gallery</a>
                    </div>
                </div>
            </div>

            <div class="card card-round">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="mb-1">Project status</h5>
                            <span class="text-muted">Ready for customization and data integration.</span>
                        </div>
                        <div class="avatar avatar-online avatar-sm">
                            <span class="avatar-title rounded-circle">OK</span>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 85%;" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <span class="text-muted">85% complete</span>
                            <span class="text-muted">Customization ready</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card card-round h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h4 class="card-title">Powerful admin layout</h4>
                        <p class="card-category text-muted">Built for responsive dashboards, quick overviews, and easy navigation.</p>
                    </div>
                    <div class="mt-4">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Flexible layout
                                <span class="badge bg-primary">Ready</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Reusable components
                                <span class="badge bg-success">Fast</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Laravel Blade support
                                <span class="badge bg-info">Configured</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
