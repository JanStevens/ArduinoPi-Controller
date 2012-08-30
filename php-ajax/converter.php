<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Fritz
 * Date: 30/08/12
 * Time: 10:38
 * To change this template use File | Settings | File Templates.
 */
//This is an old file but still left here for people who need it,
// I used it to convert my csv file to an valid JSON file.
/*date_default_timezone_set('Europe/Brussels');
$file = fopen("../data/light.csv", "r+w") or exit("Unable to open file");
$i = 0;
while(!feof($file))
{
    $var = fgets($file);
    $data = explode(",", $var);
    $result[$i] = array(strtotime(trim($data[0]))*1000, intval(trim($data[1])));
    $i++;
}
$json_encoded = json_encode($result);

fclose($file);

$new_file = fopen("../data/example.json", "w+");
fwrite($new_file, $json_encoded);

fclose($new_file);
echo "<h1>All done!</h1>";    */

