<?php
$active_tab = "home";
include_once("header.php");
?>
<div class="row-fluid">
    <section>
        <div class="page-header"><h1>The ArduinoPi Controller</h1>

            <p>This is an example page of the Arduino Raspberry Pi Light Controller.<br/>
                The setup we use are 3 RGB leds, using the serial connection and the UART of the Raspberry Pi, it is
                possible to control
                the Arduino from a web browser using PHP!</p>

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





