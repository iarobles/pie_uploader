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

include_once "../../src/utils/FileExplorer.php";
include_once "../../src/vo/FileVO.php";
include_once "../../src/vo/ViewParamsVO.php";
include_once "../../src/dao/DAOFactory.php";

$REQUEST_ACTION_DELETE = "delete";
$REQUEST_ACTION_EDIT = "edit";
$REQUEST_ACTION_SHOW_EXPLORER = "explorer";
$REQUEST_PATH_TO_EXPLORE = "dir";
?>
<?php

$action = isset($_REQUEST["action"]) ? $_REQUEST["action"] : $REQUEST_ACTION_SHOW_EXPLORER;
$isZip = isset($_REQUEST["isZip"]) ? $_REQUEST["isZip"] : "false";
//echo "will execute action:" . $action;

$viewParams = new ViewParamsVO();

$directory = $_REQUEST[$REQUEST_PATH_TO_EXPLORE];
//echo "---dir to explore:" . $directory."<br/>";
$directory = FileExplorer::getFinalPath($directory);
$viewParams->add("currentExploringPath", FileExplorer::formatPath($directory));
//echo "---dir to explore:" . $directory."<br/>";

if ($action == $REQUEST_ACTION_SHOW_EXPLORER) {

    $isAllowed = DAOFactory::getUserDAO()->isAllowedToExplore($directory, $_SESSION["userName"]);

    if ($isAllowed == true) {

        $filesFound = FileExplorer::listDirContents($directory);

        $viewParams->add("filesFound", $filesFound);
        $viewParams->add("isZipForm", $isZip);

        include_once "../../src/views/file_explorer_view.php";
    }
} else if ($action == $REQUEST_ACTION_DELETE) {
    $fileToDeletePath = $_REQUEST["fileToDeletePath"];
    $fileToDeletePath = FileExplorer::getFinalPath($fileToDeletePath);
    $fileToDeleteBaseDir = dirname($fileToDeletePath);
    //echo "dir to delete:" . $fileToDeleteBaseDir;
    $isAllowed = DAOFactory::getUserDAO()->isAllowedToExplore($fileToDeleteBaseDir, $_SESSION["userName"]);

    if ($isAllowed == true) {
        //echo "file to delete:" . $fileToDeletePath;
        FileExplorer::recursiveDelete($fileToDeletePath);
        $viewParams->add("fileToDeletePath", $fileToDeletePath);
        include_once "../../src/views/file_explorer_delete_view.php";
    }
}
?>

