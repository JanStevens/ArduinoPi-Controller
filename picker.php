<?php
/**
 * User: Fritz
 * Date: 28/08/12
 * Time: 16:29
 */
$active_tab = "picker";
include_once("header.php")
?>
<div class="row-fluid">
    <div class="span12">
        <div class="page-header"><h1>Color Picker</h1>

            <p>Select a color using the color picker below. You can use the advanced Farbtastic color picker or the
                sliders.<br/>
                After selecting the color, click on the big box displaying your color to update it to the LEDs.</p>
        </div>
        <div class="row-fluid">
            <div id = "sliders">
                <div id="colorpicker"></div>
                <div id="swatch" class="ui-widget-content ui-corner-all">
                    <div id="innerswatch">#000000</div>
                </div>
                <div style = "clear:both"></div>
                <div id="red"></div>
                <div id="green"></div>
                <div id="blue"></div>
            </div>
        </div>
    </div>
</div>
<?php include_once("footer.php"); ?>