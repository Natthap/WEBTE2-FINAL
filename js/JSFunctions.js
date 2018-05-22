function initializeAll(id) {
    var data = getDataFromRest(id);
}

function getDataFromRest(id) {
    $.ajax({
        type: 'GET',
        url: '../../../semestralnyProjekt/php/rest/RestSubRoute.php/getAllusersRoute?id='+ id,
        dataType: 'json',
        success: function (data) {
            createTable(data);
        },
        error: function (xhr, textStatus, errorThrown) {
            alert('GET nefunguje :/');
            console.log(xhr.status);
            //console.log(errorThrown);
            console.log(textStatus);
        }
    });
}

function createTable(data) {
    $('#data').append("<table class='table table-hover'><thead><tr><th>Meno</th><th>Aktivne</th><th>Typ</th></tr></thead><tbody id='body'>");
    for (var i = 0; i < data.length; i++) {
        var act = "";
        var type = "";
        if(data[i]['active'] == 1) {
            act = "Ano";
        } else {
            act = "Nie";
        }

        if(data[i]['type'] = 0) {
            type = "Sukromna";
        } else if(data[i]['type'] = 1) {
            type = "Verejna";
        } else {
            type = "Stafetova";
        }
            $('#body').append("<tr onclick='onClick(" + data[i]['id'] + ")'><td>" + data[i]['name'] + "</td><td>" + act + "</td><td>" + type + "</td><td style=\"display:none;\" id='" + data[i]['id'] + "'>" + data[i]['geojson'] + "</td></tr>");
        addRoute(JSON.parse(data[i]['geojson']), 0);
    }
    $('#data').append("</tbody></table>");
}

function onClick(id) {
    var route = $('#'+id).text();
    clearRoute()
    addRoute(JSON.parse(route), 0);
}