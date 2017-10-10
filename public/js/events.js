$(document).ready(function() {
    getEvents();
});


function getEvents() {
    $.ajax({
        url: "api/events",
        type: 'GET',
        contentType: "application/json",
        success: function(res) {
            $.each( res, function( i, d ) {
                $("#eventsList").append('<div class="panel panel-primary"><div class="panel-heading"><h3 class="panel-title">' + d.title + '</h3></div><div class="panel-body"><i>' + d.comment + '</i><br>' + d.date + '<br>' + d.location + '</div><button type="button" class="btn btn-success" data-dismiss="modal"><i class="fa fa-check" aria-hidden="true"></i></button></div>');
            });
        }
    });
}

function addNewEvent() {
        var groupId = 1;
        var userId = 1;
        var title = $("#eventTitle").val();
        var date = $("#eventDateInput").val();
        var comment = $("#eventComment").val();
        var location = $("#eventLocation").val();

        var data = {
            'groupId' : groupId,
            'userId' : userId,
            'title' : title,
            'date' : date,
            'comment' : comment,
            'location' : location
        };

        $.ajax({
            url: "api/events",
            type: 'PUT',
            contentType: "application/json",
            data: JSON.stringify(data),
            success: function() {
                window.location.reload(true)
            },
            error: function (data) {
                var errors;
                for (d in data.responseJSON) {
                    errors = data.responseJSON[d];
                }
                $("#errorEventTitle").html(errors['title']);
                $("#errorEventLocation").html(errors['location']);
                $("#errorEventDate").html(errors['date']);
            }

        });
    }

