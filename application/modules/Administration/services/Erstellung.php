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

    /**
     * Administration_Service_Erstellung constructor.
     */
    public function __construct() {
        $this->erstellungMapper = new Administration_Model_Mapper_ErstellungMapper();
    }

    /**
     * @return Application_Model_Klasse[]
     */
    public function getKlassenList() {
        return $this->erstellungMapper->getKlassen();
    }

    /**
     * @return Application_Model_Klassengruppe[]
     */
    public function getKlassengruppenList() {
        return $this->erstellungMapper->getAllClassgroups();
    }

    /**
     * @return array|Erstellung_Model_Element[]
     */
    public function getElementList() {
        return $this->erstellungMapper->getAllElements();
    }

    /**
     * @return Erstellung_Model_Circuit[]
     * @throws Exception
     */
    public function getCircuitList() {
        return $this->erstellungMapper->getAllCircuits();
    }

    /**
     * @return Erstellung_Model_Trait[]
     */
    public function getTraits ()
    {
        $mapper = new Erstellung_Model_Mapper_TraitMapper();
        return $mapper->getAllTraits();
    }
}
