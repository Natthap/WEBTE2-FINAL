<?php
//get logged user's id
$id = null;
if (isset($_GET["id"])) {
    $id = $_GET["id"];
}

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//change paths!
include_once '../Config.php';
include_once '../services/ServiceRoutes.php';
include_once '../services/ServiceSubRoutes.php';


$route = new ServiceRoutes;
$subroute = new ServiceSubRoutes;

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $request = explode('/', trim($_SERVER['PATH_INFO'], '/'));

    //return array of USER active route at [0] and routes's subroutes at []
    //test: RestSubRoute.php/getActiveRouteOfUser?id=2
    if ($request[0] == "getActiveRouteOfUser") {
        $arr1 = $route->getActiveRouteOfUser($db, $id);
        if (sizeof($arr1) > 0) {
            $arr2 = $subroute->getAllSubroutesOfRoute($db, $arr1[0]["id"]);
            $arr = array_merge($arr1, $arr2);
            // return all our data to an AJAX call
            echo json_encode($arr, JSON_PRETTY_PRINT);
        }
    }

    //return all user's Routes
    if ($request[0] == "getAllusersRoute") {
        $arr = $route->getAllUserRoutes($db, $id);
        // return all our data to an AJAX call
        echo json_encode($arr, JSON_PRETTY_PRINT);
    }

    if ($request[0] == "getAllFuckingRoutes") {
        $arr1 = $route->getAllRoutes($db);

        $arr2 = $route->getAllRelayRoutes($db);

        $arr = array_merge($arr1, $arr2);
        // return all our data to an AJAX call
        echo json_encode($arr, JSON_PRETTY_PRINT);
    }
}



?>
