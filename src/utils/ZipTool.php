<?php

require_once("pclzip.lib.php");
require_once("../PieConfiguration.php");
require_once("../vo/FileVO.php");

class ZipTool {

    public static function extractZip($zipLocation, $zipDestiny) {

        $unzippedFiles = array();

        //echo "$zipLocation,$zipDestiny";
        if ($zipLocation != null && $zipDestiny != null && strlen(trim($zipLocation)) > 0 && strlen(trim($zipDestiny)) > 0) {

            /*
              if ($zipLocation != "/") {
              $zipLocation = PieConfig::getConfig("APACHE_HOME") . "/" . $zipLocation;
              } else {
              $zipLocation = PieConfig::getConfig("APACHE_HOME") . "/";
              }

              if ($zipDestiny != "/") {
              $zipLocation = PieConfig::getConfig("APACHE_HOME") . "/" . $zipLocation;
              } else {
              $zipDestiny = PieConfig::getConfig("APACHE_HOME") . "/";
              } */

            $archive = new PclZip($zipLocation);
            $unzippedFilesArray = $archive->extract(PCLZIP_OPT_PATH, $zipDestiny);

            foreach ($unzippedFilesArray as $unzipedFileArray) {
                $fileUnzipped = new FileVO($unzipedFileArray["stored_filename"], null, null, $unzipedFileArray["filename"], null);
                array_push($unzippedFiles, $fileUnzipped);
            }
        }

        //print_r($unzippedFiles);

        return $unzippedFiles;
    }

}

?>
