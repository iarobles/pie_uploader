<?php
//we need a better way to emulate a controller because this implementation sucks

require_once('../../lib/recaptcha_1_11/recaptchalib.php');
require_once('../../src/dao/DAOFactory.php');
require_once('../../src/PieConfiguration.php');
require_once('../../src/vo/ViewParamsVO.php');
$captchaEnabled = PieConfig::getConfig("CAPTCHA_ENABLED");
//next tree variables are the only that the view should be aware
$isCaptchaValid = $captchaEnabled ? false : true; //always valid if captcha is not enabled
$isValidUser = false;
$message = null;

$theUserFound = null;
if ($captchaEnabled) {
    $publickey = PieConfig::getConfig("RECAPTCHA_PUBLIC_KEY");
    $privatekey = PieConfig::getConfig("RECAPTCHA_PRIVATE_KEY");
    $resp = recaptcha_check_answer($privatekey,
                    $_SERVER["REMOTE_ADDR"],
                    $_POST["recaptcha_challenge_field"],
                    $_POST["recaptcha_response_field"]);

    if (!$resp->is_valid) {
        // What happens when the CAPTCHA was entered incorrectly
        $message = "Not valid captcha";
    } else {
        $isCaptchaValid = true;
    }
}

//if the captcha is valid we validate that is a valid user
if ($isCaptchaValid) {
    $loginName = $_POST["userName"];
    $password = $_POST["password"];

    //echo "loginName:" . $loginName . " password:" . $password;

    $theUserFound = DAOFactory::getUserDAO()->getUserByLoginNameAndPassword($loginName, $password);

    if ($theUserFound != null) {

        $message = "the user " . $loginName . " is valid";
        $isValidUser = true;

        //finally we put the user in session
        session_start();
        $_SESSION["userName"] = $theUserFound->getLoginName();
    } else {
        $message = "the user " . $loginName . " or his password is not valid";
    }
    
    //$message = "user:" . $loginName . " password:" . $password;
}



//finally we show the view
//the view only should know about $viewParams and its content
$viewParams = new ViewParamsVO();
$viewParams->add("isCaptchaValid", $isCaptchaValid);
$viewParams->add("isValidUser", $isValidUser);
$viewParams->add("message", $message);


include_once "../../src/views/login_result.php";
?>