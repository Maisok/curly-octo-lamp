<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;

class PostController extends Controller
{
    public function index($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts;

        return view('user_posts', compact('user'));
    }

    public function store(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        $post = $user->posts()->create([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return response()->json($post, 201);
    }

    public function update(Request $request, $id, $post_id)
    {
        $post = Post::where('user_id', $id)->findOrFail($post_id);

        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return response()->json($post);
    }

    public function destroy($id, $post_id)
    {
        $post = Post::where('user_id', $id)->findOrFail($post_id);
        $post->delete();

        return response()->json(null, 204);
    }
    public function show($id, $post_id)
{
    $post = Post::where('user_id', $id)->findOrFail($post_id);
    return response()->json($post);
}
}