<?php
/**
 * Created by PhpStorm.
 * User: mzikl
 * Date: 12.5.2018
 * Time: 13:49
 */
/*
 * Function return all news as array of arrays where index is ID of news
 * values are text and time
 */
function getallnews($db)
{
    $sql = "SELECT id,text,time FROM news";

    $stmt = $db->prepare($sql);

    $stmt->execute();

    $result = array(array());
    $x = 0;
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        
        $result[$x] = array($row["text"], $row["time"]);
        $x++;
    }
    return $result;
}

/*
 * Function will insert new news to database
 */
function addnews($db,$text) {

    
    $current_date = date('Y-m-d H:i:s');
    $sql = "INSERT INTO news (text, time) VALUES ('". $text ."','". $current_date ."')";
    
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return;
}


?>