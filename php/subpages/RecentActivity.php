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
$title = 'Nedávna aktivita';
$recent = 'active';

//include header template
require('layout/header.php');
require("layout/Menu.php");

?>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <div class="container">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-tab1" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Sukromne trasy</a>
                <a class="nav-item nav-link" id="nav-tab2" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Verejne trasy</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <div id="data"></div>
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <div id="data1"></div>
            </div>
        </div>
    <div>

    <script type="text/javascript">
        var id = "<?php echo($_SESSION['memberID']); ?>";

        $( document ).ready(function (){
            $('#data').empty();
            $('#data1').empty();
            $.ajax({
                type: 'GET',
                url: "../rest/RestRoute.php/getAllSubroutesOfUser?id="+id,
                dataType: 'json',
                success: function (data) {
                    $('#data').append("<table class='table table-hover'><tr><th>notes 1 </th><th>average speed </th><th>start time</th><th>end time</th></tr>");

                    for (var i = 0; i < data.length; i++) {
                        $('#data').append("<tr> "+"<td> "+data[i]['notes'] + "</td>"+"<td> "+data[i]['averageSpeed'] + "</td>"+"<td> "+data[i]['startTime'] + "</td>"+"<td> "+data[i]['endTime'] + "</td>"+"</tr> ");
                    }
                    $('#data').append("</table>");
                },
                error: function (xhr, textStatus, errorThrown) {
                    alert('GET nefunguje ');
                    console.log(xhr.status);
                    //console.log(errorThrown);
                    console.log(textStatus);
                }
            });
        });

        $('#nav-tab1').click(function() {
            $('#data').empty();
            $('#data1').empty();
            $.ajax({
                type: 'GET',
                url: "../rest/RestRoute.php/getAllSubroutesOfUser?id="+id,
                dataType: 'json',
                success: function (data) {
                    $('#data').append("<table class='table table-hover'><thead><tr><th>notes</th><th>average speed</th><th>start time</th><th>end time</th></tr></thead><tbody id='body'>");

                    for (i = 0; i < data.length; i++) {
                        $('#body').append("<tr><td>"+data[i]['notes'] + "</td><td>"+data[i]['averageSpeed'] + "</td><td>"+data[i]['startTime'] + "</td><td>"+data[i]['endTime'] + "</td></tr>");
                    }
                    $('#data').append("</tbody></table>");
                },
                error: function (xhr, textStatus) {
                    console.log(xhr.status);
                    console.log(textStatus);
                }
            });
        });

        $('#nav-tab2').click(function() {
            $('#data').empty();
            $('#data1').empty();
            $.ajax({
                type: 'GET',
                url: '../rest/RestRoute.php/getAllPublicSubRoutes',
                dataType: 'json',
                success: function (data) {
                    // $length = data[0]
                    $('#data1').append("<table class='table table-hover'><thead><tr><th>notes 2 </th><th>average speed </th><th>start time</th><th>end time</th></tr></thead><tbody id='body1'>")
                    for (i = 0; i < data.length; i++) {
                        $('#body1').append("<tr> "+"<td> "+""+data[i]['notes'] + "</td><td>"+data[i]['averageSpeed'] + "</td><td>"+data[i]['startTime'] + "</td><td> "+data[i]['endTime'] + "</td></tr> ");
                    }
                    $('#data1').append("</tbody></table>");
                },
                error: function (xhr, textStatus, errorThrown) {
                    console.log(xhr.status);
                    //console.log(errorThrown);
                    console.log(textStatus);
                }
            });
        });
    </script>

<?php
//include header template
require('layout/footer.php');
