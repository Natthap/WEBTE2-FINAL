<?php require('../Config.php');

//include the user class, pass in the database connection
include('classes/user.php');
include('classes/phpmailer/mail.php');
$user = new User($db);

ob_start();
session_start();

//if not logged in redirect to login page
if(!$user->is_logged_in()){
    header('Location: Login.php');
    exit();
}

//define page title
$title = 'Members Page';

//include header template
require('layout/header.php'); 
?>

<?php
if ($_SESSION['personType'] == 2) {
    echo '<div class="container">';
        echo '<div class="row">';
            echo '<div class="col-xs-12 col-sm-10 col-md-10 col-sm-offset-3 col-md-offset-3">';
                echo '<h2>Toto je stránka len pre prihlásených administrátorov - Vitaj '.htmlspecialchars($_SESSION['username'], ENT_QUOTES).'</h2>';
                echo '<p><a class="btn btn-primary" href="Logout.php">Odhlásiť sa</a>';
                echo '<hr>';
            echo '</div>';
        echo '</div>';
    echo '</div>';
}

if ($_SESSION['personType'] == 1) {
    echo '<div class="container">';
        echo '<div class="row">';
            echo '<div class="col-xs-12 col-sm-10 col-md-10 col-sm-offset-3 col-md-offset-3">';
                echo '<h2>Toto je stránka len pre prihlásených pouzivatelov - Vitaj '.htmlspecialchars($_SESSION['username'], ENT_QUOTES).'</h2>';
                echo '<p><a class="btn btn-primary" href="Logout.php">Odhlásiť sa</a>';
                echo '<hr>';
            echo '</div>';
        echo '</div>';
    echo '</div>';
}
?>

<?php 
//include header template
require('layout/footer.php'); 
?>