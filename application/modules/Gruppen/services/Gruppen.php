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
        
    }
    
    
    public function editGruppe() {
        
    }
    
    public function joinGruppe() {
        
    }
    
    public function setSl() {
        
    }
    
    public function inviteCharakter() {
        
    }
    
}
