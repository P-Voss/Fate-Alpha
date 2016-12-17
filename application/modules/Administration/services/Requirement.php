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
    
    /**
     * @param Zend_Controller_Request_Http $request
     * @return array
     */
    public function buildRequirementArray(Zend_Controller_Request_Http $request) {
        $requirements = array();
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
        if($request->getParam('skillsAny') !== null){
            $requirements['FaehigkeitAny'] = implode('|', $request->getParam('skillsAny'));
        }
        if($request->getParam('skillsIncompatible') !== null){
            $requirements['FaehigkeitInc'] = $request->getParam('skillsIncompatible');
        }
        if($request->getParam('magien') !== null){
            $requirements['Magie'] = $request->getParam('magien');
        }
        if($request->getParam('magienAny') !== null){
            $requirements['MagieAny'] = implode('|', $request->getParam('magienAny'));
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
