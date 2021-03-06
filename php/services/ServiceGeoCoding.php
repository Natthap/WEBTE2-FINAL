<?php
/**
 * Created by PhpStorm.
 * User: mzikl
 * Date: 12.5.2018
 * Time: 13:49
 */

class ServiceGeoCoding
{

    // function to geocode address, it will return false if unable to geocode address
    function getGeoJson($address)
    {

        // url encode the address
        $address = urlencode($address);

        // google map geocode api url
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key=AIzaSyByMYlDd-vW0NeOJae_oKJdRbFSX8oixT0";

        // get the json response
        $resp_json = file_get_contents($url);

        // decode the json
        $resp = json_decode($resp_json, true);

        $location = json_encode($resp["results"][0]["geometry"]["location"]);

        $response = $resp["status"];

        // response status will be 'OK', if able to geocode given address
        if ($response == 'OK') {
            return $location;
        } else {
            return "";
        }
    }
}
?>