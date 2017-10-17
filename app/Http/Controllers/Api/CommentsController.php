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
        $tempComment = htmlspecialchars($request->comment);
        $comment->comment = $tempComment;
        $comment->save();

        return response()->json("Comment posted");
    }

    public function show($eventId)
    {
        $comments = Comment::where('eventId', '=', $eventId)->with('user')->get(['eventId', 'comment', 'userId']);
        $data = [];
        foreach ($comments as $comment) {
            $temp = [
                "name" => $comment->user->name,
                "comment" => $comment->comment
            ];
            array_push($data, $temp);
        }

        return $data;
    }
}