@extends('layouts.app')

@section('title', 'OJT Documents | InternLink')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <h3 class="fw-bold mb-3">OJT Documents</h3>
        <p class="text-white-50">Upload mandatory internship documents like resumes, consent forms, and internship agreements.</p>
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
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Upload Document</div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('student.documents.upload') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label text-white-75">Document Type</label>
                            <select name="document_type" class="form-select" required>
                                <option value="">Choose a type</option>
                                <option value="Resume">Resume</option>
                                <option value="Consent Form">Consent Form</option>
                                <option value="Internship Agreement">Internship Agreement</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-white-75">Upload File</label>
                            <input type="file" name="document" class="form-control" accept=".pdf,.doc,.docx" required />
                        </div>
                        <button type="submit" class="btn btn-primary btn-round w-100">Upload Document</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Uploaded Documents</div>
                </div>
                <div class="card-body">
                    @if ($documents->isEmpty())
                        <div class="text-white-50">No documents uploaded yet.</div>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach ($documents as $document)
                                <li class="list-group-item bg-transparent border-0 py-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $document->document_type }}</strong><br>
                                            <small class="text-muted">{{ $document->filename }}</small>
                                        </div>
                                        <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="btn btn-sm btn-outline-info">Download</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
