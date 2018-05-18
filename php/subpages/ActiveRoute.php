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
$title = 'Aktívne trasy';

//include header template
require('layout/header.php');
require("layout/Menu.php");

if ($_SESSION['personType'] == 2) {

}
if ($_SESSION['personType'] == 1) {

}
?>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="../../js/googleMap.js"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBnj9vchPrrDWFJsZ_OLK8vZr9cFoAhYnI" ></script>

    <div class="container col col-lg-12">
        <div class="row justify-content-md-center mapContainer">
            <div class="col col-lg-8 border border-primary rounded m-3">
                <div id="mapDiv" class="col-12 ml-0 mt-0">
                </div>
            </div>
            <div class="col col-lg-3 border border-primary rounded pb-3 m-3">
                <div id="tableDiv">
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
                            <td>kokot2</td>
                            <td>kokot</td>
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
            </div>
        </div>
        <div class="row justify-content-md-center">
            <div class="col col-lg border border-primary rounded pb-3">
                <div id="formDiv">
                    <h3>Pridanie podtrasy</h3>
                    <form class="" role="form" method="post" action="#">
                        <div class="form-group">
                            <input type="hidden" name="gpsStart" class="form-control" id="gpsStart" value="<?php echo $_SESSION['memberID']; ?>">
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="gpsEnd" class="form-control" id="gpsEnd" value="">
                        </div>
                        <div class="form-group">
                            <label for="startTime">Zaciatocny cas</label>
                            <input type="text" name="startTime" class="form-control" id="startTime" placeholder="Zaciatocny cas">
                        </div>
                        <div class="form-group">
                            <label for="endTime">Koncovy cas</label>
                            <input type="text" name="endTime" class="form-control" id="endTime" placeholder="Koncovy cas">
                        </div>
                        <div class="form-group">
                            <label for="rating">Hodnotenie</label>
                            <input type="text" name="rating" class="form-control" id="rating" placeholder="Hodnotenie">
                        </div>
                        <div class="form-group">
                            <label for="note">Poznamka</label>
                            <input type="text" name="note" class="form-control" id="note" placeholder="Poznamka">
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php
//include header template
require('layout/footer.php');
