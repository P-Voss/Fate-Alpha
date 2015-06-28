<?php

/**
 * Description of ErstellungMapper
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_Model_Mapper_ErstellungMapper extends Application_Model_Mapper_ErstellungMapper {
    
    public function getNachteile() {
        return parent::getAllNachteile();
    }
    
    public function getVorteile() {
        return parent::getAllVorteile();
    }
    
    public function getKlassen() {
        return parent::getAllClasses();
    }
    
    public function getElemente() {
        return parent::getAllElements();
    }
    
}
