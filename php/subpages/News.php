<?php require('../Config.php');

//include the user class, pass in the database connection
include('classes/user.php');
include('../services/ServiceNews.php');

$user = new User($db);
$newsService = new ServiceNews();

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
$news = 'active';

//include header template
require('layout/header.php');
require("layout/Menu.php");

if(isset($_POST['submit'])) {
    $message = $_POST['message'];

    $newsService->addnews($db, $message);
}
?>

<div class="container">
    <div class="emailForm">
        <form class="" role="form" method="post" action="#">
            <div class="form-group">
                <label for="textAreaInput">Text spravy</label>
                <textarea class="form-control" name="message" id="textAreaInput" rows="5"></textarea>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Odoslat</button>
        </form>
    </div>
<div>

<?php
//include header template
require('layout/footer.php');