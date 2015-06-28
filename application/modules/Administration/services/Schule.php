<?php

/**
 * Description of Schule
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_Service_Schule {
    
    /**
     * @var Administration_Model_Mapper_SchuleMapper
     */
    private $mapper;
    /**
     * @var Administration_Model_Mapper_ErstellungMapper
     */
    private $erstellungMapper;
    
    public function __construct() {
        $this->mapper = new Administration_Model_Mapper_SchuleMapper();
        $this->erstellungMapper = new Administration_Model_Mapper_ErstellungMapper();
    }
    
    public function getSchulList() {
        return $this->mapper->getAllSchools();
    }
    
    public function createSchule(Zend_Controller_Request_Http $request, $userId) {
        $schule = new Administration_Model_Schule();
        $date = new DateTime();
        $schule->setCreateDate($date->format('Y-m-d H:i:s'));
        $schule->setBezeichnung($request->getPost('name'));
        $schule->setBeschreibung($request->getPost('beschreibung'));
        $schule->setCreator($userId);
        return $this->mapper->createSchule($schule);
    }
    
    public function editSchule(Zend_Controller_Request_Http $request, $userId) {
        $schule = new Administration_Model_Schule();
        $date = new DateTime();
        $schule->setId($request->getPost('schulId'));
        $schule->setEditDate($date->format('Y-m-d H:i:s'));
        $schule->setBezeichnung($request->getPost('name'));
        $schule->setBeschreibung($request->getPost('beschreibung'));
        $schule->setEditor($userId);
        return $this->mapper->updateSchule($schule);
    }
    
    public function getSchuleById($schuleId) {
        return $this->mapper->getSchuleById($schuleId);
    }
    
    public function deleteSchule(Zend_Controller_Request_Http $request) {
        return $this->mapper->deleteNews($request->getPost('schulId'));
    }
    
}
