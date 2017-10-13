$(document).ready(function() {
    getEvents();
    materializeStuff();
});

function materializeStuff(){
    $(".button-collapse").sideNav();
    $(".dropdown-button").dropdown({ hover: false });
    $('.modal').modal();
    $('select').material_select();
    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15, // Creates a dropdown of 15 years to control year,
        today: 'Today',
        clear: 'Clear',
        close: 'Ok',
        closeOnSelect: false,
        format: 'yyyy-mm-dd'
    });
    $('.timepicker').pickatime({
        default: 'now', // Set default time: 'now', '1:30AM', '16:30'
        fromnow: 0,       // set default time to * milliseconds from now (using with default = 'now')
        twelvehour: false, // Use AM/PM or 24-hour format
        donetext: 'OK', // text for done-button
        cleartext: 'Clear', // text for clear-button
        canceltext: 'Cancel', // Text for cancel-button
        autoclose: false, // automatic close timepicker
        ampmclickable: true, // make AM PM clickable
        aftershow: function(){} //Function for after opening timepicker
    });
}

$(".createNewEvent").on('click', function(){
    $('#newEventModal').modal('open');
});

$(".attendanceBtn").on('click', function(){
    $('#attendanceModal').modal('open');
});

$(".inviteBtn").on('click', function(){
    $('#inviteModal').modal('open');
});

$("#newCommentBtn").on('click', function () {
    newComment();
});

function getEvents() {
    $.ajax({
        url: "http://localhost:8000/api/events",
        type: 'GET',
        contentType: "application/json",
        success: function(res) {
            $.each( res, function( i, d ) {
                $("#eventsList").append('<div class="col s12 m6 l4"><div class="card"><div class="card-content white-text"><div class="card__meta"><p>Alus</p><time>' + d.date + '</time></div><span class="card-title grey-text text-darken-4">' + d.title + '</span><p class="card-subtitle grey-text text-darken-2">' + d.comment + '</p> <span class="blue-text text-darken-2 card-info">' + d.location + '</span></div><div class="card-action"> <a class="btn-floating btn-large waves-effect waves-light green eventId' + d.id + '" onclick="attendance(' + d.id + ')"><i class="material-icons">check</i></a> <a class="btn-floating btn-large waves-effect waves-light orange modal-trigger attendanceBtn" href="#attendanceModal" onclick="getParticipants(' + d.id + ')"><i class="material-icons">group</i></a> <a class="btn-floating btn-large waves-effect waves-light red modal-trigger inviteBtn" href="#inviteModal"><i class="material-icons">send</i></a> <a class="btn-floating btn-large waves-effect waves-light red modal-trigger commentBtn"' + d.id + ' href="#commentModal"' + d.id + ' onclick="getComments(' + d.id + ')"><i class="material-icons">comment</i></a></div></div></div>');
            });
        }
    });
}

function addNewEvent() {
    var groupId = 1;
    var userId = 1;
    var title = $("#title").val();
    var date = $("#date").val();
    var time = $("#time").val();
    var datetime = date + ' ' + time;
    var comment = $("#comment").val();
    var location = $("#location").val();

    var data = {
        'groupId' : groupId,
        'userId' : userId,
        'title' : title,
        'date' : datetime,
        'comment' : comment,
        'location' : location
    };

    $.ajax({
        url: "http://localhost:8000/api/events",
        type: 'POST',
        contentType: "application/json",
        data: JSON.stringify(data),
        success: function() {
            window.location.reload(true)
        }
    });
}

function attendance(eventId) {
    var userId = 1;
    var event = $(".eventId" + eventId);

    if(event.hasClass('green')) {
        var status = 2;
        var data = {
            'userId' : 1,
            'eventId' : eventId,
            'status' : status
        };

        $.ajax({
            url: "http://localhost:8000/api/userevent/" + eventId + "/" + userId + "/" + status,
            type: 'POST',
            contentType: "application/json",
            data: JSON.stringify(data),
            success: function () {
                event.removeClass('green');
                event.addClass('red');
                event.html('<i class="material-icons">cancel</i>');
            }
        });
    } else {
        status = 1;
        data = {
            'userId' : userId,
            'eventId' : eventId,
            'status' : status
        };

        $.ajax({
            url: "http://localhost:8000/api/userevent/" + eventId + "/" + userId + "/" + status,
            type: 'PUT',
            contentType: "application/json",
            data: JSON.stringify(data),
            success: function () {
                event.removeClass('red');
                event.addClass('green');
                event.html('<i class="material-icons">check</i>');
            }
        });
    }





}

function getParticipants(eventId) {
    $("#going").html("");
    $("#notGoing").html("");
    $("#unanswered").html("");
    $.ajax({
        url: "http://localhost:8000/api/userevent/" + eventId,
        type: 'GET',
        contentType: "application/json",
        success: function(res) {
            console.log(res);
            $.each( res, function( i, d ) {
                if(d.status === 1) {
                    $("#going").append('<p>' + d.name + '</p>');
                } else if (d.status === 2) {
                    $("#notGoing").append('<p>' + d.name + '</p>');
                } else {
                    $("#unanswered").append('<p>' + d.name + '</p>');
                }
            });
        }
    });
}

function getComments(eventId) {
    $("#comments").html("");
    $.ajax({
        url: "http://localhost:8000/api/comments/" + eventId,
        type: 'GET',
        contentType: "application/json",
        success: function(res) {
            console.log(res);
            $("#commentModal").attr('data-id', eventId);
            $.each( res, function( i, d ) {
                $("#comments").append('<p>' + d.name + ' : ' + d.comment + '</p>');
            });
        }
    });
}

function newComment() {
    var eventId = $("#commentModal").attr('data-id');
    var userId = 1;
    var text = $("#commentText").val();

    var data = {
        'userId' : userId,
        'comment' : text
    };

    $.ajax({
        url: "http://localhost:8000/api/comments/" + eventId,
        type: 'POST',
        contentType: "application/json",
        data: JSON.stringify(data),
        success: function() {
            window.location.reload(true)
        }
    });
}


