<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function getPostAuthor($postId)
{
    $post = Post::find($postId);
    return response()->json($post->author); // Assuming `author` is a `belongsTo` relation in the Post model.
}
public function getPostComments($postId)
{
    $post = Post::find($postId);
    return response()->json($post->comments); // Assuming `comments` is a `morphMany` relationship in the Post model.
}

}
