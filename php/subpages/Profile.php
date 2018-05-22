<?php require('../Config.php');

//include the user class, pass in the database connection
include('classes/user.php');
include('../services/ServiceUser.php');
include('../services/ServiceGeoCoding.php');

$user = new User($db);
$userService = new ServiceUser();
$geoClass = new ServiceGeoCoding();

ob_start();
session_start();
error_reporting(0);

//if not logged in redirect to login page
if(!$user->is_logged_in()){
    header('Location: Login.php');
    exit();
}

//define page title
$title = 'Profil';
$profile = 'active';

//include header template
require('layout/header.php');
require("layout/Menu.php");

$id = $_SESSION['memberID'];

if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $meno = $_POST['meno'];
    $priezvisko = $_POST['priezvisko'];
    $skola = $_POST['skola'];
    $skola_adresa = $_POST['skola_adresa'];
    $bydlisko = $_POST['bydlisko'];
    $bydlisko_adresa = $_POST['bydlisko_adresa'];

    $userData = array("meno"=>$meno,"priezvisko"=>$priezvisko,"skola"=>$skola,"skola_adresa"=>$skola_adresa,"bydlisko"=>$bydlisko,
        "bydlisko_adresa"=>$bydlisko_adresa,"email"=>$email);

    $userService->updateUserData($db, $userData, $id, $geoClass);
}

$row = $userService->getUserData($db, $id);
?>

<div class="container">
    <div class="emailForm">
        <form class="" role="form" method="post" action="#">
            <?php
            echo "<div class=\"form - group\">
                <label for=\"email\">Vas email</label>
                <input type=\"email\" name=\"email\" class=\"form-control\" id=\"email\" value=\"".$row['email']."\">
            </div>
            <div class=\"form-group\">
                <label for=\"meno\">Vase meno</label>
                <input type=\"text\" name=\"meno\" class=\"form-control\" id=\"meno\" value=\"".$row['meno']."\">
            </div>
            <div class=\"form-group\">
                <label for=\"priezvisko\">Vase priezvisko</label>
                <input type=\"text\" name=\"priezvisko\" class=\"form-control\" id=\"priezvisko\"
                       value=\"".$row['priezvisko']."\">
            </div>
            <div class=\"form-group\">
                <label for=\"skola\">Nazov skoly</label>
                <input type=\"text\" name=\"skola\" class=\"form-control\" id=\"skola\"
                       value=\"".$row['skola']."\">
            </div>
            <div class=\"form-group\">
                <label for=\"skola_adresa\">Adresa skoly</label>
                <input type=\"text\" name=\"skola_adresa\" class=\"form-control\" id=\"skola_adresa\"
                       value=\"".$row['skola_adresa']."\">
            </div>
            <div class=\"form-group\">
                <label for=\"bydlisko\">Bydlisko</label>
                <input type=\"text\" name=\"bydlisko\" class=\"form-control\" id=\"bydlisko\"
                       value=\"".$row['bydlisko']."\">
            </div>
            <div class=\"form-group\">
                <label for=\"bydlisko_adresa\">Adresa bydliska</label>
                <input type=\"text\" name=\"bydlisko_adresa\" class=\"form-control\" id=\"bydlisko_adresa\"
                       value=\"".$row['bydlisko_adresa']."\">
            </div>
            <button type=\"submit\" name=\"submit\" class=\"btn btn-primary\">Odoslat</button>";
            ?>
        </form>
    </div>
<div>

<?php
//include header template
require('layout/footer.php');
