<?php

namespace App\Http\Controllers\Api;

use App\EventsUsers;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use JWTAuth;

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
        $this->validate($request, [
            'status' => 'required|numeric|min:1|max:3',
        ]);

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
        /*$this->validate($request, [
            'status' => 'required|integer|between:1,3',
        ]);*/

        $eventId = $request->eventId;
        $userId = $request->userId;
        $status = $request->status;

        DB::table('eventsUsers')
            ->where('eventId', $eventId)
            ->where('userId', $userId)
            ->update(['status' => $status]);

        return response()->json("success");
    }

    public function invitable($eventId)
    {
        $data = [];
        $loggedInUser = JWTAuth::user()->id;
        $users = User::get();

        foreach ($users as $user) {
            $eventUsers = EventsUsers::where('eventId', $eventId)->where('userId', $user->id)->get();
            if(count($eventUsers) == 0) {
                if($user->id == $loggedInUser) {
                    continue;
                } else {
                    $temp = [
                        "userId" => $user->id,
                        "name" => $user->name
                    ];
                    array_push($data, $temp);
                }   
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