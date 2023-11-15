<?php

namespace App\Http\Controllers;

use App\Models\comment;
use App\Models\User;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function AddComment(Request $request)
    {
        comment::create([
            'blog_id' => $request->input('blog_id'),
            'user_id' => $request->input('user_id'),
            'comment' => $request->input('text'),

        ]);
        return response()->json(['message' => 'Comment added successfully']);
    }
    public function GetComment($id)
    {
        $comments = Comment::with('user')->where('blog_id', $id)->get();

        return response()->json($comments);
    }
}
