<?php

/*
 * Description of UserVO
 *
 * @author ismael
 */

class UserVO {

    private $loginName;
    private $password;

    function __construct($loginName, $password) {
        $this->loginName = $loginName;
        $this->password = $password;
    }

    public function getLoginName() {
        return $this->loginName;
    }

    public function setLoginName($loginName) {
        $this->loginName = $loginName;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

}

?>
