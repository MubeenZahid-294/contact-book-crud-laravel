<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::where('user_id', auth()->id())
                   ->withCount('contacts')
                   ->get();
        return view('tags.index', compact('tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:50',
            'color' => 'required|string',
        ]);

        Tag::create([
            'user_id' => auth()->id(),
            'name'    => $request->name,
            'color'   => $request->color,
        ]);

        return back()->with('success', 'Tag created!');
    }

    public function destroy(Tag $tag)
    {
        abort_if($tag->user_id !== auth()->id(), 403);
        $tag->delete();
        return back()->with('success', 'Tag deleted!');
    }
}