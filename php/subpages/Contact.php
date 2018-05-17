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
$title = 'Kontakt';

//include header template
require('layout/header.php');
require("layout/Menu.php");
?>

<div class="container">
    <div class="contact_form wow fadeInLeft">
        <form class="" role="form" method="post" action="" autocomplete="off">
            <div class="form-group"><input type="text" name="name" class="wp-form-control wpcf7-text" placeholder="Vaše meno"></div>
            <div class="form-group"><input type="mail" name="email" class="wp-form-control wpcf7-email" placeholder="Emailová adresa"></div>
            <div class="form-group"><input type="text" name="subject" class="wp-form-control wpcf7-text" placeholder="Predmet"></div>
            <div class="form-group"><textarea name="message" class="wp-form-control wpcf7-textarea" cols="30" rows="10" placeholder="Čo by ste nám chceli povedat?"></textarea></div>
            <div class="form-group"><input type="submit" name="submit" value="Poslať" class="wpcf7-submit"></div>
        </form>
    </div>
<div>

<?php
//include header template
require('layout/footer.php');
