<?php

/**
 * Description of Administration_Service_Charakter
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_Service_Charakter extends Application_Service_Charakter {

    /**
     * @param int $charakterId
     *
     * @return Application_Model_Charakter
     * @throws Exception
     */
    public function getCharakterById($charakterId) {
        $charakter = $this->buildCharakter($charakterId);
        return $charakter;
    }

    /**
     * @param int $charakterId
     *
     * @return Application_Model_Charakter
     * @throws Exception
     */
    protected function buildCharakter($charakterId) {
        $charakterBuilder = new Application_Service_CharakterBuilder();
        if ($charakterBuilder->initCharakterByCharakterId($charakterId)) {
            $charakterBuilder
                ->unsetModifiers()
                ->setTraits()
                ->setCircuit()
                ->setNaturelement()
                ->setClassData()
                ->setLuck()
                ->setMagien()
                ->setOdo()
                ->setProfile()
                ->setSkills()
                ->setItems()
                ->setAchievements()
                ->setVermoegen()
                ->setWerte();
            return $charakterBuilder->getCharakter();
        } else {
            throw new Exception('Character could not be loaded');
        }
    }

    /**
     * @param Zend_Controller_Request_Http $request
     *
     * @return int
     * @throws Exception
     */
    public function saveCharakterData(Zend_Controller_Request_Http $request) {
        $charakter = new Application_Model_Charakter();
        $charakter->setCharakterid($request->getPost('charakterId'));
        
        $charakter->setVorname($request->getPost('vorname'));
        $charakter->setNachname($request->getPost('nachname'));
        $charakter->setNickname($request->getPost('nickname'));
        $charakter->setAugenfarbe($request->getPost('augenfarbe'));
        $charakter->setGeburtsdatum($request->getPost('geburtsdatum'));
        $charakter->setGeschlecht($request->getPost('geschlecht'));
        $charakter->setSexualitaet($request->getPost('sex'));
        $charakter->setSize($request->getPost('size'));

        $charakter->setMagiOrganization($request->getPost('organization', 0));
        
        $odo = new Application_Model_Odo();
        $odo->setId($request->getPost('odo'));
        $charakter->setOdo($odo);
        
        $element = new Application_Model_Element();
        $element->setId($request->getPost('element'));
        $charakter->setNaturElement($element);

        $luck = new Application_Model_Luck();
        $luck->setId($request->getPost('luck'));
        $charakter->setLuck($luck);

        $mapper = new Application_Model_Mapper_CharakterMapper();
        return $mapper->editCharakter($charakter);
    }

    /**
     * @param Zend_Controller_Request_Http $request
     *
     * @return int
     * @throws Exception
     */
    public function saveCharakterWerte(Zend_Controller_Request_Http $request) {
        $charakter = new Application_Model_Charakter();
        $charakter->setCharakterid($request->getPost('charakterId'));
        
        $charakterWerte = new Application_Model_Charakterwerte();
        $charakterWerte->setStaerke($request->getPost('staerke'));
        $charakterWerte->setAgilitaet($request->getPost('agilitaet'));
        $charakterWerte->setAusdauer($request->getPost('ausdauer'));
        $charakterWerte->setKontrolle($request->getPost('kontrolle'));
        $charakterWerte->setDisziplin($request->getPost('disziplin'));
        $charakterWerte->setUebung($request->getPost('uebung'));
        $charakterWerte->setFp($request->getPost('fp'));
        $charakterWerte->setStartpunkte($request->getPost('bonustage'));
        
        $charakter->setCharakterwerte($charakterWerte);
        
        $mapper = new Application_Model_Mapper_CharakterMapper();
        return $mapper->editCharakterWerte($charakter);
    }

    /**
     * @return Application_Model_Charakter[]
     * @throws Zend_Db_Statement_Exception
     */
    public function getCharaktersByNextBirthdays() {
        $mapper = new Application_Model_Mapper_CharakterMapper();
        return $mapper->getCharaktersOrderedByNextBirthday();
    }

    /**
     * @param $characterId
     *
     * @throws Exception
     */
    public function delete ($characterId)
    {
        $mapper = new Application_Model_Mapper_CharakterMapper();
        $character = new Application_Model_Charakter();
        $character->setCharakterid($characterId);
        $mapper->deleteCharakter($character);
    }
    
}
