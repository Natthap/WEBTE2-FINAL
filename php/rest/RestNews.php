<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'config.php';
include_once 'ServiceNews.php';
    
    

if ($_SERVER['REQUEST_METHOD'] == 'GET'){

    $arr[] = getallnews($db);
    // return all our data to an AJAX call
    echo json_encode($arr,JSON_PRETTY_PRINT);
    
}  

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
    
    addnews($db,$request[0]);
    
    
    http_response_code(201);
   

}


?>

