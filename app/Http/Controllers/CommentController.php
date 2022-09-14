<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentAddRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Episode;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index(Episode $episode): CommentResource
    {
        return new CommentResource($episode);
    }

    public function add(CommentAddRequest $request, Episode $episode): CommentResource
    {
        $episode->comments()->create([
            'parent_id' => $request->comment,
            'comment' => $request->text,
            'user_id' => Auth::id(),
        ]);

        return new CommentResource($episode->fresh());
    }

    public function delete(Comment $comment)
    {
        $comment->delete();

        return null;
    }
}
