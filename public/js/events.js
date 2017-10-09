    $.ajax({
        url: "api/events",
        type: 'GET',
        success: function(res) {
            $.each( res, function( i, d ) {
                $("#eventsList").append('<div class="panel panel-primary"><div class="panel-heading"><h3 class="panel-title">' + d.title + '</h3></div><div class="panel-body"><i>' + d.comment + '</i><br>' + d.date + '<br>' + d.location + '</div><button type="button" class="btn btn-success" data-dismiss="modal"><i class="fa fa-check" aria-hidden="true"></i></button></div>');
            });
        }
    });
