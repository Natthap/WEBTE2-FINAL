<?php
$id = $_GET["id"];

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../Config.php';
include_once '../services/ServiceTeam.php';
    
    
   
    $team = new ServiceTeam;

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $request = explode('/', trim($_SERVER['PATH_INFO'], '/'));

    //if(request[0] == "getAllTeams")
   // {
        $arr =  $team->getAllTeams($db);
        // return all our data to an AJAX call
        echo json_encode($arr,JSON_PRETTY_PRINT); 
   // }    
}


?>