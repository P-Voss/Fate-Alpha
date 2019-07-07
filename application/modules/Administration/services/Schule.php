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
        $schule->setMagiOrganization($request->getPost('MagiOrganization'));

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
        $schule->setMagiOrganization($request->getPost('MagiOrganization'));
        
        $schule->setRequirementList(
            $this->requirementService->createRequirementListFromArray(
                $this->requirementService->buildRequirementArray($request)
            )
        );
        $this->mapper->deleteDependencies($schule);
        $this->mapper->setDependencies($schule);
        return $this->mapper->updateSchule($schule);
    }

    /**
     * @param $schuleId
     *
     * @return Administration_Model_Schule
     * @throws Exception
     */
    public function getSchuleById($schuleId) {
        $school = $this->mapper->getSchuleById($schuleId);
        $school->setRequirementList($this->requirementService->getRequirementListSchool($schuleId));
        return $school;
    }
    
    public function deleteSchule(Zend_Controller_Request_Http $request) {
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
