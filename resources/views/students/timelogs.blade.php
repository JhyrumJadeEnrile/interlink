@extends('layouts.app')

@section('title', 'Time Logs | InternLink')




@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .location-suggestion-item {
        padding: 9px 14px; font-size: 12px; color: #444;
        cursor: pointer; border-bottom: 1px solid #f5f5f8; transition: background .12s;
        display: flex; align-items: center; gap: 8px;
    }
    .location-suggestion-item::before { content: '\1F4CD'; font-size: 11px; opacity: .4; }
    .location-suggestion-item:hover { background: #f4f5ff; color: #5867dd; }
    .location-suggestion-item:last-child { border-bottom: none; }

    /* Form label icons */
    .form-label i { opacity: .7; }

    /* Tighter card body on left form */
    .tl-form-card .card-body { padding: 1.25rem !important; }

    /* Confirm location btn */
    #location-confirm-btn { transition: opacity .2s, box-shadow .2s; }
    #location-confirm-btn:not([style*="opacity: 0.4"]) { box-shadow: 0 3px 10px rgba(40,199,111,.3); }

    /* Badge pill for hours */
    .hrs-badge { background:#f0f0f5;color:#1a1a2e;font-size:12px;padding:5px 12px;border-radius:50px;font-weight:600; }
</style>

@endpush

@section('content')

<div class="page-header">
    <h3 class="fw-bold mb-1">Daily Time Logs</h3>
    <ul class="breadcrumbs mb-3">
        <li class="nav-home"><a href="{{ url('/dashboard') }}"><i class="icon-home"></i></a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">My OJT</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Time Logs</a></li>
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

    {{-- ── Log Form ── --}}
    <div class="col-lg-5">
        <div class="card card-round">
            <div class="card-header d-flex align-items-center gap-2" style="background:linear-gradient(135deg,rgba(255,173,70,.08),rgba(255,173,70,.02)) !important;">
                <span style="width:34px;height:34px;border-radius:10px;background:rgba(255,173,70,.18);display:flex;align-items:center;justify-content:center;box-shadow:0 2px 6px rgba(255,173,70,.2);">
                    <i class="fas fa-clock" style="color:#ffad46;font-size:15px;"></i>
                </span>
                <div>
                    <span class="card-title mb-0">Log Time</span>
                    <div style="font-size:11px;color:#aaa;font-weight:400;">Fill in your daily attendance</div>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('student.timelogs.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold d-flex align-items-center gap-1" style="font-size:12px;color:#555;">
                            <i class="fas fa-calendar-alt" style="color:#5867dd;font-size:11px;"></i> Date
                        </label>
                        <input type="date" name="date" id="log-date" class="form-control" style="height:42px;"
                               value="{{ old('date', now()->format('Y-m-d')) }}" required />
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold" style="font-size:12px;color:#555;">Time In</label>
                            <input type="time" id="time-in-picker" class="form-control" style="height:40px;"
                                   value="{{ old('time_in') ? \Carbon\Carbon::parse(old('time_in'))->format('H:i') : '' }}" required />
                            <input type="hidden" name="time_in" id="time-in-value" value="{{ old('time_in') }}" />
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold" style="font-size:12px;color:#555;">
                                Time Out <span class="fw-normal" style="color:#bbb;">(optional)</span>
                            </label>
                            <input type="time" id="time-out-picker" class="form-control" style="height:40px;"
                                   value="{{ old('time_out') ? \Carbon\Carbon::parse(old('time_out'))->format('H:i') : '' }}" />
                            <input type="hidden" name="time_out" id="time-out-value" value="{{ old('time_out') }}" />
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:12px;color:#555;">Work Location</label>

                        {{-- Search row --}}
                        <div class="d-flex gap-2 mb-2">
                            <div class="position-relative flex-grow-1">
                                <input type="text" id="location-search"
                                       class="form-control pe-5"
                                       placeholder="Search address or place name…"
                                       autocomplete="off"
                                       style="height:40px;" />
                                <button type="button" id="location-search-btn"
                                        style="position:absolute;right:8px;top:50%;transform:translateY(-50%);border:none;background:none;color:#5867dd;font-size:14px;cursor:pointer;">
                                    <i class="fas fa-search"></i>
                                </button>
                                <div id="location-suggestions"
                                     style="display:none;position:absolute;top:44px;left:0;right:0;background:#fff;border:1px solid #e0e0ea;border-radius:8px;z-index:9999;box-shadow:0 4px 12px rgba(0,0,0,.1);max-height:180px;overflow-y:auto;"></div>
                            </div>
                            {{-- Confirm button --}}
                            <button type="button" id="location-confirm-btn"
                                    class="btn btn-success btn-round px-3 flex-shrink-0"
                                    style="height:40px;font-size:12px;font-weight:600;white-space:nowrap;opacity:0.4;pointer-events:none;"
                                    title="Confirm this location">
                                <i class="fas fa-check me-1"></i> Use This Location
                            </button>
                        </div>

                        {{-- Map --}}
                        <div id="location-map" style="height:200px;border-radius:10px;border:1px solid #e0e0ea;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,.06);"></div>

                        {{-- Confirmed location badge --}}
                        <div id="location-confirmed-badge" class="mt-2 align-items-center gap-2 px-3 py-2 rounded"
                             style="display:none;background:rgba(40,199,111,.08);border:1px solid rgba(40,199,111,.2);">
                            <i class="fas fa-map-marker-alt text-success me-1"></i>
                            <span id="location-confirmed-text" style="font-size:12px;color:#1a1a2e;font-weight:500;"></span>
                            <button type="button" id="location-clear-btn"
                                    style="border:none;background:none;color:#aaa;font-size:11px;margin-left:auto;cursor:pointer;float:right;">
                                <i class="fas fa-times"></i> Clear
                            </button>
                        </div>

                        {{-- Hidden fields --}}
                        <input type="hidden" name="location" id="location-value" value="{{ old('location') }}" />
                        <input type="hidden" name="latitude"  id="lat-value"  value="{{ old('latitude') }}" />
                        <input type="hidden" name="longitude" id="lng-value"  value="{{ old('longitude') }}" />
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:12px;color:#555;">Photo Attachment</label>
                        <div class="tl-dropzone position-relative text-center p-3" id="tl-drop-area">
                            <i class="fas fa-camera mb-1 d-block" id="tl-icon" style="color:#ccc;font-size:24px;"></i>
                            <span id="tl-file-text" style="font-size:12px;color:#aaa;display:block;">Click to attach workspace photo</span>
                            <span style="font-size:10px;color:#ccc;">JPG, PNG — up to 5 MB</span>
                            <input type="file" name="photo" id="tl-file-input" accept="image/*"
                                   class="position-absolute top-0 start-0 w-100 h-100 opacity-0" style="cursor:pointer;" />
                        </div>
                    </div>

                    <button type="submit" class="btn btn-warning btn-round w-100 fw-bold text-dark" style="height:44px;font-size:13px;letter-spacing:.01em;box-shadow:0 4px 12px rgba(255,173,70,.3);">
                        <i class="fas fa-paper-plane me-2"></i>Submit Time Log
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- ── Right column ── --}}
    <div class="col-lg-7">

        {{-- Progress card --}}
        <div class="card card-round mb-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span style="width:34px;height:34px;border-radius:10px;background:rgba(40,199,111,.12);display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-chart-line" style="color:#28c76f;font-size:14px;"></i>
                    </span>
                    <div>
                        <h6 class="fw-bold mb-0" style="font-size:14px;">OJT Hours Progress</h6>
                        <div style="font-size:10px;color:#aaa;">Updated in real-time</div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-end mb-2">
                    <span style="font-size:12px;color:#888;">Approved Hours</span>
                    <div>
                        <span class="fw-bold" style="font-size:22px;color:#28c76f;">{{ number_format($student->hoursCompleted(), 2) }}</span>
                        <span style="font-size:12px;color:#aaa;"> / {{ $student->required_hours ?? 0 }} hrs required</span>
                    </div>
                </div>
                {{-- Pending hours notice --}}
                @php
                    $pendingHours = $student->timeLogs()->where('status', 'pending')->sum('duration_minutes') / 60;
                @endphp
                @if($pendingHours > 0)
                <div class="d-flex align-items-center gap-2 mb-2 px-2 py-1 rounded" style="background:rgba(255,173,70,.08);border:1px solid rgba(255,173,70,.2);">
                    <i class="fas fa-hourglass-half" style="color:#ffad46;font-size:11px;"></i>
                    <span style="font-size:11px;color:#888;">
                        <strong style="color:#ffad46;">{{ number_format($pendingHours, 2) }} hrs</strong> pending supervisor approval
                    </span>
                </div>
                @endif

                <div class="progress mb-3" style="height:8px;border-radius:50px;background:#f0f0f5;">
                    <div class="progress-bar bg-success" role="progressbar"
                         style="width:{{ $student->progressPercentage() }}%;border-radius:50px;"
                         aria-valuenow="{{ $student->progressPercentage() }}" aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>

                <div class="row g-2 text-center">
                    <div class="col-6">
                        <div style="background:#f4f5f7;border-radius:8px;padding:10px;">
                            <div style="font-size:10px;text-transform:uppercase;letter-spacing:.06em;color:#aaa;font-weight:600;">Progress</div>
                            <div class="fw-bold" style="font-size:16px;color:#1a1a2e;margin-top:2px;">{{ $student->progressPercentage() }}%</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div style="background:#f4f5f7;border-radius:8px;padding:10px;">
                            <div style="font-size:10px;text-transform:uppercase;letter-spacing:.06em;color:#aaa;font-weight:600;">Remaining</div>
                            <div class="fw-bold" style="font-size:16px;color:#f25961;margin-top:2px;">{{ number_format($student->hoursRemaining(), 2) }} hrs</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Logs table --}}
        <div class="card card-round">
            <div class="card-header d-flex align-items-center gap-2" style="background:linear-gradient(135deg,rgba(29,122,243,.05),transparent) !important;">
                <span style="width:34px;height:34px;border-radius:10px;background:rgba(29,122,243,.1);display:flex;align-items:center;justify-content:center;box-shadow:0 2px 6px rgba(29,122,243,.15);">
                    <i class="fas fa-history" style="color:#1d7af3;font-size:14px;"></i>
                </span>
                <div>
                    <span class="card-title mb-0">Recent Logs</span>
                    <div style="font-size:11px;color:#aaa;font-weight:400;">Your submitted time entries</div>
                </div>
                <span class="ms-auto badge rounded-pill border" style="background:#f4f5f7;color:#555;font-size:11px;padding:5px 12px;">
                    {{ $timelogs->count() }} {{ Str::plural('entry', $timelogs->count()) }}
                </span>
            </div>
            <div class="card-body p-0">
                @if ($timelogs->isEmpty())
                    <div class="text-center py-5">
                        <div style="width:60px;height:60px;border-radius:50%;background:#f4f5f7;margin:0 auto 14px;display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-calendar-times" style="font-size:22px;color:#ccc;"></i>
                        </div>
                        <h6 class="fw-bold mb-1">No timesheet records</h6>
                        <p class="text-muted mb-0" style="font-size:13px;">Your daily check-ins will appear here after submission.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-head-bg-light align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">Date / Shift</th>
                                    <th>Hours</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                    <th class="pe-4 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($timelogs as $log)
                                <tr>
                                    <td class="ps-4 py-3" style="min-width:160px;">
                                        <div class="fw-bold" style="font-size:13px;color:#1a1a2e;margin-bottom:6px;">
                                            {{ $log->date->format('M d, Y') }}
                                        </div>
                                        <div class="d-flex align-items-center gap-1" style="font-size:12px;margin-bottom:3px;">
                                            <span style="width:8px;height:8px;border-radius:50%;background:#28c76f;display:inline-block;flex-shrink:0;"></span>
                                            <span style="color:#555;font-weight:500;">IN</span>
                                            <span style="color:#1a1a2e;font-weight:600;margin-left:4px;">
                                                {{ $log->time_in ? \Carbon\Carbon::parse($log->time_in)->format('h:i A') : 'N/A' }}
                                            </span>
                                        </div>
                                        <div class="d-flex align-items-center gap-1" style="font-size:12px;">
                                            <span style="width:8px;height:8px;border-radius:50%;background:#f25961;display:inline-block;flex-shrink:0;"></span>
                                            <span style="color:#555;font-weight:500;">OUT</span>
                                            <span style="color:#1a1a2e;font-weight:600;margin-left:4px;">
                                                {{ $log->time_out ? \Carbon\Carbon::parse($log->time_out)->format('h:i A') : 'Active' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge rounded-pill" style="background:#f0f0f5;color:#1a1a2e;font-size:11px;padding:5px 10px;">
                                            {{ number_format(abs($log->total_hours), 2) }} hrs
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        @if($log->location)
                                            <div style="max-width:150px;">
                                                <span style="font-size:12px;color:#555;display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" title="{{ $log->location }}">
                                                    <i class="fas fa-map-marker-alt text-danger me-1"></i>{{ $log->location }}
                                                </span>
                                                <small style="font-size:10px;color:#aaa;display:block;margin-top:2px;">
                                                    {{ Str::limit($log->location, 30) }}
                                                </small>
                                            </div>
                                        @else
                                            <span style="font-size:12px;color:#bbb;">
                                                <i class="fas fa-minus me-1"></i>Not set
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3">
                                        <span class="badge rounded-pill px-3
                                            @if($log->status === 'approved') bg-success
                                            @elseif($log->status === 'rejected') bg-danger
                                            @else bg-secondary
                                            @endif"
                                            style="font-size:11px;">
                                            {{ ucfirst($log->status) }}
                                        </span>
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        @if($log->status === 'pending')
                                        <button type="button"
                                                class="btn btn-sm btn-icon btn-link text-danger"
                                                title="Delete log"
                                                onclick="confirmDeleteLog({{ $log->id }}, '{{ $log->date->format('M d, Y') }}')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <form id="delete-log-{{ $log->id }}"
                                              method="POST"
                                              action="{{ route('student.timelogs.destroy', $log->id) }}"
                                              class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        @else
                                        <span style="font-size:11px;color:#ccc;">—</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

    </div>{{-- /col --}}
</div>{{-- /row --}}

<style>
    .tl-dropzone {
        border: 1.5px dashed #dde0ea;
        border-radius: 10px;
        background: #fafbfc;
        transition: border-color .15s, background .15s;
        cursor: pointer;
    }
    .tl-dropzone:hover { border-color: #ffad46; background: rgba(255,173,70,.04); }
    .tl-dropzone:hover #tl-icon { color: #ffad46 !important; }
</style>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
(function () {
    var map, marker, pendingLat, pendingLng, pendingLabel;
    var defaultLat = 14.5995, defaultLng = 120.9842;

    document.addEventListener('DOMContentLoaded', function () {
        var mapEl = document.getElementById('location-map');
        if (!mapEl) return;

        map = L.map('location-map').setView([defaultLat, defaultLng], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors', maxZoom: 19
        }).addTo(map);

        marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);

        marker.on('dragend', function (e) {
            var p = e.target.getLatLng();
            reverseGeocode(p.lat, p.lng);
        });

        map.on('click', function (e) {
            marker.setLatLng(e.latlng);
            reverseGeocode(e.latlng.lat, e.latlng.lng);
        });

        setTimeout(function () { map.invalidateSize(); }, 300);

        // Restore old value if present
        var oldVal = document.getElementById('location-value').value;
        if (oldVal) showConfirmed(oldVal);

        // Confirm button click
        document.getElementById('location-confirm-btn').addEventListener('click', function () {
            if (pendingLabel) {
                document.getElementById('location-value').value = pendingLabel;
                document.getElementById('lat-value').value      = pendingLat || '';
                document.getElementById('lng-value').value      = pendingLng || '';
                showConfirmed(pendingLabel);
            }
        });

        // Clear button
        document.getElementById('location-clear-btn').addEventListener('click', function () {
            document.getElementById('location-value').value = '';
            document.getElementById('lat-value').value      = '';
            document.getElementById('lng-value').value      = '';
            document.getElementById('location-search').value = '';
            document.getElementById('location-confirmed-badge').style.display = 'none';
            disableConfirmBtn();
            pendingLabel = pendingLat = pendingLng = null;
        });

        // Search input
        var searchTimeout;
        var inp = document.getElementById('location-search');
        var btn = document.getElementById('location-search-btn');

        inp.addEventListener('input', function () {
            clearTimeout(searchTimeout);
            var q = this.value.trim();
            if (q.length < 3) { hideSuggestions(); return; }
            searchTimeout = setTimeout(function () { doSearch(q); }, 400);
        });

        btn.addEventListener('click', function () {
            var q = inp.value.trim();
            if (q.length >= 3) doSearch(q);
        });

        document.addEventListener('click', function (e) {
            if (!e.target.closest('#location-search') && !e.target.closest('#location-suggestions')) hideSuggestions();
        });
    });

    function reverseGeocode(lat, lng) {
        fetch('https://nominatim.openstreetmap.org/reverse?format=json&lat=' + lat + '&lon=' + lng)
            .then(function (r) { return r.json(); })
            .then(function (d) { setPending(d.display_name || (lat.toFixed(5)+', '+lng.toFixed(5)), lat, lng); })
            .catch(function () { setPending(lat.toFixed(5)+', '+lng.toFixed(5), lat, lng); });
    }

    function setPending(label, lat, lng) {
        pendingLabel = label;
        pendingLat   = lat;
        pendingLng   = lng;
        document.getElementById('location-search').value = label;
        if (map && marker && lat && lng) {
            marker.setLatLng([lat, lng]);
            map.setView([lat, lng], 15);
        }
        enableConfirmBtn();
    }

    function enableConfirmBtn() {
        var btn = document.getElementById('location-confirm-btn');
        btn.style.opacity = '1';
        btn.style.pointerEvents = 'auto';
    }

    function disableConfirmBtn() {
        var btn = document.getElementById('location-confirm-btn');
        btn.style.opacity = '0.4';
        btn.style.pointerEvents = 'none';
    }

    function showConfirmed(label) {
        var badge = document.getElementById('location-confirmed-badge');
        document.getElementById('location-confirmed-text').textContent = label;
        badge.style.display = 'flex';
        disableConfirmBtn();
    }

    function doSearch(q) {
        fetch('https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(q) + '&limit=5&countrycodes=ph')
            .then(function (r) { return r.json(); })
            .then(showSuggestions)
            .catch(hideSuggestions);
    }

    function showSuggestions(results) {
        var box = document.getElementById('location-suggestions');
        box.innerHTML = '';
        if (!results.length) {
            box.innerHTML = '<div class="location-suggestion-item" style="color:#aaa;padding:10px 14px;">No results found</div>';
            box.style.display = 'block'; return;
        }
        results.forEach(function (r) {
            var item = document.createElement('div');
            item.className = 'location-suggestion-item';
            item.textContent = r.display_name;
            item.addEventListener('click', function () {
                setPending(r.display_name, parseFloat(r.lat), parseFloat(r.lon));
                hideSuggestions();
            });
            box.appendChild(item);
        });
        box.style.display = 'block';
    }

    function hideSuggestions() {
        var box = document.getElementById('location-suggestions');
        if (box) box.style.display = 'none';
    }
})();
</script>

<script>
// File picker
document.addEventListener('DOMContentLoaded', function () {
    var input    = document.getElementById('tl-file-input');
    var text     = document.getElementById('tl-file-text');
    var icon     = document.getElementById('tl-icon');

    if (input) {
        input.addEventListener('change', function () {
            if (this.files.length) {
                text.textContent = this.files[0].name;
                text.style.color = '#ffad46';
                text.style.fontWeight = '600';
                icon.className = 'fas fa-images fs-2 mb-2 d-block';
                icon.style.color = '#ffad46';
            }
        });
    }

    // Combine date + time into Y-m-d\TH:i format before submit
    var form = document.querySelector('form[action*="timelogs"]');
    if (form) {
        form.addEventListener('submit', function () {
            var date    = document.getElementById('log-date').value;
            var timeIn  = document.getElementById('time-in-picker').value;
            var timeOut = document.getElementById('time-out-picker').value;
            if (date && timeIn)  document.getElementById('time-in-value').value  = date + 'T' + timeIn;
            if (date && timeOut) document.getElementById('time-out-value').value = date + 'T' + timeOut;
        });
    }
});
</script>
@endpush