@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
@endsection

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
            <div id="eventsList">

            </div>
            <div class="modal fade" id="eventModal" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">New Event</h4>
                        </div>
                        <form>
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="eventTitle">Title</label>
                                    <input type="text" class="form-control" id="eventTitle" placeholder="Title" value="{{ old('eventTitle') }}" name="eventTitle">
                                </div>
                                <div class="form-group">
                                    <label for="eventDate">Date</label>
                                    <div class='input-group date' id='eventDate'>
                                        <input type='text' class="form-control" id="eventDate" name="eventDate"/>
                                        <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                    </div>
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
                        </form>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" onclick="addNewEvent()">Submit</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        $('#eventDate').datetimepicker({
            format: 'YYYY-MM-DD HH:mm'
        });
    });
</script>
@endsection
