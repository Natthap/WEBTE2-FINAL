function GoogleMapa() {
    var long = [];
    var lat = [];
    var bydlisko_name = [];
    var json1 = [];


    $('#data').empty();
    $.ajax({
        type: 'GET',
        url: 'Rest_mapa.php',
        dataType: 'json',
        success: function (data) {
            for (var i = 0; i < data.length; i++) {

                json1[i] = JSON.parse(data[i]['skola_GPS']);


                long[i] = json1[i]['results'][0]['geometry']['location']['lng'];
                lat[i] = json1[i]['results'][0]['geometry']['location']['lat'];
                bydlisko_name[i] = json1[i]['results'][0]['formatted_address'];
            }
            /* call map function with markers*/
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 7.2,
                center: {
                    lat: 48.750086,
                    lng: 19.669258
                }
            });

            setMarkers(map, lat, long, bydlisko_name, data.length);

        },
        error: function (xhr, textStatus, errorThrown) {
            alert('GET nefunguje :/');
            console.log(xhr.status);
            //console.log(errorThrown);
            console.log(textStatus);
        }
    });

}

function setMarkers(map, lat, long, bydlisko_name, dlzka) {

    var beaches = [];
    for (var i = 0; i < 4; i++) {
        beaches.push([bydlisko_name[i], lat[i], long[i], 1]);
    }


    var image = {
        url: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png',
        // This marker is 20 pixels wide by 32 pixels high.
        size: new google.maps.Size(20, 32),
        // The origin for this image is (0, 0).
        origin: new google.maps.Point(0, 0),
        // The anchor for this image is the base of the flagpole at (0, 32).
        anchor: new google.maps.Point(0, 32)
    };
    // Shapes define the clickable region of the icon. The type defines an HTML
    // <area> element 'poly' which traces out a polygon as a series of X,Y points.
    // The final coordinate closes the poly by connecting to the first coordinate.
    var shape = {
        coords: [1, 1, 1, 20, 18, 20, 18, 1],
        type: 'poly'
    };

    for (var i = 0; i < beaches.length; i++) {
        var beach = beaches[i];
        var marker = new google.maps.Marker({
            position: {
                lat: beach[1],
                lng: beach[2]
            },
            map: map,
            icon: image,
            shape: shape,
            title: beach[0],
            zIndex: beach[3]
        });
    }
}