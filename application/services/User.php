<?php

/**
 * Description of User
 *
 * @author Vosser
 */
class Application_Service_User {
    
    /**
     * @var Application_Model_Mapper_UserMapper
     */
    private $userMapper;
    
    
    public function __construct() {
        $this->userMapper = new Application_Model_Mapper_UserMapper();
    }
    
    /**
     * @param int $userid
     * @return boolean
     */
    public function hasChara($userid){
        return $this->userMapper->hasChara($userid);
    }
    
    /**
     * @param int $userid
     * @return Application_Model_User
     */
    public function getCharakter($userid){
        return $this->userMapper->getCharakterByUserId($userid);
    }
    
    /**
     * @param Zend_Controller_Request_Http $request
     * @return boolean
     */
    public function createUser(Zend_Controller_Request_Http $request) {
        if($request->getPost('rules') !== 'on' AND $request->getPost('password') !== $request->getPost('passwordVerified')){
            return false;
        }
        $user = new Application_Model_User();
        $user->setUsername($request->getPost('loginname'));
        $user->setProfilname($request->getPost('profilname'));
        $user->setEmail($request->getPost('mail'));
        $user->setPasswort($request->getPost('password'));
        $user->setUsergruppe('User');
        return $this->userMapper->createUser($user, $request->getServer('REMOTE_ADDR'));
    }
    
    /**
     * @param int $userId
     * @return Application_Model_User
     */
    public function getUserById($userId) {
        return $this->userMapper->getUserById($userId);
    }
    
    
    public function changePassword(Zend_Controller_Request_Http $request, $userId) {
        if($this->userMapper->verifyPassword($userId, $request->getParam('passwordOld')) === false
                ||
            $request->getParam('passwordNew') !== $request->getParam('passwordNewConfirm')
        ) {
            return false;
        }
        return $this->userMapper->changePassword($userId, $request->getParam('passwordNew'));
    }
    
    public function changeEmail(Zend_Controller_Request_Http $request, $userId) {
        $this->userMapper->changeEmail($userId, $request->getParam('mail'));
    }
    
    public function deleteCharakter(Zend_Controller_Request_Http $request, $userId) {
        if($this->userMapper->verifyPassword($userId, $request->getParam('password')) === false
                ||
            $request->getParam('password') !== $request->getParam('passwordConfirm')
        ) {
            return false;
        }
        $charakterMapper = new Application_Model_Mapper_CharakterMapper();
        $charakter = $charakterMapper->getCharakterByUserId($userId);
        if($charakter !== false){
            $charakterMapper->deleteCharakter($charakter);
        }
    }
    
    public function deleteAccount(Zend_Controller_Request_Http $request, $userId) {
        if($this->userMapper->verifyPassword($userId, $request->getParam('password')) === false
                ||
            $request->getParam('password') !== $request->getParam('passwordConfirm')
        ) {
            return false;
        }
        $this->userMapper->deleteUser($userId);
        $charakterMapper = new Application_Model_Mapper_CharakterMapper();
        $charakter = $charakterMapper->getCharakterByUserId($userId);
        if($charakter !== false){
            $charakterMapper->deleteCharakter($charakter);
        }
    }
    
}
