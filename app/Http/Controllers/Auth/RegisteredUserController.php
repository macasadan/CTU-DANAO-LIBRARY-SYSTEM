<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Rules\StrongPassword;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s\'-]+$/', // Allow apostrophes and hyphens
                function ($attribute, $value, $fail) {
                    if (str_contains(strtolower($value), 'admin')) {
                        $fail('Name contains restricted words.');
                    }
                }
            ],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email:rfc,dns', // Added DNS validation
                'max:255',
                'unique:' . User::class
            ],

            'password' => ['required', 'confirmed',  'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/', new StrongPassword],

        ]);

        $user = User::create([
            'name' => strip_tags(trim($request->name)),
            'email' => filter_var($request->email, FILTER_SANITIZE_EMAIL),
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
