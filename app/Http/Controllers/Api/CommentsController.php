<?php

namespace App\Http\Controllers\Api;

use App\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function store(Request $request, $eventId)
    {
        $comment = new Comment();
        $comment->userId = $request->userId;
        $comment->eventId = $eventId;
        $comment->comment = $request->comment;
        $comment->save();

        return response()->json("Comment posted");
    }

    public function show($eventId)
    {
        return Comment::where('eventId', '=', $eventId)->get();
    }
}