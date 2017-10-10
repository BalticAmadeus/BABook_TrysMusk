<?php
namespace App\Http\Controllers\api;
use App\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Group;
use Illuminate\Support\Facades\Auth;

class EventsController extends Controller
{
    public function index()
    {
        return Event::orderBy('date', 'desc')->get();
    }

    public function show(Event $event)
    {
        return $event;
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $id = $request->user()->id;
        $event = Event::create([
            "userId" => $id,
            "groupId" => 1,
            "title" => $data["title"],
            "date" => $data["date"],
            "comment" => $data["comment"],
            "location" => $data["location"]
        ]);

        return response()->json($event, 201);
    }

    public function update(Request $request, Event $event)
    {
        $event->update($request->all());

        return response()->json($event, 200);
    }

    public function delete(Event $event)
    {
        $event->delete();

        return response()->json(null, 204);
    }
}