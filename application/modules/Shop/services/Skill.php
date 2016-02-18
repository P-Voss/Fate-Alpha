<?php
/**
 * Description of Shop_Service_Skill
 *
 * @author Voß
 */
class Shop_Service_Skill {
    
    /**
     * @var Shop_Model_Mapper_SkillMapper
     */
    private $mapper;
    /**
     * @var Shop_Model_Mapper_SkillartMapper 
     */
    private $skillartMapper;
    /**
     * @var Shop_Service_Requirement
     */
    private $requirementValidator;
    
    public function __construct() {
        $this->requirementValidator = new Shop_Service_Requirement();
        $this->mapper = new Shop_Model_Mapper_SkillMapper();
        $this->skillartMapper = new Shop_Model_Mapper_SkillartMapper();
    }
    
    /**
     * @param Application_Model_Charakter $charakter
     * @return array
     */
    public function getSkillArtenForCharakter(Application_Model_Charakter $charakter) {
        $arten = array();
        $this->requirementValidator->setCharakter($charakter);
        $skillarten = $this->skillartMapper->getSkillArten();
        foreach ($skillarten as $skillart) {
            if($this->skillartMapper->checkIfLearned($charakter->getCharakterid(), $skillart->getId())){
                $skillart->setLearned(true);
                $skillart->setRequirementList(new Shop_Model_Requirementlist());
            }else{
                $skillart->setRequirementList($this->mapper->getRequirements($skillart->getId()));
                $skillart->setLearned(false);
            }
            if($this->requirementValidator->validate($skillart->getRequirementList())){
                $arten[] = $skillart;
            }
        }
        return $arten;
    }
    
    /**
     * @param int $charakterId
     * @param Application_Model_Skillart $skillart
     * @return \Application_Model_Skillart
     */
    public function getLearnedSkillBySkillart($charakterId, Application_Model_Skillart $skillart) {
        $skills = $this->mapper->getSkillsBySkillArtId($skillart->getId());
        foreach($skills as $skill) {
            if($this->mapper->checkIfLearned($charakterId, $skill->getId())){
                $skillart->addSkill($skill);
            }
        }
        return $skillart;
    }
    
    /**
     * @param Application_Model_Charakter $charakter
     * @param int $skillartId
     * @return array
     */
    public function getUnlearnedSkillsByArtId(Application_Model_Charakter $charakter, $skillartId) {
        $this->requirementValidator->setCharakter($charakter);
        $skills = $this->mapper->getSkillsBySkillArtId($skillartId);
        $returnSkills = array();
        foreach ($skills as $skill){
            if($this->mapper->checkIfLearned($charakter->getCharakterid(), $skill->getId()) === true){
                continue;
            }
            if($this->requirementValidator->validate($this->mapper->getRequirements($skill->getId())) === true){
                $returnSkills[] = $skill;
            }
        }
        return $returnSkills;
    }
    
    
    public function unlockSkillart(Application_Model_Charakter $charakter, $skillartId) {
        $this->requirementValidator->setCharakter($charakter);
        $skillart = $this->skillartMapper->getSkillartById($skillartId);
        if($this->requirementValidator->validate($skillart->getRequirementList()) === true){
            $this->skillartMapper->unlockSkillartForCharakter($charakter, $skillart);
        }
    }
    
    /**
     * @param Application_Model_Charakter $charakter
     * @param int $skillId
     * @return array
     */
    public function unlockSkill(Application_Model_Charakter $charakter, $skillId) {
        $this->requirementValidator->setCharakter($charakter);
        $skill = $this->mapper->getSkillById($skillId);
        if($this->mapper->checkIfLearned($charakter->getCharakterid(), $skill->getId()) === true){
            return array(
                'failure' => 'Fähigkeit wurde schon erlernt!',
            );
        }
        if($skill->getFp() > $charakter->getCharakterwerte()->getFp()){
            return array(
                'failure' => 'Du hast nicht genug FP!'
            );
        }
        if($this->requirementValidator->validate($this->mapper->getRequirements($skill->getId())) !== true){
            return array(
                'failure' => 'Der Charakter erfüllt nicht alle Voraussetzungen zum Erlernen der Magie!',
            );
        }
        if($this->mapper->unlockSkill($charakter, $skill)){
            return array(
                'success' => 'Fähigkeit erlernt!',
            );
        }else{
            return array(
                'failure' => 'Da trat ein Fehler auf, frag mal einen Admin!',
            );
        }
    }
    
    /**
     * @param Application_Model_Charakter $charakter
     * @param int $skillId
     * @return Shop_Model_Skill
     */
    public function getSkillById(Application_Model_Charakter $charakter, $skillId) {
        $skill = $this->mapper->getSkillById($skillId);
        if($this->mapper->checkIfLearned($charakter->getCharakterid(), $skill->getId()) === false){
            return array(
                'failure' => 'Charakter beherrscht die Fähigkeit nicht!',
            );
        }else{
            return $skill;
        }
    }
    
}
