<?php
/**
 * User: Fritz
 * Date: 28/08/12
 * Time: 14:54
 */
$active_tab = "hover";
include_once("header.php");
?>
<div class="row-fluid">
    <div class="span12">
        <div class="page-header"><h1>Hover example</h1>

            <p>Hover over the different colors to turn the leds on. A simple AJAX call is made to a PHP page that sends
                the right command
                to the Arduino.<br/>Look at the html source, every button has a value property that corresponds with the
                port number on the Arduino.</p></div>
        <div class="row-fluid">
            <div class="span4">
                <h3>Led 1</h3>

                <div class="hover-light">
                    <button class="btn btn-primary btn-large" value="2">Blue</button>
                    <button class="btn btn-success btn-large" value="3">Green</button>
                    <button class="btn btn-danger btn-large" value="4">Red</button>
                </div>
            </div>
            <div class="span4">
                <h3>Led 2</h3>

                <div class="hover-light">
                    <button class="btn btn-primary btn-large" value="5">Blue</button>
                    <button class="btn btn-success btn-large" value="6">Green</button>
                    <button class="btn btn-danger btn-large" value="7">Red</button>
                </div>
            </div>
            <div class="span4">
                <h3>Led 3</h3>

                <div class="hover-light">
                    <button class="btn btn-primary btn-large" value="8">Blue</button>
                    <button class="btn btn-success btn-large" value="9">Green</button>
                    <button class="btn btn-danger btn-large" value="10">Red</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once("footer.php"); ?>
