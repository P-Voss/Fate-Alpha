<?php

/**
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_Service_Skill {
    
    /**
     * @var Administration_Model_Mapper_SkillMapper
     */
    private $mapper;
    /**
     * @var Administration_Service_Requirement
     */
    private $requirementService;
    
    public function __construct() {
        $this->mapper = new Administration_Model_Mapper_SkillMapper();
        $this->requirementService = new Administration_Service_Requirement();
    }
    
    public function getMagieList() {
        return $this->mapper->getMagien();
    }
    
    public function getSkillList() {
        return $this->mapper->getSkills();
    }
    
    public function getMagieById($magieId) {
        $magie = $this->mapper->getMagieById($magieId);
        $magie->setRequirementList($this->mapper->getRequirementsMagie($magieId));
        return $magie;
    }
    
    public function editMagie(Zend_Controller_Request_Http $request, $userId) {
        $magie = new Administration_Model_Magie();
        $date = new DateTime();
        $element = new Administration_Model_Element();
        $element->setId($request->getPost('element'));
        $schule = new Administration_Model_Schule();
        $schule->setId($request->getPost('magieschule'));
        
        $magie->setId($request->getPost('magieId'));
        $magie->setEditDate($date->format('Y-m-d H:i:s'));
        $magie->setEditor($userId);
        $magie->setBezeichnung($request->getPost('name'));
        $magie->setBeschreibung($request->getPost('beschreibung'));
        $magie->setFp($request->getPost('fp'));
        $magie->setElement($element);
        $magie->setSchule($schule);
        $magie->setPrana($request->getPost('prana'));
        $magie->setStufe($request->getPost('stufe'));
        $magie->setRang($request->getPost('rang'));
        $magie->setLernbedingung($request->getPost('lernbedingung'));
        
        $magie->setRequirementList(
            $this->requirementService->createRequirementListFromArray(
                $this->buildRequirementArray($request)
            )
        );
        $result = $this->mapper->updateMagie($magie);
        $this->mapper->deleteDependencies($magie);
        $this->mapper->setDependencies($magie);
    }
    
    public function createMagie(Zend_Controller_Request_Http $request, $userId) {
        $magie = new Administration_Model_Magie();
        $date = new DateTime();
        $element = new Administration_Model_Element();
        $element->setId($request->getPost('element'));
        $schule = new Administration_Model_Schule();
        $schule->setId($request->getPost('magieschule'));
        
        $magie->setCreateDate($date->format('Y-m-d H:i:s'));
        $magie->setCreator($userId);
        $magie->setBezeichnung($request->getPost('name'));
        $magie->setBeschreibung($request->getPost('beschreibung'));
        $magie->setFp($request->getPost('fp'));
        $magie->setElement($element);
        $magie->setSchule($schule);
        $magie->setPrana($request->getPost('prana'));
        $magie->setStufe($request->getPost('stufe'));
        $magie->setRang($request->getPost('rang'));
        $magie->setLernbedingung($request->getPost('lernbedingung'));
        
        $magie->setRequirementList(
            $this->requirementService->createRequirementListFromArray(
                $this->buildRequirementArray($request)
            )
        );
        $magie->setId($this->mapper->createMagie($magie));
        $this->mapper->deleteDependencies($magie);
        $this->mapper->setDependencies($magie);
    }
    
    public function getSkillById($skillId) {
        $skill = $this->mapper->getSkillById($skillId);
        $skill->setRequirementList($this->requirementService->getRequirementListSkill($skillId));
        return $skill;
    }
    
    public function editSkill(Zend_Controller_Request_Http $request, $userId) {
        $skill = new Administration_Model_Skill();
        $date = new DateTime();
        $skill->setEditDate($date->format('Y-m-d H:i:s'));
        $skill->setEditor($userId);
        $skill->setId($request->getPost('skillId'));
        $skill->setBezeichnung($request->getPost('name'));
        $skill->setBeschreibung($request->getPost('beschreibung'));
        $skill->setFp($request->getPost('fp'));
        $skill->setSkillArt($request->getPost('skillart'));
        $skill->setRang($request->getPost('rang'));
        $skill->setUebung($request->getPost('uebung'));
        $skill->setDisziplin($request->getPost('disziplin'));
        
        $skill->setRequirementList(
            $this->requirementService->createRequirementListFromArray(
                $this->buildRequirementArray($request)
            )
        );
        
        $this->mapper->updateSkill($skill);
    }
    
    public function createSkill(Zend_Controller_Request_Http $request, $userId) {
        $skill = new Administration_Model_Skill();
        $date = new DateTime();
        $skill->setCreateDate($date->format('Y-m-d H:i:s'));
        $skill->setCreator($userId);
        $skill->setBezeichnung($request->getPost('name'));
        $skill->setBeschreibung($request->getPost('beschreibung'));
        $skill->setFp($request->getPost('fp'));
        $skill->setSkillArt($request->getPost('skillart'));
        $skill->setRang($request->getPost('rang'));
        $skill->setUebung($request->getPost('uebung'));
        $skill->setDisziplin($request->getPost('disziplin'));
        
        $skill->setRequirementList(
            $this->requirementService->createRequirementListFromArray(
                $this->buildRequirementArray($request)
            )
        );
        $this->mapper->createSkill($skill);
    }
    
    /**
     * @param Zend_Controller_Request_Http $request
     * @return array
     */
    public function buildRequirementArray(Zend_Controller_Request_Http $request) {
        $requirements = array();
//        if($request->getParam('fp') !== null){
//            $requirements['FP'] = $request->getParam('fp');
//        }
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
        if($request->getParam('skillsIncompatible') !== null){
            $requirements['FaehigkeitInc'] = $request->getParam('skillsIncompatible');
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
