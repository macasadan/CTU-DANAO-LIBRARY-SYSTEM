<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function submitMessage(Request $request)
    {
        $validatedData = $request->validate([
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
            'message' => 'required|string|max:1000'
        ]);
    
        Message::create($validatedData);
    
        return back()->with('success', 'Your message has been sent successfully!');
    }
}
