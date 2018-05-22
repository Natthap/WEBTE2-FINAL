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
$title = 'Tímy';
$team = 'active';

//include header template
require('layout/header.php');
require("layout/Menu.php");

if ($_SESSION['personType'] == 1) {
    header('Location: Login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $teamService->deleteTeam($db, $id);
}

$results = $userService->getAllUsers($db);

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $user1 = $_POST['user1'];
    $user2 = $_POST['user2'];
    $user3 = $_POST['user3'];
    $user4 = $_POST['user4'];
    $user5 = $_POST['user5'];
    $user6 = $_POST['user6'];

    $userIDs = array($user1, $user2, $user3, $user4, $user5, $user6);
    $teamService->addTeam($db, $name, $userIDs, $userService);

    header('Location: Teams.php');
    exit();
}
?>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <div class="container">
        <div class="row">
            <div id="data" class="col-12">
            </div>
        </div>
        <div class="row">
            <div class="emailForm col-12">
                <form class="" role="form" method="post" action="#">
                    <div class="form-group">
                        <label for="name">Nazov timu</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Nazov timu">
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
        </div>
    <div>

    <script>
        var id = "<?php echo($_SESSION['memberID']); ?>";

        $(document).ready(function () {
            $('#data').empty();
            $.ajax({
                type: 'GET',
                url: "../rest/RestTeam.php/getAllTeams",
                dataType: 'json',
                success: function (data) {
                    $('#data').append("<table class='table table-hover'><thead><tr><th>Nazov timu</th><th>Upravit tim</th>" +
                        "<th>Zmazat tim</th></tr></thead><tbody id='body'>")

                    for (var i = 0; i < data.length; i++) {
                        $('#body').append("<tr><td>" + data[i]['nazov'] + "</td><td><a href='TeamEdit.php?id=" + data[i]['id'] + "' " +
                            "class='btn btn-primary btn-xs'><i class='far fa-edit'></i> Upraviť</a></td><td><a href='?id=" + data[i]['id'] + "' " +
                            "class='btn btn-primary btn-xs'><i class='fas fa-trash-alt'></i> Vymazať</a></td></tr>");
                    }
                    $('#data').append("<tbody></table>");
                },
                error: function (xhr, textStatus) {
                    console.log(xhr.status);
                    console.log(textStatus);
                }
            });
        });

    </script>

<?php
//include header template
require('layout/footer.php');
