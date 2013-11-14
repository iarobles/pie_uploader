<?php

session_start();
$isLogged = (isset($_SESSION["userName"])) ? true : false;
if ($isLogged == false) {
    header("Location:../../redirect.php");
    exit;
}
?>
<?php

session_start();

include_once "../../src/PieConfiguration.php";
include_once "../../src/vo/ViewParamsVO.php";
include_once "../../src/vo/FileVO.php";
include_once "../../src/utils/ZipTool.php";
include_once "../../src/dao/DAOFactory.php";
include_once "../dao/UsersDAO.php";

$isZip = isset($_REQUEST["isZip"]) ? $_REQUEST["isZip"] : "false";
//echo "isZip:" . $isZip;
$viewParams = new ViewParamsVO();

$exploredPath = $_REQUEST["exploredPath"];
//echo "exploredPath:" . $exploredPath;
//we ensure that the user is allowed to upload on the dir
$isAllowed = DAOFactory::getUserDAO()->isAllowedToExplore($exploredPath, $_SESSION["userName"]);
if ($isAllowed == true) {

    $filesToUpload = sizeof($_FILES["uploads"]["name"]);
//echo "will upload:" . $filesToUpload;

    $filesNotUploaded = array();
    $filesUploaded = array();

    for ($i = 0; $i < $filesToUpload; $i++) {
        $fileName = $_FILES["uploads"]["name"][$i];
        $fileDelimiter = ($exploredPath == "/") ? "" : "/";
        $baseDir = FileExplorer::getFinalPath($exploredPath);
        $destinyPath = FileExplorer::getFinalPath($baseDir . $fileDelimiter . $fileName);
        //echo "destinyPath:" . $destinyPath . "</br>";
        $uploaded = copy($_FILES["uploads"]["tmp_name"][$i], $destinyPath);
        if ($uploaded == false) {

            array_push($filesNotUploaded, $fileName);
        } else {

            array_push($filesUploaded, $fileName);
            if ($isZip == "true") {
                $zipLocation = $destinyPath;
                $zipDestiny = $baseDir;
                //echo "zip location:" . $zipLocation . " zip destiny:" . $zipDestiny . "</br>";
                $unzippedFiles = ZipTool::extractZip($zipLocation, $zipDestiny);

                foreach ($unzippedFiles as $unzippedFile) {
                    array_push($filesUploaded, $unzippedFile->getFileName());
                }
            }
        }
    }

    $totalNotUploaded = sizeof($filesNotUploaded);
    $totalUploaded = $filesToUpload - $totalNotUploaded;
    $viewParams->add("filesNotUploaded", $filesNotUploaded);
    $viewParams->add("filesUploaded", $filesUploaded);
    $viewParams->add("totalUploaded", $totalUploaded);
    $viewParams->add("totalNotUploaded", $totalNotUploaded);
    $viewParams->add("exploredPath", $exploredPath);
    $viewParams->add("isZip", $isZip);

    include_once "../../src/views/file_uploader_view.php";
}
?>
