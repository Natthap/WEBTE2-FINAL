<?php
/**
 * Created by PhpStorm.
 * User: mzikl
 * Date: 12.5.2018
 * Time: 13:47
 */

$title = 'Uvodna stranka';

require("php/subpages/layout/header.php");
?>

    <link rel="stylesheet" href="css/main.css">
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="js/GoogleMapaIndex.js"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBnj9vchPrrDWFJsZ_OLK8vZr9cFoAhYnI" ></script>

    <div class="container col col-lg-12">
        <div class="row justify-content-md-center mapContainer">
            <div class="col col-lg-8 border border-primary rounded">
                <div id="mapDiv" class="col-12">
                </div>
            </div>
            <div class="col col-lg-3">
                <div class="col col-lg-12 border border-primary rounded">
                    <div id="loginDiv" class="col-12 p-3">
                        <h3>Prihlasenie a registracia</h3>
                        <hr>
                        <p><a href='php/subpages/Register.php'>Zaregistrujte sa</a></p>
                        <hr>
                        <p><a href='php/subpages/Login.php'>Prihláste sa</a></p>
                    </div>
                </div>
                <div class="col col-lg-12 border border-primary rounded">
                    <div id="newsDiv" class="col-12 p-3">
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-md-center mapContainer">
            <input id="A" type="button" onclick()="GoogleMapa(1)" data='1' name="Mapa" value="Skola" checked>
            <input id="B" type="button" onclick()="GoogleMapa(2)" data='2' name="Mapa" value="Bydlisko">
        </div>
    </div>

    <script>
        $('#A').click(function(event) {
            var id = $(this).attr('data');
            GoogleMapa(id);
        });

        $('#B').click(function(event) {
            var id = $(this).attr('data');
            GoogleMapa(id);
        });
    </script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('#newsDiv').empty();
            $.ajax({
                type: 'GET',
                url: 'https://147.175.98.140/semestralnyProjekt/php/rest/RestNews.php',
                dataType: 'json',
                success: function (data) {
                    $length = data[0]
                    for (i = 0; i < data[0].length; i++) {
                        $('#newsDiv').append(data[0][i] + "<br>");
                    }
                },
                error: function (xhr, textStatus, errorThrown) {
                    alert('GET nefunguje 😕');
                    console.log(xhr.status);
                    //console.log(errorThrown);
                    console.log(textStatus);
                }
            });
        });
    </script>
</body>
</html>