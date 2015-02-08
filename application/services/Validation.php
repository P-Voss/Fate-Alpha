<?php

/**
 * Description of Validation
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Service_Validation {
    
    private $_validatorFactory;
    private $_informationMapper;
    private $_informationFactory;


    public function __construct() {
        $this->_validatorFactory = new Application_Model_Validation_Factory();
        $this->_informationFactory = new Application_Model_Erstellung_Information_InformationFactory();
    }
    
    public function validateByRequest(Zend_Controller_Request_Http $request) {
        $validator = $this->_validatorFactory->getValidator($request->getPost('type'));
        return json_encode(array('result' => $validator->validate($request->getPost('value'))));
    }
    
    public function validateCreation($charakterArray) {
        if(!$this->_checkPoints($charakterArray)){
            return false;
        }
        if(!$this->_checkCombination($charakterArray)){
            return false;
        }
        return true;
    }
    
    private function _checkPoints($charakterArray){
        $punkte = 0;
        if(key_exists('vorteile', $charakterArray)){
            $this->_informationMapper = $this->_informationFactory->getConcrete('Vorteil');
            foreach ($charakterArray['vorteile'] as $vorteilId){
                $punkte += $this->_informationMapper->getPunkte($vorteilId);
            }
        }
        if(key_exists('nachteile', $charakterArray)){
            $this->_informationMapper = $this->_informationFactory->getConcrete('Nachteil');
            foreach ($charakterArray['nachteile'] as $nachteilId){
                $punkte -= $this->_informationMapper->getPunkte($nachteilId);
            }
        }
        if(key_exists('odo', $charakterArray)){
            $this->_informationMapper = $this->_informationFactory->getConcrete('Odo');
            $punkte += $this->_informationMapper->getPunkte($charakterArray['odo']);
        }
        if(key_exists('luck', $charakterArray)){
            $this->_informationMapper = $this->_informationFactory->getConcrete('Luck');
            $punkte += $this->_informationMapper->getPunkte($charakterArray['luck']);
        }
        if(key_exists('circuit', $charakterArray)){
            $this->_informationMapper = $this->_informationFactory->getConcrete('Circuit');
            $punkte += $this->_informationMapper->getPunkte($charakterArray['circuit']);
        }
        if(key_exists('element', $charakterArray)){
            $this->_informationMapper = $this->_informationFactory->getConcrete('Element');
            $punkte += $this->_informationMapper->getPunkte($charakterArray['element']);
        }
        if(key_exists('klasse', $charakterArray)){
            $this->_informationMapper = $this->_informationFactory->getConcrete('Klasse');
            $punkte += $this->_informationMapper->getPunkte($charakterArray['klasse']);
        }
        return (30 - $punkte) >= 0;
    }
    
    private function _checkCombination($charakterArray){
        $mapper = new Application_Model_Mapper_ErstellungMapper();
        if(isset($charakterArray['vorteile'])){
            $vorteilIds = $charakterArray['vorteile'];
        }else{
            $vorteilIds = array();
        }
        if(isset($charakterArray['nachteile'])){
            $nachteilIds = $charakterArray['nachteile'];
        }else{
            $nachteilIds = array();
        }
        $disabledVorteile = $mapper->getVorteilIncompatibilities($vorteilIds, $nachteilIds);
        $disabledNachteile = $mapper->getNachteilIncompatibilities($nachteilIds, $vorteilIds);
        foreach ($vorteilIds as $vorteil){
            if(in_array($vorteil, $disabledVorteile)){
                return false;
            }
        }
        foreach ($nachteilIds as $nachteil){
            if(in_array($nachteil, $disabledNachteile)){
                return false;
            }
        }
        return true;
    }
    
}
