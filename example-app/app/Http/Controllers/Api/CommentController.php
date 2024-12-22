<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function getCommentOwner($commentId)
{
    $comment = Comment::find($commentId);
    return response()->json($comment->commentable); // Assuming `commentable` is a polymorphic relationship.
}

}
