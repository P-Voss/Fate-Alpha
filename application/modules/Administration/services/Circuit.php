<?php

/**
 * Description of Administration_Service_Circuit
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_Service_Circuit {
    
    /**
     * @var Administration_Model_Mapper_CircuitMapper
     */
    private $mapper;
    /**
     * @var Administration_Model_Mapper_ErstellungMapper
     */
    private $erstellungMapper;
    
    public function __construct() {
        $this->mapper = new Administration_Model_Mapper_CircuitMapper();
        $this->erstellungMapper = new Administration_Model_Mapper_ErstellungMapper();
    }
    
    public function createCircuit(Zend_Controller_Request_Http $request, $userId) {
        $element = new Administration_Model_Circuit();
        $date = new DateTime();
        $element->setCreateDate($date->format('Y-m-d H:i:s'));
        $element->setKategorie($request->getPost('kategorie'));
        $element->setBeschreibung($request->getPost('beschreibung'));
        $element->setMenge($request->getPost('menge'));
        $element->setKosten($request->getPost('kosten'));
        $element->setCreator($userId);
        return $this->mapper->createCircuit($element);
    }
    
    public function editCircuit(Zend_Controller_Request_Http $request, $userId) {
        $element = new Administration_Model_Circuit();
        $date = new DateTime();
        $element->setId($request->getPost('circuitId'));
        $element->setEditDate($date->format('Y-m-d H:i:s'));
        $element->setKategorie($request->getPost('kategorie'));
        $element->setBeschreibung($request->getPost('beschreibung'));
        $element->setMenge($request->getPost('menge'));
        $element->setKosten($request->getPost('kosten'));
        $element->setEditor($userId);
        return $this->mapper->updateCircuit($element);
    }
    
    public function getCircuitById($circuitId) {
        return $this->mapper->getCircuitById($circuitId);
    }
    
    public function deleteCircuit(Zend_Controller_Request_Http $request) {
        
    }
    
}
