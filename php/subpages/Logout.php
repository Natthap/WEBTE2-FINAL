<?php require('../Config.php');

//include the user class, pass in the database connection
include('classes/user.php');
include('classes/phpmailer/mail.php');
$user = new User($db);

ob_start();
session_start();

//logout
$user->logout(); 

//logged in return to index page
header('Location: Register.php');
exit;
?>