<?php
session_start();
$isLogged = (isset($_SESSION["userName"])) ? true : false;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>Pie Uploader ... uploading is piece of pie!</title>
        <link rel="shortcut icon" href="./webroot/images/Pie.gif"/>


        <link type="text/css" href="./lib/jquery/jquery-ui-1_8/css/start/jquery-ui-1.8.4.custom.css" rel="stylesheet" />
        <script type="text/javascript" src="./lib/jquery/jquery-ui-1_8/js/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="./lib/jquery/jquery-ui-1_8/js/jquery-ui-1.8.4.custom.min.js"></script>


        <link rel="stylesheet" type="text/css" href="./webroot/css/login.css" media="all"/>
        <link rel="stylesheet" type="text/css" href="./webroot/css/main.css" media="all"/>

        <!-- widgets css -->
        <link type="text/css" href="./lib/jquery/widgets/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" />
        <link href="./lib/jquery/css-dock-menu/style.css" rel="stylesheet" type="text/css" />
        <link href="./lib/jquery/widgets/tipTipv13/tipTip.css" rel="stylesheet" type="text/css" />

        <!-- widgets js --->
        <script type="text/javascript" src="./lib/jquery/css-dock-menu/js/jquery.js"></script>
        <script type="text/javascript" src="./lib/jquery/css-dock-menu/js/interface.js"></script>
        <script type="text/javascript" src="./lib/jquery/widgets/combobox.js"></script>
        <script type="text/javascript" src="./lib/jquery/widgets/jquery-form.js"></script>
        <script type="text/javascript" src="./lib/jquery/widgets/flexigrid/flexigrid.pack.js"></script>
        <script type="text/javascritp" src="./lib/jquery/widgets/tipTipv13/jquery.tipTip.minified.js"></script>
        <script type="text/javascritp" src="./lib/jquery/widgets/multiple-file-upload/jquery.MultiFile.pack.js"></script>

        <!--[if lt IE 7]>
         <style type="text/css">
         .dock img { behavior: url(./lib/jquery/css-dock-menu/iepngfix.htc) }
         </style>
        <![endif]-->


        <script type="text/javascript" src="./webroot/login/js/login.js"></script>
    </head>
    <body id="pie_main_body">
        <?php if ($isLogged == true): ?>
        <?php include_once './webroot/desktop/desktop.html'; ?>
        <?php else: ?>
        <?php include_once './webroot/login/login.php'; ?>
        <?php endif; ?>
    </body>
</html>
