<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
    'name'     => [
        'required',
        'string',
        'min:3',
        'max:100',
        'regex:/^[a-zA-Z\s]+$/'
    ],
    'email'    => [
        'required',
        'email',
        'max:100',
        'unique:users',
    ],
    'password' => [
        'required',
        'confirmed',
        Password::min(8)
            ->mixedCase()
            ->numbers()
            ->symbols()
    ],
], [
    'name.required'      => 'Your name is required.',
    'name.min'           => 'Name must be at least 3 characters.',
    'name.regex'         => 'Name can only contain letters and spaces.',
    'email.required'     => 'Email address is required.',
    'email.email'        => 'Please enter a valid email address.',
    'email.unique'       => 'This email is already registered.',
    'password.required'  => 'Password is required.',
    'password.confirmed' => 'Passwords do not match.',
]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->intended(route('contacts.index'));
    }
}
