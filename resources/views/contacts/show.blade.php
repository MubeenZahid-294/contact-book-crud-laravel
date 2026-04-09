@extends('contacts.layout')
@section('page-title', $contact->name)
@section('page-subtitle', $contact->company ?? 'Contact Details')

@section('content')
<div class="max-w-xl">
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-brand-600 to-purple-600 px-6 py-8 flex items-center gap-4">
            @if($contact->photo)
    <img src="{{ Storage::url($contact->photo) }}"
         class="w-16 h-16 rounded-full object-cover border-2 border-white/30">
@else
    <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center text-white font-bold text-2xl">
        {{ strtoupper(substr($contact->name, 0, 2)) }}
    </div>
@endif
            <div>
                <h2 class="text-white font-bold text-xl">{{ $contact->name }}</h2>
                <p class="text-white/70 text-sm">{{ $contact->company ?? 'No company' }}</p>
                @if($contact->is_favorite)
                    <span class="inline-flex items-center gap-1 mt-1 text-yellow-300 text-xs">⭐ Favorite</span>
                @endif
            </div>
        </div>

        {{-- Info --}}
        <div class="p-6 space-y-4">
            @foreach([['✉️', 'Email', $contact->email], ['📞', 'Phone', $contact->phone], ['📍', 'Address', $contact->address]] as [$icon, $label, $value])
            <div class="flex items-start gap-3">
                <span class="text-lg">{{ $icon }}</span>
                <div>
                    <p class="text-xs text-slate-400 uppercase tracking-wider font-medium">{{ $label }}</p>
                    <p class="text-slate-700 text-sm mt-0.5">{{ $value ?? '—' }}</p>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Actions --}}
        <div class="px-6 py-4 border-t border-slate-100 flex gap-3">
            <a href="{{ route('contacts.edit', $contact) }}"
               class="bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition">
                Edit
            </a>
            <form action="{{ route('contacts.favorite', $contact) }}" method="POST">
                @csrf
                <button type="submit"
                        class="bg-yellow-50 hover:bg-yellow-100 text-yellow-600 text-sm font-medium px-5 py-2 rounded-lg transition">
                    {{ $contact->is_favorite ? 'Unfavorite' : '⭐ Favorite' }}
                </button>
            </form>
            <a href="{{ route('contacts.index') }}"
               class="bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-medium px-5 py-2 rounded-lg transition">
                Back
            </a>
        </div>
    </div>
</div>
@endsection