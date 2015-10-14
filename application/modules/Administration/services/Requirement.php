<?php
/**
 * Description of Requirement
 *
 * @author Voß
 */
class Administration_Service_Requirement {
    
    /**
     * @param array $requirements
     * @return \Administration_Model_Requirementlist
     */
    public function createRequirementListFromArray(array $requirements){
        $requirementList = new Administration_Model_Requirementlist();
        foreach ($requirements as $validator => $value){
            if($value === null){
                continue;
            }
            if(is_array($value)){
                foreach ($value as $subValue){
                    $requirement = new Administration_Model_Requirement();
                    $requirement->setArt($validator);
                    $requirement->setRequiredValue($subValue);
                    $requirementList->addRequirement($requirement);
                }
            }else{
                $requirement = new Administration_Model_Requirement();
                $requirement->setArt($validator);
                $requirement->setRequiredValue($value);
                $requirementList->addRequirement($requirement);
            }
        }
        return $requirementList;
    }
    
    
    public function getRequirementListSkill($skillId) {
        $mapper = new Administration_Model_Mapper_SkillMapper();
        return $mapper->getRequirementsSkill($skillId);
    }
    
}
