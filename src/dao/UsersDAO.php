<?php

/**
 * This is the right way of buiding a DAO, you only define methods that will implement
 * all the real instances so in case you want to switch to a different implementation
 * you only need to change a line of a configuration file (PieConfiguaration.php)
 * YOU SHOULD NEVER EVER use the class directly, instead use the DAOFactory
 * @author ismael
 */
interface UsersDAO {

    //given a login name and a password search the user in the persistence store
    //returns: if the user is found a UserVO is returned otherwise null is returned;
    public function getUserByLoginNameAndPassword($loginName, $password);

    /**
     * Given a login name returns an array of the paths that the user can access
     * @param <type> $userLoginName
     * @return An array of AllowedPathVO
     */
    public function getAllowedPathsByLoginName($userLoginName);

    public function isAllowedToExplore($pathToExplore, $userLoginName);
}

?>
