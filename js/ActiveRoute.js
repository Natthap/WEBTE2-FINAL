$(window).ready(function() {
    //zmenit giddenActiveMapID na id kde  bude schovane ID cesty
    loadDataToMap($('#hiddenActiveMapID').val());
});

function getUserRoute(id) {
    //ajax
}
function loadDataToMap(id) {
    var allRoutes = getUserRoute(id);

    for (var i = 0; i < allRoutes.length; i++) {
        if (i != 0) {
            addRoute(JSON.parse(allRoutes[i]['geojson']), 1);
        } else {
            addRoute(JSON.parse(allRoutes[i]['geojson']), 0);
        }
    }
}