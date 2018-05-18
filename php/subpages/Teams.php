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

//include header template
require('layout/header.php');
require("layout/Menu.php");

if ($_SESSION['personType'] == 1) {
    header('Location: Login.php');
    exit();
}
?>

<div class="container">
    <div class="row">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Email</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>John</td>
                <td><a href='TeamEdit.php?id=<?php echo $_SESSION['memberID'];?>'
                       class="btn btn-primary btn-xs"><i class="far fa-edit"></i> Upraviť</a>
                </td>
                <td><a href='TeamEdit.php?id=<?php echo $_SESSION['memberID'];?>'
                       class="btn btn-primary btn-xs"><i class="fas fa-trash-alt"></i> Vymazať</a>
                </td>
            </tr>
            <tr>
                <td>Mary</td>
                <td>Moe</td>
                <td>mary@example.com</td>
            </tr>
            <tr>
                <td>July</td>
                <td>Dooley</td>
                <td>july@example.com</td>
            </tr>
            </tbody>
        </table>
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

<?php
//include header template
require('layout/footer.php');
