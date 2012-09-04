<?php
/**
 * User: Fritz
 * Date: 30/08/12
 * Time: 11:51
 */
include_once "arduino_pi.class.php";

$arduinopi = new ArduinoPi(MEGA2560);

try {
    $arduinopi->writeToFileAnalog("A0", "live-data");
} catch (phpSerialException $e) {
    $e->getMessage();
} catch (Exception $e) {
    $e->getMessage();
}
