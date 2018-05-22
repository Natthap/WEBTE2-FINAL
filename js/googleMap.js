    var map;
    var request;
    var markers = [];
    var subRoutes = [];
    var route;
    var directions;
    var renderer;
    var polylines = [];
    var listener;

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
        
        listener =
            google.maps.event.addListener(map, 'click', function (event) {
                placeMarker(event.latLng);
                if (markers.length == 2) {

                    var org = new google.maps.LatLng(markers[0].getPosition().lat(), markers[0].getPosition().lng());
                    var dest = new google.maps.LatLng(markers[1].getPosition().lat(), markers[1].getPosition().lng());

                    google.maps.event.trigger(markers[1], 'click');
                    google.maps.event.trigger(markers[0], 'click');

                    request = {
                        origin: org,
                        destination: dest,
                        travelMode: google.maps.DirectionsTravelMode.WALKING
                    };
                    addRoute(request, Math.random());
                    google.maps.event.removeListener(listener);
                }
            });

    }

    function addRoute(request, value) {
        directions.route(request, function(response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                renderer.setDirections(response);
                renderer.setMap(map);
                var polylineOptions = {
                    strokeColor: '#'+(value*0xFFFFFF<<0).toString(16),
                    strokeOpacity: 1,
                    strokeWeight: 4
                };
                if(value == 0) {
                    polylineOptions.strokeOpacity = 0.3;
                    polylineOptions.strokeColor = "#0000FF";
                } else {
                    $('#gps').val(JSON.stringify(request));
                    $('#distance').val(response.routes[0].legs[0].distance.value/1000);
                }
                renderDirectionsPolylines(response,polylineOptions, value);
            } else {
                renderer.setMap(null);
                renderer.setPanel(null);
            }
        });
    }


    function renderDirectionsPolylines(response,polylineOptions, value) {
        var legs = response.routes[0].legs;
        for (i = 0; i < legs.length; i++) {
            var steps = legs[i].steps;
            for (j = 0; j < steps.length; j++) {
                var nextSegment = steps[j].path;
                var stepPolyline = new google.maps.Polyline(polylineOptions);
                for (k = 0; k < nextSegment.length; k++) {
                    stepPolyline.getPath().push(nextSegment[k]);
                }
                if(value != 0) {
                    polylines.push(stepPolyline);
                }
                stepPolyline.setMap(map);
                // route click listeners, different one on each step
                google.maps.event.addListener(stepPolyline, 'click', function(evt) {
                    placeMarker(evt.latLng);
                })

            }
        }
    }

    function placeMarker(location) {
     //   if(!request) {
            var marker = new google.maps.Marker({
                position: location,
                map: map,
                indexOf: markers.length
            });
            if(subRoutes.length != 0 || route) {
                if(subRoutes.length != 0) {
                    request1 = {
                        origin: new google.maps.LatLng(subRoutes[subRoutes.length-1].destination.lat, subRoutes[subRoutes.length-1].destination.lng),
                        destination: new google.maps.LatLng (marker.getPosition().lat(), marker.getPosition().lng()),
                        travelMode: google.maps.DirectionsTravelMode.WALKING
                    };
                    addRoute(request1, 1);
                    request = request1;
                } else if(route) {
                    request1 = {
                        origin: new google.maps.LatLng(route.origin.lat, route.origin.lng),
                        destination: new google.maps.LatLng (marker.getPosition().lat(), marker.getPosition().lng()),
                        travelMode: google.maps.DirectionsTravelMode.WALKING
                    };
                    addRoute(request1, 1);
                    request = request1;
                }
                marker.setMap(null);
                return;
            }
            google.maps.event.addListener(marker, 'click', function (event) {
                this.setMap(null);
                removeMarker(marker);
            });
            markers.push(marker);
       // }
    }

    function removeMarker(marker) {
        markers.splice(marker.indexOf, 1);
    }

    function clearSubRoute() {
        for(var i=0; i<polylines.length; i++) {
            polylines[i].setMap(null);
        }
        polylines = [];
        $('#gps').val("");
        $('#distance').val("");
        var request1;
        if(subRoutes.length != 0) {
            request1 = {
                origin: new google.maps.LatLng(subRoutes[subRoutes.length-1].origin.lat, subRoutes[subRoutes.length-1].origin.lng),
                destination: new google.maps.LatLng(subRoutes[subRoutes.length-1].destination.lat, subRoutes[subRoutes.length-1].destination.lng),
                travelMode: google.maps.DirectionsTravelMode.WALKING
            };

        } else if(route) {
            request1 = {
                origin: new google.maps.LatLng(route.origin.lat, route.origin.lng),
                destination: new google.maps.LatLng (route.destination.lat, route.destination.lng),
                travelMode: google.maps.DirectionsTravelMode.WALKING
            };
        }
        if(request1) {
            directions.route(request1, function (response, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    renderer.setDirections(response);
                }
            });
        } else {
            renderer.setMap(null);
            listener = google.maps.event.addListener(map, 'click', function (event) {
                placeMarker(event.latLng);
                if (markers.length == 2) {

                    var org = new google.maps.LatLng(markers[0].getPosition().lat(), markers[0].getPosition().lng());
                    var dest = new google.maps.LatLng(markers[1].getPosition().lat(), markers[1].getPosition().lng());

                    google.maps.event.trigger(markers[1], 'click');
                    google.maps.event.trigger(markers[0], 'click');

                    request = {
                        origin: org,
                        destination: dest,
                        travelMode: google.maps.DirectionsTravelMode.WALKING
                    };
                    addRoute(request, Math.random());
                    google.maps.event.removeListener(listener);
                }
            });
        }
    }

    function setRoute(data) {
        route = data;
        google.maps.event.removeListener(listener);
    }

    function setSubRoutes(data) {
        subRoutes.push(data);
    }


