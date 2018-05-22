<?php require('../Config.php');

//include the user class, pass in the database connection
include('classes/user.php');
include('../services/ServiceSubRoutes.php');

$user = new User($db);
$subroute = new ServiceSubRoutes();

ob_start();
session_start();
error_reporting(0);

//if not logged in redirect to login page
if(!$user->is_logged_in()){
    header('Location: Login.php');
    exit();
}

//define page title
$title = 'Aktívne trasy';
$active = 'active';

//include header template
require('layout/header.php');
require("layout/Menu.php");

if ($_SESSION['personType'] == 2) {

}
if ($_SESSION['personType'] == 1) {

}

if(isset($_POST['submit'])) {
    $speed = $subroute->getAverageSpeed($_POST['startTime'], $_POST['endTime'], $_POST['distance']);

    $userData = array("routeID" => $_POST['routeID'], "rating" => $_POST['rating'], "start" => $_POST['startTime'], "end" => $_POST['endTime'], "geojson" => $_POST['gps'], "speed" => $speed, "notes" => $_POST['note']);

    $subroute->createUsersSubroute($db, $userData);
}
?>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="../../js/googleMap.js"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBnj9vchPrrDWFJsZ_OLK8vZr9cFoAhYnI&callback=initialize"></script>

    <div class="container col col-lg-12">
        <div class="row justify-content-md-center mapContainer">
            <div class="col col-lg-7 border border-primary rounded m-3">
                <div id="mapDiv" class="col-12 ml-0 mt-0">
                </div>
            </div>
            <div class="col col-lg-4 border border-primary rounded pb-3 m-3">
                <div id="tableDiv">
                </div>
            </div>
        </div>
        <div class="row justify-content-md-center mapContainer">
            <button class="btn btn-primary mb-3" onclick="clearSubRoute()">Vycistit mapu</button>
        </div>
        <div class="row justify-content-md-center">
            <div class="col col-lg-11 border border-primary rounded pb-3">
                <div id="formDiv">
                    <h3>Pridanie podtrasy</h3>
                    <form class="" role="form" method="post" action="#">
                        <div class="form-group">
                            <input type="hidden" name="gps" class="form-control" id="gps" value="">
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="distance" class="form-control" id="distance" value="">
                        </div>
                        <div class="form-group">
                            <label for="startTime">Zaciatocny cas</label>
                            <input type="datetime-local" name="startTime" class="form-control" id="startTime" placeholder="Zaciatocny cas">
                        </div>
                        <div class="form-group">
                            <label for="endTime">Koncovy cas</label>
                            <input type="datetime-local" name="endTime" class="form-control" id="endTime" placeholder="Koncovy cas">
                        </div>
                        <div class="form-group">
                            <label for="rating">Hodnotenie</label>
                            <select name="rating" class="form-control" id="rating">
                                <option value="1">A</option>
                                <option value="2">B</option>
                                <option value="3">C</option>
                                <option value="4">D</option>
                                <option value="5">E</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="note">Poznamka</label>
                            <input type="text" name="note" class="form-control" id="note" placeholder="Poznamka">
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var id = "<?php echo($_SESSION['memberID']); ?>";

        $( document ).ready(function novinky() {
            console.log(id);
            $('#tableDiv').empty();
            $.ajax({
                type: 'GET',
                url: '../rest/RestSubRoute.php/getActiveRouteOfUser?id='+id,
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    $('#tableDiv').append("<table class='table table-hover'><thead><tr><th>Zaciatok</th><th>Koniec</th><th>Hodnotenie</th><th>Rychlost</th><th>Poznamka</th></tr></thead><tbody id='body'>");
                    for (var i = 0; i < data.length; i++) {
                        var value = Math.random();
                        if(value == 0) {
                            value += 1;
                        }
                        var color = '#'+(value*0xFFFFFF<<0).toString(16);
                        if(i == 0) {
                            $("<h2>Trasa: "+ data[i]['name']+"</h2>").insertBefore('#tableDiv');
                            setRoute(JSON.parse(data[i]['geojson']));
                            $('form').append("<input type=\"hidden\" name=\"routeID\" class=\"form-control\" id=\"routeID\" value=" + data[i]['id'] + ">");
                        } else {
                            $('#body').append("<tr style='color:"+ color+";'><td>" + data[i]['startTime'] + "</td><td>" + data[i]['endTime'] + "</td><td>" + data[i]['rating'] + "</td><td>" + data[i]['averageSpeed'] + "</td><td>" + data[i]['notes'] + "</td></tr>");
                            setSubRoutes(JSON.parse(data[i]['geojson']));
                        }
                        addRoute(JSON.parse(data[i]['geojson']), i != 0 ? value : 0);
                    }
                    $('#tableDiv').append("</tbody></table>");


                },
                error: function (xhr, textStatus) {
                    console.log(xhr.status);
                    console.log(textStatus);
                }
            });
        });

    </script>

<?php
//include header template
require('layout/footer.php');
