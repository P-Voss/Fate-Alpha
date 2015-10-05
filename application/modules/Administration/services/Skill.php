<?php

/**
 * Description of Nachteil
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
        return $this->mapper->getMagieById($magieId);
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
                array(
                    'Schule' => $request->getPost('magieschule'),
                    'FP' => $request->getPost('fp'),
                    'Element' => $request->getPost('element'),
                    'Magie' => $request->getPost('magien'),
                )
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
                array(
                    'Schule' => $request->getPost('magieschule'),
                    'FP' => $request->getPost('fp'),
                    'Element' => $request->getPost('element'),
                    'Magie' => $request->getPost('magien'),
                )
            )
        );
        $magie->setId($this->mapper->createMagie($magie));
        $this->mapper->deleteDependencies($magie);
        $this->mapper->setDependencies($magie);
    }
    
    public function getSkillById($skillId) {
        return $this->mapper->getSkillById($skillId);
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
                array(
                    'FP' => $request->getPost('fp'),
                    'Uebung' => $request->getPost('fp'),
                    'Disziplin' => $request->getPost('disziplin'),
                    'Faehigkeit' => $request->getPost('skills'),
                )
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
                array(
                    'FP' => $request->getPost('fp'),
                    'Uebung' => $request->getPost('fp'),
                    'Disziplin' => $request->getPost('disziplin'),
                    'Faehigkeit' => $request->getPost('skills'),
                )
            )
        );
        $this->mapper->createSkill($skill);
    }
    
}
