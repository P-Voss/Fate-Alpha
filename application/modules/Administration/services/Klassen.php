<?php

/**
 * Description of Nachteil
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_Service_Klassen {
    
    /**
     * @var Administration_Model_Mapper_KlasseMapper
     */
    private $mapper;
    
    public function __construct() {
        $this->mapper = new Administration_Model_Mapper_KlasseMapper();
    }
    
    public function createKlasse(Zend_Controller_Request_Http $request, $userId) {
        $klasse = new Administration_Model_Klasse();
        $date = new DateTime();
        $klasse->setCreateDate($date->format('Y-m-d H:i:s'));
        $klasse->setBezeichnung($request->getPost('name'));
        $klasse->setBeschreibung($request->getPost('beschreibung'));
        $klasse->setFamilienname($request->getPost('familienname'));
        $klasse->setKosten($request->getPost('kosten'));
        $klasse->setGruppe($request->getPost('klassengruppe'));
        $klasse->setCreator($userId);
        return $this->mapper->createClass($klasse);
    }
    
    public function editKlasse(Zend_Controller_Request_Http $request, $userId) {
        $klasse = new Administration_Model_Klasse();
        $date = new DateTime();
        $klasse->setId($request->getPost('klassenId'));
        $klasse->setEditDate($date->format('Y-m-d H:i:s'));
        $klasse->setBezeichnung($request->getPost('name'));
        $klasse->setBeschreibung($request->getPost('beschreibung'));
        $klasse->setFamilienname($request->getPost('familienname'));
        $klasse->setKosten($request->getPost('kosten'));
        $klasse->setGruppe($request->getPost('klassengruppe'));
        $klasse->setEditor($userId);
        return $this->mapper->updateClass($klasse);
    }
    
    public function getKlasseById(Zend_Controller_Request_Http $request) {
        return $this->mapper->getClassById($request->getParam('id'));
    }
    
    public function getKlasseList() {
        return $this->mapper->getClasses();
    }
    
    public function deleteKlasse(Zend_Controller_Request_Http $request) {
        return $this->mapper->deleteClass($request->getPost('classId'));
    }
    
}
