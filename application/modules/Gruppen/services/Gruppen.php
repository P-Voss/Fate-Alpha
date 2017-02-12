<?php

/**
 * Description of Gruppen
 *
 * @author Voß
 */
class Gruppen_Service_Gruppen {
    
    
    public function getGruppenByCharakterId($charakterId) {
        $mapper = new Gruppen_Model_Mapper_GruppenMapper();
        return $mapper->getGruppenByCharakterId($charakterId);
    }
    
    
    public function getGruppenByUserId($userId) {
        $mapper = new Gruppen_Model_Mapper_GruppenMapper();
        return $mapper->getGruppenByUserId($userId);
    }
    
    
    public function getGruppenByLeaderId($userId) {
        $mapper = new Gruppen_Model_Mapper_GruppenMapper();
        return $mapper->getGruppenByLeaderId($userId);
    }
    
    
    public function getGruppeByGruppenId($gruppenId) {
        $mapper = new Gruppen_Model_Mapper_GruppenMapper();
        $gruppe = $mapper->getGruppeByGruppenId($gruppenId);
        $gruppe->setMitglieder($mapper->getGruppenmitglieder($gruppe->getId()));
        return $gruppe;
    }
    
    
    public function validateAccess($gruppenId, $charakterId, $userId) {
        $mapper = new Gruppen_Model_Mapper_GruppenMapper();
        return $mapper->validateAccess($gruppenId, $charakterId, $userId);
    }
    
    
    public function createGruppe(Zend_Controller_Request_Http $request) {
        if($request->getPost('gruppenname') == ''){
            return false;
        }
        $mapper = new Gruppen_Model_Mapper_GruppenMapper();
        $date = new DateTime();
        $gruppe = new Gruppen_Model_Gruppe();
        $gruppe->setGruender(Zend_Auth::getInstance()->getIdentity()->userId);
        $gruppe->setBeschreibung($request->getPost('beschreibung'));
        $gruppe->setName($request->getPost('gruppenname'));
        $gruppe->setPasswort($request->getPost('passwort'));
        $gruppe->setCreateDate($date->format('Y-m-d'));
        $mapper->createGruppe($gruppe);
    }
    
    
    public function switchDataExposure(Zend_Controller_Request_Http $request, $charakterId) {
        $mapper = new Gruppen_Model_Mapper_GruppenMapper();
        $mapper->setFreigabe($charakterId, $request->getPost('gruppenId'), $request->getPost('exposed'));
    }
    
    
    public function leaveGroup($gruppenId, $charakterId) {
        $mapper = new Gruppen_Model_Mapper_GruppenMapper();
        $mapper->removeCharakterFromGroup($charakterId, $gruppenId);
    }
    
    
    public function addNachricht(Zend_Controller_Request_Http $request, $userId) {
        $mapper = new Gruppen_Model_Mapper_GruppenMapper();
        $userMapper = new Application_Model_Mapper_UserMapper();
        $date = new DateTime();
        $nachricht = new Gruppen_Model_Nachricht();
        $nachricht->setCreateDate($date->format('Y-m-d H:i:s'));
        $nachricht->setNachricht($request->getPost('nachricht'));
        $nachricht->setUserId($userId);
        $nachrichtenId = $mapper->addNachricht($nachricht, $request->getPost('gruppenId'));
        $userMapper->addNotificationForGroup($nachrichtenId);
        return $nachrichtenId;
    }
    
    
    public function getGruppenchat($gruppenId) {
        $userService = new Application_Service_User();
        $charakterService = new Application_Service_Charakter();
        $mapper = new Gruppen_Model_Mapper_GruppenMapper();
        $nachrichten = $mapper->getNachrichtenByGruppenId($gruppenId);
        foreach ($nachrichten as $nachricht) {
            $nachricht->setUser($userService->getUserById($nachricht->getUserId()));
            $charakter = $charakterService->getCharakterByUserid($nachricht->getUserId());
            if($charakter !==  false){
                $nachricht->setCharakter($charakter);
            }
        }
        return $nachrichten;
    }
    
    
    public function editGruppe() {
        
    }
    
    public function joinGruppe(Zend_Controller_Request_Http $request, $charakterId) {
        $mapper = new Gruppen_Model_Mapper_GruppenMapper();
        $gruppe = $mapper->getGruppeByCredentials($request->getPost('gruppenname'), $request->getPost('passwort'));
        if($gruppe !== false){
            $mapper->addCharakterToGroup($charakterId, $gruppe->getId());
        }
    }
    
    public function setSl() {
        
    }
    
    public function dataExposed($gruppenId, $charakterId) {
        $mapper = new Gruppen_Model_Mapper_GruppenMapper();
        return $mapper->checkFreigabe($gruppenId, $charakterId);
    }
    
    
    public function getExposedIds($gruppenId) {
        $mapper = new Gruppen_Model_Mapper_GruppenMapper();
        return $mapper->getFreigaben($gruppenId);
    }
    
    
    public function addToGroup(Zend_Controller_Request_Http $request, $leaderId) {
        if($this->isLeader($leaderId, $request->getPost('gruppenId'))){
            $mapper = new Gruppen_Model_Mapper_GruppenMapper();
            foreach ($request->getPost('charaktere') as $charakterId) {
                $mapper->addCharakterToGroup($charakterId, $request->getPost('gruppenId'));
            }
        }
    }
    
    
    public function removeFromGroup(Zend_Controller_Request_Http $request, $leaderId) {
        if($this->isLeader($leaderId, $request->getPost('gruppenId'))){
            $mapper = new Gruppen_Model_Mapper_GruppenMapper();
            foreach ($request->getPost('charaktere') as $charakterId) {
                $mapper->removeCharakterFromGroup($charakterId, $request->getPost('gruppenId'));
            }
        }
    }
    
    public function isLeader($leaderId, $gruppenId){
        $mapper = new Gruppen_Model_Mapper_GruppenMapper();
        $gruppen = $mapper->getGruppenByUserId($leaderId);
        foreach ($gruppen as $gruppe) {
            if($gruppe->getId() == $gruppenId){
                return true;
            }
        }
        return false;
    }
    
    
    public function getLogsByGruppenId($gruppenId) {
        $mapper = new Gruppen_Model_Mapper_LogMapper();
        return $mapper->getLogsByGruppe($gruppenId);
    }
    
    
    public function removeNotifications($userId, $gruppenId) {
        $mapper = new Application_Model_Mapper_UserMapper();
        $mapper->removeUserNotificationsForGroup($userId, $gruppenId, 1);
    }
    
}
