<?php

namespace App\Http\Controllers\Api;

use App\Group;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GroupsController extends Controller
{
    public function index()
    {
        $data = [];
        $groups = Group::select('id', 'name')->get();
        foreach ($groups as $group) {
            $temp = [
                "groupId" => $group->id,
                "name" => $group->name
            ];
            array_push($data, $temp);
        }


        return response()->json($data);
    }
}