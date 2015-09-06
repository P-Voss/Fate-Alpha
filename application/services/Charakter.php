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
        $charakter = $mapper->getCharakterByUserId($userId);
        if($charakter !== false){
            $charakter->setCharakterwerte($mapper->getCharakterwerte($charakter->getCharakterid()));
            $charakter->setVorteile($mapper->getVorteileByCharakterId($charakter->getCharakterid()));
            $charakter->setNachteile($mapper->getNachteileByCharakterId($charakter->getCharakterid()));
            $charakter->setUserid($userId);
        }
        return $charakter;
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
    public function getCharakter(Zend_Controller_Request_Http $request) {
        $mapper = new Application_Model_Mapper_CharakterMapper();
        return $mapper->getCharakter($request->getParam('charakter'));
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
<table class='userlist'>
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
            {$charakter->getGeburtsdatum()}
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
HTML;
        return $html;
    }
    
}
