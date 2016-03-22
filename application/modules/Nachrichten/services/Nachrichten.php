<?php

/**
 * Description of Nachrichten
 *
 * @author Voß
 */
class Nachrichten_Service_Nachrichten {
    
    /**
     * @var Application_Model_Mapper_UserMapper 
     */
    private $userMapper;
    /**
     * @var Nachrichten_Model_Mapper_NachrichtenMapper 
     */
    private $mapper;
    
    
    public function __construct() {
        $this->userMapper = new Application_Model_Mapper_UserMapper();
        $this->mapper = new Nachrichten_Model_Mapper_NachrichtenMapper();
    }
    
    /**
     * @param int $userId
     * @return \Nachrichten_Model_Nachricht
     */
    public function getNachrichtenReceivedByUserId($userId) {
        $userMapper = new Application_Model_Mapper_UserMapper();
        $nachrichten = $this->mapper->getNachrichtenByReceiverId($userId);
        foreach ($nachrichten as $nachricht) {
            $nachricht->setVerfasser($userMapper->getUserById($nachricht->getVerfasserId()));
            $nachricht->setEmpfaenger($userMapper->getUserById($nachricht->getEmpfaengerId()));
        }
        return $nachrichten;
    }
    
    /**
     * @param int $userId
     * @return \Nachrichten_Model_Nachricht
     */
    public function getNachrichtenSentByUserId($userId) {
        $nachrichten = $this->mapper->getNachrichtenByDispatcherId($userId);
        foreach ($nachrichten as $nachricht) {
            $nachricht->setVerfasser($this->userMapper->getUserById($nachricht->getVerfasserId()));
            $nachricht->setEmpfaenger($this->userMapper->getUserById($nachricht->getEmpfaengerId()));
        }
        return $nachrichten;
    }
    
    
    public function getNachrichtenArchivByUserId($userId) {
        $nachrichten = $this->mapper->getNachrichtenarchivById($userId);
        foreach ($nachrichten as $nachricht) {
            $nachricht->setVerfasser($this->userMapper->getUserById($nachricht->getVerfasserId()));
            $nachricht->setEmpfaenger($this->userMapper->getUserById($nachricht->getEmpfaengerId()));
        }
        return $nachrichten;
    }
    
    /**
     * @param int $nachrichtId
     * @return Nachrichten_Model_Nachricht
     */
    public function getNachrichtById($nachrichtId) {
        $nachricht = $this->mapper->getNachrichtById($nachrichtId);
        $nachricht->setVerfasser($this->userMapper->getUserById($nachricht->getVerfasserId()));
        $nachricht->setEmpfaenger($this->userMapper->getUserById($nachricht->getEmpfaengerId()));
        return $nachricht;
    }
    
    /**
     * @param Zend_Controller_Request_Http $request
     */
    public function saveMessage(Zend_Controller_Request_Http $request) {
        $nachricht = new Nachrichten_Model_Nachricht();
        $nachricht->setNachricht($request->getPost('nachricht'));
        $nachricht->setVerfasserId(Zend_Auth::getInstance()->getIdentity()->userId);
        $nachricht->setEmpfaengerId($request->getPost('user'));
        $nachricht->setBetreff($request->getPost('betreff'));
        if($request->getPost('admin') !== null){
            $nachricht->setAdmin(true);
        }  else {
            $nachricht->setAdmin(false);
        }
        $this->mapper->saveMessage($nachricht);
    }
    
    /**
     * @param Zend_Controller_Request_Http $request
     */
    public function deleteMessage(Zend_Controller_Request_Http $request) {
        $nachricht = $this->mapper->getNachrichtById($request->getParam('id'));
        if($nachricht->getEmpfaengerId() === Zend_Auth::getInstance()->getIdentity()->userId){
            $this->mapper->deleteMessage($nachricht);
        }
    }
    
    /**
     * @param int $nachrichtId
     */
    public function readMessage($nachrichtId) {
        return $this->mapper->setRead($nachrichtId);
    }
    
}
