<?php

include_once "../vo/UserVO.php";
include_once "../vo/AllowedPathVO.php";
include_once "../dao/UsersDAO.php";
include_once "../PieConfiguration.php";
include_once "../utils/FileExplorer.php";

/**
 * this DAO search all relevant info of the users using a php file (PieConfiguration.php)
 *
 * IMPORTANT! YOU SHOULD NEVER EVER use the class directly, instead use the DAOFactory
 * @author ismael
 */
class UsersPHPDAO implements UsersDAO {

    //given a login name and a password search the user in the persistence store
    //in this case a php file
    //returns: a UserVO
    public function getUserByLoginNameAndPassword($loginName, $password) {

        //$loginName = "test";
        //$password = "123";
        //echo "searching for user with name:" . $loginName . " and password:" . $password . "<br/>";
        $usersStore = PieConfig::getConfig("PIE_VALID_USERS");
        $theUserFound = null;

        $loginName = ($loginName != null) ? trim($loginName) : null;
        if ($loginName != null && !empty($usersStore) && $usersStore[$loginName] != null) {
            $thePassword = $usersStore[$loginName];

            if ($password == $thePassword) {
                $theUserFound = new UserVO($loginName, $password);
            }
        }

        //echo "user found:" . print_r($theUserFound, true) . "<br/>";
        return $theUserFound;
    }

    /**
     * Given a login name returns an array of the paths that the user can access
     * @param <type> $userLoginName
     * @return An array of AllowedPathVO
     */
    public function getAllowedPathsByLoginName($userLoginName) {
        $allowedPaths = array();
        $allowedPathsVOs = array();

        //echo "getting allowed paths for user:" . $userLoginName;
        if ($userLoginName != null) {
            $allAvailablePaths = PieConfig::getConfig("USER_ALLOWED_PATHS");
            $userAllowedPaths = $allAvailablePaths[$userLoginName];
            if ($userAllowedPaths != null && !empty($userAllowedPaths)) {
                $allowedPaths = $userAllowedPaths;
            }
        }

        //finally we fill the vo
        foreach ($allowedPaths as $allowedPath) {
            $allowedPathVO = new AllowedPathVO($allowedPath);
            array_push($allowedPathsVOs, $allowedPathVO);
        }

        //echo "getting allowed paths for user:" . $userLoginName . " are:" . print_r($allowedPathsVOs,true);

        return $allowedPathsVOs;
    }

    public function isAllowedToExplore($pathToExplore, $userLoginName) {
        $isAllowed = false;

        $allowedPaths = $this->getAllowedPathsByLoginName($userLoginName);

        foreach ($allowedPaths as $allowedPath) {
             //echo "<br/>--------------- is allowed to explore --------------  allowedpath:".$allowedPath->getPath().", pathToExplore:".$pathToExplore." <br/>";
            if (FileExplorer::isABranchOfMainPath($allowedPath->getPath(), $pathToExplore) == true) {
                $isAllowed = true;
                break;
            }
        }

        return $isAllowed;
    }

}

?>
