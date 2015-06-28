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
    
    public function __construct() {
        $this->mapper = new Administration_Model_Mapper_SkillMapper();
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
        $magie->setEditDate($date->format('Y-m-d H:i:s'));
        $magie->setEditor($userId);
        $magie->setBezeichnung($request->getPost('name'));
        $magie->setFp($request->getPost('fp'));
        $magie->setElement($request->getPost('element'));
        $magie->setSchule($request->getPost('magieschule'));
        $magie->setPrana($request->getPost('prana'));
        $magie->setStufe($request->getPost('stufe'));
        $magie->setRang($request->getPost('rang'));
        $magie->setLernbedingung($request->getPost('lernbedingung'));
        
        $dependencies = $request->getPost('magien');
        $this->mapper->deleteDependencies($magie);
        $result = $this->mapper->updateMagie($magie);
        $this->mapper->setDependencies($dependencies, $magie);
    }
    
    public function createMagie(Zend_Controller_Request_Http $request, $userId) {
        $magie = new Administration_Model_Magie();
        $date = new DateTime();
        $magie->setCreateDate($date->format('Y-m-d H:i:s'));
        $magie->setCreator($userId);
        $magie->setBezeichnung($request->getPost('name'));
        $magie->setFp($request->getPost('fp'));
        $magie->setElement($request->getPost('element'));
        $magie->setSchule($request->getPost('magieschule'));
        $magie->setPrana($request->getPost('prana'));
        $magie->setStufe($request->getPost('stufe'));
        $magie->setRang($request->getPost('rang'));
        $magie->setLernbedingung($request->getPost('lernbedingung'));
        
        $dependencies = $request->getPost('magien');
        $magie->setId($this->mapper->createMagie($magie));
        $this->mapper->deleteDependencies($magie);
        $this->mapper->setDependencies($dependencies, $magie);
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
        
        $this->mapper->updateSkill($magie);
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
        
        $this->mapper->createSkill($skill);
    }
    
}
