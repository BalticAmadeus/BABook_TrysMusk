@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                        <!-- Trigger the modal with a button -->
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#eventModal">New Event</button>

                        <!-- Modal -->
                        <div class="modal fade" id="eventModal" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">New Event</h4>
                                    </div>
                                    <form method="POST" action="/home">
                                        {{ csrf_field() }}
                                    <div class="modal-body">
                                            <div class="form-group">
                                                <label for="eventTitle">Title</label>
                                                <input type="text" class="form-control" id="eventTitle" placeholder="Title" name="eventTitle">
                                            </div>
                                            <div class="form-group">
                                                <label for="eventDate">Date</label>
                                                <input type="text" class="form-control" id="eventDate" placeholder="Date" name="eventDate">
                                            </div>
                                        <div class="form-group">
                                            <label for="eventComment">Comment</label>
                                            <input type="text" class="form-control" id="eventComment" placeholder="Comment" name="eventComment">
                                        </div>
                                        <div class="form-group">
                                            <label for="eventLocation">Location</label>
                                            <input type="text" class="form-control" id="eventLocation" placeholder="Location" name="eventLocation">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                    </form>
                                </div>

                            </div>
                        </div>

                </div>
            </div>
        </div>

        <div class="col-md-2">
                @foreach ($events as $event)
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ $event->title }}</h3>
                    </div>
                    <div class="panel-body">
                        {{ $event->comment }}
                        {{ $event->date }}
                        {{ $event->location }}
                    </div>
                    <button type="button" class="btn btn-success" data-dismiss="modal">Yes</button>
                </div>
                    @endforeach
        </div>
    </div>
</div>
@endsection
