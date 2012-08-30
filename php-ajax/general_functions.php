<?php
/**
 * User: Fritz
 * Date: 30/08/12
 * Time: 16:09
 * Contains general functions that are needed everywhere, keeps other files compact
 */
include_once "php_serial.class.php";
// Set the timezone
date_default_timezone_set("Europe/Brussels");
/* This will make the serial connection */
$serial = new phpSerial;
$serial->deviceClose();
$serial->deviceSet("/dev/ttyAMA0");
$serial->confBaudRate(115200);
$serial->confParity("none");
$serial->confCharacterLength(8);
$serial->confStopBits(1);

define("LIVE_FILE","/opt/www/data/live-data.json");

// Asks for a sensor and write the value to a specific file
// Note it has only basic function, so be sure the file can be read/write by php
function request_sensor($filename, $cmd) {
    global $serial;
    // Open the device
    $serial->deviceOpen();
    // now send the command
    $serial->sendMessage($cmd);
    // Wait till we get a respons
    $val = intval(trim($serial->readPort()));
    // flot needs the date/time in this way
    $date = date("U") * 1000;
    // Store the data in a new array
    $new_data = array($date, $val);
    // Open the file provided by the user
    $file = fopen($filename, "r+w");
    // get the contents, its one big string so no need for a while loop
    $var = fgets($file);
    fclose($file);
    $result = json_decode($var);
    // If the file has values then append the data using array push, else create the file
    if ($result) {
        array_push($result, $new_data);
        $json_encoded = json_encode($result);
    } else {
        $json_encoded = json_encode(array($new_data));
    }
    // clear the data in the old file
    $file = fopen($filename, "w+");
    // write the new data to the file
    fwrite($file, $json_encoded);
    // close the file again
    fclose($file);
}

// Checks if a value is between a low and high value
function isBetween($num, $low, $high) {
    if ($num < $low) return false;
    if ($num > $high) return false;
    return true;
}

// Sends a command using the serial interface
function sendCommand($cmd) {
    global $serial;
    $serial->deviceOpen();
    // now send the command
    $serial->sendMessage($cmd);
    $serial->deviceClose();
}