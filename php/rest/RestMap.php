<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../Config.php';
include_once '../services/ServiceNews.php';
include_once '../services/ServiceUser.php';


    
 $service = new ServiceUser;

if ($_SERVER['REQUEST_METHOD'] == 'GET'){

    $arr = $service->getAllUsersData($db);
 
    
    // return all our data to an AJAX call
    echo json_encode($arr,JSON_PRETTY_PRINT);
    
}  

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
    
    addnews($db,$request[0]);
    
     $response=array(
				'status' => 1,
				'status_message' =>'Product Updated Successfully.'
			);
    
    http_response_code(400);
    throw new Exception(http_response_code());
    header('Content-Type: application/json');
    echo json_encode($response);
   

}


?>