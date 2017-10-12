<?php

namespace App\Http\Controllers\Api;

use App\EventsUsers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
//    public function index()
//    {
//        return EventsUsers::all();
//    }
//
    public function show($eventId)
    {
        return EventsUsers::where('eventId', '=', $eventId)->get();
    }

    public function store($eventId, $userId, $status)
    {
        $eventUser = new EventsUsers();
        $eventUser -> eventId = $eventId;
        $eventUser -> userId = $userId;
        $eventUser -> status = $status;
        $eventUser->save();

        return response()->json("Invited");
    }

    public function update($eventId, $userId, $status)
    {
        DB::table('eventsUsers')
            ->where('eventId', $eventId)
            ->where('userId', $userId)
            ->update(['status' => $status]);

        return response('success');
    }

//    public function delete(Request $request, $userId)
//    {
//        $event = EventsUsers::findOrFail($userId);
//        $event->delete();
//        return 204;
//    }
}