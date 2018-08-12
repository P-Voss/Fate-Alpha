<?php

/**
 * Description of Application_Service_Charakter
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Service_Charakter {
    
    /**
     * @var Application_Service_Cache 
     */
    protected $cacheService;
    /**
     * @var Application_Model_Mapper_CharakterMapper 
     */
    protected $charakterMapper;
    
    
    public function __construct() {
        $this->cacheService = new Application_Service_Cache();
        $this->charakterMapper = new Application_Model_Mapper_CharakterMapper();
    }


    /**
     * @param int $userId
     *
     * @return boolean|\Application_Model_Charakter
     * @throws Exception
     */
    public function getCharakterByUserid($userId) {
        $charakterId = $this->charakterMapper->getCharakterIdByUserId($userId);
        return $this->getCharakterById($charakterId);
    }

    /**
     * @param string $accessKey
     *
     * @return Application_Model_Charakter
     * @throws Exception
     * @todo Implementation
     */
    public function getCharakterByAccessKey($accessKey)
    {
        $charakterId = 4;
        return $this->getCharakterById($charakterId);
    }

    /**
     * @param int $charakterId
     *
     * @return Application_Model_Charakter
     * @throws Exception
     */
    public function getCharakterById($charakterId) {
        $charakter = false;
        if ($charakterId !== false && $charakterId > 0) {
            if ($this->cacheService->isActive()) {
                $charakter = $this->cacheService->fetch('charakter', $charakterId);
            }
            if ($charakter === false) {
                $charakter = $this->buildCharakter($charakterId);
            }
            if ($charakter !== false && $this->cacheService->isActive()) {
                $this->cacheService->storeCharakter('charakter', $charakter->getCharakterid(), $charakter);
            }
            return $charakter;
        } else {
            return $charakter;
            # return new Application_Model_Charakter();
        }
    }

    /**
     * @todo Builder-Pattern
     *
     * @param int $charakterId
     *
     * @return boolean|Application_Model_Charakter
     * @throws Exception
     */
    private function buildCharakter($charakterId) {
        $klassenMapper = new Application_Model_Mapper_KlasseMapper();
        $charakter = $this->charakterMapper->getCharakter($charakterId);
        if($charakter !== false){
            $charakter->setKlasse($this->charakterMapper->getCharakterKlasse($charakter->getCharakterid()));
            $charakter->setKlassengruppe($klassenMapper->getKlassengruppe($charakter->getKlasse()->getId()));
            $charakter->setNaturelement($this->charakterMapper->getNaturelement($charakter->getCharakterid()));
            $charakter->setCharakterwerte($this->charakterMapper->getCharakterwerte($charakter->getCharakterid()));
            $charakter->setVorteile($this->charakterMapper->getVorteileByCharakterId($charakter->getCharakterid()));
            $charakter->setNachteile($this->charakterMapper->getNachteileByCharakterId($charakter->getCharakterid()));
            $charakter->getCharakterwerte()->vorteilToUebermenschMod($charakter->getVorteile());
            
            $charakter->setModifiers($this->charakterMapper->getModifierByCharakter($charakter->getCharakterid()));
            
            $charakter->setLuck($this->charakterMapper->getLuck($charakter->getCharakterid(), $charakter->getModifiers()));
            $charakter->setVermoegen($this->charakterMapper->getVermoegen($charakter->getCharakterid(), $charakter->getModifiers()));
            $charakter->setMagiccircuit($this->charakterMapper->getMagiccircuit($charakter->getCharakterid()));
            $charakter->setOdo($this->charakterMapper->getOdo($charakter->getCharakterid(), $charakter->getModifiers()));

            if (in_array($charakter->getMagiccircuit()->getKategorie(), ['A', 'B', 'C'])) {
                $charakter->getCharakterwerte()->setCircuitMod($charakter->getMagiccircuit()->getKategorie());
            }
            
            $charakter->setCharakterprofil($this->getProfile($charakter->getCharakterid()));
            
            $charakter->setSkills($this->charakterMapper->getCharakterSkills($charakterId));
            $charakter->setMagieschulen($this->charakterMapper->getCharakterMagieschulen($charakterId));
            $charakter->setMagien($this->charakterMapper->getCharakterMagien($charakterId));
            
            $odo = $charakter->getOdo();
            $odo->calculateActualOdo($charakter->getMagiccircuit(), $charakter->getCharakterwerte()->getCategory('kon'), $charakter->getKlassengruppe());
            $charakter->setOdo($odo);
        }
        return $charakter;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getCharakters() {
        $charakters = $this->charakterMapper->getAllCharakters();
        foreach ($charakters as $charakter) {
            $charakter->setCharakterprofil($this->getProfile($charakter->getCharakterid()));
        }
        return $charakters;
    }

    /**
     * @param Zend_Controller_Request_Http $request
     * @param int $charakterId
     * @throws Zend_Db_Select_Exception
     * @throws Exception
     */
    public function addAssociate(Zend_Controller_Request_Http $request, $charakterId) {
        $profileToUnlock = $this->charakterMapper->verifyProfilecode($request->getParam('Charaktercode'), $charakterId);
        if($profileToUnlock !== false){
            if($this->charakterMapper->setAssociation($profileToUnlock, $charakterId)){
                $this->charakterMapper->setNewProfileCode($profileToUnlock['charakterId']);
            }
        }
    }

    /**
     * @param int $charakterId
     * @return array
     * @throws Exception
     */
    public function getAssociates($charakterId) {
        return $this->charakterMapper->getFriendlist($charakterId);
    }

    /**
     * @param int $charakterId
     * @return Application_Model_Charakterprofil
     * @throws Exception
     */
    public function getProfile($charakterId) {
        return $this->charakterMapper->getCharakterProfil($charakterId);
    }

    /**
     * @param Zend_Controller_Request_Http $request
     * @param int $charakterId
     * @return Application_Model_Charakterprofil
     * @throws Exception
     */
    public function getVisibleProfile(Zend_Controller_Request_Http $request, $charakterId) {
        $profil = $this->charakterMapper->getCharakterProfil($request->getParam('charakter'));
        $freigabe = $this->charakterMapper->getDatenfreigabe($request->getParam('charakter'), $charakterId);
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
     *
     * @return string
     * @throws Exception
     */
    public function getPreview(Zend_Controller_Request_Http $request) {
        $charakter = $this->charakterMapper->getCharakter($request->getPost('id'));
        $charakter->setCharakterprofil($this->charakterMapper->getCharakterProfil($charakter->getCharakterid()));
        return $this->buildPreviewHtml($charakter);
    }

    /**
     * @param Application_Model_Charakter $charakter
     * @param Application_Model_Charakter $charakterToCheck
     * @return boolean
     * @throws Exception
     */
    public function isAssociated(
            Application_Model_Charakter $charakter, 
            Application_Model_Charakter $charakterToCheck
    ) {
        return $this->charakterMapper->checkAssociation($charakter->getCharakterid(), $charakterToCheck->getCharakterid());
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
     * @throws Exception
     */
    public function getMagieStufe($charakterId, $magieschuleId) {
        return $this->charakterMapper->getCharakterMagieStufe($charakterId, $magieschuleId);
    }

    /**
     * @param int $charakterId
     * @return array
     * @throws Exception
     */
    public function getMagieschulen($charakterId) {
        return $this->charakterMapper->getCharakterMagieschulen($charakterId);
    }

    /**
     * @param int $charakterId
     * @return array
     * @throws Exception
     */
    public function getSkills($charakterId) {
        return $this->charakterMapper->getCharakterSkills($charakterId);
    }
    
    
    public function getMagien($charakterId) {
        return $this->charakterMapper->getCharakterMagien($charakterId);
    }

    /**
     * @param Application_Model_Charakter $charakter
     * @param Zend_Controller_Request_Http $request
     *
     * @todo Exceptionhandling
     * @throws Exception
     */
    public function saveCharpic(Application_Model_Charakter $charakter, Zend_Controller_Request_Http $request) {
        $this->charakterMapper->saveCharakterpic($charakter->getCharakterid(), $request->getParam('charpic'));
    }

    /**
     * @param Application_Model_Charakter $charakter
     * @param Zend_Controller_Request_Http $request
     *
     * @todo Exceptionhandling
     * @throws Exception
     */
    public function saveProfilpic(Application_Model_Charakter $charakter, Zend_Controller_Request_Http $request) {
        $this->charakterMapper->saveProfilpic($charakter->getCharakterid(), $request->getParam('profilpic'));
    }

    /**
     * @param Application_Model_Charakter $charakter
     * @param Zend_Controller_Request_Http $request
     */
    public function saveStory(Application_Model_Charakter $charakter, Zend_Controller_Request_Http $request) {
        $mapper = new Application_Model_Mapper_ProfilMapper();
        $mapper->saveStory($charakter->getCharakterid(), $request->getPost('story'));
    }

    /**
     * @param Application_Model_Charakter $charakter
     * @param Zend_Controller_Request_Http $request
     */
    public function savePrivate(Application_Model_Charakter $charakter, Zend_Controller_Request_Http $request) {
        $mapper = new Application_Model_Mapper_ProfilMapper();
        $mapper->savePrivate($charakter->getCharakterid(), $request->getPost('private'));
    }

    /**
     * @param $charakterId
     *
     * @return Application_Model_Achievement[]
     * @throws Exception
     */
    public function getAchievements($charakterId) {
        return $this->charakterMapper->getAchievements($charakterId);
    }
    
}
