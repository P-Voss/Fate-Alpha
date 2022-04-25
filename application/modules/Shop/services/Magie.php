<?php

namespace Shop\Services;

use Application_Model_Charakter;
use Application_Model_Schule;
use Application_Service_Charakter;
use Exception;
use Shop\Models\Mappers\MagieMapper;
use Shop\Models\Mappers\SchuleMapper;
use Shop\Models\Requirementlist;
use Shop\Models\Requirement as RequirementModel;
use Shop\Models\Schule;

/**
 * Class Magie
 * @package Shop\Services
 */
class Magie
{

    /**
     * @var SchuleMapper
     */
    private $mapper;
    /**
     * @var MagieMapper
     */
    private $magieMapper;
    /**
     * @var Requirement
     */
    private $requirementValidator;

    
    public function __construct ()
    {
        $this->requirementValidator = new Requirement();
        $this->mapper = new SchuleMapper();
        $this->magieMapper = new MagieMapper();
    }

    /**
     * @param Application_Model_Charakter $charakter
     *
     * @return Schule[]
     */
    public function getSchoolsWithoutOrganization (Application_Model_Charakter $charakter)
    {
        $schulen = [];
        $this->requirementValidator->setCharakter($charakter);
        $schoolCost = $charakter->getMagischoolId() !== 0 ? 40 : 0;
        try {
            $magieschulen = $this->mapper->getAllSchools();
            foreach ($magieschulen as $magieschule) {
                if ($magieschule->getMagiOrganization() > 0) {
                    continue;
                }
                $characterService = new Application_Service_Charakter();
                $charakter->setMagieStufe(
                    $characterService->getMagieStufe(
                        $charakter->getCharakterid(),
                        $magieschule->getId()
                    )
                );
                if ($charakter->getMagischoolId() === $magieschule->getId()) {
                    $magieschule->setLearned(true);
                    $magieschule->setRequirementList(new Requirementlist());
                } else {
                    $magieschule->setRequirementList($this->mapper->getRequirements($magieschule->getId()));
                    $magieschule->setLearned(false);
                }

                if (!$this->requirementValidator->validate($magieschule->getRequirementList())) {
                    continue;
                }
                $magieschule->setKosten($schoolCost);
                $schulen[] = $magieschule;
            }
            return $schulen;
        } catch (Exception $exception) {
            return [];
        }
    }

    /**
     * @param Application_Model_Charakter $charakter
     *
     * @return Schule[]
     */
    public function getSchoolsFromOrganization (Application_Model_Charakter $charakter)
    {
        $schulen = [];
        $this->requirementValidator->setCharakter($charakter);

        $schoolCost = $charakter->getMagischoolId() !== 0 ? 40 : 0;
        try {
            $magieschulen = $this->mapper->getAllSchools();
            foreach ($magieschulen as $magieschule) {
                if ((int) $charakter->getMagiOrganization() !== $magieschule->getMagiOrganization() || $magieschule->getMagiOrganization() === 0) {
                    continue;
                }
                $characterService = new Application_Service_Charakter();
                $charakter->setMagieStufe(
                    $characterService->getMagieStufe(
                        $charakter->getCharakterid(),
                        $magieschule->getId()
                    )
                );
                if ($charakter->getMagischoolId() === $magieschule->getId()) {
                    $magieschule->setLearned(true);
                    $magieschule->setRequirementList(new Requirementlist());
                } else {
                    $magieschule->setRequirementList($this->mapper->getRequirements($magieschule->getId()));
                    $magieschule->setLearned(false);
                }

                if (
                    count($this->getUnlearnedMagienBySchulId($charakter, $magieschule->getId())) === 0
                    && $magieschule->getLearned() === false
                ) {
                    continue;
                }

                if (!$this->requirementValidator->validate($magieschule->getRequirementList())) {
                    continue;
                }
                $magieschule->setKosten($schoolCost);
                $schulen[] = $magieschule;
            }
            return $schulen;
        } catch (Exception $exception) {
            return [];
        }
    }

    /**
     * @param $characterId
     *
     * @return Application_Model_Schule[]
     * @throws Exception
     */
    public function getSchoolsByCharacter ($characterId)
    {
        $schoolMapper = new \Application_Model_Mapper_SchuleMapper();
        return $schoolMapper->getSchoolsByCharacter($characterId);
    }

    /**
     * @param $organizationId
     *
     * @return Application_Model_Schule[]
     * @throws Exception
     */
    public function getSchoolByOrganization ($organizationId)
    {
        $schoolMapper = new \Application_Model_Mapper_SchuleMapper();
        return $schoolMapper->getSchoolByOrganization($organizationId);
    }

    /**
     * @param int $charakterId
     * @param Application_Model_Schule $schule
     *
     * @return \Application_Model_Magie[]
     */
    public function getLearnedMagieBySchule ($charakterId, Application_Model_Schule $schule)
    {
        try {
            $learnedMagie = [];
            $magien = $this->magieMapper->getMagienByMagieschuleId($schule->getId());
            foreach ($magien as $magie) {
                if ($this->magieMapper->checkIfLearned($charakterId, $magie->getId())) {
                    $learnedMagie[] = $magie;
                }
            }
            return $learnedMagie;
        } catch (Exception $exception) {
            return [];
        }
    }

    /**
     * @param Application_Model_Charakter $charakter
     * @param int $schuleId
     *
     * @throws Exception
     */
    public function unlockSchool (Application_Model_Charakter $charakter, $schuleId)
    {
        $this->requirementValidator->setCharakter($charakter);
        $magieschule = $this->mapper->getMagieschuleById($schuleId);
        $requirements = $this->mapper->getRequirements($magieschule->getId());

        $kosten = 0;
        if ($charakter->getMagischoolId() !== 0) {
            $kosten = 40;
        }

        $organizationRequirement = new RequirementModel();
        $organizationRequirement->setArt('Organization')->setRequiredValue($magieschule->getMagiOrganization());

        $fpRequirement = new RequirementModel();
        $fpRequirement->setArt('FP')->setRequiredValue($kosten);
        $requirements->addRequirement($fpRequirement);
        $requirements->addRequirement($organizationRequirement);

        if ($this->requirementValidator->validate($requirements)) {
            $this->mapper->unlockMagieschuleForCharakter($charakter, $magieschule, $kosten);
        }
    }

    /**
     * @param Application_Model_Charakter $charakter
     * @param int $magieId
     *
     * @return array
     * @throws Exception
     */
    public function unlockMagie (Application_Model_Charakter $charakter, $magieId)
    {
        $this->requirementValidator->setCharakter($charakter);
        $magie = $this->magieMapper->getMagieById($magieId);
        if ($magie->getLernbedingung() !== "Standard") {
            return [
                'failure' => 'Du brauchst einen Lehrer um die Magie zu lernen.',
            ];
        }
        if ($this->magieMapper->checkIfLearned($charakter->getCharakterid(), $magie->getId())) {
            return [
                'failure' => 'Magie wurde schon erlernt!',
            ];
        }

        if ((int)$magie->getElement()->getId() === (int)$charakter->getNaturElement()->getId()) {
            $magie->setFp($magie->getFp() * 0.9);
        }
        if ($magie->getFp() > $charakter->getCharakterwerte()->getFp()) {
            return [
                'failure' => 'Du hast nicht genug FP!',
            ];
        }
        if (!$this->requirementValidator->validate($this->magieMapper->getRequirements($magie->getId()))) {
            return [
                'failure' => 'Der Charakter erfüllt nicht alle Voraussetzungen zum Erlernen der Magie!',
            ];
        }
        if ($this->magieMapper->unlockMagie($charakter, $magie)) {
            return [
                'success' => 'Magie erlernt!',
            ];
        } else {
            return [
                'failure' => 'Da trat ein Fehler auf, frag mal einen Admin!',
            ];
        }
    }

    /**
     * @param Application_Model_Charakter $charakter
     * @param int $magieschuleId
     *
     * @return \Shop\Models\Magie[]
     * @throws Exception
     */
    public function getUnlearnedMagienBySchulId (Application_Model_Charakter $charakter, $magieschuleId)
    {
        $this->requirementValidator->setCharakter($charakter);
        $magien = $this->magieMapper->getShopMagienByMagieschuleId($magieschuleId);
        $returnMagien = [];
        foreach ($magien as $magie) {
            if ($magie->getElement()->getId() === $charakter->getNaturElement()->getId()) {
                $magie->setFp($magie->getFp() * 0.9);
            }
            if ($this->magieMapper->checkIfLearned($charakter->getCharakterid(), $magie->getId())) {
                continue;
            }
            $magie->setLearned(false);
            if (!$this->requirementValidator->validate($this->magieMapper->getRequirements($magie->getId()))) {
//                continue;
            }
            $returnMagien[] = $magie;
        }
        return $returnMagien;
    }

    /**
     * @param Application_Model_Charakter $charakter
     * @param int $magieId
     *
     * @return \Shop\Models\Magie
     * @throws Exception
     */
    public function getMagieById (Application_Model_Charakter $charakter, $magieId)
    {
        $magie = $this->magieMapper->getMagieById($magieId);
        if (!$this->magieMapper->checkIfLearned($charakter->getCharakterid(), $magie->getId())) {
            throw new Exception('Skill has not been learned');
        } else {
            return $magie;
        }
    }

}
