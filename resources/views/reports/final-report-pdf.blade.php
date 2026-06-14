<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Final OJT Report</title>
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
        .header { margin-bottom: 24px; }
        .student-card { border: 1px solid #ccc; padding: 16px; margin-bottom: 16px; }
        .student-title { font-size: 18px; margin-bottom: 8px; }
        .field { margin-bottom: 6px; }
        .label { font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Final OJT Report</h1>
        <p>Summary of student hours, journal submissions, and internship completion status.</p>
    </div>

    @foreach ($students as $student)
        <div class="student-card">
            <div class="student-title">{{ $student->name }} ({{ $student->email }})</div>
            <div class="field"><span class="label">Required Hours:</span> {{ $student->required_hours ?? 'Not set' }}</div>
            <div class="field"><span class="label">Completed Hours:</span> {{ number_format($student->hoursCompleted(), 2) }}</div>
            <div class="field"><span class="label">Journal Entries:</span> {{ $student->journals->count() }}</div>
            <div class="field"><span class="label">Approved Time Logs:</span> {{ $student->timeLogs()->approved()->count() }}</div>
            <div class="field"><span class="label">Progress:</span> {{ $student->progressPercentage() }}%</div>
        </div>
    @endforeach
</body>
</html>
