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
    
    
    public function getSkillArtenForCharakter(Application_Model_Charakter $charakter) {
        $arten = array();
        $this->requirementValidator->setCharakter($charakter);
        $skillarten = $this->skillartMapper->getSkillArten();
        foreach ($skillarten as $skillart) {
            
        }
    }
    
}
