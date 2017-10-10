<?php
namespace App\Http\Controllers\api;
use App\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function index()
    {
        return Event::all();
    }

    public function show($id)
    {
        return Event::find($id);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:30|min:2',
            'location' => 'required|max:100|min:5',
            'date' => 'required|date_format:Y-m-d H:i',
        ]);
        return Event::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $article = Event::findOrFail($id);
        $article->update($request->all());

        return $article;
    }

    public function delete(Request $request, $id)
    {
        $article = Event::findOrFail($id);
        $article->delete();

        return 204;
    }
}