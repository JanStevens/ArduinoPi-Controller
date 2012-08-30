<?php
/**
 * User: Fritz
 * Date: 30/08/12
 * Time: 9:16
 */
$active_tab = "sensor";
include_once("header.php");
?>
<div class="row-fluid">
    <section>
        <div class="page-header"><h1>Basic Sensor Display</h1>
            <p>An example of reading sensor data, a simple json file gets exported and displayed as a graph. This graph
                is static and uses the flot plugin.</p>
            </div>
        <div class="row-fluid">
            <div class="span11 graph" style=" height:400px;" id="graph-sensor"></div>
        </div>
    </section>
    <section>
        <div class="page-header"><h1>Live sensor reading</h1>
        <p>This example uses a PHP cron job to request for new sensor values every minute. The values then get saved to a json file.<br>
        Again jQuery will read the json file and update it every 60 seconds. Click the following button to delete the log file:</p>
            <button class="btn btn-danger" id="delete-log">Delete the log file</button>
            <button class="btn btn-success" id="request-val">Request value</button>
        </div>
        <div class="row-fluid">
            <div class="span11 graph" style=" height:400px;" id="graph-sensor-live"></div>
        </div>

    </section>
</div>


<?php include_once("footer.php"); ?>