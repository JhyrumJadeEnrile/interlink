@extends('layouts.app')

@section('title', 'OJT Documents | InternLink')

@section('content')

{{-- Page Header with Formal Photo Upload Module --}}
<div class="page-header d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between pb-3 mb-4 border-bottom">
    <div class="d-flex align-items-center">
        <!-- Profile Photo Upload Element -->
        <div class="avatar avatar-xl position-relative me-3 group shadow-sm">
            <img src="{{ Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : 'https://via.placeholder.com/100' }}"
                 alt="Formal Profile Photo"
                 class="avatar-img rounded-circle border border-2 border-primary"
                 style="width: 65px; height: 65px; object-fit: cover;">

            <form action="{{ route('profile.photo.update') }}" method="POST" enctype="multipart/form-data" class="position-absolute bottom-0 end-0 m-0">
                @csrf
                <label for="studentPhotoInput" class="btn btn-primary btn-sm btn-round p-0 d-flex align-items-center justify-content-center shadow" style="width: 24px; height: 24px; cursor: pointer; border-radius: 50%;">
                    <i class="fas fa-camera" style="font-size: 10px;"></i>
                </label>
                <input type="file" id="studentPhotoInput" name="profile_photo" class="d-none" onchange="this.form.submit()">
            </form>
        </div>
        <div>
            <h3 class="fw-bold mb-1">OJT Documents</h3>
            <ul class="breadcrumbs p-0 m-0" style="background: transparent;">
                <li class="nav-home"><a href="{{ url('/dashboard') }}"><i class="icon-home"></i></a></li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item"><a href="#">My OJT</a></li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item"><a href="#">Documents</a></li>
            </ul>
        </div>
    </div>
</div>

{{-- Alerts --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><i class="fas fa-exclamation-triangle me-1"></i> Please fix the following:</strong>
        <ul class="mb-0 mt-1 ps-3">
            @foreach ($errors->all() as $error)
                <li style="font-size:13px;">{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row g-4">

    {{-- ── Upload Card ── --}}
    <div class="col-md-5">
        <div class="card card-round h-100">
            <div class="card-header d-flex align-items-center gap-2">
                <span style="width:32px;height:32px;border-radius:8px;background:rgba(88,103,221,.12);display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-cloud-upload-alt" style="color:#5867dd;font-size:15px;"></i>
                </span>
                <span class="card-title mb-0">Upload Control</span>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('student.documents.upload') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:12px;color:#555;">Document Classification</label>
                        <select name="document_type" class="form-select" style="height:40px;" required>
                            <option value="" disabled selected>Choose type…</option>
                            <option value="Resume">Resume / CV</option>
                            <option value="Consent Form">Parental Consent Form</option>
                            <option value="Internship Agreement">MOA / Internship Agreement</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:12px;color:#555;">Select File</label>
                        <div class="doc-dropzone position-relative text-center p-4" id="doc-drop-area">
                            <i class="fas fa-file-upload fs-2 mb-2 d-block" id="doc-icon" style="color:#ccc;"></i>
                            <span id="doc-file-text" style="font-size:13px;color:#aaa;">Click to attach file</span>
                            <div style="font-size:11px;color:#bbb;margin-top:4px;">PDF, DOC, DOCX — up to 10 MB</div>
                            <input type="file" name="document" id="doc-file-input"
                                   class="position-absolute top-0 start-0 w-100 h-100 opacity-0"
                                   style="cursor:pointer;" accept=".pdf,.doc,.docx" required />
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-round w-100 fw-semibold">
                        <i class="fas fa-upload me-2"></i>Process Document
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- ── Registry Card ── --}}
    <div class="col-md-7">
        <div class="card card-round">
            <div class="card-header d-flex align-items-center">
                <span style="width:32px;height:32px;border-radius:8px;background:rgba(40,199,111,.12);display:flex;align-items:center;justify-content:center;" class="me-2">
                    <i class="fas fa-folder-open" style="color:#28c76f;font-size:15px;"></i>
                </span>
                <span class="card-title mb-0">Document Registry</span>
                <span class="ms-auto badge rounded-pill border" style="background:#f4f5f7;color:#555;font-size:11px;padding:5px 12px;">
                    {{ $documents->count() }} {{ Str::plural('file', $documents->count()) }}
                </span>
            </div>
            <div class="card-body p-0">

                @if ($documents->isEmpty())
                    <div class="text-center py-5 px-3">
                        <div style="width:60px;height:60px;border-radius:50%;background:#f4f5f7;margin:0 auto 14px;display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-file-invoice" style="font-size:22px;color:#ccc;"></i>
                        </div>
                        <h6 class="fw-bold mb-1" style="color:#1a1a2e;">No uploaded records yet</h6>
                        <p class="text-muted mb-0" style="font-size:13px;">Use the upload tool on the left to store your required OJT forms.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-head-bg-light align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4" style="width:30%;">Type</th>
                                    <th style="width:45%;">Filename</th>
                                    <th class="pe-4 text-end" style="width:25%;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($documents as $document)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <span class="badge rounded-pill px-3 py-1
                                            @if($document->document_type === 'Resume') bg-info
                                            @elseif($document->document_type === 'Consent Form') bg-warning text-dark
                                            @else bg-success
                                            @endif"
                                            style="font-size:11px;">
                                            {{ $document->document_type }}
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fas fa-file-pdf" style="color:#e34c3a;font-size:16px;flex-shrink:0;"></i>
                                            <span class="text-truncate" style="max-width:200px;font-size:13px;color:#555;" title="{{ $document->filename }}">
                                                {{ $document->filename }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        {{-- View --}}
                                        <a href="{{ asset('storage/' . $document->file_path) }}"
                                           target="_blank"
                                           class="btn btn-sm btn-icon btn-link"
                                           title="View document"
                                           style="color:#5867dd;">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>

                                        {{-- Delete --}}
                                        <button type="button"
                                                class="btn btn-sm btn-icon btn-link text-danger ms-1"
                                                title="Delete document"
                                                onclick="confirmDeleteDoc({{ $document->id }}, '{{ addslashes($document->filename) }}')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>

                                        {{-- Hidden delete form --}}
                                        <form id="delete-doc-{{ $document->id }}"
                                              method="POST"
                                              action="{{ route('student.documents.destroy', $document->id) }}"
                                              class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
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

<style>
    .doc-dropzone {
        border: 1.5px dashed #dde0ea;
        border-radius: 10px;
        background: #fafbfc;
        transition: border-color .15s, background .15s;
        cursor: pointer;
    }
    .doc-dropzone:hover,
    .doc-dropzone.drag-over {
        border-color: #5867dd;
        background: rgba(88,103,221,.04);
    }
    .doc-dropzone:hover #doc-icon,
    .doc-dropzone.drag-over #doc-icon { color: #5867dd !important; }
</style>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input   = document.getElementById('doc-file-input');
    const text    = document.getElementById('doc-file-text');
    const icon    = document.getElementById('doc-icon');
    const dropArea = document.getElementById('doc-drop-area');

    if (input) {
        input.addEventListener('change', function () {
            if (this.files.length) {
                text.textContent = this.files[0].name;
                text.style.color = '#5867dd';
                text.style.fontWeight = '600';
                icon.className = 'fas fa-file-check fs-2 mb-2 d-block';
                icon.style.color = '#5867dd';
            }
        });
    }

    // Drag highlight
    ['dragenter','dragover'].forEach(e => dropArea?.addEventListener(e, () => dropArea.classList.add('drag-over')));
    ['dragleave','drop'].forEach(e => dropArea?.addEventListener(e, () => dropArea.classList.remove('drag-over')));
});

function confirmDeleteDoc(id, name) {
    swal({
        title: 'Delete document?',
        text: '"' + name + '" will be permanently removed.',
        icon: 'warning',
        buttons: {
            cancel: { text: 'Cancel', visible: true, className: 'btn btn-secondary btn-round' },
            confirm: { text: 'Yes, delete it', className: 'btn btn-danger btn-round' }
        },
        dangerMode: true
    }).then(function (confirmed) {
        if (confirmed) {
            document.getElementById('delete-doc-' + id).submit();
        }
    });
}
</script>
@endpush
