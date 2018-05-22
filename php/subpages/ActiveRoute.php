<?php require('../Config.php');

//include the user class, pass in the database connection
include('classes/user.php');

$user = new User($db);

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
?>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="../../js/googleMap.js"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBnj9vchPrrDWFJsZ_OLK8vZr9cFoAhYnI&callback=initialize"></script>

    <div class="container col col-lg-12">
        <div class="row justify-content-md-center mapContainer">
            <div class="col col-lg-8 border border-primary rounded m-3">
                <div id="mapDiv" class="col-12 ml-0 mt-0">
                </div>
            </div>
            <div class="col col-lg-3 border border-primary rounded pb-3 m-3">
                <div id="tableDiv">
                </div>
            </div>
        </div>
        <div class="row justify-content-md-center mapContainer">
            <button class="btn btn-primary mb-3" onclick="clearSubRoute()">Vycistit mapu</button>
        </div>
        <div class="row justify-content-md-center">
            <div class="col col-lg border border-primary rounded pb-3">
                <div id="formDiv">
                    <h3>Pridanie podtrasy</h3>
                    <form class="" role="form" method="post" action="#">
                        <div class="form-group">
                            <input type="hidden" name="gpsStart" class="form-control" id="gpsStart" value="<?php echo $_SESSION['memberID']; ?>">
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="gpsEnd" class="form-control" id="gpsEnd" value="">
                        </div>
                        <div class="form-group">
                            <label for="startTime">Zaciatocny cas</label>
                            <input type="text" name="startTime" class="form-control" id="startTime" placeholder="Zaciatocny cas">
                        </div>
                        <div class="form-group">
                            <label for="endTime">Koncovy cas</label>
                            <input type="text" name="endTime" class="form-control" id="endTime" placeholder="Koncovy cas">
                        </div>
                        <div class="form-group">
                            <label for="rating">Hodnotenie</label>
                            <input type="text" name="rating" class="form-control" id="rating" placeholder="Hodnotenie">
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
            $('#tableDiv').empty();
            $.ajax({
                type: 'GET',
                url: '../rest/RestSubRoute.php/getAllusersRoute?id='+id,
                dataType: 'json',
                success: function (data) {
                    var length = data[0];
                    $('#tableDiv').append("<table class='table table-hover'><thead><tr><th>meno cesty</th><th>active</th></tr></thead><tbody>");
                    for (var i = 0; i < data.length; i++) {
                        $('#tableDiv').append("<tr><td>" + data[i]['name'] + "</td><td>" + data[i]['active'] + "</td></tr>");
                    }
                    $('#tableDiv').append("</tbody></table>");

                },
                error: function (xhr, textStatus) {
                    alert('GET nefunguje :/');
                    console.log(xhr.status);
                    console.log(textStatus);
                }
            });
        });

    </script>

<?php
//include header template
require('layout/footer.php');
