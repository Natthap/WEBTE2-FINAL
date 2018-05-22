<?php require('../Config.php');

//include the user class, pass in the database connection
include('classes/user.php');
include('../services/ServiceUser.php');
include('../services/ServiceTeam.php');

$user = new User($db);
$userService = new ServiceUser();
$teamService = new ServiceTeam();

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

//include header template
require('layout/header.php');
require("layout/Menu.php");

$id = null;
if (isset($_GET["id"])) {
    $id=$_GET["id"];
}

if ($_SESSION['personType'] == 1) {
    header('Location: Login.php');
    exit();
}

$results = $userService->getAllUsers($db);
$teamName = $teamService->getTeamName($db, $id);

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $user1 = $_POST['user1'];
    $user2 = $_POST['user2'];
    $user3 = $_POST['user3'];
    $user4 = $_POST['user4'];
    $user5 = $_POST['user5'];
    $user6 = $_POST['user6'];

    $userIDs = array($user1, $user2, $user3, $user4, $user5, $user6);
    $teamService->updateTeam($db, $id, $name, $userIDs, $userService);

    header('Location: Teams.php');
    exit();
}

?>

<div class="container">
    <div class="emailForm">
        <form class="" role="form" method="post" action="#">
            <div class="form-group">
                <label for="name">Nazov timu</label>
                <input type="text" name="name" class="form-control" id="name" value="<?php echo $teamName; ?>">
            </div>
            <div class="row">
                <div class="col">
                    <select class="form-control" name="user1">
                        <option value=""> - </option>
                        <?php
                        foreach ($results as $row) {
                            echo "<option value='$row[0]'>".$row[1]." ".$row[2]."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col">
                    <select class="form-control" name="user2">
                        <option value=""> - </option>
                        <?php
                        foreach ($results as $row) {
                            echo "<option value='$row[0]'>".$row[1]." ".$row[2]."</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <select class="form-control" name="user3">
                        <option value=""> - </option>
                        <?php
                        foreach ($results as $row) {
                            echo "<option value='$row[0]'>".$row[1]." ".$row[2]."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col">
                    <select class="form-control" name="user4">
                        <option value=""> - </option>
                        <?php
                        foreach ($results as $row) {
                            echo "<option value='$row[0]'>".$row[1]." ".$row[2]."</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <select class="form-control" name="user5">
                        <option value=""> - </option>
                        <?php
                        foreach ($results as $row) {
                            echo "<option value='$row[0]'>".$row[1]." ".$row[2]."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col">
                    <select class="form-control" name="user6">
                        <option value=""> - </option>
                        <?php
                        foreach ($results as $row) {
                            echo "<option value='$row[0]'>".$row[1]." ".$row[2]."</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Odoslat</button>
        </form>
    </div>
<div>

<?php
//include header template
require('layout/footer.php');