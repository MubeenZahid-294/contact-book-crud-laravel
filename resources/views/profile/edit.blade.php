@extends('contacts.layout')
@section('page-title', 'Profile Settings')
@section('page-subtitle', 'Manage your account details')

@section('content')
<div class="max-w-2xl space-y-6">

    {{-- Profile Info --}}
    <div class="bg-white rounded-xl border border-slate-200 p-6">

        {{-- Avatar --}}
        <div class="flex items-center gap-4 mb-6 pb-6 border-b border-slate-100">
            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-brand-500 to-purple-500
                        flex items-center justify-center text-white font-bold text-2xl">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
            <div>
                <p class="font-semibold text-slate-800 text-lg">{{ auth()->user()->name }}</p>
                <p class="text-slate-400 text-sm">{{ auth()->user()->email }}</p>
                <p class="text-xs text-slate-300 mt-0.5">
                    Member since {{ auth()->user()->created_at->format('M Y') }}
                </p>
            </div>
        </div>

        <h2 class="text-sm font-semibold text-slate-700 mb-4">Update Profile</h2>

        <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    Full Name
                </label>
                <input type="text" name="name"
                       value="{{ old('name', auth()->user()->name) }}"
                       class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-sm
                              focus:outline-none focus:ring-2 focus:ring-brand-500
                              @error('name') border-red-400 @enderror">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    Email Address
                </label>
                <input type="email" name="email"
                       value="{{ old('email', auth()->user()->email) }}"
                       class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-sm
                              focus:outline-none focus:ring-2 focus:ring-brand-500
                              @error('email') border-red-400 @enderror">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium
                           px-6 py-2.5 rounded-lg transition">
                Save Changes
            </button>
        </form>
    </div>

    {{-- Change Password --}}
    <div class="bg-white rounded-xl border border-slate-200 p-6">
        <h2 class="text-sm font-semibold text-slate-700 mb-4">Change Password</h2>

        <form action="{{ route('profile.password') }}" method="POST" class="space-y-4">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    Current Password
                </label>
                <input type="password" name="current_password"
                       class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-sm
                              focus:outline-none focus:ring-2 focus:ring-brand-500
                              @error('current_password') border-red-400 @enderror">
                @error('current_password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    New Password
                </label>
                <input type="password" name="password"
                       class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-sm
                              focus:outline-none focus:ring-2 focus:ring-brand-500
                              @error('password') border-red-400 @enderror">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    Confirm New Password
                </label>
                <input type="password" name="password_confirmation"
                       class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-sm
                              focus:outline-none focus:ring-2 focus:ring-brand-500">
            </div>

            <button type="submit"
                    class="bg-slate-800 hover:bg-slate-900 text-white text-sm font-medium
                           px-6 py-2.5 rounded-lg transition">
                Update Password
            </button>
        </form>
    </div>

    {{-- Danger Zone --}}
    <div class="bg-white rounded-xl border border-red-200 p-6">
        <h2 class="text-sm font-semibold text-red-600 mb-1">Danger Zone</h2>
        <p class="text-xs text-slate-400 mb-4">
            Once you delete your account, all contacts and data will be permanently removed.
        </p>
        <form action="{{ route('profile.destroy') }}" method="POST"
              onsubmit="return confirm('Are you sure? This cannot be undone!')">
            @csrf @method('DELETE')
            <button type="submit"
                    class="bg-red-50 hover:bg-red-100 text-red-600 text-sm font-medium
                           px-6 py-2.5 rounded-lg transition border border-red-200">
                Delete My Account
            </button>
        </form>
    </div>

</div>
@endsection