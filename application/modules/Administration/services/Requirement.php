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
     * @return \Administration_Model_Requirementlist
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
                $requirement->setRequiredValue(implode(':', $value));
            } else {
                $requirement->setRequiredValue($value);
            }
            $requirement->setArt($validator);
            $requirementList->addRequirement($requirement);
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
     * @param Zend_Controller_Request_Http $request
     *
     * @return array
     */
    public function buildRequirementArray (Zend_Controller_Request_Http $request)
    {
        $requirements = [];
        if ($request->getParam('uebung', 0) > 0) {
            $requirements['Uebung'] = $request->getParam('uebung');
        }
        if ($request->getParam('disziplin', 0) > 0) {
            $requirements['Disziplin'] = $request->getParam('disziplin');
        }
        if ($request->getParam('staerke', 0) > 0) {
            $requirements['Staerke'] = $request->getParam('staerke');
        }
        if ($request->getParam('agilitaet', 0) > 0) {
            $requirements['Agilitaet'] = $request->getParam('agilitaet');
        }
        if ($request->getParam('ausdauer', 0) > 0) {
            $requirements['Ausdauer'] = $request->getParam('ausdauer');
        }
        if ($request->getParam('kontrolle', 0) > 0) {
            $requirements['Kontrolle'] = $request->getParam('kontrolle');
        }
        if ($request->getParam('skills') !== null) {
            $requirements['Faehigkeit'] = $request->getParam('skills');
        }
        if ($request->getParam('skillsAny') !== null) {
            $requirements['FaehigkeitAny'] = implode('|', $request->getParam('skillsAny'));
        }
        if ($request->getParam('skillsIncompatible') !== null) {
            $requirements['FaehigkeitInc'] = implode('|', $request->getParam('skillsIncompatible'));
        }
        if ($request->getParam('traitIncompatible') !== null) {
            $requirements['traitInc'] = implode('|', $request->getParam('traitIncompatible'));
        }
        if ($request->getParam('magien') !== null) {
            $requirements['Magie'] = $request->getParam('magien');
        }
        if ($request->getParam('magienAny') !== null) {
            $requirements['MagieAny'] = implode('|', $request->getParam('magienAny'));
        }
        if ($request->getParam('magieschule') !== null) {
            $requirements['Schule'] = $request->getParam('magieschule');
        }
        if ($request->getParam('gruppen') !== null) {
            $requirements['Gruppe'] = implode('|', $request->getParam('gruppen'));
        }
        if ($request->getParam('klassen') !== null) {
            $requirements['Klasse'] = implode('|', $request->getParam('klassen'));
        }
        if ($request->getParam('trait') !== null) {
            $requirements['Trait'] = $request->getParam('trait');
        }
        return $requirements;
    }

}
