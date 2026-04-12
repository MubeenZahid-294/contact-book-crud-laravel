@extends('contacts.layout')
@section('page-title', 'Add New Contact')
@section('page-subtitle', 'Fill in the details below')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-slate-200 p-6">
        <form action="{{ route('contacts.store') }}" method="POST"
              enctype="multipart/form-data" class="space-y-5">
            @csrf
            {{-- Validation Error Summary --}}
@if($errors->any())
<div class="col-span-2 bg-red-50 border border-red-200 rounded-lg px-4 py-3">
    <p class="text-red-600 text-sm font-medium mb-1">
        Please fix the following errors:
    </p>
    <ul class="list-disc list-inside space-y-0.5">
        @foreach($errors->all() as $error)
            <li class="text-red-500 text-xs">{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
            <div class="grid grid-cols-2 gap-4">

                <div class="col-span-2 sm:col-span-1">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="John Doe"
                           class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 @error('name') border-red-400 @enderror">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="col-span-2 sm:col-span-1">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Company</label>
                    <input type="text" name="company" value="{{ old('company') }}" placeholder="Acme Corp"
                           class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                </div>

                <div class="col-span-2 sm:col-span-1">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="john@example.com"
                           class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 @error('email') border-red-400 @enderror">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="col-span-2 sm:col-span-1">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+92 300 1234567"
                           class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Address</label>
                    <textarea name="address" rows="2" placeholder="123 Main Street, Lahore"
                              class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">{{ old('address') }}</textarea>
                </div>

                {{-- Profile Photo --}}
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Profile Photo</label>
                    <input type="file" name="photo" accept="image/*"
                           class="w-full border border-slate-200 rounded-lg px-4 py-2 text-sm text-slate-500
                                  file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0
                                  file:text-sm file:font-medium file:bg-brand-50 file:text-brand-600
                                  hover:file:bg-brand-100 cursor-pointer">
                    @error('photo')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>
            {{-- Tags --}}
            @if($userTags->count() > 0)
            <div class="col-span-2">
                <label class="block text-sm font-medium text-slate-700 mb-2">Tags</label>
                <div class="flex flex-wrap gap-2">
                    @foreach($userTags as $tag)
                    <label class="flex items-center gap-1.5 cursor-pointer">
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                               class="rounded border-slate-300 text-brand-600">
                        <span @class([
                            'px-2.5 py-1 rounded-full text-xs font-medium',
                            'bg-indigo-100 text-indigo-700' => $tag->color === 'indigo',
                            'bg-blue-100 text-blue-700'     => $tag->color === 'blue',
                            'bg-green-100 text-green-700'   => $tag->color === 'green',
                            'bg-yellow-100 text-yellow-700' => $tag->color === 'yellow',
                            'bg-red-100 text-red-700'       => $tag->color === 'red',
                            'bg-pink-100 text-pink-700'     => $tag->color === 'pink',
                        ])>{{ $tag->name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Submit Buttons --}}
            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium px-6 py-2.5 rounded-lg transition">
                    Save Contact
                </button>
                <a href="{{ route('contacts.index') }}"
                   class="bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-medium px-6 py-2.5 rounded-lg transition">
                    Cancel
                </a>
            </div>

        </form>
    </div>
</div>
<script>
// Real-time name validation
document.querySelector('input[name="name"]').addEventListener('input', function() {
    const val     = this.value;
    const error   = document.getElementById('nameError');
    const isValid = /^[a-zA-Z\s]+$/.test(val) && val.length >= 3;

    this.classList.toggle('border-red-400',   !isValid && val.length > 0);
    this.classList.toggle('border-green-400',  isValid);

    if (error) {
        error.textContent = !isValid && val.length > 0
            ? (val.length < 3 ? 'Name must be at least 3 characters.' : 'Name can only contain letters.')
            : '';
    }
});

// Real-time phone validation
const phoneInput = document.querySelector('input[name="phone"]');
if (phoneInput) {
    phoneInput.addEventListener('input', function() {
        const val     = this.value;
        const isValid = /^[0-9\+\-\s]+$/.test(val) && val.length >= 7;

        this.classList.toggle('border-red-400',  !isValid && val.length > 0);
        this.classList.toggle('border-green-400', isValid);
    });
}

// Real-time email validation
const emailInput = document.querySelector('input[name="email"]');
if (emailInput) {
    emailInput.addEventListener('input', function() {
        const val     = this.value;
        const isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val);

        this.classList.toggle('border-red-400',  !isValid && val.length > 0);
        this.classList.toggle('border-green-400', isValid && val.length > 0);
    });
}
</script>
@endsection