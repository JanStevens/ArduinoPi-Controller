<?php
$active_tab = "home";
include_once("header.php");
?>
<div class="row-fluid">
    <section>
        <div class="page-header"><h1>The ArduinoPi 1.0</h1>

            <p>The ArduinoPi 1.0 is a PHP class with API support that allows for easy controll using PHP and
                jQuery.<br/>
                You can use a simple post or get request to switch ports on the Arduino. The basic page contains
                all the basic information.<br/>Hover, Color Picker and Sensor are examples used with the basic commands.
            </p>

            <p>
                <button class="btn btn-primary" href="http://fritz-hut.com">Visit my blog to learn more</button>
            </p>
        </div>
    </section>
    <section>
        <div class="span12">
            <div class="row-fluid">
                <ul class="polaroids">
                    <li><a href="hover.php" title="Hover Example"><img src="img/hover_img.PNG" alt="Hover Example"></a>
                    </li>
                    <li><a href="picker.php" title="Color Picker"><img src="img/picker_img.PNG" alt="Color Picker"></a>
                    </li>
                    <li><a href="sensor.php" title="Sensor Example"><img src="img/sensor_img.PNG" alt="Sensor Example"></a>
                    </li>
                    <li><a href="sensor.php" title="Live Sensor Example"><img src="img/sensor-live_img.PNG"
                                                                              alt="Live Sensor Example"></a></li>
                </ul>
            </div>
        </div>
    </section>
</div>
<?php
include_once("footer.php");
?>





