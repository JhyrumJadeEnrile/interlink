<?php

namespace App\Http\Controllers;

use App\Models\OjtDocument;
use App\Models\TimeLog;
use App\Models\WeeklyJournal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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

        return view('students.documents', compact('student', 'documents'));
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

    public function destroyDocument(Request $request, $id)
    {
        $this->authorizeStudent();

        $document = OjtDocument::where('id', $id)
                               ->where('student_id', $request->user()->id)
                               ->firstOrFail();

        Storage::disk('public')->delete($document->file_path);
        $document->delete();

        return back()->with('success', 'Document deleted successfully.');
    }

    public function journals(Request $request)
    {
        $this->authorizeStudent();

        $student = $request->user();
        $journals = $student->journals()->latest()->get();

        return view('students.journals', compact('student', 'journals'));
    }

    public function storeJournal(Request $request)
    {
        $this->authorizeStudent();

        $validated = $request->validate([
            'week_start' => ['required', 'date'],
            'content' => ['required', 'string', 'max:5000'],
            'photo' => ['nullable', 'image', 'max:5120'],
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('journal-photos', 'public');
        }

        WeeklyJournal::create([
            'student_id' => $request->user()->id,
            'week_start' => $validated['week_start'],
            'content' => $validated['content'],
            'photo_path' => $photoPath,
        ]);

        return back()->with('success', 'Weekly journal submitted.');
    }

    public function destroyJournal(Request $request, $id)
    {
        $this->authorizeStudent();

        $journal = WeeklyJournal::where('id', $id)
                                ->where('student_id', $request->user()->id)
                                ->firstOrFail();

        if ($journal->photo_path) {
            Storage::disk('public')->delete($journal->photo_path);
        }

        $journal->delete();

        return back()->with('success', 'Journal entry deleted successfully.');
    }

    public function timelogs(Request $request)
    {
        $this->authorizeStudent();

        $student = $request->user();
        $timelogs = $student->timeLogs()->latest('date')->get();

        return view('students.timelogs', compact('student', 'timelogs'));
    }

    public function submitTimeLog(Request $request)
    {
        $this->authorizeStudent();

        $validated = $request->validate([
            'date'      => ['required', 'date'],
            'time_in'   => ['required', 'date_format:Y-m-d\TH:i'],
            'time_out'  => ['nullable', 'date_format:Y-m-d\TH:i'],
            'location'  => ['nullable', 'string', 'max:255'],
            'photo'     => ['nullable', 'image', 'max:5120'],
        ]);

        $timeIn  = Carbon::parse($validated['time_in']);
        $timeOut = !empty($validated['time_out']) ? Carbon::parse($validated['time_out']) : null;

        if ($timeOut && $timeOut->lessThanOrEqualTo($timeIn)) {
            return back()->withErrors(['time_out' => 'Time-out must be after Time-in.'])->withInput();
        }

        $duration   = $timeOut ? $timeIn->diffInMinutes($timeOut) : 0;
        $student    = $request->user();
        $supervisorId = $student->supervisor_id;

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('time-log-photos', 'public');
        }

        TimeLog::create([
            'student_id'       => $student->id,
            'supervisor_id'    => $supervisorId,
            'date'             => $validated['date'],
            'time_in'          => $timeIn,
            'time_out'         => $timeOut,
            'duration_minutes' => $duration,
            'latitude'         => null,
            'longitude'        => null,
            'location'         => $validated['location'] ?? null,
            'photo_path'       => $photoPath,
            'status'           => TimeLog::STATUS_PENDING,
        ]);

        return back()->with('success', 'Time log submitted for supervisor review.');
    }

    public function profile(Request $request)
    {
        $this->authorizeStudent();
        $student = $request->user();
        return view('students.profile', compact('student'));
    }

    public function updateProfile(Request $request)
    {
        $this->authorizeStudent();
        $student = $request->user();

        $rules = [
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $student->id],
        ];

        if ($request->filled('password')) {
            $rules['current_password']      = ['required'];
            $rules['password']              = ['required', 'min:8', 'confirmed'];
        }

        $request->validate($rules);

        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $student->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.'])->withInput();
            }
            $student->password = Hash::make($request->password);
        }

        $student->name  = $request->name;
        $student->email = $request->email;
        $student->save();

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updateTimeOut(Request $request, $id)
    {
        $this->authorizeStudent();

        $log = TimeLog::where('id', $id)
                      ->where('student_id', $request->user()->id)
                      ->where('status', TimeLog::STATUS_PENDING)
                      ->whereNull('time_out')
                      ->firstOrFail();

        $validated = $request->validate([
            'time_out' => ['required', 'date_format:Y-m-d\TH:i'],
        ]);

        $timeOut = Carbon::parse($validated['time_out']);

        if ($timeOut->lessThanOrEqualTo(Carbon::parse($log->time_in))) {
            return back()->withErrors(['time_out' => 'Time-out must be after Time-in.'])->withInput();
        }

        $duration = Carbon::parse($log->time_in)->diffInMinutes($timeOut);

        $log->update([
            'time_out'         => $timeOut,
            'duration_minutes' => $duration,
        ]);

        return back()->with('success', 'Clock-out time updated successfully.');
    }

    public function destroyTimeLog(Request $request, $id)
    {
        $this->authorizeStudent();

        $log = TimeLog::where('id', $id)
                      ->where('student_id', $request->user()->id)
                      ->where('status', TimeLog::STATUS_PENDING)
                      ->firstOrFail();

        if ($log->photo_path) {
            Storage::disk('public')->delete($log->photo_path);
        }

        $log->delete();

        return back()->with('success', 'Time log deleted successfully.');
    }
}