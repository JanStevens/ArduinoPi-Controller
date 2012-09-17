<?php
/**
 * We extend the serial class and add our own layer on top it. This class will only be used on Arduino-RaspberryPi
 * connections. If the serial device is different or another baud rate is needed then people can
 * still change this using the original serial class library.
 *
 * @author Jan Stevens [http://fritz-hut.com]
 */


define("HIGH", 255);
define("LOW", 0);

define("MEGA2560", 100);
define("UNO", 101);
define("LEONARDO", 102);
define("ADK", 103);

date_default_timezone_set("Europe/Brussels");

include_once "php_serial.class.php";

class ArduinoPi extends phpSerial
{
    private $_arduino = null;
    private $_ardName = null;

    /**
     * Constructer.
     *
     * @params int $device
     * @returns ArduinoPi
     */
    public function __construct($device)
    {
        // Setup the serial connection, call the parent constructor
        try {
            parent::__construct();
            $this->deviceSet("/dev/rfcomm0");
            $this->confBaudRate(115200);
            $this->confParity("none");
            $this->confCharacterLength(8);
            $this->confStopBits(1);
            $this->_setDevice($device);
        } catch (phpSerialException $e) {
            $this->_jsonError($e->getMessage());
            die();
        } catch (Exception $e) {
            $this->_jsonError($e->getMessage());
            die();
        }
    }

    /**
     * Sets the device name, right now only the Arduino Mega 2560 is supported
     * Analog pins also can be used as digital pins, pwm can also be digital pins
     *
     * @param int $name The name of the device
     * @return bool
     * @throws Exception
     */
    private function _setDevice($name)
    {
        switch ($name) {
            case MEGA2560:
                $this->_arduino = array("PWM" => array(0, 13), "DIGITAL" => array(0, 69), "ANALOG" => array(0, 15));
                $this->_ardName = MEGA2560;
                return true;
                break;
            case UNO:
                $this->_arduino = array("PWM" => array(3, 5, 6, 9, 10, 11), "DIGITAL" => array(0, 20), "ANALOG" => array(0, 5));
                $this->_ardName = UNO;
                return true;
                break;
            case LEONARDO:
                $this->_arduino = array("PWM" => array(3, 5, 6, 9, 10, 11, 13), "DIGITAL" => array(0, 20), "ANALOG" => array(4, 6, 8, 9, 10, 12, 14, 15, 16, 17, 18, 19));
                $this->_ardName = LEONARDO;
                return true;
                break;
            case ADK:
                // Analog pins also can be used as digital pins
                $this->_arduino = array("PWM" => array(0, 13), "DIGITAL" => array(0, 69), "ANALOG" => array(0, 15));
                $this->_ardName = ADK;
                return true;
                break;
            default:
                throw new Exception("Your device is not compatible with the ArduinoPi");
        }
    }

    /**
     * Writes a PWM value to a specific port using the command interface
     * @cmd: @<port>,<value>:
     *
     * @param int $port The port value as an int
     * @param int $value The value of the port for PWM
     * @return bool
     * @throws Exception
     */
    public function writePWM($port, $value)
    {
        if ($this->_isBetween($port, $this->_arduino["PWM"])) {
            if ($this->_isBetween($value, array(0, 255))) {
                $cmd = "@" . $port . "," . $value . ":";
                $this->deviceOpen();
                $this->sendMessage($cmd);
                $this->deviceClose();
                return true;
            } else
                throw new Exception("writePWM: Wrong value, it must be between 0-255");
        } else
            throw new Exception("writePWM: Wrong port value");
    }

    /**
     * Writes to a specific digital port, if PWM ports are needed use the other function!
     * @cmd: @<port>,<value>:
     *
     * @param int $port The port value
     * @param int $value The value, HIGH or LOW
     * @return bool
     * @throws Exception
     */
    public function writeDigital($port, $value)
    {
        if (is_string($port)) {
            $port = $this->_transAnalogPin($port);
        }
        if ($this->_isBetween($port, $this->_arduino["DIGITAL"])) {
            if ($value == HIGH || $value == LOW) {
                $cmd = "@" . $port . "," . $value . ":";
                $this->deviceOpen();
                $this->sendMessage($cmd);
                $this->deviceClose();
                return true;
            } else
                throw new Exception("writeDigital: The value should be HIGH or LOW (globals");
        } else
            throw new Exception("writeDigital: Wrong port, check that you are writing to a digital port!");
    }

    /**
     * Write multiple ports at the same time (no serial transfer delay)
     * @cmd @101,<#port>,<port1>,<value1>,<port2>,<value2>,...:
     *
     * @param int[] $port The port values in an array
     * @param int[]|int $value The value can be a array or one value for all the ports
     * @return bool
     * @throws Exception
     */
    public function writeMultiplePWM($port, $value)
    {
        if (is_array($port) && is_array($value) && count($port) == count($value)) {
            $cmd = "@101," . count($port);
            for ($i = 0; $i < count($port); $i++) {
                if ($this->_isBetween($port[$i], $this->_arduino["PWM"]) && $this->_isBetween($value[$i], array(0, 255))) {
                    $cmd .= "," . $port[$i] . "," . $value[$i];
                }
            }

            $cmd .= ":";
            $this->deviceOpen();
            $this->sendMessage($cmd);
            $this->deviceClose();
            return true;
        } else if (is_array($port) && $this->_isBetween($value, array(0, 255))) {
            $cmd = "@101," . count($port);
            foreach ($port as $port_num) {
                if ($this->_isBetween($port_num, $this->_arduino["PWM"])) {
                    $cmd .= "," . $port_num . "," . $value;
                }
            }
            $cmd .= ":";
            $this->deviceOpen();
            $this->sendMessage($cmd);
            $this->deviceClose();
            return true;
        } else
            throw new Exception("writeMultiplePWM: Port and value should be array, use writePWM instead");
    }

    /**
     * Write multiple ports at the same time (no serial transfer delay)
     * @cmd @101,<#port>,<port1>,<value1>,<port2>,<value2>,...:
     *
     * @param int[] $port The port values in an array
     * @param int[]|int $value The value can be a array or one value for all the ports
     * @return bool
     * @throws Exception
     */
    public function writeMultipleDigital($port, $value)
    {
        if (is_array($port) && is_array($value) && count($port) == count($value)) {
            $cmd = "@101," . count($port);
            for ($i = 0; $i < count($port); $i++) {
                if (is_string($port[$i])) {
                    $port[$i] = $this->_transAnalogPin($port[$i]);
                }
                if ($this->_isBetween($port[$i], $this->_arduino["DIGITAL"]) && ($value[$i] == HIGH || $value[$i] == LOW)) {
                    $cmd .= "," . $port[$i] . "," . $value[$i];
                }
            }
            $cmd .= ":";
            $this->deviceOpen();
            $this->sendMessage($cmd);
            $this->deviceClose();
            return true;
        } else if (is_array($port) && ($value == HIGH || $value == LOW)) {
            $cmd = "@101," . count($port);
            foreach ($port as $port_num) {
                if (is_string($port_num)) {
                    $port_num = $this->_transAnalogPin($port_num);
                }
                if ($this->_isBetween($port_num, $this->_arduino["DIGITAL"])) {
                    $cmd .= "," . $port_num . "," . $value;
                }
            }
            $cmd .= ":";
            $this->deviceOpen();
            $this->sendMessage($cmd);
            $this->deviceClose();
            return true;
        } else
            throw new Exception("writeMultipleDigital: Port and value should be array, use writeDigital instead");
    }

    /**
     * Reads a specific Analog port
     * @cmd: @102,<port>:
     *
     * @param int $port The port value
     * @return int returns false or else a value, note the value may also be zero
     * @throws Exception
     */
    public function readAnalog($port)
    {
        if (is_string($port)) {
            $port = $this->_transAnalogPin($port);
        }
        if ($this->_isBetween($port, $this->_arduino["ANALOG"])) {
            $cmd = "@102," . $port . ":";
            $this->deviceOpen();
            $this->sendMessage($cmd, 0.1);
            $val = intval(trim($this->readPort()));
            $this->deviceClose();
            return $val;
        } else
            throw new Exception("readAnalog: Wrong value for the port");
    }

    /**
     * Request multiple analog ports and return them as an array
     * @cmd @103,<#ports>,<port>,<port>,<port>
     *
     * @param array $port
     * @return array
     * @throws Exception
     */
    public function readMultipleAnalog($port)
    {
        if (is_array($port)) {
            $cmd = "@103," . count($port);
            for ($i = 0; $i < count($port); $i++) {
                if (is_string($port[$i])) {
                    $port[$i] = $this->_transAnalogPin($port[$i]);
                }
                if ($this->_isBetween($port[$i], $this->_arduino["ANALOG"])) {
                    $cmd .= "," . $port[$i];
                }
            }
            $cmd .= ":";
            $this->deviceOpen();
            $this->sendMessage($cmd, 0.1);
            $val = trim($this->readPort());
            $this->deviceClose();
            // The last value is nothing since arduino appends an extra comma, remove it!
            $result = explode(",", $val);
            unset($result[count($result) - 1]);
            return array_values($result);
        } else
            throw new Exception("readMultipleAnalog: Port should be an array");
    }

    /**
     * Writes the analog reading to a file, file must be readable or writable else nothing can be done.
     *
     * @param int $port
     * @param String $filename the name of the file, all filenames are saved in the data folder
     * @return int $val the value from the reading is returned
     * @throws Exception
     */
    public function writeToFileAnalog($port, $filename)
    {
        $filePath = $_SERVER["DOCUMENT_ROOT"] . "data/" . $filename . ".json";
        if (file_exists($filePath) && !empty($filename)) {
            if (is_readable($filePath) && is_writable($filePath)) {
                $val = $this->readAnalog($port);
                $new_data = array(date("U") * 1000, $val);
                $file = fopen($filePath, "r+w");
                $var = fgets($file);
                fclose($file);

                $result = json_decode($var);
                if ($result) {
                    array_push($result, $new_data);
                    $json_encoded = json_encode($result);
                } else {
                    $json_encoded = json_encode(array($new_data));
                }
                $file = fopen($filePath, "w+");
                fwrite($file, $json_encoded);
                fclose($file);
                return $val;
            } else
                throw new Exception("writetoFileAnalog: Could not read/write the file");
        } else
            throw new Exception("writeToFileAnalog: Could not open the file");
    }

    /**
     * Clears a file in the data folder
     *
     * @param $filename
     * @return bool
     * @throws Exception
     */
    public function deleteFile($filename)
    {
        $filePath = $_SERVER["DOCUMENT_ROOT"] . "data/" . $filename . ".json";
        if (file_exists($filePath) && !empty($filename)) {
            if (is_readable($filePath) && is_writable($filePath)) {
                $file = fopen($filePath, "w+");
                fclose($file);
                return true;
            } else
                throw new Exception("writetoFileAnalog: Could not read/write the file");
        } else
            throw new Exception("writeToFileAnalog: Could not open the file");
    }

    /**
     * This function will process everything from the API. Can be expanded future if needed
     *
     * @param String $mode the mode we want
     * @param array $data contains the data, ports and/or values
     * @throws Exception
     */
    public function process($mode, $data)
    {
        try {
            switch ($mode) {
                case "digital":
                    $this->writeDigital(intval($data[0]), $this->_convertToGlobal($data[1]));
                    $this->_jsonSuccess();
                    break;
                case "pwm":
                    $this->writePWM(intval($data[0]), $this->_convertToGlobal($data[1]));
                    $this->_jsonSuccess();
                    break;
                case "analog":
                    $val = $this->readAnalog(intval($data[0]));
                    if (is_int($val))
                        $this->_jsonSuccess($val);
                    else
                        throw new Exception("Could not read Analog Port");
                    break;
                case "multiple-digital":
                    $ports = array();
                    $values = array();
                    for ($i = 0; $i < count($data); $i += 2) {
                        array_push($ports, intval($data[$i]));
                        array_push($values, $this->_convertToGlobal($data[$i + 1]));
                    }
                    $this->writeMultipleDigital($ports, $values);
                    $this->_jsonSuccess();
                    break;
                case "multiple-pwm":
                    $ports = array();
                    $values = array();
                    for ($i = 0; $i < count($data); $i += 2) {
                        array_push($ports, intval($data[$i]));
                        array_push($values, $this->_convertToGlobal($data[$i + 1]));
                    }

                    $this->writeMultiplePWM($ports, $values);
                    $this->_jsonSuccess();
                    break;
                case "multiple-analog":
                    $result = $this->readMultipleAnalog($data);
                    if (is_array($result))
                        $this->_jsonSuccess($result);
                    else
                        throw new Exception("Could not read Analog Ports");
                    break;
                case "analog-file":
                    $result = $this->writeToFileAnalog(intval($data[0]), $data[1]);
                    if (is_int($result))
                        $this->_jsonSuccess($result);
                    else
                        throw new Exception("Could not write to file or read the value");
                    break;
                case "delete-file":
                    $this->deleteFile($data[0]);
                    $this->_jsonSuccess();
                    break;
                default:
                    throw new Exception("Command not recognized");
            }
        } catch (phpSerialException $e) {
            $this->_jsonError($e->getMessage());
        } catch (Exception $e) {
            $this->_jsonError($e->getMessage());
        }

    }

    /**
     * Returns true if the vale lies between high or low value.
     * If the $range array contains more then two values we look for $num in $range
     *
     * @param int $num The number we check for
     * @param int[] $range An array containing multiple variables
     * @return bool
     */
    private function _isBetween($num, $range)
    {
        if (count($range) == 2) {
            if ($num < $range[0]) return false;
            if ($num > $range[1]) return false;
            return true;
        } else {
            return in_array($num, $range) ? true : false;
        }
    }

    /**
     * Converts A0-A15 to the right port number
     *
     * @param String $string
     * @return int
     */
    private function _transAnalogPin($string)
    {
        $val = explode("A", $string);
        return $val[1];
    }

    /**
     * Converts "High" or "LOW" to the global HIGH or LOW, if other value is presented convert it to an int
     *
     * @param String $string
     * @return int
     */
    private function _convertToGlobal($string)
    {
        if (strtolower($string) == "high") return HIGH;
        if (strtolower($string) == "low") return LOW;
        return intval($string);
    }

    /**
     * Prints a success message back for JSON (jQuery)
     *
     * @param null $result
     */
    private function _jsonSuccess($result = null)
    {
        $msg = array("state" => "success", "result" => $result);
        header('Content-type: application/json');
        echo json_encode($msg, JSON_FORCE_OBJECT);
    }

    /**
     * Prints out the error message
     *
     * @param $error
     */
    private function _jsonError($error)
    {
        $msg = array("state" => "failed", "error" => $error);
        header('Content-type: application/json');
        echo json_encode($msg, JSON_FORCE_OBJECT);
    }
}
