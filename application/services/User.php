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
     * @param int $userId
     * @return boolean
     */
    public function hasChara($userId){
        return $this->userMapper->hasChara($userId);
    }
    
    /**
     * @param int $userId
     * @return boolean
     */
    public function isAdmin($userId) {
        return $this->userMapper->isAdmin($userId);
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
        $errorArray = array();
        if($request->getPost('rules') !== 'on'){
            $errorArray[] = 'Du musst die Regeln akzeptieren';
        }
        if($request->getPost('password') !== $request->getPost('passwordVerified')){
            $errorArray[] = 'Die Passwörte stimmen nicht überein';
        }
        if($this->checkEmailExists($request->getPost('mail'))){
            $errorArray[] = 'Die eigegebene Email-Adresse ist schon in Verwendung';
        }
        if($this->checkUsernameExists($request->getPost('loginname'))){
            $errorArray[] = 'Der Username ist schon vergeben';
        }
        if($this->checkProfilnameExists($request->getPost('profilname'))){
            $errorArray[] = 'Der Profilname ist schon vergeben';
        }
        if(count($errorArray) > 0){
            return $errorArray;
        }
        $user = new Application_Model_User();
        $user->setUsername($request->getPost('loginname'));
        $user->setProfilname($request->getPost('profilname'));
        $user->setEmail($request->getPost('mail'));
        $user->setPasswort($request->getPost('password'));
        $user->setUsergruppe('User');
        return $this->userMapper->createUser($user, $request->getServer('REMOTE_ADDR'));
    }
    
    
    public function checkUsernameExists($username) {
        return $this->userMapper->usernameExists($username);
    }
    
    
    public function checkProfilnameExists($profilname) {
        return $this->userMapper->profilnameExists($profilname);
    }
    
    public function checkEmailExists($email) {
        return $this->userMapper->emailExists($email);
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
        Zend_Auth::getInstance()->clearIdentity();
    }
    
    /**
     * @return \Application_Model_User
     */
    public function getUsers() {
        $charakterMapper = new Application_Model_Mapper_CharakterMapper();
        $users = $this->userMapper->getUsers();
        foreach ($users as $user) {
            $charakter = $charakterMapper->getCharakterByUserId($user->getId());
            if($charakter !== false){
                $user->setCharakter($charakter);
            }
        }
        return $users;
    }
    
    /**
     * @return \Application_Model_User
     */
    public function getActiveUsers() {
        return $this->userMapper->getActiveUsers();
    }
    
}
