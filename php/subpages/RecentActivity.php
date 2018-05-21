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
$title = 'Nedávna aktivita';

//include header template
require('layout/header.php');
require("layout/Menu.php");

?>

    <script src="jquery.js"></script>


<div class="container">
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="tab1" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">All subroutes of user </a>
            <a class="nav-item nav-link" id="tab2" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">All public subroutes</a>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="aa" role="tabpanel" aria-labelledby="nav-home-tab">


        </div>
        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">

        </div>
    </div>
<div>
    <div >
    <table id="data"></table>
    </div>
    <div >
    <table id="data1"></table>
    </div>

    <script type="text/javascript">
        var id = "<?php echo($_SESSION['memberID']); ?>";
    </script>


<script>


    $( document ).ready(function (){
        $('#data').empty();
        $('#data1').empty();

    $.ajax({
    type: 'GET',
    url: "../rest/RestRoute.php/getAllSubroutesOfUser?id="+id,
    dataType: 'json',
    success: function (data) {

    $('#data').append("<table class='table table-hover'><tr><th>notes </th><th>average speed </th><th>start time</th><th>end time</th></tr>")


        for (i = 0; i < data.length; i++) {
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
    $('#tab1').click(function() {
        $('#data').empty();
        $('#data1').empty();

        $.ajax({
            type: 'GET',
            url: "../rest/RestRoute.php/getAllSubroutesOfUser?id="+id,
            dataType: 'json',
            success: function (data) {

                $('#data').append("<table class='table table-hover'><tr><th>notes </th><th>average speed </th><th>start time</th><th>end time</th></tr>")


                for (i = 0; i < data.length; i++) {
                    $('#data').append("<tr>"+"<td>"+data[i]['notes'] + "</td>"+"<td> "+data[i]['averageSpeed'] + "</td>"+"<td>"+data[i]['startTime'] + "</td>"+"<td>"+data[i]['endTime'] + "</td>"+"</tr>");
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

    // $('#tab2').click(function() {
    //     $('#data').empty();
    //     $('#data1').empty();
    //
    //     $.ajax({
    //         type: 'GET',
    //         url: '../rest/RestUser.php?id='+id,
    //         dataType: 'json',
    //         success: function (data) {
    //             $('#data1').append("Kto definoval:"+"<br>");
    //             $('#data1').append("<th>meno </th><th>priezvisko</th></tr>");
    //
    //
    //             $('#data1').append("<tr> ");
    //             $('#data1').append("<td> "+data['meno'] + "</td>");
    //             $('#data1').append("<td> "+data['priezvisko'] + "</td>");
    //
    //             $('#data1').append("</tr> ");
    //
    //             $('#data1').append("</table>");
    //         },
    //         error: function (xhr, textStatus, errorThrown) {
    //             alert('GET nefunguje ');
    //             console.log(xhr.status);
    //             //console.log(errorThrown);
    //             console.log(textStatus);
    //         }
    //     });
    // });

    $('#tab2').click(function() {
        $('#data').empty();
        $('#data1').empty();

        $.ajax({
            type: 'GET',
            url: '../rest/RestRoute.php/getAllPublicSubRoutes',
            dataType: 'json',
            success: function (data) {
                // $length = data[0]

                $('#data1').append("<table class='table table-hover'><tr><th>notes </th><th>average speed </th><th>start time</th><th>end time</th></tr>")
                for (i = 0; i < data.length; i++) {
                    $('#data1').append("<tr> "+"<td> "+""+data[i]['notes'] + "</td>"+"<td> "+data[i]['averageSpeed'] + "</td>"+"<td> "+data[i]['startTime'] + "</td>"+"<td> "+data[i]['endTime'] + "</td>"+"</tr> ");
                }
                $('#data1').append("</table>");
            },
            error: function (xhr, textStatus, errorThrown) {
                alert('GET nefunguje ');
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
?>