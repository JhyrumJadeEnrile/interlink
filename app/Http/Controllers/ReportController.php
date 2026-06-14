<?php

namespace App\Http\Controllers;

use App\Models\TimeLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ReportController extends Controller
{
    public function finalOjtReport(Request $request)
    {
        $user = $request->user();

        if ($user->isStudent()) {
            $students = collect([$user]);
        } elseif ($user->isCoordinator() || $user->isAdmin()) {
            $students = User::where('role', 'student')->with(['journals', 'timeLogs', 'evaluations'])->get();
        } else {
            abort(403);
        }

        $completed = $students->filter(fn (User $student) => $student->required_hours && $student->hoursCompleted() >= $student->required_hours);
        $pending = $students->filter(fn (User $student) => ! ($student->required_hours && $student->hoursCompleted() >= $student->required_hours));

        return view('reports.final-report', compact('students', 'completed', 'pending'));
    }

    public function downloadPdf(Request $request)
    {
        $user = $request->user();

        if (! ($user->isCoordinator() || $user->isAdmin())) {
            abort(403);
        }

        if (! class_exists(\Dompdf\Dompdf::class)) {
            return back()->with('warning', 'PDF export requires the barryvdh/laravel-dompdf package.');
        }

        $students = User::where('role', 'student')->with(['journals', 'timeLogs', 'evaluations'])->get();
        $view = View::make('reports.final-report-pdf', compact('students'))->render();

        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($view);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="ojt-final-report.pdf"',
        ]);
    }
}
