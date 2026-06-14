<?php

namespace App\Http\Controllers;

use App\Models\TimeLog;
use Illuminate\Http\Request;

class SupervisorController extends Controller
{
    private function authorizeSupervisor(): void
    {
        $user = request()->user();

        if (! $user || ! $user->isSupervisor()) {
            abort(403);
        }
    }

    public function pendingLogs(Request $request)
    {
        $this->authorizeSupervisor();

        $supervisor = $request->user();
        $logs = TimeLog::where('supervisor_id', $supervisor->id)
            ->pending()
            ->with('student')
            ->latest('date')
            ->get();

        return view('supervisor.time-approvals', compact('logs'));
    }

    public function approveLog(Request $request, TimeLog $timeLog)
    {
        $this->authorizeSupervisor();

        if ($timeLog->supervisor_id !== $request->user()->id) {
            abort(403);
        }

        $validated = $request->validate([
            'supervisor_signature' => ['required', 'string', 'max:255'],
            'supervisor_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $timeLog->update([
            'status' => TimeLog::STATUS_APPROVED,
            'approved_by' => $request->user()->id,
            'approved_at' => now(),
            'supervisor_signature' => $validated['supervisor_signature'],
            'supervisor_notes' => $validated['supervisor_notes'],
        ]);

        return back()->with('success', 'Time log approved successfully.');
    }

    public function rejectLog(Request $request, TimeLog $timeLog)
    {
        $this->authorizeSupervisor();

        if ($timeLog->supervisor_id !== $request->user()->id) {
            abort(403);
        }

        $validated = $request->validate([
            'supervisor_notes' => ['required', 'string', 'max:2000'],
        ]);

        $timeLog->update([
            'status' => TimeLog::STATUS_REJECTED,
            'approved_by' => $request->user()->id,
            'approved_at' => now(),
            'supervisor_notes' => $validated['supervisor_notes'],
        ]);

        return back()->with('success', 'Time log rejected.');
    }
}
