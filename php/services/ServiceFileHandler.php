<?php
/**
 * Created by PhpStorm.
 * User: mzikl
 * Date: 12.5.2018
 * Time: 13:53
 */

include "ServiceGeoCoding.php";
include "ServiceMailHandler.php";
//include "../subpages/classes/user.php";

header('charset=utf-8');

class ServiceFileHandler
{

    /*
    *Funkcia prijme csv subor a rozparsuje jeho obsah
    *potom kazdeho pouzivatela prida do db pomocou funkcie
    *createUser a rozposle im mail pomocou funkcie sendMail,
    *ak pouzivatel existuje neprida sa.
    */
    function filehandler($db, $tmpName)
    {
        
        $error_messages = array();
        $row = 1;
        if (($handle = fopen($tmpName, "r")) !== FALSE) {
            $flag = true;
            while (($data = fgetcsv($handle, 1000, "\n")) !== FALSE) {
                if ($flag) {
                    $flag = false;
                    continue;
                }

                $num = count($data);
                $row++;
                for ($c = 0; $c < $num; $c++) {
                    $data1 = explode(";", $data[$c]);


                    //vytvorenie hesla pouzivatela
                    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $charactersLength = strlen($characters);
                    $password = '';
                    for ($i = 0; $i < 7; $i++) {
                        $password .= $characters[rand(0, $charactersLength - 1)];
                    }


                    $bydlisko_adresa = $data1[8] . "," . $data1[7] . "," . $data1[6];
                    $hash_password = password_hash($password, PASSWORD_BCRYPT);
                    $userData = array("meno" => $data1[1], "priezvisko" => $data1[2], "skola" => $data1[4], "skola_adresa" => $data1[5], "bydlisko" => $data1[6], "bydlisko_adresa" => $bydlisko_adresa, "password" => $hash_password, "email" => $data1[3], "active" => "", "resetToken" => "", "resetComplete" => "No");


                    if (!userExist($db, $data1[3])) {
                        createUser($db, $userData);
                        sendMail($data1[3], $password);
                    } else {
                        array_push($error_messages, "Uzivatel s emailom: " . $data1[3] . " uz existuje");
                    }
                }
            }
            fclose($handle);
            array_push($error_messages, "Nepodarilo sa otvorit subor");
        }

        return $error_messages;
    }
}
?>
