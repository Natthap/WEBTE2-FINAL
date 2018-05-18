<?php
/**
 * Created by PhpStorm.
 * User: mzikl
 * Date: 12.5.2018
 * Time: 13:52
 */

class ServiceRoutes
{

    function createUserRoute($db, $routeData)
    {
        $sql = "INSERT INTO routes (FK_members, name, active, geojson, type)
            VALUES ('"
            . $routeData["userID"] . "', '" . $routeData["name"] . "', '"
            . $routeData["active"] . "', '" . $routeData["geojson"] . "', '"
            . $routeData["type"]
            . "')";

        $stmt = $db->prepare($sql);

        $stmt->execute();

    }

    function updateActiveUserRoute($db, $routeData)
    {
        $sql = "UPDATE routes
            SET active='" . $routeData["active"] . "'
            WHERE id='" . $routeData["routeID"] . "'";

        $stmt = $db->prepare($sql);

        $stmt->execute();
    }

    function getAllUserRoutes($db, $userID)
    {
        $sql = "SELECT * FROM routes WHERE FK_members='" . $userID . "'";

        $stmt = $db->prepare($sql);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    function getAllPublicRoutes($db)
    {
        $sql = "SELECT * FROM routes WHERE type='0'";

        $stmt = $db->prepare($sql);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    function createTeamRelayRoute($db, $routeData)
    {
        $sql = "INSERT INTO routes_relay (FK_team, name, active, geojson)
            VALUES ('"
            . $routeData["teamID"] . "', '" . $routeData["name"] . "', '"
            . $routeData["active"] . "', '" . $routeData["geojson"] . "', '"
            . "')";

        $stmt = $db->prepare($sql);

        $stmt->execute();
    }

    function updateTeamRelayRoute($db, $routeData)
    {
        $sql = "UPDATE routes_relay
            SET active='" . $routeData["active"] . "'
            WHERE ='" . $routeData["routeID"] . "'";

        $stmt = $db->prepare($sql);

        $stmt->execute();
    }

    function getAllTeamRelayRoutes($db, $teamID)
    {
        $sql = "SELECT * FROM routes_ralay WHERE FK_team='" . $teamID . "'";

        $stmt = $db->prepare($sql);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    function getAllRelayRoutes($db)
    {
        $sql = "SELECT * FROM routes_ralay";

        $stmt = $db->prepare($sql);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}
?>