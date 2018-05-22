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
    <script src="../../js/SortFilter.js"></script>
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
                <div id='data1'>
                </div>
            </div>
        </div>
    <div>

    <script type="text/javascript">
        var id = "<?php echo($_SESSION['memberID']); ?>";
        var typ = "<?php echo($_SESSION['personType']); ?>";
        var path;

        $(document).ready(function (){
            $('#data').empty();
            $('#data1').empty();
            if (typ == 2) {
                path = "../rest/RestRoute.php/getAllSubroutes";
            }
            if (typ == 1) {
                path = "../rest/RestRoute.php/getAllSubroutesOfUser?id="+id;
            }
            $.ajax({
                type: 'GET',
                url: path,
                dataType: 'json',
                success: function (data) {
                    $('#data').append("<table id='tabulka2' class='table table-hover'><thead><tr><th onclick='sortTable(1,tabulka2)'>notes 1 </th><th onclick='sortTable(2,tabulka2)'>average speed </th><th onclick='sortTable(3,tabulka2)'>start time</th><th>end time</th></tr></thead><tbody id='bodyDef'>");

                    for (var i = 0; i < data.length; i++) {
                        $('#bodyDef').append("<tr> "+"<td> "+data[i]['notes'] + "</td>"+"<td> "+data[i]['averageSpeed'] + "</td>"+"<td> "+data[i]['startTime'] + "</td>"+"<td> "+data[i]['endTime'] + "</td>"+"</tr> ");
                    }
                    $('#data').append("</tbody></table>");
                },
                error: function (xhr, textStatus) {
                    console.log(xhr.status);
                    console.log(textStatus);
                }
            });
        });

        $('#nav-tab1').click(function() {
            $('#data').empty();
            $('#data1').empty();
            if (typ == 2) {
                path = "../rest/RestRoute.php/getAllSubroutes";
            }
            if (typ == 1) {
                path = "../rest/RestRoute.php/getAllSubroutesOfUser?id="+id;
            }
            $.ajax({
                type: 'GET',
                url: path,
                dataType: 'json',
                success: function (data) {
                    $('#data').append("<table id='tabulka' class='table table-hover'><thead><tr><th onclick='sortTable(1,tabulka)'>notes</th><th onclick='sortTable(2,tabulka)'>average speed</th><th onclick='sortTable(3,tabulka)'>start time</th><th onclick='sortTable(4,tabulka)'>end time</th></tr></thead><tbody id='body'>");

                    for (var i = 0; i < data.length; i++) {
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
            if (typ == 2) {
                path = "../rest/RestRoute.php/getAllSubroutes";
            }
            if (typ == 1) {
                path = "../rest/RestRoute.php/getAllPublicSubRoutes";
            }
            $.ajax({
                type: 'GET',
                url: path,
                dataType: 'json',
                success: function (data) {
                    // $length = data[0]
                    $('#data1').append("<table id='data1' class='table table-hover'<tr><thead><th onclick='sortTable(1,tabulka1)'>notes 2 </th><th onclick='sortTable(2,tabulka1)'>average speed </th><th onclick='sortTable(1,tabulka1)'>start time</th><th onclick='sortTable(3,tabulka1)'>end time</th></tr></thead><tbody id='body1'>")
                    for (var i = 0; i < data.length; i++) {
                        $('#body1').append("<tr> "+"<td> "+""+data[i]['notes'] + "</td><td>"+data[i]['averageSpeed'] + "</td><td>"+data[i]['startTime'] + "</td><td> "+data[i]['endTime'] + "</td></tr> ");
                    }
                    $('#data1').append("</tbody></table>")
                    
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
