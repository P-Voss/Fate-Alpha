<?php

/**
 * Description of Element
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_Service_Element {
    
    /**
     * @var Administration_Model_Mapper_ElementMapper
     */
    private $mapper;
    /**
     * @var Administration_Model_Mapper_ErstellungMapper
     */
    private $erstellungMapper;
    
    public function __construct() {
        $this->mapper = new Administration_Model_Mapper_ElementMapper;
        $this->erstellungMapper = new Administration_Model_Mapper_ErstellungMapper();
    }
    
    public function createElement(Zend_Controller_Request_Http $request, $userId) {
        $element = new Administration_Model_Element();
        $date = new DateTime();
        $element->setCreateDate($date->format('Y-m-d H:i:s'));
        $element->setBezeichnung($request->getPost('name'));
        $element->setBeschreibung($request->getPost('beschreibung'));
        $element->setCharakterisierung($request->getPost('charakter'));
        $element->setKosten($request->getPost('kosten'));
        $element->setCreator($userId);
        return $this->mapper->createElement($element);
    }
    
    public function editElement(Zend_Controller_Request_Http $request, $userId) {
        $element = new Administration_Model_Element();
        $date = new DateTime();
        $element->setId($request->getPost('elementId'));
        $element->setEditDate($date->format('Y-m-d H:i:s'));
        $element->setBezeichnung($request->getPost('name'));
        $element->setBeschreibung($request->getPost('beschreibung'));
        $element->setCharakterisierung($request->getPost('charakter'));
        $element->setKosten($request->getPost('kosten'));
        $element->setEditor($userId);
        return $this->mapper->updateElement($element);
    }
    
    public function getElementById($elementId) {
        return $this->mapper->getElementById($elementId);
    }
    
    public function deleteElement(Zend_Controller_Request_Http $request) {
        
    }
    
}
