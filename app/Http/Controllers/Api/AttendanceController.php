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
        $data = [];
        $eventUsers = EventsUsers::where('eventId', $eventId)->with('users')->get(['eventId', 'status', 'userId']);

        foreach ($eventUsers as $eventUser) {
            $temp = [
                "name" => $eventUser->users[0]->name,
                "status" => $eventUser->status
            ];
            array_push($data, $temp);
        }

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $eventId = $request->eventId;
        $userId = $request->userId;
        $status = $request->status;

        $check = EventsUsers::where('eventId', $eventId)->where('userId', $userId)->count();

        if(!$check) {
            $eventUser = new EventsUsers();
            $eventUser -> eventId = $eventId;
            $eventUser -> userId = $userId;
            $eventUser -> status = $status;
            $eventUser->save();
        } else {
            $this->update($request);
        }

        return response()->json("Invited");
    }

    public function update(Request $request)
    {
        $eventId = $request->eventId;
        $userId = $request->userId;
        $status = $request->status;

        DB::table('eventsUsers')
            ->where('eventId', $eventId)
            ->where('userId', $userId)
            ->update(['status' => $status]);

        return response('success');
    }

    public function invitable($eventId)
    {
        $data = [];
        $users = User::get();
        $eventUsers = EventsUsers::where('eventId', $eventId)->get();

        foreach ($users as $user) {
            if(count($eventUsers) == 0) {
                $temp = [
                    "userId" => $user->id,
                    "name" => $user->name
                ];
                array_push($data, $temp);
            } else {
                foreach ($eventUsers as $eventUser) {
                    if($eventUser->userId != $user->id) {
                        $temp = [
                            "userId" => $user->id,
                            "name" => $user->name
                        ];
                        array_push($data, $temp);
                    }
                }
            }
        }
        return response()->json($data);
    }
}