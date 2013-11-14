<?php
include_once "view_utils.php";
//header('Content-Type: application/x-json');
?>
{
"message":"<?php echo $message; ?>",
"isValidCaptcha":<?php echo ($isCaptchaValid == true) ? "true" : "false"; ?>,
"isValidUser":<?php echo ($isValidUser == true) ? "true" : "false"; ?>
}

