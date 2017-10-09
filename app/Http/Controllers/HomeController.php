<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::select('id', 'groupId', 'userId', 'title', 'date', 'comment', 'location')->get();

        return view('home', ['events' => $events]);
    }

    /**
     * @return mixed
     */
    public function newEvent(Request $req)
    {
        $event = new Event;
        $id = Auth::user()->id;
        $eventTitle = Input::get('eventTitle');
        $eventDate = Input::get('eventDate');
        $eventComment = Input::get('eventComment');
        $eventLocation = Input::get('eventLocation');

        $messages = [
            'max' => 'Įvedėte per daug simbolių.',
            'min' => 'Įvedėte per mažai simbolių.',
            'required' => 'Privalomas laukelis.',
            'date_format' => 'Neteisingas laiko formatas, M-M-D, V:M:S.',
        ];

        $this->validate($req, [
            'eventTitle' => 'required|max:30|min:2',
            'eventLocation' => 'required|max:100|min:5',
            'eventDate' => 'date_format:M-M-D, V:M:S.',
        ], $messages);

        $event->groupId = 1;
        $event->userId = $id;
        $event->title = $eventTitle;
        $event->date = $eventDate;
        $event->comment = $eventComment;
        $event->location = $eventLocation;
        $event->save();

        return Redirect::back();
    }
}
