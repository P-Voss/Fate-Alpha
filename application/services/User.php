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
        return $mapper->getCharakterByUserId($userid);
    }
    
    public function createUser(Zend_Controller_Request_Http $request) {
        $mapper = new Application_Model_Mapper_UserMapper();
        if($request->getPost('rules') !== 'on' AND $request->getPost('password') !== $request->getPost('passwordVerified')){
            return false;
        }
        $user = new Application_Model_User();
        $user->setUsername($request->getPost('loginname'));
        $user->setProfilname($request->getPost('profilname'));
        $user->setEmail($request->getPost('mail'));
        $user->setPasswort($request->getPost('password'));
        $user->setUsergruppe('User');
        return $mapper->createUser($user, $request->getServer('REMOTE_ADDR'));
    }
    
}
