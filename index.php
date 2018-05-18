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

<div class="container">
    <div class="row justify-content-md-center">
        <div id="mapDiv" class="col col-lg-8 border border-primary rounded">
            tu bude mapa
        </div>
        <div class="col col-lg-4 box">
            <div id="loginDiv" class="col col-lg border border-primary rounded">
                <h3>Prihlasenie a registracia</h3>
                <hr>
                <p><a href='php/subpages/Register.php'>Zaregistrujte sa</a></p>
                <hr>
                <p><a href='php/subpages/Login.php'>Prihláste sa</a></p>
            </div>
            <div id="newsDiv" class="col col-lg border border-primary rounded">
                tu budu novinky
            </div>
        </div>
    </div>
</div>

<?php
require('php/subpages/layout/footer.php');