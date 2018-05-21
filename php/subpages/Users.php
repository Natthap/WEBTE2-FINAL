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
$title = 'Používatelia';
$users = 'active';

//include header template
require('layout/header.php');
require("layout/Menu.php");

if ($_SESSION['personType'] == 1) {
    header('Location: Login.php');
    exit();
}?>
    <script src="jquery.js"></script>
    <div class="container">

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
    <div class="row">
        <table id="data" class='table table-hover'></table>
    </div>
            <script>
                $('#data').empty();

                $.ajax({
                    type: 'GET',
                    url: "../rest/RestUser.php/getAllUsers",
                    dataType: 'json',
                    success: function (data) {

                        $('#data').append("<tr><th>Name </th><th>Surname </th></tr>");


                        for (i = 0; i < Object.keys(data).length; i++) {
                            $('#data').append("<tr>"+"<td> "+data[i][0] + "</td>"+"<td> "+data[i][1] + "</td></tr>");

                            
                        }

                    
                    },
                    error: function (xhr, textStatus, errorThrown) {

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
