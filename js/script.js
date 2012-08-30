/* Author: Fritz
 This includes all the javascript we need to make it work,
 The plugin.js file are other jQuery plugins used!
 */

(function ($) {
    $(document).ready(function () {
        /*
        Hover Page
        When a user hover a button on the hover page then it should trigger the right response
        We add the port values in the value of the buttons and retrieve them with jQuery.
         */
        $(".hover-light > button").hover(function () {
            var port = $(this).val();
            $.post("php-ajax/cmd.php?mode=hover", {port:port, value:255});
        }, function () {
            var port = $(this).val();
            $.post("php-ajax/cmd.php?mode=hover", {port:port, value:0});
        });

        /*
         Color Picker Page
         When a user clicks on the big box in the color picker page we should request the values.
         The sliders give the values back in RGB so we request the value and then send it
         with an AJAX post to the cmd.php file
         */
        $("#swatch").click(function () {
            var red = $("#red").slider("value");
            var green = $("#green").slider("value");
            var blue = $("#blue").slider("value");
            $.post("php-ajax/cmd.php?mode=picker", {red:red, green:green, blue:blue});

        });

        /*
         Sensor Page
         The first graph is loaded from an JSON file we created, so lets load in the JSON file,
         Note that the data variable holds a string with the right formatting, it should be one big array
         holding smaller arrays with the right value for x and y.
         The time format is in UNIX time and multiplyed with 1000.
         */
        $.getJSON('data/example.json', function (data) {
            $.plot($("#graph-sensor"), [ {label:"Sensor 1", data:data} ], graph_options);
        });

        /*
        This function will update the live graph, we preform a ajax call to the right data source and then update
        the desired graph (placeholder). Note that both graphs use the same options 'graph_options'
         */
        var updateLiveGraph = function () {
            $.ajax({
                type:"GET",
                cache:false,
                async:true,
                url:'data/live-data.json',
                dataType:'json',
                success:function (data) {
                    $.plot($("#graph-sensor-live"), [
                        {label:"Sensor Live", data:data}
                    ], graph_options);

                }
            });
        };

        // Call the function so the user can see the current graph without waiting
        updateLiveGraph();

        // Interval will execute the updateLiveGraph(); function every minute.
        setInterval(function () {
            updateLiveGraph()
        }, 60000);

        // We add an event handler so when a user clicks a button we execute the right ajax call and when the call
        // is executed we call the graph so the new data gets loaded
        $('#delete-log').click(function () {
            $.post("php-ajax/cmd.php?mode=delete-log", function (data) {
                updateLiveGraph();
            });

        });

        // manually request for a sensor reading, since the time interval is one minute this might be a bit overkill.
        $('#request-val').click(function () {
            $.post("php-ajax/cmd.php?mode=request-val", {port:0}, function (data) {
                updateLiveGraph();
            });
        });

        /* END =================================================================================================== END
        WARNING THIS IS THE MORE ADVANCED CODE CHANGE ONLY IF YOU KNOW JQUERY!
         Other code for the color picker
         original code comes from: http://www.emanueleferonato.com/2011/03/22/jquery-color-picker-using-farbtastic-and-jquery-ui/
         */
        if ($('#colorpicker').length != 0) {
            var colorPicker = $.farbtastic("#colorpicker");
            colorPicker.linkTo(pickerUpdate);
            $("#red,#green,#blue").slider({
                orientation:"horizontal",
                range:"min",
                max:255,
                slide:sliderUpdate
            });
            function sliderUpdate() {
                var red = $("#red").slider("value");
                var green = $("#green").slider("value");
                var blue = $("#blue").slider("value");
                var hex = hexFromRGB(red, green, blue);
                colorPicker.setColor("#" + hex);
            }

            function hexFromRGB(r, g, b) {
                var hex = [r.toString(16), g.toString(16), b.toString(16)];
                $.each(hex, function (nr, val) {
                    if (val.length === 1) {
                        hex[nr] = "0" + val;
                    }
                });
                return hex.join("").toUpperCase();
            }

            function pickerUpdate(color) {
                $("#swatch").css("background-color", color);
                if (colorPicker.hsl[2] > 0.5) {
                    $("#innerswatch").css("color", "#000000");
                }
                else {
                    $("#innerswatch").css("color", "#ffffff");
                }
                $("#innerswatch").html(color.toUpperCase())
                var red = parseInt(color.substring(1, 3), 16);
                var green = parseInt(color.substring(3, 5), 16);
                var blue = parseInt(color.substring(5, 7), 16);
                $("#red").slider("value", red);
                $("#green").slider("value", green);
                $("#blue").slider("value", blue);
            }
        }

        /* The options to make the graph cool, read the flot page for more information on the values */
        var graph_options = {
            series:{
                lines:{ show:true},
                points:{ show:true}
            },

            legend:{
                show:true,
                position:"ne"
            },

            xaxis:{
                mode:"time",
                timeformat:"%0d/%0m (%0h:%0m)",
                autoscaleMargin:0.01,
                timezone:"browser"
            },

            yaxis:{
                min:0
            },
            yaxes:[
                {
                    axisLabel:'Sensor Value',
                    axisLabelFontFamily:"Helvetica Neue, Helvetica, Arial, sans-serif",
                    axisLabelPadding:10
                }
            ],

            grid:{
                hoverable:true,
                backgroundColor:{ colors:["#fff", "#eee"] },
                borderWidth:0
            },
            colors:["#049cdb", "#46a546", "#9d261d", "#ffc40d", "#f89406", "#c3325f", "#7a43b6"]
        };

        // Advanced options for the tool tip.
        function showTooltip(x, y, contents) {
            $('<div class="tooltip">' + contents + '</div>').css({
                position:'absolute',
                display:'none',
                top:y + 5,
                left:x + 20
            }).appendTo("body").fadeIn(200);
        }

        var previousPoint = null;
        $("#graph-sensor, #graph-sensor-live").bind("plothover", function (event, pos, item) {
            if (item) {
                if (previousPoint != item.datapoint) {
                    previousPoint = item.datapoint;

                    $(".tooltip").remove();
                    var x = new Date(item.datapoint[0]), y = item.datapoint[1];
                    showTooltip(item.pageX, item.pageY,
                        item.series.label + ": " + y + " @ " + $.format.date(x, "HH:mm"));
                }
            }
            else {
                $(".tooltip").remove();
                clicksYet = false;
                previousPoint = null;
            }
        });
    });
})(jQuery);





