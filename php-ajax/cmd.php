<?php
/**
 * User: Fritz
 * Date: 28/08/12
 * Time: 14:54
 */
include_once "general_functions.php";
// If we have a post request then continue
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // We switch on the mode passed on by GET
    switch ($_GET["mode"]) {
        // Picker option, we take the 3 extra values and then check if they are between
        // the desired values (we cannot write an analog value higher then 255)
        case "picker":
            $red = intval($_POST["red"]);
            $blue = intval($_POST["blue"]);
            $green = intval($_POST["green"]);

            if (isBetween($red, 0, 255) && isBetween($blue, 0, 255) && isBetween($green, 0, 255)) {
                $result = "@101," . $red . "," . $green . "," . $blue . ":";
                sendCommand($result);
            }
            break;
        // We now request a val manually
        case "request-val":
            $port = intval($_POST["port"]);
            if (isBetween($port, 0, 13)) {
                $result = "@102," . $port . ":";
                request_sensor(LIVE_FILE, $result);
            }
            break;
        // We hover over a object and this should trigger an desired result
        case "hover":
            $port = intval($_POST["port"]);
            $value = intval($_POST["value"]);
            if (isBetween($port, 0, 99) && isBetween($value, 0, 255)) {
                $result = "@" . $port . "," . $value . ":";
                sendCommand($result);
            }
            break;
         // We want to delete the log
        case "delete-log":
            // clear the data
            $file = fopen(LIVE_FILE, "w+");
            break;

        // Room for more functions!
    }
}
