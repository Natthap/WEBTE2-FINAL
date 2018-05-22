    var map;
    var request;
    var route;
    var directions;
    var renderer;
    var polylines = [];

    function initialize() {
        var latlng = new google.maps.LatLng(48.750086, 19.669258);
        var myOptions = {
            zoom: 7.2,
            center: latlng,
            mapTypeId: 'roadmap'
        };
        map = new google.maps.Map(document.getElementById("mapDiv"), myOptions);
        directions  = new google.maps.DirectionsService();
        renderer = new google.maps.DirectionsRenderer({
            suppressPolylines: true
        });
    }

    function addRoute(request) {
        directions.route(request, function(response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                renderer.setDirections(response);
                renderer.setMap(map);
                var polylineOptions = {
                    strokeColor: '#0000FF',
                    strokeOpacity: 1,
                    strokeWeight: 4
                };
                renderDirectionsPolylines(response,polylineOptions);
            } else {
                renderer.setMap(null);
                renderer.setPanel(null);
            }
        });
    }


    function renderDirectionsPolylines(response,polylineOptions) {
        var legs = response.routes[0].legs;
        for (i = 0; i < legs.length; i++) {
            var steps = legs[i].steps;
            for (j = 0; j < steps.length; j++) {
                var nextSegment = steps[j].path;
                var stepPolyline = new google.maps.Polyline(polylineOptions);
                for (k = 0; k < nextSegment.length; k++) {
                    stepPolyline.getPath().push(nextSegment[k]);
                }
                polylines.push(stepPolyline);
                stepPolyline.setMap(map);
                // route click listeners, different one on each step
                google.maps.event.addListener(stepPolyline, 'click', function(evt) {
                    placeMarker(evt.latLng);
                })

            }
        }
    }

    function clearRoute() {
        for(var i=0; i<polylines.length; i++) {
            polylines[i].setMap(null);
        }
        polylines = [];
        renderer.setMap(null);
    }
