<?php

/**
 *
 * @author ismael
 */
class ViewParamsVO {

    private $params = array();

    public function add($paramName, $paramValue) {
        $this->params[$paramName] = $paramValue;
    }

    public function get($paramName) {
        return $this->params[$paramName];
    }

    public function getParams() {
        return $this->params;
    }

}

?>
