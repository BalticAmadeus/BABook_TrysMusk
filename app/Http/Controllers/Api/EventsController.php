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
        $events = Event::with('participants')->get(['id', 'groupId', 'title', 'date', 'comment', 'location']);
        /*$status = EventsUsers::where('userId', '=', $userId)->get(['status']);*/
        $data = [];
        foreach ($events as $event) {
            /*$arrayUserEvents = (array) $userEvents;
            $keyus = array_search($event->id, array_column($arrayUserEvents[0], 'eventId') );
            if ($keyus == 1) {
                $status = $userEvents[$keyus]->status;
            } else {
                $status = null;
            }*/
            $temp = [
                "id" => $event->id,
                "groupName" => $event->group->name,
                "title" => $event->title,
                "date" => $event->date,
                "location" => $event->location,
                "comment" => $event->comment,
                "status" => null
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
        return Event::create($request->all());
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