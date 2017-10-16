<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\EventsUsers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function index(Request $request)
    {
        $userId = 1;

        $events = Event::with('group')->get();
        $data = [];
        foreach($events as $event) {
            $status = EventsUsers::select('status')->where('userId', $userId)->where('eventId', $event->id)->first();
            $temp = [
                "id" => $event->id,
                "creatorName" => "",
                "groupName" => $event->group->name,
                "date" => $event->date,
                "title" => $event->title,
                "comment" => $event->comment,
                "location" => $event->location,
                "status" => $status['status']
            ];
            array_push($data, $temp);
        }

        return $data;
    }

    public function show($id)
    {
        return Event::find($id)->get(['id', 'groupId', 'userId', 'title', 'date', 'comment', 'location']);
    }

    public function store(Request $request)
    {
        $event = new Event();
        $event->groupId = $request->groupId;
        $event->userId = $request->userId;
        $event->title = $request->title;
        $event->date = $request->date;
        $event->comment = $request->comment;
        $event->location = $request->location;
        $event->save();

        return response()->json("Comment posted");
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $event->update($request->all());
        return $event;
    }

    public function delete(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return 204;
    }
}