<?php

/**
 * Description of Application_Service_Charakter
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Service_Charakter {
    
    /**
     * @param int $userId
     * @return boolean|\Application_Model_Charakter
     */
    public function getCharakterByUserid($userId) {
        $mapper = new Application_Model_Mapper_CharakterMapper();
        $klassenMapper = new Application_Model_Mapper_KlasseMapper();
        $charakter = $mapper->getCharakterByUserId($userId);
        if($charakter !== false){
            $charakter->setUserid($userId);
            $charakter->setKlasse($mapper->getCharakterKlasse($charakter->getCharakterid()));
            $charakter->setKlassengruppe($klassenMapper->getKlassengruppe($charakter->getKlasse()->getId()));
            $charakter->setNaturelement($mapper->getNaturelement($charakter->getCharakterid()));
            $charakter->setCharakterwerte($mapper->getCharakterwerte($charakter->getCharakterid()));
            $charakter->setVorteile($mapper->getVorteileByCharakterId($charakter->getCharakterid()));
            $charakter->setNachteile($mapper->getNachteileByCharakterId($charakter->getCharakterid()));
            $charakter->setSkills($mapper->getCharakterSkills($charakter->getCharakterid()));
            $charakter->setMagieschulen($mapper->getCharakterMagieschulen($charakter->getCharakterid()));
            $charakter->setMagien($mapper->getCharakterMagien($charakter->getCharakterid()));
            
            $charakter->setModifiers($mapper->getModifierByCharakter($charakter->getCharakterid()));
            
            $charakter->setOdo($mapper->getOdo($charakter->getCharakterid(), $charakter->getModifiers()));
            $charakter->setLuck($mapper->getLuck($charakter->getCharakterid(), $charakter->getModifiers()));
            $charakter->setVermoegen($mapper->getVermoegen($charakter->getCharakterid(), $charakter->getModifiers()));
            $charakter->setMagiccircuit($mapper->getMagiccircuit($charakter->getCharakterid()));
            $charakter->applyModifiers();
        }
        return $charakter;
    }
    
    
    public function getCharakters() {
        $mapper = new Application_Model_Mapper_CharakterMapper();
        $charakters = $mapper->getAllCharakters();
        foreach ($charakters as $charakter) {
            $charakter->setCharakterprofil($this->getProfile($charakter->getCharakterid()));
        }
        return $charakters;
    }
    
    /**
     * @param Zend_Controller_Request_Http $request
     * @param int $charakterId
     */
    public function addAssociate(Zend_Controller_Request_Http $request, $charakterId) {
        $mapper = new Application_Model_Mapper_CharakterMapper();
        $profileToUnlock = $mapper->verifyProfilecode($request->getParam('Charaktercode'), $charakterId);
        if($profileToUnlock !== false){
            if($mapper->setAssociation($profileToUnlock, $charakterId)){
                $mapper->setNewProfileCode($profileToUnlock['charakterId']);
            }
        }
    }
    
    /**
     * @param int $charakterId
     * @return array
     */
    public function getAssociates($charakterId) {
        $mapper = new Application_Model_Mapper_CharakterMapper();
        return $mapper->getFriendlist($charakterId);
    }
    
    /**
     * @param int $charakterId
     * @return Application_Model_Charakterprofil
     */
    public function getProfile($charakterId) {
        $mapper = new Application_Model_Mapper_CharakterMapper();
        return $mapper->getCharakterProfil($charakterId);
    }
    
    /**
     * @param Zend_Controller_Request_Http $request
     * @return Application_Model_Charakter
     */
    public function getCharakter(Zend_Controller_Request_Http $request, $fullData = false) {
        $mapper = new Application_Model_Mapper_CharakterMapper();
        $klassenMapper = new Application_Model_Mapper_KlasseMapper();
        $charakter = $mapper->getCharakter($request->getParam('charakter'));
        if($fullData === true AND $charakter !== false){
            $charakter->setKlasse($mapper->getCharakterKlasse($charakter->getCharakterid()));
            $charakter->setKlassengruppe($klassenMapper->getKlassengruppe($charakter->getKlasse()->getId()));
            $charakter->setNaturelement($mapper->getNaturelement($charakter->getCharakterid()));
            $charakter->setCharakterwerte($mapper->getCharakterwerte($charakter->getCharakterid()));
            $charakter->setVorteile($mapper->getVorteileByCharakterId($charakter->getCharakterid()));
            $charakter->setNachteile($mapper->getNachteileByCharakterId($charakter->getCharakterid()));
            
            $charakter->setModifiers($mapper->getModifierByCharakter($charakter->getCharakterid()));
            
            $charakter->setOdo($mapper->getOdo($charakter->getCharakterid(), $charakter->getModifiers()));
            $charakter->setLuck($mapper->getLuck($charakter->getCharakterid(), $charakter->getModifiers()));
            $charakter->setVermoegen($mapper->getVermoegen($charakter->getCharakterid(), $charakter->getModifiers()));
            $charakter->setMagiccircuit($mapper->getMagiccircuit($charakter->getCharakterid()));
            $charakter->applyModifiers();
            
            $charakter->setCharakterprofil($this->getProfile($charakter->getCharakterid()));
        }
        return $charakter;
    }
    
    /**
     * @param Zend_Controller_Request_Http $request
     * @param int $charakterId
     * @return Application_Model_Charakterprofil
     */
    public function getVisibleProfile(Zend_Controller_Request_Http $request, $charakterId) {
        $mapper = new Application_Model_Mapper_CharakterMapper();
        $profil = $mapper->getCharakterProfil($request->getParam('charakter'));
        $freigabe = $mapper->getDatenfreigabe($request->getParam('charakter'), $charakterId);
        if($freigabe['public'] !== 1){
            $profil->setCharaktergeschichte(null);
        }
        if($freigabe['privat'] !== 1){
            $profil->setPrivatdaten(null);
        }
        return $profil;
    }
    
    /**
     * @param Zend_Controller_Request_Http $request
     * @return string
     */
    public function getPreview(Zend_Controller_Request_Http $request) {
        $mapper = new Application_Model_Mapper_CharakterMapper();
        $charakter = $mapper->getCharakter($request->getPost('id'));
        $charakter->setCharakterprofil($mapper->getCharakterProfil($charakter->getCharakterid()));
        return $this->buildPreviewHtml($charakter);
    }
    
    /**
     * @param Application_Model_Charakter $charakter
     * @param Application_Model_Charakter $charakterToCheck
     * @return boolean
     */
    public function isAssociated(
            Application_Model_Charakter $charakter, 
            Application_Model_Charakter $charakterToCheck
    ) {
        $mapper = new Application_Model_Mapper_CharakterMapper();
        return $mapper->checkAssociation($charakter->getCharakterid(), $charakterToCheck->getCharakterid());
    }
    
    /**
     * @param Application_Model_Charakter $charakter
     * @return string
     */
    private function buildPreviewHtml(Application_Model_Charakter $charakter){
        $nick = (($charakter->getNickname() != null) ? ' - ' . $charakter->getNickname() : '');
        $html = <<<HTML
<p>
    <strong>
        {$charakter->getVorname()} {$charakter->getNachname()} {$nick}
    </strong>
</p>
<div style="float:left">
    <img width="100" height="130" border="0" src="{$charakter->getCharakterprofil()->getProfilpic()}">
</div>
<div>
    <table style="text-align: left" cellspacing="10em" class='userlist'>
        <colgroup>
            <col width="120px">
            <col width="200px">
        </colgroup>
        <tr>
            <td>
                Alter
            </td>
            <td>
                {$charakter->getAlter('y')} Jahre
            </td>
        </tr>
        <tr>
            <td>
                Geburtstag
            </td>
            <td>
                {$charakter->getGeburtsdatum('d.m.Y')}
            </td>
        </tr>
        <tr>
            <td>
                Größe
            </td>
            <td>
                {$charakter->getSize()} cm
            </td>
        </tr>
        <tr>
            <td>
                Augenfarbe
            </td>
            <td>
                {$charakter->getAugenfarbe()}
            </td>
        </tr>
    </table>
</div>
<div style="clear: both"></div>
HTML;
        return $html;
    }
    
    /**
     * @param int $charakterId
     * @param int $magieschuleId
     * @return int
     */
    public function getMagieStufe($charakterId, $magieschuleId) {
        $mapper = new Application_Model_Mapper_CharakterMapper();
        return $mapper->getCharakterMagieStufe($charakterId, $magieschuleId);
    }
    
    /**
     * @param int $charakterId
     * @return array
     */
    public function getMagieschulen($charakterId) {
        $mapper = new Application_Model_Mapper_CharakterMapper();
        return $mapper->getCharakterMagieschulen($charakterId);
    }
    
    /**
     * @param int $charakterId
     * @return array
     */
    public function getSkills($charakterId) {
        $mapper = new Application_Model_Mapper_CharakterMapper();
        return $mapper->getCharakterSkills($charakterId);
    }
    
    
    public function getMagien($charakterId) {
        $mapper = new Application_Model_Mapper_CharakterMapper();
        return $mapper->getCharakterMagien($charakterId);
    }
    
    /**
     * @param Application_Model_Charakter $charakter
     * @param Zend_Controller_Request_Http $request
     * @return int
     */
    public function saveCharpic(Application_Model_Charakter $charakter, Zend_Controller_Request_Http $request) {
        $mapper = new Application_Model_Mapper_CharakterMapper();
        $mapper->saveCharakterpic($charakter->getCharakterid(), $request->getParam('charpic'));
    }
    
    /**
     * @param Application_Model_Charakter $charakter
     * @param Zend_Controller_Request_Http $request
     * @return int
     */
    public function saveProfilpic(Application_Model_Charakter $charakter, Zend_Controller_Request_Http $request) {
        $mapper = new Application_Model_Mapper_CharakterMapper();
        $mapper->saveProfilpic($charakter->getCharakterid(), $request->getParam('profilpic'));
    }
    
    
    public function saveStory(Application_Model_Charakter $charakter, Zend_Controller_Request_Http $request) {
        $mapper = new Application_Model_Mapper_ProfilMapper();
        $mapper->saveStory($charakter->getCharakterid(), $request->getPost('story'));
    }
    
    
    public function savePrivate(Application_Model_Charakter $charakter, Zend_Controller_Request_Http $request) {
        $mapper = new Application_Model_Mapper_ProfilMapper();
        $mapper->savePrivate($charakter->getCharakterid(), $request->getPost('private'));
    }
    
}
