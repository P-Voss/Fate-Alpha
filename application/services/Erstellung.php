<?php

/**
 * Description of CharakterController
 *
 * @author Vosser
 */
class Application_Service_Erstellung {
    
    private $_mapper;
    private $_punkteFactory;
    private $_beschreibungFactory;
    
    public function init() {
        $this->_mapper = new Application_Model_Mapper_ErstellungMapper();
        $this->_beschreibungFactory = new Application_Model_Erstellung_BeschreibungFactory();
    }
    
    public function getCreationParams() {
        $this->_mapper = new Application_Model_Mapper_ErstellungMapper();
        $creationParamContainer = array();
        $creationParamContainer['vorteile'] = $this->_mapper->getAllVorteile();
        $creationParamContainer['nachteile'] = $this->_mapper->getAllNachteile();
        $creationParamContainer['klassen'] = $this->_mapper->getAllClasses();
        $creationParamContainer['odo'] = $this->_mapper->getAllOdo();
        $creationParamContainer['circuits'] = $this->_mapper->getAllCircuits();
        $creationParamContainer['elemente'] = $this->_mapper->getAllElements();
        $creationParamContainer['luck'] = $this->_mapper->getAllLuckvalues();
        return $creationParamContainer;
    }
    
    public function calculatePointsByRequest(Zend_Controller_Request_Http $request) {
        $this->_punkteFactory = new Application_Model_Erstellung_Punkte_PunkteFactory();
        $mapper = $this->_punkteFactory->getConcrete($request->getPost('type'));
        return $mapper->getPunkte($request->getPost('value'));
    }
    
    public function fetchBeschreibungByRequest(Zend_Controller_Request_Http $request) {
        $this->_beschreibungFactory = new Application_Model_Erstellung_BeschreibungFactory();
        $mapper = $this->_beschreibungFactory->getConcrete($request->getPost('type'));
        return $validator->validate($request->getPost('value'));
    }
    
}
