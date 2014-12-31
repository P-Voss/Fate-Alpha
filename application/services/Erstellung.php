<?php

/**
 * Description of CharakterController
 *
 * @author Vosser
 */
class Application_Service_Erstellung {
    
    private $_mapper;
    
    public function init() {
        $this->_mapper = new Application_Model_Mapper_ErstellungMapper();
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
    
    public function calculatePoints(Zend_Controller_Request_Http $request) {
        
    }
    
}
