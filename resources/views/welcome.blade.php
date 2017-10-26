<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
        <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>
        <style type="text/css">
            #messages{
                border: 1px solid black;
                height: 300px;
                margin-bottom: 8px;
                overflow: scroll;
                padding: 5px;
            }
        </style>
    </head>
<body>
    <ul class="chat"></ul>
    <hr>
    <form>
        <textarea style="width: 100%; height: 50px"></textarea>
        <input type="submit" value="Submit">
    </form>
    <script>
        var socket = io(':6001');

        function appendMessage(data) {
            $('.chat').append(
                $('<li/>').text(data.message)
            );
        }

        $('form').on('submit', function (data) {
            var text = $('textarea').val(),
                msg = {message : text};

            socket.send(msg);
            appendMessage(msg);

            $('textarea').val('');

            return false;
        });

        socket.on('message', function (data) {
           appendMessage(data);
        });

        /*socket.on('message', function (data) {
            console.log('From server: ', data)
        }).on('server-info', function (data) {
            console.info(data);
        });*/
    </script>


    {{--<div class="container spark-screen">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Chat Message Module</div>
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-lg-8" >
                                <div id="messages" ></div>
                            </div>
                            <div class="col-lg-8" >
                                <form action="sendmessage" method="POST">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" >
                                    --}}{{--<input type="hidden" name="user" value="{{ Auth::user()->name }}" >--}}{{--
                                    <textarea class="form-control msg"></textarea>
                                    <br/>
                                    <input type="button" value="Send" class="btn btn-success send-msg">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var socket = io();
        socket.on('message', function (data) {
            data = jQuery.parseJSON(data);
            console.log(data.user);
            $( "#messages" ).append( "<strong>"+data.user+":</strong><p>"+data.message+"</p>" );
        });
        $(".send-msg").click(function(e){
            e.preventDefault();
            var token = $("input[name='_token']").val();
            var user = $("input[name='user']").val();
            var msg = $(".msg").val();
            if(msg != ''){
                $.ajax({
                    type: "POST",
                    url: '{!! URL::to("sendmessage") !!}',
                    dataType: "json",
                    data: {'_token':token,'message':msg,'user':user},
                    success:function(data){
                        console.log(data);
                        $(".msg").val('');
                    }
                });
            }else{
                alert("Please Add Message.");
            }
        })
    </script>--}}
</body>
</html>
