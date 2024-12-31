<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'comments.user', 'likes'])->latest()->paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'content' => 'required|string|max:1000',
        'image' => 'nullable|image',
    ]);

    $post = Post::create([
        'user_id' => auth()->id(),
        'content' => $validated['content'],
        'image' => $validated['image'] ? $request->file('image')->store('posts') : null,
    ]);

    return redirect()->route('posts.index');
}


}
