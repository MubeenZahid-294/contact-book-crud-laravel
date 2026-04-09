<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Helpers\NotificationHelper;

class ContactController extends Controller
{

    public function index(Request $request)
{
    $query = Contact::owned()->with('tags');

    if ($request->filled('search')) {
        $query->search($request->search);
    }

    if ($request->filter === 'favorites') {
        $query->where('is_favorite', true);
    }

    if ($request->filled('tag')) {
        $query->whereHas('tags', fn($q) => $q->where('tags.id', $request->tag));
    }

    $sortField = in_array($request->sort, ['name', 'email', 'company', 'created_at'])
        ? $request->sort : 'name';
    $sortDir = $request->direction === 'desc' ? 'desc' : 'asc';
    $query->orderBy($sortField, $sortDir);

    $contacts   = $query->paginate(9)->withQueryString();
    $totalCount = Contact::owned()->count();
    $favCount   = Contact::owned()->where('is_favorite', true)->count();
    $userTags   = \App\Models\Tag::where('user_id', auth()->id())->get();

    // Chart data — contacts added per month (last 6 months)
    $chartData = collect(range(5, 0))->map(function ($i) {
        $month = now()->subMonths($i);
        return [
            'month' => $month->format('M'),
            'count' => Contact::owned()
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count(),
        ];
    });

    // Tag distribution
    $tagStats = \App\Models\Tag::where('user_id', auth()->id())
                ->withCount('contacts')
                ->orderByDesc('contacts_count')
                ->take(5)
                ->get();

    return view('contacts.index', compact(
        'contacts', 'totalCount', 'favCount',
        'sortField', 'sortDir', 'userTags',
        'chartData', 'tagStats'
    ));
}

    public function create()
{
    $userTags = \App\Models\Tag::where('user_id', auth()->id())->get();
    return view('contacts.create', compact('userTags'));
}

    public function store(Request $request)
{
    $data = $request->validate([
        'name'    => 'required|string|max:100',
        'email'   => 'nullable|email|max:100',
        'phone'   => 'nullable|string|max:20',
        'company' => 'nullable|string|max:100',
        'address' => 'nullable|string|max:255',
        'photo'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'tags'    => 'nullable|array',
        'tags.*'  => 'exists:tags,id',
    ]);

    if ($request->hasFile('photo')) {
        $data['photo'] = $request->file('photo')->store('photos', 'public');
    }

    $data['user_id'] = auth()->id();
    $contact = Contact::create($data);

    if ($request->filled('tags')) {
        $contact->tags()->sync($request->tags);
    }

    NotificationHelper::create("Added contact: {$contact->name}", 'success', 'contact');

return redirect()->route('contacts.index')
                 ->with('success', 'Contact added successfully!');
}

    public function show(Contact $contact)
    {
        abort_if($contact->user_id !== auth()->id(), 403);
        return view('contacts.show', compact('contact'));
    }

    public function edit(Contact $contact)
{
    abort_if($contact->user_id !== auth()->id(), 403);
    $userTags = \App\Models\Tag::where('user_id', auth()->id())->get();
    return view('contacts.edit', compact('contact', 'userTags'));
}

    public function update(Request $request, Contact $contact)
{
    abort_if($contact->user_id !== auth()->id(), 403);

    $data = $request->validate([
        'name'    => 'required|string|max:100',
        'email'   => 'nullable|email|max:100',
        'phone'   => 'nullable|string|max:20',
        'company' => 'nullable|string|max:100',
        'address' => 'nullable|string|max:255',
        'photo'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'tags'    => 'nullable|array',
        'tags.*'  => 'exists:tags,id',
    ]);

    if ($request->hasFile('photo')) {
        if ($contact->photo) {
            \Storage::disk('public')->delete($contact->photo);
        }
        $data['photo'] = $request->file('photo')->store('photos', 'public');
    }

    $contact->update($data);
    $contact->tags()->sync($request->tags ?? []);

    NotificationHelper::create("Updated contact: {$contact->name}", 'info', 'edit');

return redirect()->route('contacts.index')
                 ->with('success', 'Contact updated successfully!');
}

    public function destroy(Contact $contact)
{
    abort_if($contact->user_id !== auth()->id(), 403);

    if ($contact->photo) {
        \Storage::disk('public')->delete($contact->photo);
    }

    $contact->delete();

    NotificationHelper::create("Deleted contact: {$contact->name}", 'danger', 'delete');

return redirect()->route('contacts.index')
                 ->with('success', 'Contact deleted.');
}

    public function toggleFavorite(Contact $contact)
    {
        abort_if($contact->user_id !== auth()->id(), 403);
        $contact->update(['is_favorite' => !$contact->is_favorite]);

        return back()->with('success', $contact->is_favorite
            ? 'Added to favorites!'
            : 'Removed from favorites.');
    }
    public function export()
{
    $contacts = Contact::owned()->get();

    $filename = 'contacts_' . now()->format('Y_m_d') . '.csv';
    $headers  = [
        'Content-Type'        => 'text/csv',
        'Content-Disposition' => "attachment; filename=\"$filename\"",
    ];

    $callback = function () use ($contacts) {
        $file = fopen('php://output', 'w');

        // CSV Header Row
        fputcsv($file, ['Name', 'Email', 'Phone', 'Company', 'Address', 'Favorite', 'Added On']);

        // CSV Data Rows
        foreach ($contacts as $contact) {
            fputcsv($file, [
                $contact->name,
                $contact->email ?? '',
                $contact->phone ?? '',
                $contact->company ?? '',
                $contact->address ?? '',
                $contact->is_favorite ? 'Yes' : 'No',
                $contact->created_at->format('Y-m-d'),
            ]);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
public function stats()
{
    $totalCount = Contact::owned()->count();
    $favCount   = Contact::owned()->where('is_favorite', true)->count();

    $chartData = collect(range(5, 0))->map(function ($i) {
        $month = now()->subMonths($i);
        return [
            'month' => $month->format('M'),
            'count' => Contact::owned()
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count(),
        ];
    });

    $tagStats = \App\Models\Tag::where('user_id', auth()->id())
                ->withCount('contacts')
                ->orderByDesc('contacts_count')
                ->take(5)
                ->get();

    return view('contacts.stats', compact(
        'totalCount', 'favCount', 'chartData', 'tagStats'
    ));
}
}