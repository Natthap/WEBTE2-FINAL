<?php require('../Config.php');

//include the user class, pass in the database connection
include('classes/user.php');
include('../services/ServiceUser.php');

$user = new User($db);
$userService = new ServiceUser();

ob_start();
session_start();
error_reporting(0);

//if not logged in redirect to login page
if(!$user->is_logged_in()){
    header('Location: Login.php');
    exit();
}

//define page title
$title = 'Používatelia';
$users = 'active';

//include header template
require('layout/header.php');
require("layout/Menu.php");

if ($_SESSION['personType'] == 1) {
    header('Location: Login.php');
    exit();
}

$results = $userService->getAllUsers($db);

?>

<div class="container">
    <div class="row">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Id</th>
                <th>Meno</th>
                <th>Priezvisko</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($results as $row) {
                echo "<tr>
                    <td>".$row[0]."</td>
                    <td>".$row[1]."</td>
                    <td>".$row[2]."</td>
                </tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="emailForm col-12">
            <form class="" role="form" method="post" action="#">
                <div class="form-group">
                    <label for="exampleFormControlFile1">Example file input</label>
                    <input type="file" class="form-control-file" id="exampleFormControlFile1">
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
<div>

<?php
//include header template
require('layout/footer.php');
