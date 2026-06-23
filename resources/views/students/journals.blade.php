@extends('layouts.app')

@section('title', 'Weekly Journals | InternLink')

@section('content')

<div class="page-header">
    <h3 class="fw-bold mb-1">Weekly Journal</h3>
    <ul class="breadcrumbs mb-3">
        <li class="nav-home"><a href="{{ url('/dashboard') }}"><i class="icon-home"></i></a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">My OJT</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Weekly Journal</a></li>
    </ul>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
        <i class="fas fa-check-circle"></i><span>{{ session('success') }}</span>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><i class="fas fa-exclamation-triangle me-1"></i> Please fix the following:</strong>
        <ul class="mb-0 mt-1 ps-3">
            @foreach ($errors->all() as $error)<li style="font-size:13px;">{{ $error }}</li>@endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row g-4">

    {{-- ── Submit Form ── --}}
    <div class="col-lg-5">
        <div class="card card-round">
            <div class="card-header d-flex align-items-center gap-2">
                <span style="width:32px;height:32px;border-radius:8px;background:rgba(40,199,111,.12);display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-pen-nib" style="color:#28c76f;font-size:14px;"></i>
                </span>
                <span class="card-title mb-0">Submit Journal</span>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('student.journals.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:12px;color:#555;">Week Starting</label>
                        <input type="date" name="week_start" class="form-control" style="height:40px;"
                               value="{{ old('week_start') }}" required />
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:12px;color:#555;">Journal Content</label>
                        <textarea name="content" rows="7" class="form-control journal-textarea"
                                  placeholder="Describe your tasks, achievements, and lessons learned this week…"
                                  required>{{ old('content') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-success btn-round w-100 fw-semibold">
                        <i class="fas fa-paper-plane me-2"></i>Submit Journal Entry
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- ── Journal History ── --}}
    <div class="col-lg-7">
        <div class="card card-round">
            <div class="card-header d-flex align-items-center gap-2">
                <span style="width:32px;height:32px;border-radius:8px;background:rgba(29,122,243,.1);display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-book-open" style="color:#1d7af3;font-size:14px;"></i>
                </span>
                <span class="card-title mb-0">Journal History</span>
                <span class="ms-auto badge rounded-pill border" style="background:#f4f5f7;color:#555;font-size:11px;padding:5px 12px;">
                    {{ $journals->count() }} {{ Str::plural('entry', $journals->count()) }}
                </span>
            </div>
            <div class="card-body p-0">

                @if ($journals->isEmpty())
                    <div class="text-center py-5 px-3">
                        <div style="width:60px;height:60px;border-radius:50%;background:#f4f5f7;margin:0 auto 14px;display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-book" style="font-size:22px;color:#ccc;"></i>
                        </div>
                        <h6 class="fw-bold mb-1">No journal entries yet</h6>
                        <p class="text-muted mb-0" style="font-size:13px;">Submit your first weekly reflection using the form on the left.</p>
                    </div>
                @else
                    {{-- Journal cards list --}}
                    <div class="p-3 d-flex flex-column gap-3">
                        @foreach ($journals as $journal)
                        <div class="journal-entry-card p-3" style="border:1px solid #f0f0f5;border-radius:10px;background:#fafbfc;">
                            <div class="d-flex align-items-start justify-content-between mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <span style="width:8px;height:8px;border-radius:50%;background:#28c76f;display:inline-block;flex-shrink:0;margin-top:3px;"></span>
                                    <div>
                                        <span class="fw-bold" style="font-size:13px;color:#1a1a2e;">
                                            Week of {{ $journal->week_start ? $journal->week_start->format('M d, Y') : 'N/A' }}
                                        </span>
                                        <div style="font-size:11px;color:#aaa;margin-top:1px;">
                                            Submitted {{ $journal->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                                {{-- Delete button --}}
                                <button type="button"
                                        class="btn btn-sm btn-icon btn-link text-danger flex-shrink-0"
                                        title="Delete entry"
                                        onclick="confirmDeleteJournal({{ $journal->id }}, '{{ $journal->week_start ? $journal->week_start->format('M d, Y') : 'this entry' }}')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>

                                <form id="delete-journal-{{ $journal->id }}"
                                      method="POST"
                                      action="{{ route('student.journals.destroy', $journal->id) }}"
                                      class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>

                            <p class="mb-0 journal-content" style="font-size:13px;color:#555;line-height:1.6;white-space:pre-line;">{{ Str::limit($journal->content, 220) }}</p>

                            @if(strlen($journal->content) > 220)
                            <button class="btn btn-link btn-sm p-0 mt-1 journal-expand-btn"
                                    style="font-size:12px;color:#5867dd;"
                                    data-full="{{ e($journal->content) }}"
                                    data-short="{{ e(Str::limit($journal->content, 220)) }}">
                                Show more
                            </button>
                            @endif
                        </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    </div>

</div>

<style>
    .journal-textarea {
        resize: none;
        font-size: 13px;
        line-height: 1.6;
        border-color: #e0e0ea !important;
        border-radius: 8px !important;
    }
    .journal-textarea:focus { border-color: #28c76f !important; box-shadow: 0 0 0 3px rgba(40,199,111,.1) !important; }
    .journal-entry-card { transition: box-shadow .15s; }
    .journal-entry-card:hover { box-shadow: 0 2px 8px rgba(0,0,0,.06); }
</style>
@endsection

@push('scripts')
<script>
// Show more / less toggle
document.querySelectorAll('.journal-expand-btn').forEach(function (btn) {
    var expanded = false;
    btn.addEventListener('click', function () {
        var content = btn.previousElementSibling;
        expanded = !expanded;
        content.textContent = expanded ? btn.dataset.full : btn.dataset.short;
        btn.textContent = expanded ? 'Show less' : 'Show more';
    });
});

function confirmDeleteJournal(id, weekLabel) {
    swal({
        title: 'Delete journal entry?',
        text: 'The entry for "' + weekLabel + '" will be permanently removed.',
        icon: 'warning',
        buttons: {
            cancel: { text: 'Cancel', visible: true, className: 'btn btn-secondary btn-round' },
            confirm: { text: 'Yes, delete it', className: 'btn btn-danger btn-round' }
        },
        dangerMode: true
    }).then(function (confirmed) {
        if (confirmed) document.getElementById('delete-journal-' + id).submit();
    });
}
</script>
@endpush