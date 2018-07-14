<?php

/**
 * Description of Erstellung
 *
 * @author Voß
 */
class Erstellung_Service_Erstellung {
    
    /**
     * @param Zend_Controller_Request_Http $request
     * @return array
     */
    public function savePersonaldata(Zend_Controller_Request_Http $request) {
        $errorArray = array();
        $charakter = new Erstellung_Model_Charakter();
        if($request->getPost('vorname') === null OR $request->getPost('vorname') === ''){
            $errorArray['vorname'] = 'Der Vorname fehlt.';
        }
        $charakter->setVorname($request->getPost('vorname'));
        if($request->getPost('nachname') === null OR $request->getPost('nachname') === ''){
            $errorArray['nachname'] = 'Der Nachname fehlt.';
        }
        $charakter->setNachname($request->getPost('nachname'));
        if($request->getPost('augenfarbe') === null OR $request->getPost('augenfarbe') === ''){
            $errorArray['augenfarbe'] = 'Die Augenfarbe fehlt.';
        }
        $charakter->setAugenfarbe($request->getPost('augenfarbe'));
        if($request->getPost('geburtsdatum') === null OR $request->getPost('geburtsdatum') === ''){
            $errorArray['geburtsdatum'] = 'Das Geburtsdatum fehlt.';
        }
        $charakter->setGeburtsdatum($request->getPost('geburtsdatum'));
        if($request->getPost('geschlecht') === null OR $request->getPost('geschlecht') === ''){
            $errorArray['geschlecht'] = 'Das Geschlecht fehlt.';
        }
        $charakter->setGeschlecht($request->getPost('geschlecht'));
        if($request->getPost('sex') === null OR $request->getPost('sex') === ''){
            $errorArray['sex'] = 'Die Sexualität fehlt.';
        }
        $charakter->setSexualitaet($request->getPost('sex'));
        if($request->getPost('size') === null OR $request->getPost('size') === ''){
            $errorArray['size'] = 'Die Körpergröße fehlt.';
        }
        $charakter->setSize($request->getPost('size'));
        if($request->getPost('wohnort') === null OR $request->getPost('wohnort') === ''){
            $errorArray['wohnort'] = 'Der Wohnort fehlt.';
        }
        $charakter->setWohnort($request->getPost('wohnort'));
        $charakter->setUserid(Zend_Auth::getInstance()->getIdentity()->userId);
        if(count($errorArray) > 0){
            return array('success' => false, 'errors' => $errorArray);
        }
        $mapper = new Erstellung_Model_Mapper_CharakterMapper();
        $inserted = $mapper->createCharakter($charakter);
        if($inserted != 0){
            return array('success' => true);
        }
        return array('success' => false, 'errors' => array('unbekannter Fehler beim Erstellen'));
    }
    
    /**
     * @param Zend_Controller_Request_Http $request
     * @param int $charakterId
     * @return array
     */
    public function updatePersonaldata(Zend_Controller_Request_Http $request, $charakterId) {
        $errorArray = array();
        $charakter = new Erstellung_Model_Charakter();
        if($request->getPost('vorname') === null OR $request->getPost('vorname') === ''){
            $errorArray['vorname'] = 'Der Vorname fehlt.';
        }
        $charakter->setVorname($request->getPost('vorname'));
        if($request->getPost('nachname') === null OR $request->getPost('nachname') === ''){
            $errorArray['nachname'] = 'Der Nachname fehlt.';
        }
        $charakter->setNachname($request->getPost('nachname'));
        if($request->getPost('augenfarbe') === null OR $request->getPost('augenfarbe') === ''){
            $errorArray['augenfarbe'] = 'Die Augenfarbe fehlt.';
        }
        $charakter->setAugenfarbe($request->getPost('augenfarbe'));
        if($request->getPost('geburtsdatum') === null OR $request->getPost('geburtsdatum') === ''){
            $errorArray['geburtsdatum'] = 'Das Geburtsdatum fehlt.';
        }
        $charakter->setGeburtsdatum($request->getPost('geburtsdatum'));
        if($request->getPost('geschlecht') === null OR $request->getPost('geschlecht') === ''){
            $errorArray['geschlecht'] = 'Das Geschlecht fehlt.';
        }
        $charakter->setGeschlecht($request->getPost('geschlecht'));
        if($request->getPost('sex') === null OR $request->getPost('sex') === ''){
            $errorArray['sex'] = 'Die Sexualität fehlt.';
        }
        $charakter->setSexualitaet($request->getPost('sex'));
        if($request->getPost('size') === null OR $request->getPost('size') === ''){
            $errorArray['size'] = 'Die Körpergröße fehlt.';
        }
        $charakter->setSize($request->getPost('size'));
        if($request->getPost('wohnort') === null OR $request->getPost('wohnort') === ''){
            $errorArray['wohnort'] = 'Der Wohnort fehlt.';
        }
        $charakter->setWohnort($request->getPost('wohnort'));
        $charakter->setCharakterid($charakterId);
        if(count($errorArray) > 0){
            return array('success' => false, 'errors' => $errorArray);
        }
        $mapper = new Erstellung_Model_Mapper_CharakterMapper();
        $mapper->updateCharakter($charakter);
        return array('success' => true);
    }
    
    
    public function remove($attribute, Application_Model_Charakter $charakter) {
        $mapper = new Erstellung_Model_Mapper_CharakterMapper();
        switch ($attribute) {
            case 'klasse':
                $mapper->removeKlasse($charakter);
                $mapper->removeEigenschaften($charakter);
                $mapper->removeVorteile($charakter);
                $mapper->removeNachteile($charakter);
                $mapper->removeUnterklasse($charakter);
                break;
            case 'eigenschaften':
                $mapper->removeEigenschaften($charakter);
                $mapper->removeVorteile($charakter);
                $mapper->removeNachteile($charakter);
                $mapper->removeUnterklasse($charakter);
                break;
            case 'vornachteile':
                $mapper->removeVorteile($charakter);
                $mapper->removeNachteile($charakter);
                $mapper->removeUnterklasse($charakter);
                break;
            case 'unterklasse':
                $mapper->removeUnterklasse($charakter);
                break;
        }
    }
    
    
    public function addVorteil(Zend_Controller_Request_Http $request, Application_Model_Charakter $charakter, $klassenId) {
        $mapper = new Erstellung_Model_Mapper_CharakterMapper();
        $allowedVorteilCount = $klassenId === 2 ? 4 : 3;
        if ($mapper->getVorteilCount($charakter) < $allowedVorteilCount) {
            return $mapper->addVorteil($charakter, $request->getPost('id'));
        }
        return 0;
    }

    /**
     * @param Zend_Controller_Request_Http $request
     * @param Application_Model_Charakter $charakter
     *
     * @throws Exception
     */
    public function removeVorteil(Zend_Controller_Request_Http $request, Application_Model_Charakter $charakter) {
        $mapper = new Erstellung_Model_Mapper_CharakterMapper();
        $mapper->removeVorteil($charakter->getCharakterid(), $request->getPost('id'));
    }
    
    
    public function addNachteil(Zend_Controller_Request_Http $request, Application_Model_Charakter $charakter) {
        $mapper = new Erstellung_Model_Mapper_CharakterMapper();
        if ($mapper->getNachteilCount($charakter) < 2) {
            return $mapper->addNachteil($charakter, $request->getPost('id'));
        }
        return 0;
    }
    
    
    public function removeNachteil(Zend_Controller_Request_Http $request, Application_Model_Charakter $charakter) {
        $mapper = new Erstellung_Model_Mapper_CharakterMapper();
        $mapper->removeNachteil($charakter, $request->getPost('id'));
    }
    
    
    public function setKlasse(Zend_Controller_Request_Http $request, Application_Model_Charakter $charakter) {
        if(is_null($request->getPost('klassenId')) || !ctype_digit($request->getPost('klassenId'))){
            return array('success' => false, 'errors' => array('Die Klasse gibt es nicht.'));
        }
        $mapper = new Erstellung_Model_Mapper_CharakterMapper();
        $mapper->setKlasse($charakter, $request->getPost('klassenId'));
        return array('success' => true);
    }
    
    public function getKlasse(Erstellung_Model_Charakter $charakter) {
        $mapper = new Erstellung_Model_Mapper_CharakterMapper();
        return $mapper->getKlasse($charakter);
    }
    
    
    public function setUnterklasse(Zend_Controller_Request_Http $request, Erstellung_Model_Charakter $charakter) {
        if(is_null($request->getPost('id')) || !ctype_digit($request->getPost('id'))){
            return array('success' => false, 'errors' => array('Die Klasse gibt es nicht.'));
        }
        $mapper = new Erstellung_Model_Mapper_CharakterMapper();
        $mapper->setUnterklasse($charakter, $request->getPost('id'));
        return array('success' => true);
    }
    
    
    public function setEigenschaften(Zend_Controller_Request_Http $request, Application_Model_Charakter $charakter) {
        $errorArray = array();
        if($request->getPost('element') === null OR $request->getPost('element') === ''){
            $errorArray['element'] = 'Das Element fehlt.';
        }
        $params['naturelement'] = $request->getPost('element');
        
        if($request->getPost('odo') === null OR $request->getPost('odo') === ''){
            $errorArray['odo'] = 'Odo fehlt.';
        }
        $params['odo'] = $request->getPost('odo');
        
        if($request->getPost('luck') === null OR $request->getPost('luck') === ''){
            $errorArray['luck'] = 'Das Glück fehlt.';
        }
        $params['luck'] = $request->getPost('luck');
        
        if($request->getPost('circuit') !== null){
        $params['circuit'] = $request->getPost('circuit');
        }
        
        if(count($errorArray) > 0){
            return array('success' => false, 'errors' => $errorArray);
        }
        
        $mapper = new Erstellung_Model_Mapper_CharakterMapper();
        $mapper->setEigenschaften($charakter, $params);
        return array('success' => true);
    }
    
    public function activateCharakter(Erstellung_Model_Charakter $charakter) {
        $mapper = new Erstellung_Model_Mapper_CharakterMapper();
        $mapper->activateCharakter($charakter);
    }
    
    public function finalizeCharakter(Erstellung_Model_Charakter $charakter) {
        $mapper = new Erstellung_Model_Mapper_CharakterMapper();
        $mapper->familyname($charakter);
        $mapper->setInitalSkillarten($charakter->getCharakterid());
        $mapper->saveCharakterWerte($charakter->getCharakterid());
        $mapper->createCharakterProfile($charakter->getCharakterid());
    }
    
}
