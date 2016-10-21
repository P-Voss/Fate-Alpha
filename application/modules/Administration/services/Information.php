<?php

/**
 * Description of Information
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_Service_Information {
    
    /**
     * @var Administration_Model_Mapper_InformationMapper
     */
    private $mapper;
    /**
     * @var Administration_Model_Mapper_ErstellungMapper
     */
    private $erstellungMapper;
    /**
     * @var Administration_Service_Requirement
     */
    private $requirementService;
    
    public function __construct() {
        $this->mapper = new Administration_Model_Mapper_InformationMapper();
        $this->erstellungMapper = new Administration_Model_Mapper_ErstellungMapper();
        $this->requirementService = new Administration_Service_Requirement();
    }
    
    public function getInformationList() {
        return $this->mapper->getAllInformations();
    }
    
    public function createInformation(Zend_Controller_Request_Http $request, $userId) {
        $information = new Administration_Model_Information();
        $date = new DateTime();
        $information->setCreateDate($date->format('Y-m-d H:i:s'));
        $information->setName($request->getPost('name'));
        $information->setKategorie($request->getPost('kategorie'));
        $information->setInhalt($request->getPost('beschreibung'));
        $information->setCreator($userId);
        
        $information->setRequirementList(
            $this->requirementService->createRequirementListFromArray(
                $this->buildRequirementArray($request)
            )
        );
        $information->setInformationId($this->mapper->createInformation($information));
        $this->mapper->setDependencies($information);
    }
    
    public function editInformation(Zend_Controller_Request_Http $request, $userId) {
        $information = new Administration_Model_Information();
        $date = new DateTime();
        $information->setInformationId($request->getPost('informationId'));
        $information->setEditDate($date->format('Y-m-d H:i:s'));
        $information->setName($request->getPost('name'));
        $information->setKategorie($request->getPost('kategorie'));
        $information->setInhalt($request->getPost('inhalt'));
        $information->setEditor($userId);
        
        $information->setRequirementList(
            $this->requirementService->createRequirementListFromArray(
                $this->buildRequirementArray($request)
            )
        );
        $this->mapper->deleteDependencies($information);
        $this->mapper->setDependencies($information);
        return $this->mapper->updateInformation($information);
    }
    
    public function getInformationById($informationId) {
        return $this->mapper->getInformationById($informationId);
    }
    
    public function deleteInformation(Zend_Controller_Request_Http $request) {
        return $this->mapper->deleteNews($request->getPost('schulId'));
    }
    
    /**
     * @param Zend_Controller_Request_Http $request
     * @return array
     */
    public function buildRequirementArray(Zend_Controller_Request_Http $request) {
        $requirements = array();
        if($request->getParam('fp') !== null){
            $requirements['FP'] = $request->getParam('fp');
        }
        if($request->getParam('uebung') !== null){
            $requirements['Uebung'] = $request->getParam('uebung');
        }
        if($request->getParam('disziplin') !== null){
            $requirements['Disziplin'] = $request->getParam('disziplin');
        }
        if($request->getParam('element') !== null){
            $requirements['Element'] = $request->getParam('element');
        }
        if($request->getParam('skills') !== null){
            $requirements['Faehigkeit'] = $request->getParam('skills');
        }
        if($request->getParam('magien') !== null){
            $requirements['Magie'] = $request->getParam('magien');
        }
        if($request->getParam('magieschule') !== null){
            $requirements['Schule'] = $request->getParam('magieschule');
        }
        if($request->getParam('gruppen') !== null){
            $requirements['Gruppe'] = $request->getParam('gruppen');
        }
        if($request->getParam('klassen') !== null){
            $requirements['Klasse'] = $request->getParam('klassen');
        }
        if($request->getParam('staerke') !== null){
            $requirements['Staerke'] = $request->getParam('staerke');
        }
        if($request->getParam('agilitaet') !== null){
            $requirements['Agilitaet'] = $request->getParam('agilitaet');
        }
        if($request->getParam('ausdauer') !== null){
            $requirements['Ausdauer'] = $request->getParam('ausdauer');
        }
        if($request->getParam('kontrolle') !== null){
            $requirements['Kontrolle'] = $request->getParam('kontrolle');
        }
        if($request->getParam('vorteile') !== null){
            $requirements['Vorteil'] = $request->getParam('vorteile');
        }
        if($request->getParam('nachteile') !== null){
            $requirements['Nachteil'] = $request->getParam('nachteile');
        }
        return $requirements;
    }
    
}
