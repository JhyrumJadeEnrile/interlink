@extends('layouts.app')

@section('title', 'OJT Documents | InternLink')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">OJT Documents</h3>
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
                    <a href="#">Documents</a>
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
            <div class="col-md-5">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title"><i class="fas fa-cloud-upload-alt text-primary me-2"></i>Upload Control</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('student.documents.upload') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group px-0 py-2">
                                <label for="document_type" class="fw-semibold">Document Classification</label>
                                <select id="document_type" name="document_type" class="form-select form-control-behavior" required>
                                    <option value="" disabled selected>Choose type...</option>
                                    <option value="Resume">Resume / CV</option>
                                    <option value="Consent Form">Parental Consent Form</option>
                                    <option value="Internship Agreement">MOA / Internship Agreement</option>
                                </select>
                            </div>

                            <div class="form-group px-0 py-2">
                                <label class="fw-semibold">Select File</label>
                                <div class="custom-kai-file-input position-relative border rounded p-3 text-center bg-light transition-all">
                                    <i class="fas fa-file-pdf fs-3 text-muted mb-2 d-block"></i>
                                    <span id="file-chosen-text" class="text-secondary small d-block text-truncate fw-medium">Click to attach file</span>
                                    <input type="file" name="document" class="position-absolute top-0 start-0 w-100 h-100 opacity-0 cursor-pointer" accept=".pdf,.doc,.docx" id="file-native-input" required />
                                </div>
                                <small class="form-text text-muted">Supports PDF, DOC, DOCX up to 10MB</small>
                            </div>

                            <div class="py-2">
                                <button type="submit" class="btn btn-primary btn-round w-100 fw-bold">
                                    <i class="fas fa-upload me-2"></i>Process Document
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row justify-content-between align-items-center">
                            <div class="card-title"><i class="fas fa-folder text-success me-2"></i>Document Registry</div>
                            <span class="badge badge-neutral text-dark border rounded-pill px-3 py-1 fw-bold small">
                                Files: {{ $documents->count() }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        @if ($documents->isEmpty())
                            <div class="text-center py-5">
                                <div class="avatar avatar-lg mb-3 mx-auto bg-light rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="fas fa-file-invoice text-muted fs-4"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-1">No uploaded records</h6>
                                <p class="text-muted small px-4 mb-0">Use the upload tool to store and log your required forms.</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-head-bg-light align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th class="ps-4">Type</th>
                                            <th>Filename</th>
                                            <th class="pe-4 text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($documents as $document)
                                            <tr>
                                                <td class="ps-4">
                                                    <div class="d-flex align-items-center">
                                                        <span class="badge badge-dot me-2
                                                            {{ $document->document_type == 'Resume' ? 'bg-info' : '' }}
                                                            {{ $document->document_type == 'Consent Form' ? 'bg-warning' : '' }}
                                                            {{ $document->document_type == 'Internship Agreement' ? 'bg-success' : '' }}">
                                                        </span>
                                                        <span class="fw-bold text-dark">{{ $document->document_type }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-secondary small text-truncate d-block max-w-220" title="{{ $document->filename }}">
                                                        {{ $document->filename }}
                                                    </span>
                                                </td>
                                                <td class="pe-4 text-end">
                                                    <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="btn btn-icon btn-link btn-info btn-sm" title="View Document">
                                                        <i class="fas fa-external-link-alt"></i>
                                                    </a>
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
    .cursor-pointer { cursor: pointer; }
    .transition-all { transition: all 0.2s ease-in-out; }
    .max-w-220 { max-width: 220px; }

    .badge-dot {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
    }

    /* Input select styling correction to fit form layout */
    .form-control-behavior {
        border-color: #ebedf2 !important;
        height: 42px !important;
    }

    /* Unified look for the clean light drop layout wrapper */
    .custom-kai-file-input {
        border: 1px dashed #ebedf2 !important;
    }
    .custom-kai-file-input:hover {
        border-color: #1572e8 !important;
        background-color: #fafdff !important;
    }
    .custom-kai-file-input:hover i {
        color: #1572e8 !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('file-native-input');
        const fileText = document.getElementById('file-chosen-text');
        const iconWrapper = fileInput?.previousElementSibling?.previousElementSibling;

        if(fileInput && fileText) {
            fileInput.addEventListener('change', function() {
                if(this.files && this.files.length > 0) {
                    fileText.textContent = this.files[0].name;
                    fileText.className = "text-primary small d-block text-truncate fw-bold";
                    if(iconWrapper) iconWrapper.className = "fas fa-file-check fs-3 text-primary mb-2 d-block";
                } else {
                    fileText.textContent = "Click to attach file";
                    fileText.className = "text-secondary small d-block text-truncate fw-medium";
                    if(iconWrapper) iconWrapper.className = "fas fa-file-pdf fs-3 text-muted mb-2 d-block";
                }
            });
        }
    });
</script>
@endsection
