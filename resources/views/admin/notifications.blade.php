@extends('layouts.app')

@section('title', 'Notifications - Kaiadmin Bootstrap 5 Admin Dashboard')

@section('content')
<div class="page-header">
    <h3 class="fw-bold mb-3">Notifications</h3>
    <ul class="breadcrumbs mb-3">
        <li class="nav-home"><a href="{{ url('/dashboard') }}"><i class="icon-home"></i></a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Base</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Notifications</a></li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Bootstrap Notify state</div>
            </div>
            <div class="card-body">
                <div class="form">
                    <div class="form-group form-show-notify row">
                        <div class="col-lg-3 col-md-3 col-sm-4 text-end">
                            <label>Placement :</label>
                        </div>
                        <div class="col-lg-4 col-md-9 col-sm-8">
                            <select class="form-select input-fixed" id="notify_placement_from">
                                <option value="top">Top</option>
                                <option value="bottom">Bottom</option>
                            </select>
                            <select class="form-select input-fixed" id="notify_placement_align">
                                <option value="left">Left</option>
                                <option value="right" selected>Right</option>
                                <option value="center">Center</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-show-notify row">
                        <div class="col-lg-3 col-md-3 col-sm-4 text-end">
                            <label>State :</label>
                        </div>
                        <div class="col-lg-4 col-md-9 col-sm-8">
                            <select class="form-select input-fixed" id="notify_state">
                                <option value="primary">Primary</option>
                                <option value="info">Info</option>
                                <option value="success">Success</option>
                                <option value="warning">Warning</option>
                                <option value="danger">Danger</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-action">
                        <button class="btn btn-success" id="displayNotif">Display</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $("#displayNotif").on("click", function () {
        var placementFrom = $("#notify_placement_from option:selected").val();
        var placementAlign = $("#notify_placement_align option:selected").val();
        var state = $("#notify_state option:selected").val();
        
        $.notify({
            icon: 'fa fa-bell',
            title: 'Bootstrap Notify',
            message: 'Turning standard Bootstrap alerts into notify-like notifications',
        },{
            type: state,
            placement: {
                from: placementFrom,
                align: placementAlign
            },
            time: 1000,
        });
    });
</script>
@endpush