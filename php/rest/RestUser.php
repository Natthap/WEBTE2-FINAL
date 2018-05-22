<?php
$id = null;
if (isset($_GET["id"])) {
    $id=$_GET["id"];
}

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../Config.php';
include_once '../services/ServiceUser.php';

    
    
    $user = new ServiceUser;


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $request = explode('/', trim($_SERVER['PATH_INFO'], '/'));

    if ($request[0] == "getUserData") {
        $arr = $user->getUserData($db, $id);
        // return all our data to an AJAX call
        echo json_encode($arr, JSON_PRETTY_PRINT);
    }
    
    elseif ($request[0] == "getAllUsers") {
        $arr = $user->getAllUsers($db);
        // return all our data to an AJAX call
        echo json_encode($arr, JSON_PRETTY_PRINT);
    }
    

    
}


?>