<?php

/**
 * Description of Nachteil
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_Service_Erstellung {
    
    /**
     * @var Administration_Model_Mapper_ErstellungMapper
     */
    private $erstellungMapper;
    
    public function __construct() {
        $this->erstellungMapper = new Administration_Model_Mapper_ErstellungMapper();
    }
    
    public function getNachteilList() {
        return $this->erstellungMapper->getNachteile();
    }
    
    public function getVorteilList() {
        return $this->erstellungMapper->getVorteile();
    }
    
    public function getKlassenList() {
        return $this->erstellungMapper->getAllClasses();
    }
    
    public function getKlassengruppenList() {
        return $this->erstellungMapper->getAllClassgroups();
    }
    
    public function getElementList() {
        return $this->erstellungMapper->getAllElements();
    }
    
}
