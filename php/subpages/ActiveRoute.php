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
$title = 'Members Page';

//include header template
require('layout/header.php');
require("layout/Menu.php");

if ($_SESSION['personType'] == 2) { ?>
    <div class="container">

    </div>
<?php}

if ($_SESSION['personType'] == 1) { ?>
    <div class="container">

    </div>
<?php}

//include header template
require('layout/footer.php');
