@extends('layouts.app')

@section('title', 'Sweet Alert - Kaiadmin Bootstrap 5 Admin Dashboard')

@section('content')
<div class="page-header">
    <h3 class="fw-bold mb-3">Sweet Alert</h3>
    <ul class="breadcrumbs mb-3">
        <li class="nav-home"><a href="{{ url('/dashboard') }}"><i class="icon-home"></i></a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Base</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Sweet Alert</a></li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Basic Examples</h4>
            </div>
            <div class="card-body">
                <button class="btn btn-info" id="alert_demo_1">Simple Alert</button>
                <button class="btn btn-success" id="alert_demo_2">Success Alert</button>
                <button class="btn btn-danger" id="alert_demo_3">Warning Confirmation</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('#alert_demo_1').click(function(e) {
        swal("Here's the title of the message!");
    });

    $('#alert_demo_2').click(function(e) {
        swal("Good job!", "You clicked the button!", {
            icon : "success",
            buttons: { confirm: { className: 'btn btn-success' } }
        });
    });

    $('#alert_demo_3').click(function(e) {
        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            buttons:{
                cancel: { visible: true, className: 'btn btn-danger' },
                confirm: { text : 'Yes, delete it!', className : 'btn btn-success' }
            }
        });
    });
</script>
@endpush