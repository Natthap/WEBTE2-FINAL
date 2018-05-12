<?php
/**
 * Created by PhpStorm.
 * User: mzikl
 * Date: 12.5.2018
 * Time: 13:50
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

?>