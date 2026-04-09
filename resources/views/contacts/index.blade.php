@extends('contacts.layout')

@section('page-title', request('filter') === 'favorites' ? '⭐ Favorites' : 'All Contacts')
@section('page-subtitle', $totalCount . ' total · ' . $favCount . ' favorites')

@section('content')

{{-- Stats Row --}}
<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-slate-200 px-5 py-4">
        <p class="text-xs text-slate-400 font-medium uppercase tracking-wider">Total</p>
        <p class="text-3xl font-bold text-slate-800 mt-1">{{ $totalCount }}</p>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 px-5 py-4">
        <p class="text-xs text-slate-400 font-medium uppercase tracking-wider">Favorites</p>
        <p class="text-3xl font-bold text-yellow-500 mt-1">{{ $favCount }}</p>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 px-5 py-4">
        <p class="text-xs text-slate-400 font-medium uppercase tracking-wider">This Page</p>
        <p class="text-3xl font-bold text-brand-600 mt-1">{{ $contacts->count() }}</p>
    </div>
</div>
{{-- Tag Filters --}}
@if($userTags->count() > 0)
<div class="flex flex-wrap gap-2 mb-4">
    <a href="{{ route('contacts.index') }}"
       class="px-3 py-1.5 rounded-full text-xs font-medium transition
              {{ !request('tag') ? 'bg-brand-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
        All
    </a>
    @foreach($userTags as $tag)
    <a href="{{ route('contacts.index', ['tag' => $tag->id]) }}"
       @class([
           'px-3 py-1.5 rounded-full text-xs font-medium transition border-2',
           'border-indigo-400 bg-indigo-100 text-indigo-700' => $tag->color === 'indigo' && request('tag') == $tag->id,
           'border-transparent bg-indigo-100 text-indigo-700' => $tag->color === 'indigo' && request('tag') != $tag->id,
           'border-blue-400 bg-blue-100 text-blue-700'     => $tag->color === 'blue' && request('tag') == $tag->id,
           'border-transparent bg-blue-100 text-blue-700'  => $tag->color === 'blue' && request('tag') != $tag->id,
           'border-green-400 bg-green-100 text-green-700'  => $tag->color === 'green' && request('tag') == $tag->id,
           'border-transparent bg-green-100 text-green-700' => $tag->color === 'green' && request('tag') != $tag->id,
           'border-yellow-400 bg-yellow-100 text-yellow-700' => $tag->color === 'yellow' && request('tag') == $tag->id,
           'border-transparent bg-yellow-100 text-yellow-700' => $tag->color === 'yellow' && request('tag') != $tag->id,
           'border-red-400 bg-red-100 text-red-700'        => $tag->color === 'red' && request('tag') == $tag->id,
           'border-transparent bg-red-100 text-red-700'    => $tag->color === 'red' && request('tag') != $tag->id,
           'border-pink-400 bg-pink-100 text-pink-700'     => $tag->color === 'pink' && request('tag') == $tag->id,
           'border-transparent bg-pink-100 text-pink-700'  => $tag->color === 'pink' && request('tag') != $tag->id,
       ])>
        {{ $tag->name }}
    </a>
    @endforeach
</div>
@endif
{{-- Export Button --}}
<div class="flex justify-end mb-3">
    <a href="{{ route('contacts.export') }}"
       class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium px-4 py-2.5 rounded-lg transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
        </svg>
        Export CSV
    </a>
</div>
{{-- Search & Sort --}}
<form method="GET" action="{{ route('contacts.index') }}" class="flex gap-3 mb-6">
    @if(request('filter'))
        <input type="hidden" name="filter" value="{{ request('filter') }}">
    @endif
    <div class="relative flex-1">
        <svg class="absolute left-3 top-2.5 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M21 21l-4.35-4.35M17 11A6 6 0 105 11a6 6 0 0012 0z"/>
        </svg>
        <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
       placeholder="Search by name, email, phone or company..."
       class="w-full pl-9 pr-4 py-2.5 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 bg-white"
       autocomplete="off">
    </div>
    <select name="sort" class="border border-slate-200 rounded-lg px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-brand-500">
        <option value="name"       {{ $sortField === 'name'       ? 'selected' : '' }}>Sort: Name</option>
        <option value="company"    {{ $sortField === 'company'    ? 'selected' : '' }}>Sort: Company</option>
        <option value="created_at" {{ $sortField === 'created_at' ? 'selected' : '' }}>Sort: Newest</option>
    </select>
    <select name="direction" class="border border-slate-200 rounded-lg px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-brand-500">
        <option value="asc"  {{ $sortDir === 'asc'  ? 'selected' : '' }}>↑ Asc</option>
        <option value="desc" {{ $sortDir === 'desc' ? 'selected' : '' }}>↓ Desc</option>
    </select>
    <button type="submit"
            class="bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition">
        Search
    </button>
    @if(request('search'))
        <a href="{{ route('contacts.index', array_filter(['filter' => request('filter')])) }}"
           class="bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-medium px-4 py-2.5 rounded-lg transition">
            Clear
        </a>
    @endif
</form>

{{-- Contact Cards Grid --}}
@if($contacts->isEmpty())
    <div class="text-center py-24 text-slate-400">
        <p class="text-5xl mb-3">📭</p>
        <p class="text-lg font-medium text-slate-600">No contacts found</p>
        <p class="text-sm mt-1">Try a different search or add a new contact</p>
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($contacts as $contact)
        <div class="bg-white rounded-xl border border-slate-200 p-5 hover:shadow-md transition-shadow group relative">

            {{-- Favorite button --}}
            <form action="{{ route('contacts.favorite', $contact) }}" method="POST" class="absolute top-4 right-4">
                @csrf
                <button type="submit" title="Toggle Favorite">
                    <svg class="w-5 h-5 transition {{ $contact->is_favorite ? 'text-yellow-400 fill-yellow-400' : 'text-slate-300 fill-transparent hover:text-yellow-300' }}"
                         stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                </button>
            </form>

            {{-- Avatar + Name --}}
            <div class="flex items-center gap-3 mb-4">
               @if($contact->photo)
    <img src="{{ Storage::url($contact->photo) }}"
         class="w-11 h-11 rounded-full object-cover flex-shrink-0 border-2 border-slate-100">
@else
    <div class="w-11 h-11 rounded-full bg-gradient-to-br from-brand-500 to-purple-500 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
        {{ strtoupper(substr($contact->name, 0, 2)) }}
    </div>
@endif
                <div class="min-w-0 pr-6">
                    <p class="font-semibold text-slate-800 truncate">{{ $contact->name }}</p>
                    <p class="text-xs text-slate-400 truncate">{{ $contact->company ?? 'No company' }}</p>
                </div>
            </div>

            {{-- Details --}}
            <div class="space-y-1.5 mb-4">
                @if($contact->email)
                <p class="text-xs text-slate-500 flex items-center gap-1.5 truncate">
                    <span class="text-slate-300">✉</span> {{ $contact->email }}
                </p>
                @endif
                @if($contact->phone)
                <p class="text-xs text-slate-500 flex items-center gap-1.5">
                    <span class="text-slate-300">📞</span> {{ $contact->phone }}
                </p>
                @endif
                @if($contact->address)
                <p class="text-xs text-slate-500 flex items-center gap-1.5 truncate">
                    <span class="text-slate-300">📍</span> {{ $contact->address }}
                </p>
                @endif
            </div>
           
            {{-- Tags ← ADD THIS --}}
            @if($contact->tags->count() > 0)
            <div class="flex flex-wrap gap-1 mb-3">
                @foreach($contact->tags as $tag)
                <span @class([
                    'px-2 py-0.5 rounded-full text-xs font-medium',
                    'bg-indigo-100 text-indigo-700' => $tag->color === 'indigo',
                    'bg-blue-100 text-blue-700'     => $tag->color === 'blue',
                    'bg-green-100 text-green-700'   => $tag->color === 'green',
                    'bg-yellow-100 text-yellow-700' => $tag->color === 'yellow',
                    'bg-red-100 text-red-700'       => $tag->color === 'red',
                    'bg-pink-100 text-pink-700'     => $tag->color === 'pink',
                ])>{{ $tag->name }}</span>
                @endforeach
            </div>
            @endif

            {{-- Actions --}}
            <div class="flex gap-2 pt-3 border-t border-slate-100">
                <a href="{{ route('contacts.show', $contact) }}"
                   class="flex-1 text-center text-xs bg-slate-50 hover:bg-slate-100 text-slate-600 px-3 py-1.5 rounded-md transition font-medium">
                    View
                </a>
                <a href="{{ route('contacts.edit', $contact) }}"
                   class="flex-1 text-center text-xs bg-brand-50 hover:bg-brand-100 text-brand-600 px-3 py-1.5 rounded-md transition font-medium">
                    Edit
                </a>
                <form action="{{ route('contacts.destroy', $contact) }}" method="POST"
                      onsubmit="return confirm('Delete {{ $contact->name }}?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="text-xs bg-red-50 hover:bg-red-100 text-red-500 px-3 py-1.5 rounded-md transition font-medium">
                        Delete
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-6">{{ $contacts->links() }}</div>
@endif
{{-- Live Search Script --}}
<script>
    const searchInput = document.getElementById('searchInput');
    let searchTimer;

    searchInput.addEventListener('input', function () {
        clearTimeout(searchTimer);

        const query = this.value;

        // Show loading indicator
        searchInput.classList.add('opacity-50');

        searchTimer = setTimeout(() => {
            const url = new URL(window.location.href);
            url.searchParams.set('search', query);

            // Keep existing filters
            @if(request('filter'))
                url.searchParams.set('filter', '{{ request('filter') }}');
            @endif
            @if(request('sort'))
                url.searchParams.set('sort', '{{ request('sort') }}');
            @endif
            @if(request('direction'))
                url.searchParams.set('direction', '{{ request('direction') }}');
            @endif

            // Remove search param if empty
            if (!query) {
                url.searchParams.delete('search');
            }

            window.location.href = url.toString();
        }, 500); // 500ms delay after typing stops
    });
</script>
@endsection