<?php
include_once "../utils/FileExplorer.php";

class AllowedPathVO {

    private $path;

    function __construct($path) {
    
        $this->path = FileExplorer::formatPath($path);
    }

    public function getPath() {
        return $this->path;
    }

    public function setPath($path) {
        $this->path = $path;
    }

}

?>
