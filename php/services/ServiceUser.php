<?php
/**
 * Created by PhpStorm.
 * User: mzikl
 * Date: 12.5.2018
 * Time: 13:50
 */

/*
 * Function
 */
function getUserData($db, $id) {

    $sql = "SELECT 
            members.email, memberData.meno, memberData.priezvisko, 
            memberData.skola_adresa, memberData.bydlisko_adresa, memberData.skola, 
            memberData.bydlisko, memberData.skola_GPS, memberData, bydlisko_GPS 
            FROM members 
            INNER JOIN memberData ON members.id=memberData.FK_Members 
            WHERE members.id='".$id."'";

    $stmt = $db->prepare($sql);

    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row;
}
/*
 * Function will update data for user by his ID
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
            password='".$userData["password"]."', email='".$userData["email"]."', 
            created='".date("Y-m-d h:i:s")."', personType='1', 
            active='".$userData["active"]."', resetToken='".$userData["resetToken"]."', 
            resetComplete='".$userData["resetComplete"]
            ."')";

    $stmt = $db->prepare($sql);

    $stmt->execute();

    $sql = "SELECT id FROM members WHERE email='".$userData["email"]."'";

    $stmt->prepare($sql);

    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql = "INSERT INTO memberData (FK_Members, meno, priezvisko, skola, bydlisko, skola_adresa, bydlisko_adresa, skola_GPS, bydlisko_GPS)
            VALUES (
            FK_Members='".$row["id"]."', meno='".$userData["meno"]."', 
            priezvisko='".$userData["priezvisko"]."', skola='".$userData["skola"]."', 
            bydlisko='".$userData["bydlisko"]."', skola_adresa='".$userData["skola_adresa"]."', 
            bydlisko_adresa='".$userData["bydlisko_adresa"]."', skola_GPS='".$userData["skola_GPS"]."', 
            bydlisko_GPS='".$userData["bydlisko_GPS"]
            ."')";

    $stmt = $db->prepare($sql);

    $stmt->execute();
}
?>