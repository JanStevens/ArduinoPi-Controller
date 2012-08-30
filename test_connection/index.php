<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include "php_serial.class.php";

$serial = new phpSerial;
$serial->deviceClose();
$serial->deviceSet("/dev/ttyAMA0");
$serial->confBaudRate(115200);
$serial->confParity("none");
$serial->confCharacterLength(8);
$serial->confStopBits(1);
$serial->deviceOpen();
$serial->sendMessage("@101,205,132,201:");
// second command - we like to switch leds

$read = $serial->readPort();
$serial->deviceClose();

echo "I've sended a message! \n\r";
echo "Found: " . $read;
?>
