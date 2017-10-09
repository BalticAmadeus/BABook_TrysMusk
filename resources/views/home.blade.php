@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
                @if ($errors->has('eventTitle'))
                    <span class="help-block">
                        <div class="alert alert-danger" role="alert">
                            <strong style="color:red;">{{ $errors->first('eventTitle') }}</strong>
                        </div>
                    </span>
                @endif
                @if ($errors->has('eventDate'))
                    <span class="help-block">
                        <div class="alert alert-danger" role="alert">
                            <strong style="color:red;">{{ $errors->first('eventDate') }}</strong>
                        </div>
                    </span>
                @endif
                @if ($errors->has('eventLocation'))
                    <span class="help-block">
                        <div class="alert alert-danger" role="alert">
                            <strong style="color:red;">{{ $errors->first('eventLocation') }}</strong>
                        </div>
                    </span>
                @endif
                @foreach ($events as $event)
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{ $event->title }}</h3>
                        </div>
                        <div class="panel-body">
                            <i>{{ $event->comment }}</i><br>
                            {{ $event->date }}<br>
                            {{ $event->location }}
                        </div>
                        <button type="button" class="btn btn-success" data-dismiss="modal"><i class="fa fa-check" aria-hidden="true"></i></button>
                    </div>
                @endforeach
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
                                                <input type="text" class="form-control" id="eventTitle" placeholder="Title" value="{{ old('eventTitle') }}" name="eventTitle">
                                            </div>
                                            <div class="form-group">
                                                <label for="eventDate">Date</label>
                                                <input type="datetime-local" class="form-control" id="eventDate" placeholder="Date" value="{{ old('eventDate') }}" name="eventDate">
                                            </div>
                                        <div class="form-group">
                                            <label for="eventComment">Comment</label>
                                            <input type="text" class="form-control" id="eventComment" placeholder="Comment" name="eventComment">
                                        </div>
                                        <div class="form-group">
                                            <label for="eventLocation">Location</label>
                                            <input type="text" class="form-control" id="eventLocation" placeholder="Location" value="{{ old('eventLocation') }}" name="eventLocation">
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
    </div>
</div>
@endsection
