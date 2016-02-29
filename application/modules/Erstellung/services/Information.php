<?php

/**
 * Description of Information
 *
 * @author Voß
 */
class Erstellung_Service_Information {
    
    public function getKlassen() {
        $mapper = new Erstellung_Model_Mapper_KlassenMapper();
        return $mapper->getKlassengruppen();
    }
    
    
    public function getKlasse($id) {
        $mapper = new Erstellung_Model_Mapper_KlassenMapper();
        $klasse = $mapper->getKlassengruppeById($id);
        if($klasse !== false){
            $returnArray = array(
                'success' => true,
                'klasse' => $klasse->getBezeichnung(),
                'beschreibung' => $klasse->getBeschreibung(),
            );
        }else{
            $returnArray = array('success' => false);
        }
        return $returnArray;
    }
    
    
    public function getUnterklassen() {
        $mapper = new Application_Model_Mapper_ErstellungMapper();
        return $unterklassen = $mapper->getAllClasses();
    }
    
    
    public function getUnterklassenByCharakter(Erstellung_Model_Charakter $charakter) {
        $requirementValidator = new Erstellung_Service_Requirement($charakter);
        $mapper = new Application_Model_Mapper_ErstellungMapper();
        $unterklassenToValidate = $mapper->getUnterklassenForCharakter($charakter);
        $unterklassen = array();
        foreach ($unterklassenToValidate as $unterklasse){
            $unterklasse->setRequirementList($mapper->getUnterklassenRequirements($unterklasse->getId()));
            if($requirementValidator->validate($unterklasse->getRequirementList()) === true){
                $unterklassen[] = $unterklasse;
            }
        }
        return $unterklassen;
    }
    
    
    public function getUnterklasse($id) {
        $mapper = new Erstellung_Model_Mapper_KlassenMapper();
        $klasse = $mapper->getKlasseById($id);
        if($klasse !== false){
            $returnArray = array(
                'success' => true,
                'klasse' => $klasse->getBezeichnung(),
                'beschreibung' => $klasse->getBeschreibung(),
                'points' => $klasse->getKosten(),
            );
        }else{
            $returnArray = array('success' => false);
        }
        return $returnArray;
    }
    
    
    public function getCreationParams() {
        $mapper = new Application_Model_Mapper_ErstellungMapper();
        $creationParamContainer = array();
        $creationParamContainer['odo'] = $mapper->getAllOdo();
        $creationParamContainer['circuits'] = $mapper->getAllCircuits();
        $creationParamContainer['elemente'] = $mapper->getAllElements();
        $creationParamContainer['luck'] = $mapper->getAllLuckvalues();
        return $creationParamContainer;
    }
    
    
    public function getVorteile() {
        $mapper = new Application_Model_Mapper_ErstellungMapper();
        return $mapper->getAllVorteile();
    }
    
    
    public function getVorteil($id) {
        $mapper = new Application_Model_Mapper_VorteilMapper();
        return array(
            'points' => $mapper->getPunkte($id),
            'beschreibung' => $mapper->getBeschreibung($id),
        );
    }
    
    
    public function getNachteile() {
        $mapper = new Application_Model_Mapper_ErstellungMapper();
        return $mapper->getAllNachteile();
    }
    
    
    public function getNachteil($id) {
        $mapper = new Application_Model_Mapper_NachteilMapper();
        return array(
            'points' => $mapper->getPunkte($id),
            'beschreibung' => $mapper->getBeschreibung($id),
        );
    }
    
    
    public function hasCircuit(Erstellung_Model_Charakter $charakter) {
        $mapper = new Erstellung_Model_Mapper_CharakterMapper();
        $klassenId = $mapper->getKlasse($charakter);
        return $klassenId === 1;
    }
    
    
    public function getOdo($id) {
        $mapper = new Application_Model_Mapper_OdoMapper();
        return array(
            'points' => $mapper->getPunkte($id),
            'beschreibung' => $mapper->getBeschreibung($id),
        );
    }
    
    
    public function getCircuit($id) {
        $mapper = new Application_Model_Mapper_CircuitMapper();
        return array(
            'points' => $mapper->getPunkte($id),
            'beschreibung' => $mapper->getBeschreibung($id),
        );
    }
    
    
    public function getLuck($id) {
        $mapper = new Application_Model_Mapper_LuckMapper();
        return array(
            'points' => $mapper->getPunkte($id),
            'beschreibung' => $mapper->getBeschreibung($id),
        );
    }
    
    public function getIncompatibilities(Zend_Controller_Request_Http $request) {
        if(is_null($request->getPost('id')) OR is_null($request->getPost('type'))){
            return array('success' => false, 'errors' => array('falsche Parameter übergeben'));
        }
        if($request->getPost('type') === 'vorteil'){
            $mapper = new Application_Model_Mapper_VorteilMapper();
            return array(
                'success' => true,
                'vorteile' => $mapper->getIncompatibleVorteile($request->getPost('id')),
                'nachteile' => $mapper->getIncompatibleNachteile($request->getPost('id')),
            );
        }else{
            $mapper = new Application_Model_Mapper_NachteilMapper();
            return array(
                'success' => true,
                'vorteile' => $mapper->getIncompatibleVorteile($request->getPost('id')),
                'nachteile' => $mapper->getIncompatibleNachteile($request->getPost('id')),
            );
        }
    }
    
}
