
<?php

$id = null;
if (isset($_GET["id"])) {
    $id=$_GET["id"];
}

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../Config.php';
include_once '../services/ServiceRoutes.php';
include_once '../services/ServiceSubRoutes.php';


$route = new ServiceRoutes;
$subroute = new ServiceSubRoutes;

if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    $request = explode('/', trim($_SERVER['PATH_INFO'],'/'));

    if($request[0] == "getAllPublicRoutes"){

        $arr[] =  $route->getAllPublicRoutes($db);
        // return all our data to an AJAX call
        echo json_encode($arr,JSON_PRETTY_PRINT);
    }

    elseif($request[0] == "getAllPublicSubRoutes"){

        $arr1 =  $subroute->getAllPublicSubroutes($db);
        $arr2 = $subroute->getAllRelaySubroutes($db);
        $arr = array_merge($arr2, $arr1);
        // return all our data to an AJAX call
        echo json_encode($arr,JSON_PRETTY_PRINT);
    }

    elseif($request[0] == "getAllSubroutesOfUser"){
        //$id = explode('/', trim($_SERVER['PATH_INFO'],'/'));

        $arr =  $subroute->getAllSubroutesOfUser($db,$id);
        // return all our data to an AJAX call
        echo json_encode($arr,JSON_PRETTY_PRINT);
    }

}
?>