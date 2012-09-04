<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Fritz
 * Date: 3/09/12
 * Time: 11:50
 * To change this template use File | Settings | File Templates.
 */
$active_tab = "basic";
include_once("header.php");
?>
<script type="text/javascript">
    (function ($) {
        $(document).ready(function () {
            $("#pwm-button").click(function () {
                $.get("/api/pwm/2/255");
            });

            $("#digital-button").click(function () {
                $.post("/api/", {mode:"digital", data:[2, "low"]});
            });

            $("#analog-button").click(function () {
                $.get("/api/analog/0", function (data) {
                    $("#analog-value").html(data.result);
                });
            });

            $("#multiple-pwm-button").click(function () {
                $.post("/api/", {mode:"multiple-pwm", data:[2, 255, 3, 125, 4, 255]});
            });

            $("#multiple-digital-button").click(function () {
                $.get("/api/multiple-digital/2/high/3/low/4/high");
            });

            $("#multiple-analog-button").click(function () {
                $.post("/api/", {mode:"multiple-analog", data:["A0", "A1"]}, function (data) {
                    $("#analog-multiple-value").html(data.result[0] + " - " + data.result[1]);
                });
            });

            $('#analog-file-button').click(function () {
                $.post("/api/", {mode:"analog-file", data:[0, "live-data"]});
            });

            $('#delete-file-button').click(function () {
                $.post("/api/", {mode:"delete-file", data:["live-data"]});
            });
        });
    })(jQuery);
</script>
<div class="row-fluid">
    <div class="span12">
        <div class="page-header"><h1>Basic examples</h1>

            <p>Calling commands using the ArduinoPi 1.0 is changed a lot so I will cover the eight default commands.
                Every command can be called using ether GET or POST. I use jQuery to dynamically call the ArduinoPi API
                when a
                user clicks a button. For more information visit: <a
                    href="http://fritz-hut.com">http://fritz-hut.com</a></p></div>
        <div class="row-fluid">
            <div class="span9">
                <section id="pwm">
                    <h2>1. PWM</h2>

                    <p>The PWM option of the API will check for the right port and checks if the values are between
                        0-255. The code demonstrates the ArduinoPi 1.0 API request using an AJAX GET request when a user
                        presses a button.</p>
               <pre class="prettyprint linenums">$("#pwm-button").click(function () {
    $.get("/api/pwm/2/255");
});</pre>
                    <p>It's also possible to use a POST request. The "high" and "low" keywords can also be used in
                        jQuery. Both commands are equal, don't mix a GET and POST request this will result in unexpected
                        behavior.</p>
                    <pre class="prettyprint linenums">$("#pwm-button").click(function () {
    $.post("/api/", {mode: "pwm", data:[2, "high"]});
});</pre>
                    <h3>Example</h3>

                    <p>The button will switch port 2 with a pwm value of 255.</p>
                    <button id="pwm-button" class="btn btn-primary">PWM port 2</button>

                </section>
                <hr>
                <section id="digital">
                    <h2>2. Digital</h2>

                    <p>The analog and PWM ports can be used as digital outputs. The ArduinoPi 1.0 only accepts the
                        following values: <strong>high, low, 0 or 255</strong>. Any other value will throw an exception.
                        The code below
                        will switch port 2 low using an AJAX POST request when clicking on the button.
                    </p>
                <pre class="prettyprint linenums">$("#digital-button").click(function () {
    $.post("/api/", {mode: "digital", data: [2, "low"]});
});</pre>
                    <h3>Example</h3>

                    <p>the button will switch port 2 with a digital value of "low".</p>
                    <button id="digital-button" class="btn btn-primary">Digital port 2</button>


                </section>
                <hr>
                <section id="analog">
                    <h2>3. Analog</h2>

                    <p>The analog function is only used for <strong>reading an anlog port</strong>. To write an analog
                        port use the digital option of the ArduinoPi 1.0 API. The code below will read port A0 using an
                        AJAX GET, the result is displayed next to the button. Notice that it's allowed to use A0 for
                        selecting an Analog port.
                    </p>
                    <pre class="prettyprint linenums">$("#analog-button").click(function() {
    $.get("/api/analog/A0", function(data) {
        $("#analog-value").html(data);
    });
});</pre>
                    <h3>Example</h3>

                    <p>The button will ask the value of analog port 0: <span id="analog-value"></span></p>
                    <button id="analog-button" class="btn btn-primary">Read A0</button>
                </section>
                <hr>
                <section id="multiple-pwm">
                    <h2>4. Multiple PWM</h2>

                    <p>The multiple PWM allows a user to switch multiple ports at once using PWM. The ports and values
                        can be written consecutively, creating a long API request. Note that any invalid port/value will
                        be omitted from the request, no error will be reported. A simple POST example.</p>
                    <pre class="prettyprint linenums">$("#multiple-pwm-button").click(function () {
    $.post("/api/", {mode:"multiple-pwm", data:[2, 255, 3, 125, 4, 255]});
});</pre>
                    <h3>Example</h3>

                    <p>The button will switch port 2, 3 and 4 with their corresponding values.</p>
                    <button id="multiple-pwm-button" class="btn btn-primary">PWM 2,3,4</button>

                </section>
                <hr>
                <section id="multiple-digital">
                    <h2>5. Multiple Digital</h2>

                    <p>Multiple digital works the same way as multiple PWM. The digital ports only accept a value of 0,
                        255, "low" or "high". If a port is switched with another value it will be omitted from the API
                        request. A simple GET example:</p>
                    <pre class="prettyprint linenums">$("#multiple-digital-button").click(function () {
    $.get("/api/multiple-digital/2/high/3/low/4/high");
});</pre>
                    <h3>Example</h3>

                    <p>The button will switch port 2, 3, 4 high or low.</p>
                    <button id="multiple-digital-button" class="btn btn-primary">Digital 2,3,4</button>

                </section>
                <hr>
                <section id="multiple-analog">
                    <h2>6. Multiple Analog</h2>

                    <p>Multiple Analog will read the different analog ports specified and returns the value as an array.
                        Again its possible to use A0 and A15. Note that the Arduino makes up a value if nothing is
                        attached to the port itself.</p>
                    <pre class="prettyprint linenums">$("#multiple-analog-button").click(function() {
    $.post("/api/", {mode:"multiple-analog", data:["A0", "A1"]}, function (data) {
        $("#analog-multiple-value").html(data.result[0]+" - "+data.result[1]);
    });
});</pre>

                    <h3>Example</h3>

                    <p>The button will read analog port A0 and A1: <span id="analog-multiple-value"></span></p>
                    <button id="multiple-analog-button" class="btn btn-primary">A0 and A1</button>
                </section>
                <hr>
                <section id="analog-file">
                    <h2>7. Analog File</h2>

                    <p>The API command will do exactly the same as Analog, but it writes the result back to a specified
                        JSON file. The first parameter is the analog port, the second, the JSON file in the <strong>data
                            folder</strong>.
                        Note that this file must be created and readable/writable. The extension .json is not allowed in
                        the API call.</p>
                    <pre class="prettyprint linenums">$('#analog-file-button').click(function () {
    $.post("/api/", {mode: "analog-file", data:[0, "live-data"]});
});</pre>
                    <h3>Example</h3>

                    <p>The button will read an analog port and save it to the file live-data.json</p>
                    <button id="analog-file-button" class="btn btn-primary">A0 => live-data</button>
                </section>
                <hr>
                <section id="delete-file">
                    <h2>8. Delete File</h2>

                    <p>The API command will just open the file and clear everything in it. This is useful for starting a
                        new session of data logging on the Arduino. An ArduinoPi 1.0 POST example:</p>
                    <pre class="prettyprint linenums">$('#delete-file-button').click(function () {
    $.post("/api/", {mode:"delete-file", data:["live-data"]});
});</pre>
                    <h3>Example</h3>

                    <p>The button will empty the file live-data</p>
                    <button id="delete-file-button" class="btn btn-primary">Empty live-data</button>
                </section>
            </div>

        </div>
    </div>
</div>

<?php include_once("footer.php"); ?>