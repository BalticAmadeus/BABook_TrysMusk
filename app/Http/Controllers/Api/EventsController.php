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

        return Event::with('group', 'participants')->get(['id', 'groupId', 'title', 'date', 'comment', 'location']);
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