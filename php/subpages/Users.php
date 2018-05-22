<?php require('../Config.php');

//include the user class, pass in the database connection
include('classes/user.php');
include('../services/ServiceUser.php');
include('../services/ServiceFileHandler.php');

$user = new User($db);
$userService = new ServiceUser();
$fileHandler = new ServiceFileHandler();

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

if(isset($_POST["submit"])) {
    $uploadDir = 'https://147.175.98.140/semestralnyProjekt/php/subpages/uploads/';
    $uploadFile = $uploadDir . basename($_FILES['fileInput']['name']);

    echo '<pre>';
    if (move_uploaded_file($_FILES['fileInput']['tmp_name'], $uploadfile)) {
        echo "File is valid, and was successfully uploaded.\n";
        $fileHandler->filehandler($db, $uploadFile);
    } else {
        echo "Possible file upload attack!\n";
        $fileHandler->filehandler($db, $uploadFile);
    }

    echo 'Here is some more debugging info:';
    print_r($_FILES);

    print "</pre>";
}

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
            <form class="" role="form" method="post" action="#" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="fileInput">Vlozte subor</label>
                    <input type="file" name="fileInput" class="form-control-file" id="fileInput">
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Odoslat</button>
            </form>
        </div>
    </div>
<div>

<?php
//include header template
require('layout/footer.php');
