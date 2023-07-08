<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostDetailCustomResource;
use App\Http\Resources\PostDetailResource;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('writer:id,username')->get();
        return PostDetailResource::collection($posts);
    }

    public function show($id) 
    {
        $post = Post::with('writer:id,username,email,firstname,created_at')->findOrFail($id);
        return new PostDetailResource($post);
    }

    public function show2($id) 
    {
        $post = Post::findOrFail($id);
        return new PostDetailResource($post);
    }

    public function show3($id) 
    {
        $post = Post::with('writer:id,username,email,firstname,created_at')->findOrFail($id);
        return new PostDetailCustomResource($post);
    }

    public function store(Request $request) 
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'news_content' => 'required',
        ]);

        $request['author'] = Auth::user()->id;
        $post = Post::create($request->all());

        return new PostDetailResource($post->loadMissing('writer:id,username'));
    }
    
    public function update(Request $request, $id) 
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'news_content' => 'required',
        ]);

        $post = Post::findOrFail($id);
        $post->update($request->all());

        return new PostDetailResource($post->loadMissing('writer:id,username'));
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        $delete_result[] = [
            "code" => 200,
            "msg" => "Anda berhasil menghapus post " . $post->title . " (" . $post->id . ")",
        ];

        return response()->json(["response" => $delete_result]);

        return new PostDetailResource($post->loadMissing('writer:id,username'));
    }
}
