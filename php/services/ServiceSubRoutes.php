<?php
/**
 * Created by PhpStorm.
 * User: mzikl
 * Date: 12.5.2018
 * Time: 13:52
 */

class ServiceSubRoutes
{

    function createUsersSubroute($db, $subrouteData)
    {
        $sql = "INSERT INTO subroutes (FK_route, geojson, rating, notes, startTime, endTime, averageSpeed)
            VALUES (
            '" . $subrouteData["routeID"] . "', '" . $subrouteData["geojson"] . "', 
            '" . $subrouteData["rating"] . "', '" . $subrouteData["notes"] . "', 
            '" . $subrouteData["start"] . "', '" . $subrouteData["end"] . "',
             '" . $subrouteData["speed"] . "')";

        $stmt = $db->prepare($sql);

        $stmt->execute();
    }

    function getAllSubroutesOfRoute($db, $id)
    {
        $sql = "SELECT * FROM subroutes WHERE FK_route='" . $id . "'";

        $stmt = $db->prepare($sql);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    function getAllPublicSubroutes($db)
    {

        $sql = "SELECT id FROM routes WHERE type='0'";

        $stmt = $db->prepare($sql);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $finalResults = array();

        foreach ($result as &$value) {
            $sql = "SELECT * FROM subroutes WHERE FK_route='" . $value["id"] . "'";

            $stmt = $db->prepare($sql);

            $stmt->execute();

            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $finalResults = array_merge($finalResults, $res);
        }

        return $finalResults;
    }

    function getAllSubroutesOfUser($db, $userID)
    {
        $sql = "SELECT * FROM subroutes WHERE FK_user='" . $userID . "'";

        $stmt = $db->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getAllRelaySubroutes($db)
    {
        $sql = "SELECT * FROM subroutes_relay";

        $stmt = $db->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function createRelaySubroute($db, $subrouteData)
    {
        $sql = "INSERT INTO subroutes_relay (FK_route, geojson, rating, notes, startTime, endTime, averageSpeed, FK_user)
            VALUES (
            '" . $subrouteData["routeID"] . "', '" . $subrouteData["geojson"] . "', 
            '" . $subrouteData["rating"] . "', '" . $subrouteData["notes"] . "', 
            '" . $subrouteData["start"] . "', '" . $subrouteData["end"] . "',
             '" . $subrouteData["speed"] . "', '" . $subrouteData["userID"] . "')";

        $stmt = $db->prepare($sql);

        $stmt->execute();
    }


function getAverageSpeed($startTime, $endTime, $distance) {
    $dateStart = new DateTime($startTime);
    $dateEnd = new DateTime($endTime);

    $secondsStart = $dateStart->format('s');
    $minutesStart = $dateStart->format('i');
    $hoursStart = $dateStart->format('H');
    $timeStart = $hoursStart * 3600 + $minutesStart * 60 + $secondsStart;

    $secondsEnd = $dateEnd->format('s');
    $minutesEnd = $dateEnd->format('i');
    $hoursEnd = $dateEnd->format('H');
    $timeEnd = $hoursEnd * 3600 + $minutesEnd * 60 + $secondsEnd;

    $time = $timeEnd-$timeStart;

    $speed = $distance/$time;

        return $speed * 3600;
    }

    function getAllSubroutes($db)
    {
        $sql = "SELECT * FROM subroutes";

        $stmt = $db->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}