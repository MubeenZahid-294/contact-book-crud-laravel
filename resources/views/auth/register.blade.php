<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <div class="relative">
    <x-text-input id="password"
                  class="block mt-1 w-full pr-10"
                  type="password"
                  name="password"
                  required autocomplete="new-password" />
    <button type="button"
            onclick="togglePassword('password', 'eyeIcon1')"
            class="absolute right-3 top-2.5 text-slate-400 hover:text-slate-600">
        <svg id="eyeIcon1" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
        </svg>
    </button>
</div>
<p class="text-xs text-slate-400 mt-1">
    Must be at least 8 characters and contain:
    uppercase, lowercase, number and symbol.
    <br>
    Example:
    <span class="font-mono text-slate-500">MyPass@123</span>
</p>

{{-- ↓ ADD THIS RIGHT HERE ↓ --}}
<div class="mt-2">
    <div class="flex gap-1">
        <div id="s1" class="h-1 flex-1 rounded bg-slate-200"></div>
        <div id="s2" class="h-1 flex-1 rounded bg-slate-200"></div>
        <div id="s3" class="h-1 flex-1 rounded bg-slate-200"></div>
        <div id="s4" class="h-1 flex-1 rounded bg-slate-200"></div>
    </div>
    <p id="strengthLabel" class="text-xs mt-1 text-slate-400"></p>
</div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <div class="relative">
    <x-text-input id="password_confirmation"
                  class="block mt-1 w-full pr-10"
                  type="password"
                  name="password_confirmation"
                  required autocomplete="new-password" />
    <button type="button"
            onclick="togglePassword('password_confirmation', 'eyeIcon2')"
            class="absolute right-3 top-2.5 text-slate-400 hover:text-slate-600">
        <svg id="eyeIcon2" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
        </svg>
    </button>
</div>

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
    <script>
function togglePassword(fieldId, iconId) {
    const field = document.getElementById(fieldId);
    const icon  = document.getElementById(iconId);

    if (field.type === 'password') {
        field.type = 'text';
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 4.411m0 0L21 21"/>`;
    } else {
        field.type = 'password';
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
    }
}
</script>
<script>
document.getElementById('password').addEventListener('input', function() {
    const val      = this.value;
    let   strength = 0;

    if (val.length >= 8)          strength++;
    if (/[A-Z]/.test(val))        strength++;
    if (/[0-9]/.test(val))        strength++;
    if (/[^a-zA-Z0-9]/.test(val)) strength++;

    const colors = ['bg-red-400', 'bg-orange-400', 'bg-yellow-400', 'bg-green-500'];
    const labels = ['Weak', 'Fair', 'Good', 'Strong'];

    for (let i = 1; i <= 4; i++) {
        const bar = document.getElementById('s' + i);
        bar.className = 'h-1 flex-1 rounded ' +
            (i <= strength ? colors[strength - 1] : 'bg-slate-200');
    }

    document.getElementById('strengthLabel').textContent =
        val.length > 0 ? 'Strength: ' + (labels[strength - 1] || 'Too weak') : '';
});
</script>
</x-guest-layout>
