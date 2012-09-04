<?php
/**
 * User: Fritz
 * Date: 2/09/12
 * Time: 12:19
 */
include_once("arduino_pi.class.php");

$arduinopi = new ArduinoPi(MEGA2560);

/*****************************************************************
 * Leave this part alone, this is used for the API
 */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $arduinopi->process($_POST["mode"], $_POST["data"]);
} else {
    $handler = $_GET['handler'];
    $data = explode("/", $handler);
    if (count($data) >= 2) {
        $mode = strtolower($data[0]);
        $data = array_slice($data, 1);
        $arduinopi->process($mode, $data);
    }
}