<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\EventsUsers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class EventsController extends Controller
{
    public function index()
    {
        $data = [];
        $userId = 1;

        $events = Event::select('id', 'groupId', 'userId', 'date', 'title', 'location', 'comment')
            ->with(array('group' => function($query){
            $query->select('id', 'name');
            }))->get();

        foreach($events as $event) {
            $status = EventsUsers::select('status')->where('userId', $userId)->where('eventId', $event->id)->first();

            $creatorName = User::find($event->userId)->name;

            $temp = [
                "eventId" => $event->id,
                "creatorName" => $creatorName,
                "groupName" => $event->group["name"],
                "date" => $event->date,
                "title" => $event->title,
                "comment" => $event->comment,
                "location" => $event->location,
                "status" => $status['status']
            ];
            array_push($data, $temp);
        }

        return response()->json($data); // response builderis
    }

    public function show($eventId)
    {
        return Event::find($eventId)->get(['id', 'groupId', 'userId', 'title', 'date', 'comment', 'location']);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:50|',
            'location' => 'required|max:100',
            'date' => 'required|date_format:Y-m-d H:i',
        ]);

        $event = new Event();
        $event->groupId = $request->groupId;
        $event->userId = $request->userId;
        $event->title = $request->title;
        $event->date = $request->date;
        $event->comment = $request->comment;
        $event->location = $request->location;
        $event->save();

        return response()->json("Event successfully created!");
    }

    public function update(Request $request, $eventId)
    {
        $event = Event::findOrFail($eventId);
        $event->update($request->all());
        return response()->json("Event successfully updated!");
    }

    public function delete(Request $request, $eventId)
    {
        $event = Event::findOrFail($eventId);
        $event->delete();
        return response()->json("Event deleted!");
    }
}