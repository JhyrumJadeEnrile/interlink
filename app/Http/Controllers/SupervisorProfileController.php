<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupervisorProfileController extends Controller
{
    private function authorizeSupervisor(): void
    {
        $user = request()->user();

        if (! $user || ! $user->isSupervisor()) {
            abort(403);
        }
    }

    public function edit(Request $request)
    {
        $this->authorizeSupervisor();

        return view('admin.supervisor-profile', [
            'supervisor' => $request->user(),
        ]);
    }

    public function update(Request $request)
    {
        $this->authorizeSupervisor();

        $validated = $request->validate([
            'company_name' => ['nullable', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
        ]);

        $request->user()->update($validated);

        return back()->with('success', 'Company profile updated successfully.');
    }
}
