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

                <label for="textAreaInput">Text spravy</label>
                <textarea class="form-control" name="message" id="textAreaInput" rows="5"></textarea>

            <button id="submit" type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
<div>


    <script src="jquery.js"></script>
<script>

    $('#submit').click(function() {
        //console.log('pridaj novinku: ' + $('#textAreaInput').val());
        $.ajax({
            type: 'POST',
            url: '../rest/RestNews.php/' + $('#textAreaInput').val(),
            success: function() {
                alert("Success: " + $('#textAreaInput').val());
            },
            error: function(textStatus, xhr) {
                alert('Novinka sa nedá pridať');
                console.log(xhr.status);
                console.log(textStatus);
            }
        });
    });
</script>
<?php
//include header template
require('layout/footer.php');
?>