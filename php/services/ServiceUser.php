<?php
/**
 * Created by PhpStorm.
 * User: mzikl
 * Date: 12.5.2018
 * Time: 13:50
 */

include "ServiceGeoCoding.php";

/*
 * Function based on ID will return all user data:
 * email, meno, priezvisko,
 * skola, bydlisko, skola_adresa,
 * bydlisko_adresa, skola_GPS, bydlisko_GPS
 * arguments: db connection and id of user
 */
function getUserData($db, $id) {

    $sql = "SELECT 
            members.email, memberData.meno, memberData.priezvisko, 
            memberData.skola_adresa, memberData.bydlisko_adresa, memberData.skola, 
            memberData.bydlisko, memberData.skola_GPS, memberData.bydlisko_GPS 
            FROM members 
            INNER JOIN memberData ON members.id=memberData.FK_Members 
            WHERE members.id='".$id."'";

    $stmt = $db->prepare($sql);

    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row;
}
/*
 * Function will update data for user by his ID:
 * email, meno, priezvisko,
 * skola, bydlisko, skola_adresa,
 * bydlisko_adresa, skola_GPS, bydlisko_GPS
 * argument "$userData" must contains all above.
 * $id is id of user
 */
function updateUserData($db, $userData, $id) {

    include "ServiceGeoCoding.php";

    $sql = "UPDATE members SET email='".$userData["email"]."' WHERE id='".$id."'";

    $stmt = $db->prepare($sql);

    $stmt->execute();

    $userData["skola_GPS"] = getGeoJson($userData["skola_adresa"]);

    $userData["bydlisko_GPS"] = getGeoJson($userData["bydlisko_adresa"]);

    $sql = "UPDATE memberData SET 
            meno='".$userData["meno"]."', priezvisko='".$userData["priezvisko"]."',
            skola_adresa='" .$userData["skola_adresa"]."', bydlisko_adresa='".$userData["bydlisko_adresa"]."', 
            skola='".$userData["skola"]."', bydlisko='".$userData["bydlisko"]."', 
            skola_GPS='".$userData["skola_GPS"]."', bydlisko_GPS='".$userData["bydlisko_GPS"]."'
            WHERE  FK_Members='".$id."'";

    $stmt = $db->prepare($sql);

    $stmt->execute();
}
/*
 * Function return all users as array of arrays where index is ID of user
 * values are meno and priezvisko
 */
function getAllUsers($db) {
    $sql = "SELECT FK_Members as id, meno, priezvisko FROM memberData";

    $stmt = $db->prepare($sql);

    $stmt->execute();

    $result = array();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result[$row["id"]] = array($row["meno"], $row["priezvisko"]);
    }

    return $result;
}

/*
 * Function will update users teamID based on his ID
 * arguments: db connection, ID of user, IF of team
 */
function updateUsersTeam($db, $id, $teamID) {
    $sql = "UPDATE members 
            SET team_id='".$teamID."'
            WHERE id='".$id."'";

    $stmt = $db->prepare($sql);

    $stmt->execute();
}

/*
 * Function will insert new user to database
 * $userData must contains:
 * password, email, active, resetToken,
 * resetComplete, meno, priezvisko, skola,
 * bydlisko, skola_adresa, bydlisko_adresa
 */
function createUser($db, $userData) {

    $userData["skola_GPS"] = getGeoJson($userData["skola_adresa"]);

    $userData["bydlisko_GPS"] = getGeoJson($userData["bydlisko_adresa"]);

    $sql = "INSERT INTO members (password, email, created, personType, active, resetToken, resetComplete)
            VALUES (
            '".$userData["password"]."', '".$userData["email"]."', 
            '".date("Y-m-d h:i:s")."', '1', 
            '".$userData["active"]."', '".$userData["resetToken"]."', 
            '".$userData["resetComplete"]
            ."')";

    $stmt = $db->prepare($sql);

    $stmt->execute();

    $sql = "SELECT id FROM members WHERE email='".$userData["email"]."'";

    $stmt->prepare($sql);

    $stmt->execute();

    $id = $db->lastInsertId('id');

    $sql = "INSERT INTO memberData (FK_Members, meno, priezvisko, skola, bydlisko, skola_adresa, bydlisko_adresa, skola_GPS, bydlisko_GPS)
            VALUES (
            '".$id."', '".$userData["meno"]."', 
            '".$userData["priezvisko"]."', '".$userData["skola"]."', 
            '".$userData["bydlisko"]."', '".$userData["skola_adresa"]."', 
            '".$userData["bydlisko_adresa"]."', '".$userData["skola_GPS"]."', 
            '".$userData["bydlisko_GPS"]
            ."')";

    $stmt = $db->prepare($sql);

    $stmt->execute();
}

function userExist($db, $email) {

    $sql = "SELECT * FROM members WHERE email='".$email."'";

    $stmt = $db->prepare($sql);

    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if($row) {
        return true;
    } else {
        return false;
    }
}

function getAllUsersData($db) {
    $sql = "SELECT 
            members.email, memberData.meno, memberData.priezvisko, 
            memberData.skola_adresa, memberData.bydlisko_adresa, memberData.skola, 
            memberData.bydlisko, memberData.skola_GPS, memberData.bydlisko_GPS 
            FROM members 
            INNER JOIN memberData ON members.id=memberData.FK_Members";

    $stmt = $db->prepare($sql);

    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}
?>