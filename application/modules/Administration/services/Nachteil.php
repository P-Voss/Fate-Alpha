<?php

/**
 * Description of Nachteil
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_Service_Nachteil {
    
    /**
     * @var Administration_Model_Mapper_NachteilMapper
     */
    private $mapper;
    /**
     * @var Administration_Model_Mapper_ErstellungMapper
     */
    private $erstellungMapper;
    
    public function __construct() {
        $this->mapper = new Administration_Model_Mapper_NachteilMapper();
        $this->erstellungMapper = new Administration_Model_Mapper_ErstellungMapper();
    }
    
    public function createNachteil(Zend_Controller_Request_Http $request, $userId) {
        $nachteil = new Administration_Model_Nachteil();
        $date = new DateTime();
        $nachteil->setCreateDate($date->format('Y-m-d H:i:s'));
        $nachteil->setBezeichnung($request->getPost('name'));
        $nachteil->setBeschreibung($request->getPost('beschreibung'));
        $nachteil->setKosten($request->getPost('kosten'));
        $nachteil->setCreator($userId);
        return $this->mapper->createNachteil($nachteil);
    }
    
    public function editNachteil(Zend_Controller_Request_Http $request, $userId) {
        $nachteil = new Administration_Model_Nachteil();
        $date = new DateTime();
        $nachteil->setId($request->getPost('nachteilId'));
        $nachteil->setEditDate($date->format('Y-m-d H:i:s'));
        $nachteil->setBezeichnung($request->getPost('name'));
        $nachteil->setBeschreibung($request->getPost('beschreibung'));
        $nachteil->setKosten($request->getPost('kosten'));
        $nachteil->setEditor($userId);
        return $this->mapper->updateNachteil($nachteil);
    }
    
    public function getNachteilById($nachteilId) {
        return $this->mapper->getNachteilById($nachteilId);
    }
    
    public function deleteNachteil(Zend_Controller_Request_Http $request) {
        return $this->mapper->deleteNews($request->getPost('newsId'));
    }
    
}
