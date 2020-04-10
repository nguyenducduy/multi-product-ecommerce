<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nguyen
 * Date: 7/25/13
 * Time: 9:41 AM
 * To change this template use File | Settings | File Templates.
 */
class Controller_Site_Geturlcontent extends Controller_Site_Base {

    function indexAction(){
        $url = base64_decode( $_GET['url']);
        $ch = curl_init(); // Initialize a CURL session.
        curl_setopt($ch, CURLOPT_URL, $url);  // Pass URL as parameter.

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  // Return stream contents.
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1); // We'll be returning this transfer, and the data is binary
        $data = curl_exec($ch);  // // Grab the jpg and save the contents in the $data variable
        curl_close($ch);  // close curl resource, and free up system resources.
        // if url is images
        $infofile = getimagesize($url);
        header("Content-type: ". $infofile['mime']);
        echo $data;


    }
}