<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostDetailCustomResource;
use App\Http\Resources\PostDetailResource;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return PostResource::collection($posts);
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
}
