<?php

session_start();
session_destroy();

//will work this line for internet explorer?
header("Location:../../index.php");
?>
