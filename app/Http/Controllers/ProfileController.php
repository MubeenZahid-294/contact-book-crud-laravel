<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
    'name'  => [
        'required',
        'string',
        'min:3',
        'max:100',
        'regex:/^[a-zA-Z\s]+$/'
    ],
    'email' => [
        'required',
        'email',
        'max:100',
        'unique:users,email,' . $user->id,
    ],
], [
    'name.required'  => 'Name is required.',
    'name.min'       => 'Name must be at least 3 characters.',
    'name.regex'     => 'Name can only contain letters and spaces.',
    'email.required' => 'Email is required.',
    'email.email'    => 'Please enter a valid email address.',
    'email.unique'   => 'This email is already taken.',
]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
    'current_password' => [
        'required',
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
    'current_password.required' => 'Please enter your current password.',
    'password.required'         => 'New password is required.',
    'password.confirmed'        => 'Passwords do not match.',
]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        auth()->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password updated successfully!');
    }
    public function destroy(Request $request)
{
    $user = auth()->user();

    auth()->logout();

    $user->delete();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/')->with('success', 'Account deleted successfully.');
}
}
