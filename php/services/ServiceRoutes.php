<?php
/**
 * Created by PhpStorm.
 * User: mzikl
 * Date: 12.5.2018
 * Time: 13:52
 */

function createUserRoute($db, $routeData) {
    $sql = "INSERT INTO routes (FK_members, name, active, geojson, type)
            VALUES ('"
            .$routeData["userID"]."', '".$routeData["name"]."', '"
            .$routeData["active"]."', '".$routeData["geojson"]."', '"
            .$routeData["type"]
            ."')";

    $stmt = $db->prepare($sql);

    $stmt->execute();

}

function updateActiveUserRoute($db, $routeData) {
    $sql = "UPDATE routes
            SET active='".$routeData["active"]."'
            WHERE id='".$routeData["userID"]."'";

    echo $sql;

    $stmt = $db->prepare($sql);

    $stmt->execute();
}

function getAllUserRoutes($db) {
    $sql = "SELECT * FROM routes";

    $stmt = $db->prepare($sql);

    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    var_dump($result);
}
?>