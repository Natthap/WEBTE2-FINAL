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
$title = 'Profil';
$news = 'active';

//include header template
require('layout/header.php');
require("layout/Menu.php");
?>

<div class="container">
    <div class="emailForm">
        <form class="" role="form" method="post" action="#">
            <div class="form-group">
                <label for="textAreaInput">Text spravy</label>
                <textarea class="form-control" name="message" id="textAreaInput" rows="5"></textarea>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
<div>

<?php
//include header template
require('layout/footer.php');