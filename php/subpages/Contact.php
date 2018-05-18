<?php
require('../Config.php');

//include the user class, pass in the database connection
include('classes/user.php');
include('../services/ServiceMailHandler.php');

$user = new User($db);
$mailer = new ServiceMailHandler();

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

if(isset($_POST['submit'])){
    $mailer->sendMail($_POST['email'], "", $_POST['subject'], $_POST['message'], 2);
    /*try {
        $from = $_POST['email'];
        $body = "<p>".$_POST['message']."</p>";

        $mail = new Mail();
        $mail->setFrom(SITEEMAIL);
        $mail->addAddress($from);
        $mail->subject($_POST['subject']);
        $mail->body($body);
        $mail->send();

    } catch(PDOException $e) {
        $error[] = $e->getMessage();
    }*/
}
?>

<div class="container">
    <div class="emailForm">
        <form class="" role="form" method="post" action="#">
            <div class="form-group">
                <label for="nameInput">Vase meno</label>
                <input type="text" name="name" class="form-control" id="nameInput" placeholder="Vase meno">
            </div>
            <div class="form-group">
                <label for="emailInput">Vas email</label>
                <input type="email" name="email" class="form-control" id="emailInput" aria-describedby="emailHelp" placeholder="Zadajte email">
            </div>
            <div class="form-group">
                <label for="subjectInput">Predmet spravy</label>
                <input type="text" name="subject" class="form-control" id="subjectInput" placeholder="Zadajte predmet spravy">
            </div>
            <div class="form-group">
                <label for="textAreaInput">Text spravy</label>
                <textarea class="form-control" name="message" id="textAreaInput" rows="3"></textarea>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
<div>

<?php
//include header template
require('layout/footer.php');
