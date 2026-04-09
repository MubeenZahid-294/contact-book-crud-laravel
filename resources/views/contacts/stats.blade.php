@extends('contacts.layout')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Your contacts overview')

@section('content')

{{-- Stats Cards --}}
<div class="grid grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-slate-200 px-5 py-4">
        <p class="text-xs text-slate-400 font-medium uppercase tracking-wider">Total</p>
        <p class="text-3xl font-bold text-slate-800 mt-1">{{ $totalCount }}</p>
        <p class="text-xs text-slate-400 mt-1">All contacts</p>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 px-5 py-4">
        <p class="text-xs text-slate-400 font-medium uppercase tracking-wider">Favorites</p>
        <p class="text-3xl font-bold text-yellow-500 mt-1">{{ $favCount }}</p>
        <p class="text-xs text-slate-400 mt-1">Starred contacts</p>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 px-5 py-4">
        <p class="text-xs text-slate-400 font-medium uppercase tracking-wider">Tags</p>
        <p class="text-3xl font-bold text-brand-600 mt-1">{{ $tagStats->count() }}</p>
        <p class="text-xs text-slate-400 mt-1">Active tags</p>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 px-5 py-4">
        <p class="text-xs text-slate-400 font-medium uppercase tracking-wider">This Month</p>
        <p class="text-3xl font-bold text-green-500 mt-1">{{ $chartData->last()['count'] }}</p>
        <p class="text-xs text-slate-400 mt-1">New contacts</p>
    </div>
</div>

<div class="grid grid-cols-3 gap-6">

    {{-- Growth Chart --}}
    <div class="col-span-2 bg-white rounded-xl border border-slate-200 p-6">
        <h2 class="text-sm font-semibold text-slate-700 mb-6">
            Contacts Growth — Last 6 Months
        </h2>
        <div class="flex items-end gap-3 h-48">
            @php $max = max($chartData->pluck('count')->max(), 1); @endphp
            @foreach($chartData as $data)
            <div class="flex-1 flex flex-col items-center gap-2">
                <span class="text-xs font-semibold text-slate-600">
                    {{ $data['count'] }}
                </span>
                <div class="w-full rounded-t-lg bg-brand-600 transition-all duration-500"
                     style="height: {{ max(($data['count'] / $max) * 160, 4) }}px; opacity: {{ 0.5 + ($loop->index / count($chartData)) * 0.5 }}">
                </div>
                <span class="text-xs text-slate-400">{{ $data['month'] }}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Tag Distribution --}}
    <div class="bg-white rounded-xl border border-slate-200 p-6">
        <h2 class="text-sm font-semibold text-slate-700 mb-4">
            Top Tags
        </h2>
        @if($tagStats->count() > 0)
            @php $maxTag = max($tagStats->pluck('contacts_count')->max(), 1); @endphp
            <div class="space-y-3">
                @foreach($tagStats as $tag)
                <div>
                    <div class="flex justify-between mb-1">
                        <span @class([
                            'px-2 py-0.5 rounded-full text-xs font-medium',
                            'bg-indigo-100 text-indigo-700' => $tag->color === 'indigo',
                            'bg-blue-100 text-blue-700'     => $tag->color === 'blue',
                            'bg-green-100 text-green-700'   => $tag->color === 'green',
                            'bg-yellow-100 text-yellow-700' => $tag->color === 'yellow',
                            'bg-red-100 text-red-700'       => $tag->color === 'red',
                            'bg-pink-100 text-pink-700'     => $tag->color === 'pink',
                        ])>{{ $tag->name }}</span>
                        <span class="text-xs text-slate-400">
                            {{ $tag->contacts_count }}
                        </span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-1.5">
                        <div @class([
                            'h-1.5 rounded-full transition-all duration-500',
                            'bg-indigo-500' => $tag->color === 'indigo',
                            'bg-blue-500'   => $tag->color === 'blue',
                            'bg-green-500'  => $tag->color === 'green',
                            'bg-yellow-500' => $tag->color === 'yellow',
                            'bg-red-500'    => $tag->color === 'red',
                            'bg-pink-500'   => $tag->color === 'pink',
                        ]) style="width: {{ ($tag->contacts_count / $maxTag) * 100 }}%">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <p class="text-sm text-slate-400 text-center py-8">
                No tags yet —
                <a href="{{ route('tags.index') }}"
                   class="text-brand-600 hover:underline">
                   create some!
                </a>
            </p>
        @endif
    </div>

</div>

@endsection