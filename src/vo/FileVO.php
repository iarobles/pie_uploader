<?php
include_once "../utils/FileExplorer.php";
/**
 * This VO is used to hold all important information about a file
 *
 * @author ismael
 */
class FileVO {

    private $fileName = null;
    private $isDir = null;
    private $fileExtension = null;
    private $completePath = null;
    private $htdocsPath = null;

    function __construct($fileName, $isDir, $fileExtension, $completePath, $htdocsPath) {
    
        
        
        $this->fileName = $fileName;
        $this->isDir = $isDir;
        $this->fileExtension = $fileExtension;
        $this->completePath = FileExplorer::formatPath($completePath);
        $this->htdocsPath = FileExplorer::formatPath($htdocsPath);
    }

    public function getHtdocsPath() {
        return $this->htdocsPath;        
    }

    public function setHtdocsPath($htdocsPath) {
        $this->htdocsPath = $htdocsPath;
    }

    public function getCompletePath() {
        return $this->completePath;
    }

    public function setCompletePath($completePath) {
        $this->completePath = $completePath;
    }

    public function getImageFileExtension() {
        $fileExtension = $this->getFileExtension();

        $imageExtensions = PieConfig::getConfig("FILE_EXTENSION_IMAGE");
        $image = $imageExtensions["default"];

        if ($this->getIsDir() == true) {
            $image = $imageExtensions["directory"];
        } else {

            if ($fileExtension != null) {
                $image = $imageExtensions[$fileExtension];
            }
        }

        return $image;
    }

    public function getFileExtension() {
        return $this->fileExtension;
    }

    public function setFileExtension($fileExtension) {
        $this->fileExtension = $fileExtension;
    }

    public function getFileName() {
        return $this->fileName;
    }

    public function setFileName($fileName) {
        $this->fileName = $fileName;
    }

    public function getIsDir() {
        return $this->isDir;
    }

    public function setIsDir($isDir) {
        $this->isDir = $isDir;
    }

}

?>
