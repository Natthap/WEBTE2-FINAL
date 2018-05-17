<?php
/**
 * Created by PhpStorm.
 * User: mzikl
 * Date: 12.5.2018
 * Time: 13:52
 */

function createUsersSubroute($db, $subrouteData) {
    $sql = "INSERT INTO subroutes (FK_route, geojson, rating, notes, startTime, endTime, averageSpeed)
            VALUES (
            '".$subrouteData["routeID"]."', '".$subrouteData["geojson"]."', 
            '".$subrouteData["rating"]."', '".$subrouteData["notes"]."', 
            '".$subrouteData["start"]."', '".$subrouteData["end"]."',
             '".$subrouteData["speed"]."')";

    $stmt = $db->prepare($sql);

    $stmt->execute();
}

function getAllSubroutesOfRoute($db, $id) {
    $sql = "SELECT * FROM subroutes WHERE FK_route='".$id."'";

    $stmt = $db->prepare($sql);

    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

function getAllPublicSubroutes($db) {

    $sql = "SELECT id FROM routes WHERE type='0'";

    $stmt = $db->prepare($sql);

    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $finalResults = array();

    foreach($result as &$value) {
        $sql = "SELECT * FROM subroutes WHERE FK_route='".$value["id"]."'";

        $stmt = $db->prepare($sql);

        $stmt->execute();

        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $finalResults = array_merge($finalResults, $res);
    }

    return $finalResults;
}

function getAllSubroutesOfUser($db, $userID) {
    $sql = "SELECT * FROM subroutes_relay WHERE FK_user='".$userID."'";

    $stmt = $db->prepare($sql);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllRelaySubroutes($db) {
    $sql = "SELECT * FROM subroutes_relay";

    $stmt = $db->prepare($sql);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function createRelaySubroute($db, $subrouteData) {
    $sql = "INSERT INTO subroutes_relay (FK_route, geojson, rating, notes, startTime, endTime, averageSpeed, FK_user)
            VALUES (
            '".$subrouteData["routeID"]."', '".$subrouteData["geojson"]."', 
            '".$subrouteData["rating"]."', '".$subrouteData["notes"]."', 
            '".$subrouteData["start"]."', '".$subrouteData["end"]."',
             '".$subrouteData["speed"]."', '".$subrouteData["userID"]."')";

    $stmt = $db->prepare($sql);

    $stmt->execute();
}

function getAverageSpeed($dateTime, $distance) {
    $date = new DateTime($dateTime);

    $seconds = $date->format('s');
    $minutes = $date->format('i');
    $hours = $date->format('H');
    $time = $hours * 3600 + $minutes * 60 + $seconds;
    $speed = $distance/$time;

    return $speed * 3600;
}