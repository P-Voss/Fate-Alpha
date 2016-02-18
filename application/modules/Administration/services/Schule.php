<?php

/**
 * Description of Schule
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_Service_Schule {
    
    /**
     * @var Administration_Model_Mapper_SchuleMapper
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
        $this->mapper = new Administration_Model_Mapper_SchuleMapper();
        $this->erstellungMapper = new Administration_Model_Mapper_ErstellungMapper();
        $this->requirementService = new Administration_Service_Requirement();
    }
    
    public function getSchulList() {
        return $this->mapper->getAllSchools();
    }
    
    public function createSchule(Zend_Controller_Request_Http $request, $userId) {
        $schule = new Administration_Model_Schule();
        $date = new DateTime();
        $schule->setCreateDate($date->format('Y-m-d H:i:s'));
        $schule->setBezeichnung($request->getPost('name'));
        $schule->setBeschreibung($request->getPost('beschreibung'));
        $schule->setCreator($userId);
        
        $schule->setRequirementList(
            $this->requirementService->createRequirementListFromArray(
                array(
                    'Staerke' => $request->getPost('staerke'),
                    'Agilitaet' => $request->getPost('agilitaet'),
                    'Ausdauer' => $request->getPost('ausdauer'),
                    'Uebung' => $request->getPost('uebung'),
                    'Kontrolle' => $request->getPost('kontrolle'),
                    'Disziplin' => $request->getPost('disziplin'),
                    'Faehigkeit' => $request->getPost('skills'),
                    'Gruppe' => $request->getPost('gruppen'),
                    'Klasse' => $request->getPost('klassen'),
                )
            )
        );
        $schule->setId($this->mapper->createSchule($schule));
        $this->mapper->setDependencies($schule);
    }
    
    public function editSchule(Zend_Controller_Request_Http $request, $userId) {
        $schule = new Administration_Model_Schule();
        $date = new DateTime();
        $schule->setId($request->getPost('schuleId'));
        $schule->setEditDate($date->format('Y-m-d H:i:s'));
        $schule->setBezeichnung($request->getPost('name'));
        $schule->setBeschreibung($request->getPost('beschreibung'));
        $schule->setEditor($userId);
        
        $schule->setRequirementList(
            $this->requirementService->createRequirementListFromArray(
                array(
                    'Staerke' => $request->getPost('staerke'),
                    'Agilitaet' => $request->getPost('agilitaet'),
                    'Ausdauer' => $request->getPost('ausdauer'),
                    'Uebung' => $request->getPost('uebung'),
                    'Kontrolle' => $request->getPost('kontrolle'),
                    'Disziplin' => $request->getPost('disziplin'),
                    'Faehigkeit' => $request->getPost('skills'),
                    'Gruppe' => $request->getPost('gruppen'),
                    'Klasse' => $request->getPost('klassen'),
                )
            )
        );
        $this->mapper->deleteDependencies($schule);
        $this->mapper->setDependencies($schule);
        return $this->mapper->updateSchule($schule);
    }
    
    public function getSchuleById($schuleId) {
        return $this->mapper->getSchuleById($schuleId);
    }
    
    public function deleteSchule(Zend_Controller_Request_Http $request) {
        return $this->mapper->deleteNews($request->getPost('schulId'));
    }
    
}
