<?php

/**
 * Description of Vorteil
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_Service_Vorteil {
    
    /**
     * @var Administration_Model_Mapper_VorteilMapper
     */
    private $mapper;
    /**
     * @var Administration_Model_Mapper_ErstellungMapper
     */
    private $erstellungMapper;
    
    public function __construct() {
        $this->mapper = new Administration_Model_Mapper_VorteilMapper();
        $this->erstellungMapper = new Administration_Model_Mapper_ErstellungMapper();
    }
    
    public function createVorteil(Zend_Controller_Request_Http $request, $userId) {
        $vorteil = new Administration_Model_Vorteil();
        $date = new DateTime();
        $vorteil->setCreateDate($date->format('Y-m-d H:i:s'));
        $vorteil->setBezeichnung($request->getPost('name'));
        $vorteil->setBeschreibung($request->getPost('beschreibung'));
        $vorteil->setKosten($request->getPost('kosten'));
        $vorteil->setCreator($userId);
        return $this->mapper->createVorteil($vorteil);
    }
    
    public function editVorteil(Zend_Controller_Request_Http $request, $userId) {
        $vorteil = new Administration_Model_Vorteil();
        $date = new DateTime();
        $vorteil->setId($request->getPost('vorteilId'));
        $vorteil->setEditDate($date->format('Y-m-d H:i:s'));
        $vorteil->setBezeichnung($request->getPost('name'));
        $vorteil->setBeschreibung($request->getPost('beschreibung'));
        $vorteil->setKosten($request->getPost('kosten'));
        $vorteil->setEditor($userId);
        return $this->mapper->updateVorteil($vorteil);
    }
    
    public function getVorteilById($vorteilId) {
        return $this->mapper->getVorteilById($vorteilId);
    }
    
    public function deleteVorteil(Zend_Controller_Request_Http $request) {
        return $this->mapper->deleteNews($request->getPost('vorteilId'));
    }
    
}
