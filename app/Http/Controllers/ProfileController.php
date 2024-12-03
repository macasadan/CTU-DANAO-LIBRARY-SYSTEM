<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Borrow;
use App\Models\Reservation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
    public function updatePassword(Request $request)
    {
        // Validate and sanitize input
        $validated = $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'string', 'alpha_num', 'min:8', 'confirmed'], // Alphanumeric only
        ]);

        // Check if current password is correct
        if (!Hash::check($validated['current_password'], $request->user()->password)) {
            throw ValidationException::withMessages([
                'current_password' => __('The provided password does not match our records.'),
            ]);
        }

        // Update password
        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('profile.edit')->with('status', 'password-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }


    public function dashboard()
    {
        // Fetch borrowed books for the authenticated user
        $borrowedBooks = Borrow::with('book')
            ->where('user_id', Auth::id())
            ->whereNull('returned_at') // Only fetch books that haven't been returned
            ->get();

        // Pass both variables to the view
        return view('dashboard', compact('borrowedBooks'));
    }
}
