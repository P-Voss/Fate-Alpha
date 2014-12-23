<?php

/**
 * Description of User
 *
 * @author Vosser
 */
class Application_Service_User {
    
    public function hasChara($userid){
        $mapper = new Application_Model_Mapper_UserMapper();
        return $mapper->hasChara($userid);
    }
    
    public function getCharakter($userid){
        $mapper = new Application_Model_Mapper_CharakterMapper();
        return $mapper->getCharakterById($userid);
    }
    
}
