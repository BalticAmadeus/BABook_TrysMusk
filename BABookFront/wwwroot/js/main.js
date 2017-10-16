$(document).ready(function() {
    getEvents();
    materializeStuff();
});

function materializeStuff(){
    $(".button-collapse").sideNav();
    $(".dropdown-button").dropdown({ hover: false });
    $('.modal').modal();
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
    $('select').material_select();
}

$(".createNewEvent").on('click', function(){
    $('#newEventModal').modal('open');
    $("#groupSelect").html('<option value="" disabled selected>Group</option>');
    $.ajax({
        url: "http://trycatch2017.azurewebsites.net/api/groups",
        type: 'GET',
        contentType: "application/json",
        success: function(res) {
            $.each( res, function( i, d ) {
                $("#groupSelect").append('<option value="' + d.groupId + '">' + d.name + '</option>');
            });
            $('select').material_select();
        }
    });
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
    $("#eventsList").html("");
    $.ajax({
        url: "http://trycatch2017.azurewebsites.net/api/events",
        type: 'GET',
        contentType: "application/json",
        success: function(res) {
            console.log(res);
            if(res.length === 0) {
                $("#eventsList").html('<h1 style="color: white">No Events..</h1>');
            }
            $.each( res, function( i, d ) {
                $("#eventsList").append('<div class="col s12 m6 l4"><div class="card"><div class="card-content white-text"><p>' + d.groupName + '</p><span class="card-title">' + d.title + '</span><p class="card-subtitle grey-text text-darken-2">Kas? ' + d.comment + '</p><span class="blue-text text-darken-2 card-info">Kur? ' + d.location + '</span><div class="card__meta"><time>Kada? ' + d.date + '</time></div></div><div class="card-action center-align"><a class="attend btn-floating btn-large waves-effect waves-light purple eventId' + d.eventId + '" onclick="attendance(' + d.eventId + ')"><i class="material-icons">check</i></a><a class="parti btn-floating btn-large waves-effect waves-light cyan modal-trigger attendanceBtn" href="#attendanceModal" onclick="getParticipants(' + d.eventId + ')"><i class="material-icons">group</i></a><a class="btn-floating btn-large waves-effect waves-light red accent-3 modal-trigger inviteBtn" href="#inviteModal"><i class="material-icons">send</i></a><a class="btn-floating btn-large waves-effect waves-light cyan accent-3 modal-trigger commentBtn" href="#commentModal"' + d.eventId + ' onclick="getComments(' + d.eventId + ')"><i class="material-icons">comment</i></a></div></div></div>');
            });
        },
        error: function (jqXHR, exception) {
            var msg = '';
            if (jqXHR.status === 0) {
                msg = 'Not connect.\n Verify Network.';
            } else if (jqXHR.status == 404) {
                msg = 'Requested page not found. [404]';
            } else if (jqXHR.status == 500) {
                msg = 'Internal Server Error [500].';
            } else if (exception === 'parsererror') {
                msg = 'Requested JSON parse failed.';
            } else if (exception === 'timeout') {
                msg = 'Time out error.';
            } else if (exception === 'abort') {
                msg = 'Ajax request aborted.';
            } else {
                msg = 'Uncaught Error.\n' + jqXHR.responseText;
            }
            console.log(msg);
        }
    });
}

function addNewEvent() {
    var groupId = $("#groupSelect").val();
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

    if(validateNewEvent() === 0) {
        $.ajax({
            url: "http://trycatch2017.azurewebsites.net/api/events",
            type: 'POST',
            contentType: "application/json",
            data: JSON.stringify(data),
            success: function() {
                getEvents();
            },
            error: function (jqXHR, exception) {
                var msg = '';
                if (jqXHR.status === 0) {
                    msg = 'Not connect.\n Verify Network.';
                } else if (jqXHR.status == 404) {
                    msg = 'Requested page not found. [404]';
                } else if (jqXHR.status == 500) {
                    msg = 'Internal Server Error [500].';
                } else if (exception === 'parsererror') {
                    msg = 'Requested JSON parse failed.';
                } else if (exception === 'timeout') {
                    msg = 'Time out error.';
                } else if (exception === 'abort') {
                    msg = 'Ajax request aborted.';
                } else {
                    msg = 'Uncaught Error.\n' + jqXHR.responseText;
                }
                console.log(msg);
            }
        });
    }

}

function attendance(eventId) {
    var userId = 1;
    var event = $(".eventId" + eventId);

    if(event.hasClass('purple')) {
        var status = 1;

        var data = {
            'userId' : userId,
            'eventId' : eventId,
            'status' : status
        };

        $.ajax({
            url: "http://trycatch2017.azurewebsites.net/api/userevent",
            type: 'POST',
            contentType: "application/json",
            data: JSON.stringify(data),
            success: function () {
                event.removeClass('purple');
                event.addClass('pink');
                event.html('<i class="material-icons">cancel</i>');
            },
            error: function (jqXHR, exception) {
                var msg = '';
                if (jqXHR.status === 0) {
                    msg = 'Not connect.\n Verify Network.';
                } else if (jqXHR.status == 404) {
                    msg = 'Requested page not found. [404]';
                } else if (jqXHR.status == 500) {
                    msg = 'Internal Server Error [500].';
                } else if (exception === 'parsererror') {
                    msg = 'Requested JSON parse failed.';
                } else if (exception === 'timeout') {
                    msg = 'Time out error.';
                } else if (exception === 'abort') {
                    msg = 'Ajax request aborted.';
                } else {
                    msg = 'Uncaught Error.\n' + jqXHR.responseText;
                }
                console.log(msg);
            }
        });
    } else {
        status = 2;
        data = {
            'userId' : userId,
            'eventId' : eventId,
            'status' : status
        };

        $.ajax({
            url: "http://trycatch2017.azurewebsites.net/api/userevent",
            type: 'POST',
            contentType: "application/json",
            data: JSON.stringify(data),
            success: function () {
                event.removeClass('pink');
                event.addClass('purple');
                event.html('<i class="material-icons">check</i>');
            },
            error: function (jqXHR, exception) {
                var msg = '';
                if (jqXHR.status === 0) {
                    msg = 'Not connect.\n Verify Network.';
                } else if (jqXHR.status == 404) {
                    msg = 'Requested page not found. [404]';
                } else if (jqXHR.status == 500) {
                    msg = 'Internal Server Error [500].';
                } else if (exception === 'parsererror') {
                    msg = 'Requested JSON parse failed.';
                } else if (exception === 'timeout') {
                    msg = 'Time out error.';
                } else if (exception === 'abort') {
                    msg = 'Ajax request aborted.';
                } else {
                    msg = 'Uncaught Error.\n' + jqXHR.responseText;
                }
                console.log(msg);
            }
        });
    }
}

function getParticipants(eventId) {
    $("#going").html("");
    $("#notGoing").html("");
    $("#unanswered").html("");
    $.ajax({
        url: "http://trycatch2017.azurewebsites.net/api/userevent/" + eventId,
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
        },
        error: function (jqXHR, exception) {
            var msg = '';
            if (jqXHR.status === 0) {
                msg = 'Not connect.\n Verify Network.';
            } else if (jqXHR.status == 404) {
                msg = 'Requested page not found. [404]';
            } else if (jqXHR.status == 500) {
                msg = 'Internal Server Error [500].';
            } else if (exception === 'parsererror') {
                msg = 'Requested JSON parse failed.';
            } else if (exception === 'timeout') {
                msg = 'Time out error.';
            } else if (exception === 'abort') {
                msg = 'Ajax request aborted.';
            } else {
                msg = 'Uncaught Error.\n' + jqXHR.responseText;
            }
            console.log(msg);
        }
    });
}

function getComments(eventId) {
    $("#comments").html("");
    $.ajax({
        url: "http://trycatch2017.azurewebsites.net/api/comments/" + eventId,
        type: 'GET',
        contentType: "application/json",
        success: function(res) {
            $("#commentModal").attr('data-id', eventId);
            $.each( res, function( i, d ) {
                $("#comments").append('<p>' + d.name + ' : ' + d.comment + '</p>');
            });
        },
        error: function (jqXHR, exception) {
            var msg = '';
            if (jqXHR.status === 0) {
                msg = 'Not connect.\n Verify Network.';
            } else if (jqXHR.status == 404) {
                msg = 'Requested page not found. [404]';
            } else if (jqXHR.status == 500) {
                msg = 'Internal Server Error [500].';
            } else if (exception === 'parsererror') {
                msg = 'Requested JSON parse failed.';
            } else if (exception === 'timeout') {
                msg = 'Time out error.';
            } else if (exception === 'abort') {
                msg = 'Ajax request aborted.';
            } else {
                msg = 'Uncaught Error.\n' + jqXHR.responseText;
            }
            console.log(msg);
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
        url: "http://trycatch2017.azurewebsites.net/api/comments/" + eventId,
        type: 'POST',
        contentType: "application/json",
        data: JSON.stringify(data),
        success: function() {
            getComments(eventId);
            $("#commentText").val("");
        },
        error: function (jqXHR, exception) {
            var msg = '';
            if (jqXHR.status === 0) {
                msg = 'Not connect.\n Verify Network.';
            } else if (jqXHR.status == 404) {
                msg = 'Requested page not found. [404]';
            } else if (jqXHR.status == 500) {
                msg = 'Internal Server Error [500].';
            } else if (exception === 'parsererror') {
                msg = 'Requested JSON parse failed.';
            } else if (exception === 'timeout') {
                msg = 'Time out error.';
            } else if (exception === 'abort') {
                msg = 'Ajax request aborted.';
            } else {
                msg = 'Uncaught Error.\n' + jqXHR.responseText;
            }
            console.log(msg);
        }
    });
}

function validateNewEvent() {
    $("#errorBox").html("");
    var errors = 0;
    var groupId = $("#groupSelect").val();
    var title = $("#title").val();
    var date = $("#date").val();
    var time = $("#time").val();
    var location = $("#location").val();

    if(groupId === null) {
        $("#errorBox").append('<div class="row"><div class="col s6 offset-s3"><div class="card-panel red"><span class="white-text">Please select group!</span></div></div></div>');
        errors += 1;
    }
    if(title === "") {
        $("#errorBox").append('<div class="row"><div class="col s6 offset-s3"><div class="card-panel red"><span class="white-text">Please enter title!</span></div></div></div>');
        errors += 1;
    }
    if(date === "") {
        $("#errorBox").append('<div class="row"><div class="col s6 offset-s3"><div class="card-panel red"><span class="white-text">Please select date!</span></div></div></div>');
        errors += 1;
    }
    if(time === "") {
        $("#errorBox").append('<div class="row"><div class="col s6 offset-s3"><div class="card-panel red"><span class="white-text">Please select time!</span></div></div></div>');
        errors += 1;
    }
    if(location === "") {
        $("#errorBox").append('<div class="row"><div class="col s6 offset-s3"><div class="card-panel red"><span class="white-text">Please enter the location for the event!</span></div></div></div>');
        errors += 1;
    }
    return errors;
}


