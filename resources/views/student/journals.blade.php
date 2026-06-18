@extends('layouts.app')

@section('title', 'Weekly Journals | InternLink')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Weekly Journal</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="#">
                        <i class="icon-home text-primary"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">My OJT</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Weekly Journal</a>
                </li>
            </ul>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong class="d-block mb-1"><i class="fas fa-exclamation-triangle me-2"></i> Action Required:</strong>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-5">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">
                                <i class="fas fa-pen-nib text-success me-2"></i>Submit Journal
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('student.journals.store') }}">
                            @csrf

                            <div class="form-group px-0 py-2">
                                <label class="fw-semibold">Week Starting</label>
                                <input type="date" name="week_start" class="form-control kai-input" value="{{ old('week_start') }}" required />
                            </div>

                            <div class="form-group px-0 py-2">
                                <label class="fw-semibold">Journal Content</label>
                                <textarea name="content" rows="6" class="form-control kai-textarea" placeholder="Describe tasks, achievements, and lessons learned clearly..." required>{{ old('content') }}</textarea>
                            </div>

                            <div class="py-2 mt-2">
                                <button type="submit" class="btn btn-success btn-round w-100 fw-bold">
                                    <i class="fas fa-paper-plane me-2"></i>Submit Journal Entry
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row justify-content-between align-items-center">
                            <div class="card-title">
                                <i class="fas fa-book-open text-primary me-2"></i>Journal History
                            </div>
                            <span class="badge badge-neutral text-dark border rounded-pill px-3 py-1 fw-bold small">
                                Entries: {{ $journals->count() }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        @if ($journals->isEmpty())
                            <div class="text-center py-5">
                                <div class="avatar avatar-lg mb-3 mx-auto bg-light rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="fas fa-notes-medical text-muted fs-4"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-1">No log submissions yet</h6>
                                <p class="text-muted small px-4 mb-0">Record reflections weekly to construct timeline progression values.</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-head-bg-light align-middle mb-0 custom-journal-table">
                                    <thead>
                                        <tr>
                                            <th class="ps-4" style="width: 30%;">Week Covered</th>
                                            <th style="width: 55%;">Reflections & Tasks</th>
                                            <th class="pe-4 text-end" style="width: 15%;">Logged</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($journals as $journal)
                                            <tr class="border-bottom border-light align-top">
                                                <td class="ps-4 py-3">
                                                    <div class="d-flex align-items-center mt-1">
                                                        <span class="badge badge-dot bg-success me-2"></span>
                                                        <span class="fw-bold text-dark">
                                                            {{ $journal->week_start ? $journal->week_start->format('M d, Y') : 'N/A' }}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="py-3">
                                                    <p class="text-secondary small mb-0 long-text-block">
                                                        {{ $journal->content }}
                                                    </p>
                                                </td>
                                                <td class="pe-4 py-3 text-end text-nowrap">
                                                    <small class="text-muted text-xs d-block mt-1">
                                                        {{ $journal->created_at->diffForHumans() }}
                                                    </small>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .text-xs { font-size: 0.725rem; }

    .badge-dot {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
    }

    .kai-input {
        border-color: #ebedf2 !important;
        height: 40px !important;
    }
    .kai-input:focus, .kai-textarea:focus {
        border-color: #2bb431 !important; /* Green line response boundary */
    }

    .kai-textarea {
        border-color: #ebedf2 !important;
        resize: none;
        font-size: 0.875rem;
    }

    /* Paragraph behavior block configurations */
    .long-text-block {
        white-space: pre-line;
        line-height: 1.5;
        word-break: break-word;
    }

    .custom-journal-table tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.005);
    }
</style>
@endsection
