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
$title = 'Tímy';
$team = 'active';

//include header template
require('layout/header.php');
require("layout/Menu.php");

if ($_SESSION['personType'] == 1) {
    header('Location: Login.php');
    exit();
}
?>
<script src="jquery.js"></script>
<div class="container">
    <div class="row">
        <table id="data" class='table table-hover'></table>
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
            $('#data').empty();

            $.ajax({
                type: 'GET',
                url: "../rest/RestTeam.php/getAllTeams",
                dataType: 'json',
                success: function(data) {


                    $('#data').append("<tr><th>Name</th></tr>")


                    for (i = 0; i < data.length; i++) {
                      //  $('#data').append("<tr> ");
                        $('#data').append("<tr><td> " + "&nbsp " + data[i]['nazov'] + "</td></tr>");
                       // $('#data').append("</tr> ");
                    }
                    $('#data').append("</table>");
                },
                error: function(xhr, textStatus, errorThrown) {

                    alert('GET nefunguje ');
                    console.log(xhr.status);
                    //console.log(errorThrown);
                    console.log(textStatus);
                }
            });

        </script>

        <?php
//include header template
require('layout/footer.php');
