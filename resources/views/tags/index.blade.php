@extends('contacts.layout')
@section('page-title', 'Tags')
@section('page-subtitle', 'Manage your contact tags')

@section('content')
<div class="max-w-2xl">

    {{-- Create Tag Form --}}
    <div class="bg-white rounded-xl border border-slate-200 p-6 mb-6">
        <h2 class="text-sm font-semibold text-slate-700 mb-4">Create New Tag</h2>
        <form action="{{ route('tags.store') }}" method="POST">
            @csrf
            <div class="flex gap-3">
                <input type="text" name="name" placeholder="Tag name e.g. Family"
                       class="flex-1 border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                <select name="color"
                        class="border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                    <option value="indigo">💜 Indigo</option>
                    <option value="blue">💙 Blue</option>
                    <option value="green">💚 Green</option>
                    <option value="yellow">💛 Yellow</option>
                    <option value="red">❤️ Red</option>
                    <option value="pink">🩷 Pink</option>
                </select>
                <button type="submit"
                        class="bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition">
                    Create
                </button>
            </div>
        </form>
    </div>

    {{-- Tags List --}}
    <div class="bg-white rounded-xl border border-slate-200 divide-y divide-slate-100">
        @forelse($tags as $tag)
        <div class="flex items-center justify-between px-5 py-3.5">
            <div class="flex items-center gap-3">
                <span @class([
                    'px-3 py-1 rounded-full text-xs font-medium',
                    'bg-indigo-100 text-indigo-700' => $tag->color === 'indigo',
                    'bg-blue-100 text-blue-700'     => $tag->color === 'blue',
                    'bg-green-100 text-green-700'   => $tag->color === 'green',
                    'bg-yellow-100 text-yellow-700' => $tag->color === 'yellow',
                    'bg-red-100 text-red-700'       => $tag->color === 'red',
                    'bg-pink-100 text-pink-700'     => $tag->color === 'pink',
                ])>{{ $tag->name }}</span>
                <span class="text-xs text-slate-400">
                    {{ $tag->contacts_count }} contacts
                </span>
            </div>
            <form action="{{ route('tags.destroy', $tag) }}" method="POST"
                  onsubmit="return confirm('Delete this tag?')">
                @csrf @method('DELETE')
                <button type="submit"
                        class="text-xs bg-red-50 hover:bg-red-100 text-red-500 px-3 py-1.5 rounded-md transition">
                    Delete
                </button>
            </form>
        </div>
        @empty
        <div class="px-5 py-8 text-center text-slate-400 text-sm">
            No tags yet — create one above!
        </div>
        @endforelse
    </div>

</div>
@endsection