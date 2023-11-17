<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use App\Models\comment;
use App\Models\User;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // FUNCTION TO ADD COMMENT
    public function AddComment(Request $request)
    {
        comment::create([
            'blog_id' => $request->input('blog_id'),
            'user_id' => $request->input('user_id'),
            'comment' => $request->input('text'),

        ]);
        return response()->json(['message' => "Comment" . " " . __('message.ADDED')], RESPONSE::HTTP_OK);
    }
    // FUNCTION TO GET COMMENTS
    public function GetComment($id)
    {
        $comments = Comment::with('user')->where('blog_id', $id)->get();

        return response()->json($comments);
    }
}
