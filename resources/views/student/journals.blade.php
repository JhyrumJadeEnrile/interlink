@extends('layouts.app')

@section('title', 'Weekly Journals | InternLink')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <h3 class="fw-bold mb-3">Weekly Journal</h3>
        <p class="text-white-50">Submit your work reflections, tasks completed, and learning outcomes each week.</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Submit Journal</div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('student.journals.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label text-white-75">Week Starting</label>
                            <input type="date" name="week_start" class="form-control" value="{{ old('week_start') }}" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-white-75">Journal Content</label>
                            <textarea name="content" rows="6" class="form-control" placeholder="Describe tasks, achievements, and lessons learned." required>{{ old('content') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-success btn-round w-100">Submit Journal</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Journal History</div>
                </div>
                <div class="card-body">
                    @if ($journals->isEmpty())
                        <div class="text-white-50">No weekly journals submitted yet.</div>
                    @else
                        <div class="list-group">
                            @foreach ($journals as $journal)
                                <div class="list-group-item bg-transparent border-0 py-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div>
                                            <strong>Week of {{ $journal->week_start->format('M d, Y') }}</strong>
                                        </div>
                                        <small class="text-muted">{{ $journal->created_at->diffForHumans() }}</small>
                                    </div>
                                    <p class="mb-0 text-white-75">{{ $journal->content }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
