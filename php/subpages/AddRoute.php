<?php require('../Config.php');

//include the user class, pass in the database connection
include('classes/user.php');
include('../services/ServiceRoutes.php');
$user = new User($db);
$route = new ServiceRoutes();

ob_start();
session_start();
error_reporting(0);

//if not logged in redirect to login page
if(!$user->is_logged_in()){
    header('Location: Login.php');
    exit();
}

//define page title
$title = 'Pridanie trasy';
$addRoute = 'active';

//include header template
require('layout/header.php');
require("layout/Menu.php");

if ($_SESSION['personType'] == 2) {

}
if ($_SESSION['personType'] == 1) {

}

if(isset($_POST['submit'])) {
    $userData = array("name" => $_POST['name'], "userID" => $_SESSION['memberID'], "active" => '0', "geojson" => $_POST['gps'], "type" => $_POST['type']);
    $route->createUserRoute($db, $userData);
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
                <form class="" role="form" method="post" action="#">
                    <div class="form-group">
                        <label for="name">Nazov</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Nazov">
                    </div>
                    <div class="form-group">
                        <label for="type">Typ</label>
                        <select name="type" class="form-control" id="type">
                            <option value="0">Sukromna trasa</option>
                            <option value="1">Verejna trasa</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="gps" class="form-control" id="gps" value="">
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

<?php
//include header template
require('layout/footer.php');
