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
$title = 'História trás';

//include header template
require('layout/header.php');
require("layout/Menu.php");

if ($_SESSION['personType'] == 2) {

}
if ($_SESSION['personType'] == 1) {

}
?>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="../../js/GoogleMapaIndex.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBnj9vchPrrDWFJsZ_OLK8vZr9cFoAhYnI"></script>

<div class="container col col-lg-12">
    <div class="row justify-content-md-center mapContainer">
        <div class="col col-lg-8 border border-primary rounded m-3">
            <div id="mapDiv" class="col-12 ml-0 mt-0">
            </div>
        </div>
        <div class="col col-lg-3 border border-primary rounded m-3">

            <div>
                <table class='table table-hover' id="data"></table>
            </div>
            <script>
                $(document).ready(function() {
                    $('#data').empty();

                    $.ajax({
                        type: 'GET',
                        url: '../rest/RestRoute.php/getAllPublicRoutes',
                        dataType: 'json',
                        success: function(data) {
                            $('#data').append("<tr><th>name </th><th>active </th><th>type</th></tr>");
                            for (i = 0; i < data[0].length; i++) {
                                $('#data').append("<tr> "+"<td> " + data[0][i]['name'] + "</td>"+"<td> " +  data[0][i]['active'] + "</td>"+"<td> " +  data[0][i]['type'] + "</td>"+"</tr> ");
                            }
                            
                        },
                        error: function(xhr, textStatus, errorThrown) {
                            alert('GET nefunguje ');
                            console.log(xhr.status);
                            //console.log(errorThrown);
                            console.log(textStatus);
                        }
                    });
                });

            </script>
        </div>
    </div>
</div>

<?php
//include header template
require('layout/footer.php');
