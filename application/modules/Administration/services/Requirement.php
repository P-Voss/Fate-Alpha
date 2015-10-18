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
            $requirement = new Administration_Model_Requirement();
            if(is_array($value)){
                    $requirement->setRequiredValue(implode(':', $value));
            }else{
                $requirement->setRequiredValue($value);
            }
            $requirement->setArt($validator);
            $requirementList->addRequirement($requirement);
        }
        return $requirementList;
    }
    
    
    public function getRequirementListSkill($skillId) {
        $mapper = new Administration_Model_Mapper_SkillMapper();
        return $mapper->getRequirementsSkill($skillId);
    }
    
}
