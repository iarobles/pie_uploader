<?php

session_start();
$isLogged = (isset($_SESSION["userName"])) ? true : false;
if ($isLogged == false) {
    header("Location:../../redirect.php");
    exit;
}
?>
<?php

require_once('../../src/dao/DAOFactory.php');
require_once('../../src/PieConfiguration.php');
require_once('../../src/vo/AllowedPathVO.php');
require_once('../../src/vo/ViewParamsVO.php');
?>
<?php

//we need a better way to emulate a controller because this implementation sucks
session_start();
$isZip = isset($_REQUEST["isZip"]) ? $_REQUEST["isZip"] : "false";
$userLoginName = $_SESSION["userName"];
$allowedPaths = DAOFactory::getUserDAO()->getAllowedPathsByLoginName($userLoginName);

$viewParams = new ViewParamsVO();
$viewParams->add("allowedPaths", $allowedPaths);
$viewParams->add("isZip", $isZip);

include_once "../../src/views/file_admin_view.php";
?>