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
    'name'  => [
        'required',
        'string',
        'min:2',
        'max:50',
        'unique:tags,name,NULL,id,user_id,' . auth()->id(),
    ],
    'color' => [
        'required',
        'string',
        'in:indigo,blue,green,yellow,red,pink',
    ],
], [
    'name.required' => 'Tag name is required.',
    'name.min'      => 'Tag name must be at least 2 characters.',
    'name.max'      => 'Tag name cannot exceed 50 characters.',
    'name.unique'   => 'You already have a tag with this name.',
    'color.required'=> 'Please select a color.',
    'color.in'      => 'Invalid color selected.',
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