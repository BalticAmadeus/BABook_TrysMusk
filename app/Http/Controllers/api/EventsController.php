<?php
namespace App\Http\Controllers\api;
use App\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventsController extends Controller
{

    public function index()
    {
        return Event::orderBy('date', 'desc')->get();
    }

    public function show($id)
    {
        return Event::find($id);
    }

    public function store(Request $request)
    {
//        $data = $request->all();
//        $event = new Event;
//        $groupId = $data['groupId'];
//        $userId = $data['userId'];
//        $title = $data['title'];
//        $date = $data['date'];
//        $comment = $data['comment'];
//        $location = $data['location'];

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