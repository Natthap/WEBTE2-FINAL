<?php require('../Config.php');

//include the user class, pass in the database connection
include('classes/user.php');
$user = new User($db);

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
    echo $_GET['id'];
}
?>

<div class="container">
    <div class="row">
        <div id="data">
            <a href='?id=1' class='btn btn-primary btn-xs'><i class='fas fa-trash-alt'></i> Vymazať</a>
        </div>
    </div>
    <div class="row">
        <div class="emailForm col-12">
            <form class="" role="form" method="post" action="#">
                <div class="form-group">
                    <label for="nameInput">Vase meno</label>
                    <input type="text" name="name" class="form-control" id="nameInput" placeholder="Vase meno">
                </div>
                <div class="row">
                    <div class="col">
                        <select class="form-control">
                            <option>Default select</option>
                        </select>
                    </div>
                    <div class="col">
                        <select class="form-control">
                            <option>Default select</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <select class="form-control">
                            <option>Default select</option>
                        </select>
                    </div>
                    <div class="col">
                        <select class="form-control">
                            <option>Default select</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <select class="form-control">
                            <option>Default select</option>
                        </select>
                    </div>
                    <div class="col">
                        <select class="form-control">
                            <option>Default select</option>
                        </select>
                    </div>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
<div>

    <script>
        var id = "<?php echo($_SESSION['memberID']); ?>";
        $('#data').empty();
        $.ajax({
            type: 'GET',
            url: "../rest/RestTeam.php/getAllTeams",
            dataType: 'json',
            success: function(data) {
                $('#data').append("<table class='table table-hover'><thead><tr><th>Nazov timu</th><th>Upravit tim</th>" +
                    "<th>Zmazat tim</th></tr></thead><tbody id='body'>")

                for (var i = 0; i < data.length; i++) {
                    $('#body').append("<tr><td>" + data[i]['nazov'] + "</td><td><a href='TeamEdit.php?id="+id+"' " +
                    "class='btn btn-primary btn-xs'><i class='far fa-edit'></i> Upraviť</a></td><td><a href='?id="+id+"' " +
                    "class='btn btn-primary btn-xs'><i class='fas fa-trash-alt'></i> Vymazať</a></td></tr>");
                }
                $('#data').append("<tbody></table>");
            },
            error: function(xhr, textStatus) {
                alert('GET nefunguje ');
                console.log(xhr.status);
                console.log(textStatus);
            }
        });

    </script>

<?php
//include header template
require('layout/footer.php');
