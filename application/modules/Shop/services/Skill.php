<?php

namespace Shop\Services;


use Application_Model_Charakter;
use Exception;
use Shop\Models\Mappers\SkillartMapper;
use Shop\Models\Mappers\SkillMapper;
use Shop\Models\Skillart;
use Shop\Models\Skill as SkillModel;

/**
 * Class Skill
 * @package Shop\Services
 */
class Skill
{

    /**
     * @var SkillMapper
     */
    private $mapper;
    /**
     * @var SkillartMapper
     */
    private $skillartMapper;
    /**
     * @var Requirement
     */
    private $requirementValidator;

    /**
     * Skill constructor.
     */
    public function __construct ()
    {
        $this->requirementValidator = new Requirement();
        $this->mapper = new SkillMapper();
        $this->skillartMapper = new SkillartMapper();
    }

    /**
     * @param Application_Model_Charakter $charakter
     *
     * @return Skillart[]
     * @throws \Exception
     */
    public function getSkillArtenForCharakter (Application_Model_Charakter $charakter)
    {
        $skillarten = $this->skillartMapper->getSkillArten();
        return $skillarten;
    }

    /**
     * @param int $charakterId
     * @param Skillart $skillart
     *
     * @return SkillModel[]
     * @throws Exception
     */
    public function getLearnedSkillBySkillart ($charakterId, Skillart $skillart)
    {
        return $this->mapper->getLearnedSkillsBySkillArtId($skillart->getId(), $charakterId);
    }

    /**
     * @param Application_Model_Charakter $charakter
     * @param int $skillartId
     *
     * @return SkillModel[]
     * @throws Exception
     */
    public function getUnlearnedSkillsByArtId (Application_Model_Charakter $charakter, $skillartId)
    {
        $this->requirementValidator->setCharakter($charakter);
        $skills = $this->mapper->getShopSkillsBySkillArtId($skillartId);
        $returnSkills = [];
        foreach ($skills as $skill) {
            if ($this->mapper->checkIfLearned($charakter->getCharakterid(), $skill->getId())) {
                continue;
            }
            if ($this->requirementValidator->validate($this->mapper->getRequirements($skill->getId()))) {
                $returnSkills[] = $skill;
            }
        }
        return $returnSkills;
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
     * @return SkillModel
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
