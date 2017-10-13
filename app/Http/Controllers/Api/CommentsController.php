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
        $comments = Comment::where('eventId', '=', $eventId)->with('user')->get(['eventId', 'comment', 'userId']);
        $data = [];
        foreach ($comments as $comment) {
            $temp = [
                "eventId" => $comment->eventId,
                "name" => $comment->user->name,
                "comment" => $comment->comment
            ];
            array_push($data, $temp);
        }

        return $data;
    }
}