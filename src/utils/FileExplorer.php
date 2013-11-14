<?php

include_once("../vo/FileVO.php");
include_once("../PieConfiguration.php");
/*
 * @author ismael
 */

class FileExplorer {

    public static function listDirContents($htdocsFilePath) {
        $dirContents;

        $dirContents = array();

        if ($htdocsFilePath != null && strlen(trim($htdocsFilePath)) > 0) {

            $directory = self::getFinalPath($htdocsFilePath);
//echo "will list all contents for path:" . $directory;

            $filesNames = scandir($directory);
//echo "raw file names:" . print_r($filesNames, true);

            foreach ($filesNames as $fileName) {
                $isADir = is_dir($directory . "/" . $fileName);

                if ($fileName != ".") {

//echo "fileName:" . $fileName . " es un directorio:" . $isADir . "  <br/>";
                    $pathInfo = pathinfo($fileName);
                    $fileExtension = $pathInfo["extension"];
                    $fileNameAsVO = new FileVO($fileName, $isADir, $fileExtension, $directory . "/" . $fileName, $htdocsFilePath . "/" . $fileName);
                    array_push($dirContents, $fileNameAsVO);
                }
            }

//echo "contents for dir." . $directory . " are:" . print_r($dirContents);
        }

        return $dirContents;
    }

    //no es mia esta funcion
    public static function sureRemoveDir($dir, $DeleteMe) {
        if (!$dh = @opendir($dir))
            return;
        while (($obj = readdir($dh))) {
            if ($obj == '.' || $obj == '..')
                continue;
            if (!@unlink($dir . '/' . $obj))
                SureRemoveDir($dir . '/' . $obj, true);
        }
        if ($DeleteMe) {
            closedir($dh);
            @rmdir($dir);
        }
    }

    public static function recursiveDelete($str) {
    
       $str = self::getFinalPath($str);
       self::recursiveDeleteImplementation($str);
    }
    
    //another stupid patch to fix guindous paths
    public static function recursiveDeleteImplementation($str){

        if (is_file($str)) {
            //echo "file: " . $str . "</br>";
            return @unlink($str);
        } elseif (is_dir($str)) {
            //echo "dir: " . $str . "</br>";
            // --------- WE NEED TO FIND A BETTER WAY TO ACHIVE THIS TASK

            /*
              $scan = glob(rtrim($str, '/') . '/*');

              foreach ($scan as $index => $path) {
              self::recursiveDelete($path);
              }
              return @rmdir($str);
             *
             */
        }    
    }

    /**
     * Recibe una ruta y encuentra su ruta final
     * @param <type> $pathToProcess
     * @return <type>
     */
    public static function getFinalPath($pathToProcess) {


        //echo "<br/>----------------------------------------------<br/>";
        //echo "will get final path of:" . $pathToProcess . "</br>";
        
        $pathToProcess = self::formatPath($pathToProcess);

        $finalPath = "";
        $pathToProcess = self::addApacheHome($pathToProcess);
        if ($pathToProcess != "null") {
            $currentPath = $pathToProcess;

            $loop = 0;
            $winRoot1 = PieConfig::getConfig("WIN_ROOT1");
            $winRoot2 = PieConfig::getConfig("WIN_ROOT2");
            $winRoot3 = PieConfig::getConfig("WIN_ROOT3");
            while ($currentPath != "" && $currentPath != "/" && $currentPath != "\\" && $loop < 20	 && $currentPaht != $winRoot1 && $currentPath != $winRoot2) {
                //echo "currentPath:" . $currentPath . "</br>";

                $theBaseName = basename($currentPath);
                $currentPath = dirname($currentPath);
                //echo "<br/> ------basename:" . $theBaseName . " the currentpath:" . $currentPath . "</br>";
                //if ($theBaseName == "/" || $theBaseName == "\\" || $theBaseName == $winRoot1 || $theBaseName == $winRoot2) {
                //  echo "nothing to do";
                //} else
                if ($theBaseName == "..") {
                    $provDir = dirname($currentPath);
                    if (basename($provDir) != "..") {
                        $currentPath = $provDir;
                    }
                } else {
                    //echo "the current path:".$currentPath."  winroot1:".$winRoot1." the win root 2:".$winRoot2." wint root3:".$winRoot3." <br/>";                
                    
                    if ($currentPath == "/" || $currentPath == "\\" ) {
                        //echo "caso 1";
                        if ($finalPath == "") {
                            $finalPath = "/" . $theBaseName;
                        } else {
                            $finalPath = "/" . $theBaseName . "/" . $finalPath;
                        }                    
                    } else if($currentPath == $winRoot1 || $currentPath == $winRoot2 || $currentPath == $winRoot3 ){
                           //echo "caso 2";
                           $finalPath = $winRoot1 .$theBaseName."/".$finalPath;                  
                                        
                    } else if ($theBaseName != ".") {
                        //echo "caso 3 current path:".$currentPath;
                        if ($finalPath == "") {
                            $finalPath = $theBaseName;
                        } else {
                            $finalPath = $theBaseName . "/" . $finalPath;
                        }
                    }
                }
                $loop = $loop + 1;
                //echo "final path:" . $finalPath . "</br>";
                //another ugly patch
                if ($loop > 20) {
                    break;
                }
            }//end while

            if ($pathToProcess == "/" || $pathToProcess == "\\") {
                $finalPath = $pathToProcess;
            }


            //echo "final path:" . $finalPath;
            //ahora que tenemos el final path agregamos el home de apache si es que aplica
            //$finalPath = self::addApacheHome($finalPath);
            //si el ultimo es / lo quitamos por cualquier cosa
            if (strlen($finalPath) > 1 && substr($finalPath, strlen($finalPath) - 1, 1) == "/") {
                $finalPath = substr($finalPath, 0, strlen($finalPath) - 1);
            }

            $isGuindous = PieConfig::getConfig("IS_GUINDOUS");

            //we need to replace all the / for \
            if ($isGuindous == true) {
                $finalPath = str_replace("/", "\\", $finalPath);
            }
        }

        //echo "<br/>final path:".$finalPath;
        //echo "<br/>---------------------END -------------------------<br/>";

        return $finalPath;
    }
    
    public static function formatPath($pathToFormat){
              
              // i hate guindous paths!!
                 $pathToFormat = str_replace("\\", "/", $pathToFormat);
                 $pathToFormat = trim($pathToFormat);
                 
                 return $pathToFormat;
    }

    public static function addApacheHome($finalPath) {
        
        //maldito parche para windows
        $isGuindous = PieConfig::getConfig("IS_GUINDOUS");
        $apacheHome = PieConfig::getConfig("APACHE_HOME");
        $finalPath = self::formatPath($finalPath);
        $apacheHome = self::formatPath($apacheHome);
        /*
        if($isGuindous == true){
            $apacheHome = str_replace("/", "\\", $apacheHome);
        }*/
        
        if ($apacheHome == "/") {//ambiente unix restringido cuyo home es el mismo htdocs
            //no contiene el apache home por lo que se lo agregamos
            if (substr($finalPath, 0, 1) != "/") {
                $finalPath = "/" . $finalPath;
            }
        } else {
            //no contiene el apache home por lo que se lo agregamos
            //echo "<br />final:$finalPath  apachehome:$apacheHome" . " strpos:" . strpos($finalPath, $apacheHome);
            $posi = strpos($finalPath, $apacheHome);
            //estupido php y su lenguaje no tipeado!!

            if ($posi === false) {
                //si se tiene un / al principio
                if (substr($finalPath, 0, 1) == "/") {
                    $finalPath = $apacheHome . $finalPath;
                } else {
                    $finalPath = $apacheHome . "/" . $finalPath;
                }
            }
        }
        
        //echo "final path:".$finalPath;

        return $finalPath;
    }

    /**
     * You should always run getFinalPath method on the pathToExamine before to invoke this one
     * @param <type> $mainPath
     * @param <type> $pathToExamine
     * @return boolean
     */
    public static function isABranchOfMainPath($mainPath, $pathToCheck) {
        $isBranch = false;

        $mainPath = self::formatPath($mainPath);
        $pathToCheck = self::formatPath($pathToCheck);
        
        if ($mainPath != null && $pathToCheck != null) {
            //echo " mainPath(before):" . $mainPath . " pathTocheck:" . $pathToCheck . "</br>";
            $mainPath = self::getFinalPath($mainPath);
            $pathToCheck = self::getFinalPath($pathToCheck);
            //echo " mainPath(after):" . $mainPath . " pathTocheck:" . $pathToCheck . "</br>";
            if ($mainPath == "/" || $mainPath == "\\") {
                $isBranch = true;
            } else {

                //nasty path to avoid infinite loops
                $loopCounter = 0;
                while ($pathToCheck != "/" && $pathToCheck != "\\") {
                    //echo "mainPath:" . $mainPath . " pathToCheck:" . $pathToCheck . "</br>";
                    if ($mainPath == $pathToCheck) {
                        //echo "mainPath:" . $mainPath . " pathToCheck:" . $pathToCheck;
                        $isBranch = true;
                        break;
                    }
                    $pathToCheck = dirname($pathToCheck);
                    $loopCounter++;

                    //nasty path to avoid infinite loops
                    if ($loopCounter > 20) {
                        break;
                    }
                }
            }
        }

        return $isBranch;
    }

}

/* TESTS (not very fashions test, but very practical anyway)
 * ------------ getFinalPath test-----------------------------
 */
/*
  echo "<br/>INPUT:\"\"   RESULTADO:" . FileExplorer::getFinalPath("") . " se esperaba:APACHE_HOME";
  echo "<br/>INPUT:/   RESULTADO:" . FileExplorer::getFinalPath("/") . " se esperaba:APACHE_HOME";
  echo "<br/>INPUT:test   RESULTADO:" . FileExplorer::getFinalPath("test") . " se esperaba:APACHE_HOME/test";
  echo "<br/>INPUT:/test   RESULTADO:" . FileExplorer::getFinalPath("/test") . " se esperaba:APACHE_HOME/test";
  echo "<br/>INPUT:../test   RESULTADO:" . FileExplorer::getFinalPath("../test") . " se esperaba:/var/test";
  echo "<br/>INPUT:/test/..   RESULTADO:" . FileExplorer::getFinalPath("/test/..") . " se esperaba:APACHE_HOME";
 */
 //echo "<br/>INPUT:/test/..   RESULTADO:" . FileExplorer::getFinalPath(" C:/apps/xampp/htdocs/test") . " se esperaba:APACHE_HOME";
 
?>
