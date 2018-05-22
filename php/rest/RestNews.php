<?php
/**
 * Created by PhpStorm.
 * User: mzikl
 * Date: 12.5.2018
 * Time: 13:48
 */

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../Config.php';
include_once '../services/ServiceNews.php';

$news = new ServiceNews();

if ($_SERVER['REQUEST_METHOD'] == 'GET'){

    $arr[] = $news->getallnews($db);
    // return all our data to an AJAX call
    echo json_encode($arr,JSON_PRETTY_PRINT);

}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $request = explode('/', trim($_SERVER['PATH_INFO'],'/'));

    addnews($db,$request[0]);
    http_response_code(201);
}


?>

