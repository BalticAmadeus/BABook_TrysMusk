<?php

namespace App\Http\Controllers\Api;

use App\EventsUsers;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class AttendanceController extends Controller
{
    public function show($eventId)
    {
        $eventUsers = EventsUsers::where('eventId', '=', $eventId)->with('users')->get(['eventId', 'status', 'userId']);
        $data = [];
        foreach ($eventUsers as $eventUser) {
            $temp = [
                "userId" => $eventUser->userId,
                "name" => $eventUser->users[0]->name,
                "status" => $eventUser->status
            ];
            array_push($data, $temp);
        }

        return $data;
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