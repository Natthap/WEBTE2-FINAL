<?php require('../Config.php');

//include the user class, pass in the database connection
include('classes/user.php');
$user = new User($db);

ob_start();
session_start();

//if not logged in redirect to login page
if(!$user->is_logged_in()){
    header('Location: Login.php');
    exit();
}

//define page title
$title = 'Úvod';

//include header template
require('layout/header.php');
require("layout/Menu.php");

?>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="../../js/googleMap.js"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBnj9vchPrrDWFJsZ_OLK8vZr9cFoAhYnI" ></script>

    <div class="container col col-lg-12">
        <div class="row justify-content-md-center mapContainer">
            <div class="col col-lg-8 border border-primary rounded m-3">
                <div id="mapDiv" class="col-12 ml-0 mt-0">
                </div>
            </div>
            <div id="newsDiv" class="col col-lg-3 border border-primary rounded m-3">
            </div>
        </div>
        <a class="btn btn-primary" href="Logout.php">Odhlásiť sa</a>
    </div>

<?php
//include header template
require('layout/footer.php');
