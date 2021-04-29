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
     * @return Application_Model_Charakter
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
        $charakterId = $this->charakterMapper->getCharakterIdByAccessKey($accessKey);
        return $this->getCharakterById($charakterId);
    }

    /**
     * @param int $charakterId
     *
     * @return Application_Model_Charakter
     * @throws Exception
     */
    public function getCharakterById($charakterId) {
        if ($this->cacheService->isActive()) {
            $charakter = $this->cacheService->fetch('charakter', $charakterId);
        }
        if (!isset($charakter)) {
            $charakter = $this->buildCharakter($charakterId);
        }
        if ($charakter !== false && $this->cacheService->isActive()) {
            $this->cacheService->storeCharakter('charakter', $charakter->getCharakterid(), $charakter);
        }
        return $charakter;
    }

    /**
     * @param string $uuid
     * @return Application_Model_Charakter
     * @throws Exception
     */
    public function getCharakterByUUID(string $uuid) {
        $charakter = $this->charakterMapper->getCharakterByUUID($uuid);
        $charakter->setCharakterprofil($this->charakterMapper->getCharakterProfil($charakter->getCharakterid()));
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
     * @return array
     */
    public function getCharakters() {
        try {
            $charakters = $this->charakterMapper->getAllCharakters();
            foreach ($charakters as $charakter) {
                $charakter->setCharakterprofil($this->getProfile($charakter->getCharakterid()));
            }
            return $charakters;
        } catch (Exception $exception) {
            return [];
        }
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
     * @param string $uuid
     * @return string
     * @throws Exception
     */
    public function getPreview(string $uuid) {
        $charakter = $this->charakterMapper->getCharakterByUUID($uuid);
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
     * @param Application_Model_Charakter $charakter
     * @param string $objective
     *
     * @throws Exception
     */
    public function updateObjectives (Application_Model_Charakter $charakter, string $objective)
    {
        $this->charakterMapper->updateObjective($objective, $charakter->getCharakterid());
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

    /**
     * @param Application_Model_Trait $trait
     * @param $characterId
     *
     * @throws Exception
     */
    public function updateTraitStory (Application_Model_Trait $trait, $characterId)
    {
        $this->charakterMapper->updateTraitStory($trait, $characterId);
    }

    /**
     * @param Application_Model_Trait $trait
     * @param $characterId
     *
     * @throws Exception
     */
    public function updateTraitDescription (Application_Model_Trait $trait, $characterId)
    {
        $this->charakterMapper->updateTraitDescription($trait, $characterId);
    }

    /**
     * @param $organizationId
     * @param $characterId
     *
     * @throws Exception
     */
    public function updateOrganization ($organizationId, $characterId)
    {
        if (!in_array(
            $organizationId,
            [
                Application_Model_MagiOrganization::CLOCK_TOWER,
                Application_Model_MagiOrganization::ATLAS,
                Application_Model_MagiOrganization::WANDERING_SEA
            ])
        ) {
            return;
        }
        $this->charakterMapper->updateOrganization($organizationId, $characterId);
    }
    
}
