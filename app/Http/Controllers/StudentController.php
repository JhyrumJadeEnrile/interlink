<?php

namespace App\Http\Controllers;

use App\Models\OjtDocument;
use App\Models\TimeLog;
use App\Models\WeeklyJournal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    private function authorizeStudent(): void
    {
        $user = request()->user();

        if (! $user || ! $user->isStudent()) {
            abort(403);
        }
    }

    public function documents(Request $request)
    {
        $this->authorizeStudent();

        $student = $request->user();
        $documents = $student->documents()->latest('uploaded_at')->get();

        return view('student.documents', compact('student', 'documents'));
    }

    public function uploadDocument(Request $request)
    {
        $this->authorizeStudent();

        $validated = $request->validate([
            'document_type' => ['required', 'string', 'in:Resume,Consent Form,Internship Agreement'],
            'document' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ]);

        $file = $request->file('document');
        $path = $file->store('ojt-documents', 'public');

        OjtDocument::create([
            'student_id' => $request->user()->id,
            'document_type' => $validated['document_type'],
            'filename' => $file->getClientOriginalName(),
            'file_path' => $path,
            'uploaded_at' => now(),
        ]);

        return back()->with('success', 'Document uploaded successfully.');
    }

    public function journals(Request $request)
    {
        $this->authorizeStudent();

        $student = $request->user();
        $journals = $student->journals()->latest()->get();

        return view('student.journals', compact('student', 'journals'));
    }

    public function storeJournal(Request $request)
    {
        $this->authorizeStudent();

        $validated = $request->validate([
            'week_start' => ['required', 'date'],
            'content' => ['required', 'string', 'max:5000'],
        ]);

        WeeklyJournal::create([
            'student_id' => $request->user()->id,
            'week_start' => $validated['week_start'],
            'content' => $validated['content'],
        ]);

        return back()->with('success', 'Weekly journal submitted.');
    }

    public function timelogs(Request $request)
    {
        $this->authorizeStudent();

        $student = $request->user();
        $timelogs = $student->timeLogs()->latest('date')->get();

        return view('student.timelogs', compact('student', 'timelogs'));
    }

    public function submitTimeLog(Request $request)
    {
        $this->authorizeStudent();

        $validated = $request->validate([
            'date' => ['required', 'date'],
            'time_in' => ['required', 'date_format:Y-m-d\TH:i'],
            'time_out' => ['required', 'date_format:Y-m-d\TH:i'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'photo' => ['nullable', 'image', 'max:5120'],
        ]);

        $timeIn = Carbon::parse($validated['time_in']);
        $timeOut = Carbon::parse($validated['time_out']);

        if ($timeOut->lessThanOrEqualTo($timeIn)) {
            return back()->withErrors(['time_out' => 'Time-out must be after Time-in.'])->withInput();
        }

        $duration = $timeOut->diffInMinutes($timeIn);
        $student = $request->user();
        $supervisorId = $student->supervisor_id;

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('time-log-photos', 'public');
        }

        TimeLog::create([
            'student_id' => $student->id,
            'supervisor_id' => $supervisorId,
            'date' => $validated['date'],
            'time_in' => $timeIn,
            'time_out' => $timeOut,
            'duration_minutes' => $duration,
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'photo_path' => $photoPath,
            'status' => TimeLog::STATUS_PENDING,
        ]);

        return back()->with('success', 'Time log submitted for supervisor review.');
    }
}
