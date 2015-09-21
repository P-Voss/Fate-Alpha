<?php

/**
 * Description of CharakterController
 *
 * @author Vosser
 */
class Application_Service_Erstellung {
    
    private $_mapper;
    private $_informationMapper;
    private $_informationFactory;
    
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
    
    /**
     * @param Zend_Controller_Request_Http $request
     */
    public function getKlassengruppe(Zend_Controller_Request_Http $request) {
        $klasseMapper = new Application_Model_Mapper_KlasseMapper();
        $returnArray = [
            'gruppe' => $klasseMapper->getKlassengruppe($request->getPost('id')->getId()),
            'familienname' => $klasseMapper->getFamilienname($request->getPost('id')),
        ];
        echo json_encode($returnArray);
    }
    
    public function getCharakteristics(Zend_Controller_Request_Http $request) {
        $this->_informationFactory = new Application_Model_Erstellung_Information_InformationFactory();
        $informationMapper = $this->_informationFactory->getConcrete($request->getPost('type'));
        $returnArray = [
            'punkte' => $this->_calculatePoints($request->getPost()),
            'beschreibung' => $informationMapper->getBeschreibung($request->getPost('id')),
        ];
        if(key_exists('vorteile', $request->getPost())){
            $vorteile = $request->getPost('vorteile');
        }else{
            $vorteile = array();
        }
        if(key_exists('nachteile', $request->getPost())){
            $nachteile = $request->getPost('nachteile');
        }else{
            $nachteile = array();
        }
        $returnArray['forms'] = $this->_getUserinterface($request->getPost('klasse'), $vorteile, $nachteile);
        
        return json_encode($returnArray);
    }
    
    private function _getVorteilForm($klassenId, $disabledIds, array $selectedIds){
        $vorteile = $this->_mapper->getAllVorteile();
        $html = '';
        foreach ($vorteile as $vorteil){
            /* @var $vorteil Application_Model_Vorteil */
            $selected = (in_array($vorteil->getId(), $selectedIds)) ? 'selected=""' : '';
            $disabled = (in_array($vorteil->getId(), $disabledIds)) ? 'disabled=""' : '';
            $kosten = ($this->_specialCosts($klassenId, $vorteil->getId())) ? $this->_specialCosts($klassenId, $vorteil->getId()) : $vorteil->getKosten();
            $html .= '<option value="' . $vorteil->getId() . '" ' . $selected . $disabled . '>' . $vorteil->getBezeichnung() . ' (' . $kosten . ')</option>';
        }
        return $html;
    }
    
    /**
     * 
     * @param type $klassenIds
     * @param type $disabledIds
     * @param array $selectedIds
     * @return string
     */
    private function _getNachteilForm($klassenIds, $disabledIds, array $selectedIds){
        $nachteile = $this->_mapper->getAllNachteile();
        $html = '';
        foreach ($nachteile as $nachteil){
            /* @var $nachteil Application_Model_Nachteil */
            $selected = (in_array($nachteil->getId(), $selectedIds)) ? 'selected=""' : '';
            $disabled = (in_array($nachteil->getId(), $disabledIds)) ? 'disabled=""' : '';
            $html .= '<option value="' . $nachteil->getId() . '" ' . $selected . $disabled . '>' . $nachteil->getBezeichnung() . ' (' . $nachteil->getKosten() . ')</option>';
        }
        return $html;
    }
    
    /**
     * @param int $klassenId
     * @param array $vorteilIds
     * @param array $nachteilIds
     * @return array
     */
    private function _getUserinterface($klassenId, array $vorteilIds, array $nachteilIds){
        $this->_mapper = new Application_Model_Mapper_ErstellungMapper();
        $disabledVorteile = $this->_mapper->getVorteilIncompatibilities($vorteilIds, $nachteilIds);
        $disabledNachteile = $this->_mapper->getNachteilIncompatibilities($nachteilIds, $vorteilIds);
        $userInterface['vorteile'] = $this->_getVorteilForm($klassenId, $disabledVorteile, $vorteilIds);
        $userInterface['nachteile'] = $this->_getNachteilForm($klassenId, $disabledNachteile, $nachteilIds);
        return $userInterface;
    }
    
    /**
     * @param array $paramsArray
     * @return int
     */
    private function _calculatePoints(array $paramsArray){
        $punkte = 0;
        if(key_exists('vorteile', $paramsArray)){
            $this->_informationMapper = $this->_informationFactory->getConcrete('Vorteil');
            foreach ($paramsArray['vorteile'] as $vorteilId){
                $punkte += $this->_informationMapper->getPunkte($vorteilId);
            }
        }
        if(key_exists('nachteile', $paramsArray)){
            $this->_informationMapper = $this->_informationFactory->getConcrete('Nachteil');
            foreach ($paramsArray['nachteile'] as $nachteilId){
                $punkte -= $this->_informationMapper->getPunkte($nachteilId);
            }
        }
        if(key_exists('odo', $paramsArray)){
            $this->_informationMapper = $this->_informationFactory->getConcrete('Odo');
            $punkte += $this->_informationMapper->getPunkte($paramsArray['odo']);
        }
        if(key_exists('luck', $paramsArray)){
            $this->_informationMapper = $this->_informationFactory->getConcrete('Luck');
            $punkte += $this->_informationMapper->getPunkte($paramsArray['luck']);
        }
        if(key_exists('circuit', $paramsArray)){
            $this->_informationMapper = $this->_informationFactory->getConcrete('Circuit');
            $punkte += $this->_informationMapper->getPunkte($paramsArray['circuit']);
        }
        if(key_exists('element', $paramsArray)){
            $this->_informationMapper = $this->_informationFactory->getConcrete('Element');
            $punkte += $this->_informationMapper->getPunkte($paramsArray['element']);
        }
        if(key_exists('klasse', $paramsArray)){
            $this->_informationMapper = $this->_informationFactory->getConcrete('Klasse');
            $punkte += $this->_informationMapper->getPunkte($paramsArray['klasse']);
        }
        return (30 - $punkte);
    }
    
    private function _specialCosts($klassenId, $vorteilIds){
        
    }
    
    /**
     * 
     * @param Zend_Controller_Request_Http $request
     * @return boolean
     */
    public function createCharakter(Zend_Controller_Request_Http $request) {
        $klasseMapper = new Application_Model_Mapper_KlasseMapper();
        $validationService = new Application_Service_Validation();
        if(!$validationService->validateCreation($request->getPost())){
            return false;
        }
        $charakter = new Application_Model_Charakter();
        $charakter->setUserid(Zend_Auth::getInstance()->getIdentity()->userId);
        $charakter->setVorname($request->getPost('vorname'));
        $charakter->setNachname($request->getPost('nachname'));
        $charakter->setNickname('');
        $charakter->setGeburtsdatum($request->getPost('geburtsdatum'));
        $charakter->setGeschlecht($request->getPost('sex'));
        $charakter->setAugenfarbe($request->getPost('augenfarbe'));
        $charakter->setSize($request->getPost('size'));
        $charakter->setWohnort($request->getPost('wohnort'));
        $charakter->setKlasse($klasseMapper->getKlasseById($request->getPost('klasse')));
        $charakter->setOdo($request->getPost('odo'));
        $charakter->setLuck($request->getPost('luck'));
        if(!is_null($request->getPost('circuit'))){
            $charakter->setMagiccircuit($request->getPost('circuit'));
        }
        if(!is_null($request->getPost('nachteile'))){
            $charakter->setNachteile($request->getPost('nachteile'));
        }
        if(!is_null($request->getPost('vorteile'))){
            $charakter->setVorteile($request->getPost('vorteile'));
        }
        $mapper = new Application_Model_Mapper_CharakterMapper();
        $newCharakter = $mapper->createCharakter($charakter);
        if($newCharakter != false){
            foreach ($charakter->getVorteile() as $vorteil){
                $mapper->saveCharakterVorteil($vorteil, $newCharakter['charakterId']);
            }
            foreach ($charakter->getNachteile() as $nachteil){
                $mapper->saveCharakterNachteil($nachteil, $newCharakter['charakterId']);
            }
            $mapper->setInitalSkillarten($newCharakter['charakterId']);
            $mapper->saveCharakterWerte($newCharakter['charakterId']);
            $mapper->createCharakterProfile($newCharakter['charakterId']);
            $mapper->saveCharakterElement($request->getPost('element'), $newCharakter['charakterId']);
            return true;
        }else{
            throw new Exception('Konnte Charakter nicht anlegen');
        }
    }
    
    /**
     * @param Zend_Controller_Request_Http $request
     * @return string
     */
    public function getOrtePreview(Zend_Controller_Request_Http $request) {
        $mapper = new Application_Model_Mapper_OrteMapper();
        return $mapper->getOrtePreview($request->getPost('name'));
    }
    
    /**
     * @param Zend_Controller_Request_Http $request
     * @return string
     */
    public function getStadtteilePreview(Zend_Controller_Request_Http $request) {
        $mapper = new Application_Model_Mapper_OrteMapper();
        return $mapper->getStadtteilPreview($request->getPost('name'));
    }
    
}
