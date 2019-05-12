<?php

/**
 * Description of Shop_Service_Skill
 *
 * @author Voß
 */
class Shop_Service_Skill
{

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

    public function __construct ()
    {
        $this->requirementValidator = new Shop_Service_Requirement();
        $this->mapper = new Shop_Model_Mapper_SkillMapper();
        $this->skillartMapper = new Shop_Model_Mapper_SkillartMapper();
    }

    /**
     * @param Application_Model_Charakter $charakter
     *
     * @return Shop_Model_Skillart[]
     * @throws Exception
     */
    public function getSkillArtenForCharakter (Application_Model_Charakter $charakter)
    {
        $arten = [];
        $this->requirementValidator->setCharakter($charakter);
        $skillarten = $this->skillartMapper->getSkillArten();
        foreach ($skillarten as $skillart) {
            if ($this->skillartMapper->checkIfLearned($charakter->getCharakterid(), $skillart->getId())) {
                $skillart->setLearned(true);
                $skillart->setRequirementList(new Shop_Model_Requirementlist());
            } else {
                $skillart->setRequirementList($this->mapper->getRequirements($skillart->getId()));
                $skillart->setLearned(false);
            }
            if ($this->requirementValidator->validate($skillart->getRequirementList())) {
                $arten[] = $skillart;
            }
        }
        return $arten;
    }

    /**
     * @param int $charakterId
     * @param Application_Model_Skillart $skillart
     *
     * @return Shop_Model_Skill[]
     * @throws Exception
     */
    public function getLearnedSkillBySkillart ($charakterId, Application_Model_Skillart $skillart)
    {
        return $this->mapper->getLearnedSkillsBySkillArtId($skillart->getId(), $charakterId);
    }

    /**
     * @param Application_Model_Charakter $charakter
     * @param int $skillartId
     *
     * @return Shop_Model_Skill[]
     * @throws Exception
     */
    public function getUnlearnedSkillsByArtId (Application_Model_Charakter $charakter, $skillartId)
    {
        $this->requirementValidator->setCharakter($charakter);
        $skills = $this->mapper->getShopSkillsBySkillArtId($skillartId);
        $returnSkills = [];
        foreach ($skills as $skill) {
            if ($this->mapper->checkIfLearned($charakter->getCharakterid(), $skill->getId()) === true) {
                continue;
            }
            if ($this->requirementValidator->validate($this->mapper->getRequirements($skill->getId())) === true) {
                $returnSkills[] = $skill;
            }
        }
        return $returnSkills;
    }

    /**
     * @param Application_Model_Charakter $charakter
     * @param $skillartId
     *
     * @throws Exception
     */
    public function unlockSkillart (Application_Model_Charakter $charakter, $skillartId)
    {
        $this->requirementValidator->setCharakter($charakter);
        $skillart = $this->skillartMapper->getSkillartById($skillartId);
        if ($this->requirementValidator->validate($skillart->getRequirementList()) === true) {
            $this->skillartMapper->unlockSkillartForCharakter($charakter, $skillart);
        }
    }

    /**
     * @param Application_Model_Charakter $charakter
     * @param int $skillId
     *
     * @return array
     * @throws Exception
     */
    public function unlockSkill (Application_Model_Charakter $charakter, $skillId)
    {
        $this->requirementValidator->setCharakter($charakter);
        $skill = $this->mapper->getSkillById($skillId);
        if ($skill->getLernbedingung() !== "Standard") {
            return [
                'failure' => 'Du brauchst einen Lehrer um die Fähigkeit zu lernen.',
            ];
        }
        if ($this->mapper->checkIfLearned($charakter->getCharakterid(), $skill->getId()) === true) {
            return [
                'failure' => 'Fähigkeit wurde schon erlernt!',
            ];
        }
        if ($skill->getFp() > $charakter->getCharakterwerte()->getFp()) {
            return [
                'failure' => 'Du hast nicht genug FP!',
            ];
        }
        if ($this->requirementValidator->validate($this->mapper->getRequirements($skill->getId())) !== true) {
            return [
                'failure' => 'Der Charakter erfüllt nicht alle Voraussetzungen zum Erlernen der Magie!',
            ];
        }
        if ($this->mapper->unlockSkill($charakter, $skill)) {
            return [
                'success' => 'Fähigkeit erlernt!',
            ];
        } else {
            return [
                'failure' => 'Da trat ein Fehler auf, frag mal einen Admin!',
            ];
        }
    }

    /**
     * @param Application_Model_Charakter $charakter
     * @param int $skillId
     *
     * @return Shop_Model_Skill
     * @throws Exception
     */
    public function getSkillById (Application_Model_Charakter $charakter, $skillId)
    {
        $skill = $this->mapper->getSkillById($skillId);
        if (!$this->mapper->checkIfLearned($charakter->getCharakterid(), $skill->getId())) {
            throw new Exception('Charakter hat diese Fähigkeit nicht gelernt');
        } else {
            return $skill;
        }
    }

}
