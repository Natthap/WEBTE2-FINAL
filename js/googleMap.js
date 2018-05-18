    var geocoder;
    var map;

    var request;
    var markers = [];

    function initialize() {
        var latlng = new google.maps.LatLng(48.750086, 19.669258);
        var myOptions = {
            zoom: 7.2,
            center: latlng,
            mapTypeId: 'roadmap'
        };
        map = new google.maps.Map(document.getElementById("mapDiv"), myOptions);

        google.maps.event.addListener(map, 'click', function(event) {
            placeMarker(event.latLng);
            if(markers.length == 2) {

                var org = new google.maps.LatLng ( markers[0].getPosition().lat(), markers[0].getPosition().lng());
                var dest = new google.maps.LatLng ( markers[1].getPosition().lat(), markers[1].getPosition().lng());

                google.maps.event.trigger(markers[1], 'click');
                google.maps.event.trigger(markers[0], 'click');

                request = {
                    origin: org,
                    destination: dest,
                    travelMode: google.maps.DirectionsTravelMode.WALKING
                };

                addRoute(request);
            }
        });

        function placeMarker(location) {
            if(!request) {
                var marker = new google.maps.Marker({
                    position: location,
                    map: map,
                    indexOf: markers.length
                });
                google.maps.event.addListener(marker, 'click', function (event) {
                    this.setMap(null);
                    removeMarker(marker);
                });
                markers.push(marker);
            }
        }

        function removeMarker(marker) {
            markers.splice(marker.indexOf, 1);
        }
    }

    function addRoute(request) {
        var rendererOptions = {map: map};
        directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);

        directionsService = new google.maps.DirectionsService();
        directionsService.route(request, function (response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);
                $('#gps').val(JSON.stringify(request));
            }
            else
                alert('failed to get directions');
        });
    }
