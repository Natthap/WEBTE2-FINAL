<?php
/**
 * Created by PhpStorm.
 * User: mzikl
 * Date: 12.5.2018
 * Time: 13:47
 */

//database credentials
define('DBHOST','147.175.98.140');
define('DBUSER','matojekokot');
define('DBPASS','root');
define('DBNAME','Zadanie');

try {
    //create PDO connection
    $db = new PDO("mysql:host=".DBHOST.";charset=utf8mb4;dbname=".DBNAME, DBUSER, DBPASS);
    $db->exec("set names utf8");
    //$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);//Suggested to uncomment on production websites
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//Suggested to comment on production websites
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch(PDOException $e) {
    //show error
}
?>