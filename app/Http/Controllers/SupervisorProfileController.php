<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class SupervisorProfileController extends Controller
{
    private function authorizeSupervisor(): void
    {
        if (!Auth::check() || !Auth::user()->isSupervisor()) {
            abort(403, 'Unauthorized action.');
        }
    }

    public function edit(Request $request)
    {
        $this->authorizeSupervisor();

        // Return the supervisor user object and available companies to the view
        $companies = Company::all();
        
        return view('supervisor.profile', [
            'supervisor' => Auth::user(),
            'companies' => $companies
        ]);
    }

    public function update(Request $request)
    {
        $this->authorizeSupervisor();

        // 1. Validation
        $validated = $request->validate([
            'company_id' => ['nullable', 'exists:companies,id', 'integer'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:255'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $user = Auth::user();

        // 2. Handle File Upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if it exists
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            // Store new photo and update path
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $user->profile_photo_path = $path;
        }

        // 3. Update fields
        if ($validated['company_id']) {
            $company = Company::find($validated['company_id']);
            $user->company_id = $company->id;
            $user->company_name = $company->company_name;
        } else {
            $user->company_name = $request->input('company_name');
        }

        $user->department = $validated['department'];

        // Save the user model
        $user->save();

        return redirect()->route('supervisor.profile.edit')
                         ->with('success', 'Profile updated successfully! Department assignment reflected to your assigned students.');
    }
}
