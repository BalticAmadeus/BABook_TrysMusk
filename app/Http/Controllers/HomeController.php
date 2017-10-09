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

    public function newEvent()
    {
        $event = new Event;
        $id = Auth::user()->id;

        $event->groupId = 1;
        $event->userId = $id;
        $event->title = Input::get('eventTitle');
        $event->date = Input::get('eventDate');
        $event->comment = Input::get('eventComment');
        $event->location = Input::get('eventLocation');
        $event->save();

        return Redirect::back();
    }
}
