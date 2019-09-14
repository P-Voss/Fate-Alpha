<?php

/**
 * Description of Requirement
 *
 * @author Voß
 */
class Administration_Service_Requirement
{

    /**
     * @param array $requirements
     *
     * @return Administration_Model_Requirementlist
     */
    public function createRequirementListFromArray (array $requirements)
    {
        $requirementList = new Administration_Model_Requirementlist();
        foreach ($requirements as $validator => $value) {
            if ($value === null) {
                continue;
            }
            $requirement = new Administration_Model_Requirement();
            if (is_array($value)) {
                $requirement->setRequiredValue(implode('|', $value));
            } else {
                $requirement->setRequiredValue($value);
            }
            $requirement->setArt($validator);
            $requirementList->addRequirement($requirement);
        }
        return $requirementList;
    }

    /**
     * @param $infoId
     *
     * @return Administration_Model_Requirementlist
     * @throws Exception
     */
    public function getRequirementListInformation ($infoId)
    {
        $requirementList = new Administration_Model_Requirementlist();
        $mapper = new Administration_Model_Mapper_InformationMapper();
        foreach ($mapper->getRequirements($infoId)->getRequirements() as $requirement) {
            $infoReq = new Administration_Model_Requirement();
            $infoReq->setArt($requirement->getArt());
            $infoReq->setRequiredValue($requirement->getRequiredValue());
            $requirementList->addRequirement($infoReq);
        }
        return $requirementList;
    }

    /**
     * @param $skillId
     *
     * @return Administration_Model_Requirementlist
     * @throws Exception
     */
    public function getRequirementListSkill ($skillId)
    {
        $mapper = new Administration_Model_Mapper_SkillMapper();
        return $mapper->getRequirementsSkill($skillId);
    }

    /**
     * @param $schuleId
     *
     * @return Administration_Model_Requirementlist
     * @throws Exception
     */
    public function getRequirementListSchool ($schuleId)
    {
        $mapper = new Administration_Model_Mapper_SchuleMapper();
        return $mapper->getRequirementListSchool($schuleId);
    }

    /**
     * @param Zend_Controller_Request_Http $request
     *
     * @return array
     */
    public function buildRequirementArray (Zend_Controller_Request_Http $request)
    {
        $requirements = [];
        if ($request->getParam('uebung', 0) > 0) {
            $requirements[Application_Model_Requirements_Types::PRACTICE] = $request->getParam('uebung');
        }
        if ($request->getParam('disziplin', 0) > 0) {
            $requirements[Application_Model_Requirements_Types::DISC] = $request->getParam('disziplin');
        }
        if ($request->getParam('staerke', 0) > 0) {
            $requirements[Application_Model_Requirements_Types::STRENGTH] = $request->getParam('staerke');
        }
        if ($request->getParam('agilitaet', 0) > 0) {
            $requirements[Application_Model_Requirements_Types::AGILITY] = $request->getParam('agilitaet');
        }
        if ($request->getParam('ausdauer', 0) > 0) {
            $requirements[Application_Model_Requirements_Types::ENDURANCE] = $request->getParam('ausdauer');
        }
        if ($request->getParam('kontrolle', 0) > 0) {
            $requirements[Application_Model_Requirements_Types::CONTR] = $request->getParam('kontrolle');
        }
        if ($request->getParam('skills') !== null) {
            //            $requirements['Faehigkeit'] = $request->getParam('skills');
            $requirements[Application_Model_Requirements_Types::SKILL] = implode('|', $request->getParam('skills'));
        }
        if ($request->getParam('skillsAny') !== null) {
            $requirements[Application_Model_Requirements_Types::SKILL_ANY] = implode('|', $request->getParam('skillsAny'));
        }
        if ($request->getParam('skillsIncompatible') !== null) {
            $requirements[Application_Model_Requirements_Types::SKILL_INC] = implode('|', $request->getParam('skillsIncompatible'));
        }
        if ($request->getParam('traitIncompatible') !== null) {
            $requirements[Application_Model_Requirements_Types::TRAIT_INC] = implode('|', $request->getParam('traitIncompatible'));
        }
        if ($request->getParam('magien') !== null) {
            $requirements[Application_Model_Requirements_Types::MAGIC] = $request->getParam('magien');
        }
        if ($request->getParam('magienAny') !== null) {
            $requirements[Application_Model_Requirements_Types::MAGIC_ANY] = implode('|', $request->getParam('magienAny'));
        }
        if ($request->getParam('magieschule') !== null) {
            $requirements[Application_Model_Requirements_Types::SCHOOL] = $request->getParam('magieschule');
        }
        if ($request->getParam('magieschulenAny') !== null) {
            $requirements[Application_Model_Requirements_Types::SCHOOL_ANY] = implode('|', $request->getParam('magieschulenAny'));
        }
        if ($request->getParam('gruppen') !== null) {
            $requirements[Application_Model_Requirements_Types::GROUP] = implode('|', $request->getParam('gruppen'));
        }
        if ($request->getParam('klassen') !== null) {
            $requirements[Application_Model_Requirements_Types::CLASSID] = implode('|', $request->getParam('klassen'));
        }
        if ($request->getParam('trait') !== null) {
            $requirements[Application_Model_Requirements_Types::TRAIT] = implode('|', $request->getParam('traits'));
        }
        if ($request->getParam('characters') !== null) {
            $requirements[Application_Model_Requirements_Types::CHARACTER] = implode('|', $request->getParam('characters'));
        }
        return $requirements;
    }

}
