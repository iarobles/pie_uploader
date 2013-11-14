<?php

include_once "../PieConfiguration.php";
include_once PieConfig::getConfig("USERS_DAO_PATH_NAME") . '/' . PieConfig::getConfig("USERS_DAO_CLASS_NAME") . ".php";

/**
 *
 * @author ismael
 */
class DAOFactory {

    public static function getUserDAO() {

        $className = PieConfig::getConfig("USERS_DAO_CLASS_NAME");
        //echo "class:" . $className . "array:" . print_r(PieConfig::getConfigurations(), true);
        return new $className;
    }

}

?>
