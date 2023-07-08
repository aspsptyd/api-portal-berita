<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request) 
    {
        $validated = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'comments_content' => 'required'
        ]);

        $request['user_id'] = auth()->user()->id;

        $comment = Comment::create($request->all());

        $post_success = [
            'code' => 200,
            'msg' => 'Anda berhasil memberikan komentar',
            'comment' => $comment
        ];

        return response()->json(['response' => $post_success]);
    }
}
