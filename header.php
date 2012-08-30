<!doctype html>
<html lang="en">
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title></title>
    <meta name="description" content="">
    <meta name="author" content="">

    <meta name="viewport" content="width=device-width">
    <style type="text/css">
            /* Bootstrap fixes  */
        body {
            padding:60px 0;
        }
    </style>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-responsive.min.css">
    <link rel="stylesheet" href="css/farbtastic.css" type="text/css" />
    <link rel="stylesheet" href="css/jquery-ui-1.8.23.custom.css" type="text/css" />
    <link rel="stylesheet" href="css/style.css">

    <script src="js/libs/modernizr-2.5.3-respond-1.1.0.min.js"></script>

</head>
<body>
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="index.php">PHP - ArduinoPi Controller</a>

            <div class="nav-collapse">
                <ul class="nav">
                    <li <?php if($active_tab == "home") echo "class='active'"; ?>><a href="index.php">Home</a></li>
                    <li <?php if($active_tab == "hover") echo "class='active'"; ?>><a href="hover.php">Hover</a></li>
                    <li <?php if($active_tab == "picker") echo "class='active'"; ?>><a href="picker.php">Color Picker</a></li>
                    <li <?php if($active_tab == "sensor") echo "class='active'"; ?>><a href="sensor.php">Sensor</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="container">