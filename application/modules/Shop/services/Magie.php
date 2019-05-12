<?php

/**
 * Description of Shop_Service_Magie
 *
 * @author Voß
 */
class Shop_Service_Magie
{

    /**
     * @var Shop_Model_Mapper_SchuleMapper
     */
    private $mapper;
    /**
     * @var Shop_Model_Mapper_MagieMapper
     */
    private $magieMapper;
    /**
     * @var Shop_Service_Requirement
     */
    private $requirementValidator;

    public function __construct ()
    {
        $this->requirementValidator = new Shop_Service_Requirement();
        $this->mapper = new Shop_Model_Mapper_SchuleMapper();
        $this->magieMapper = new Shop_Model_Mapper_MagieMapper();
    }

    /**
     * @param Application_Model_Charakter $charakter
     *
     * @return Shop_Model_Schule[]
     * @throws Exception
     */
    public function getMagieschulenForCharakter (Application_Model_Charakter $charakter)
    {
        $schulen = [];
        $this->requirementValidator->setCharakter($charakter);
        $kostenFaktor = $this->mapper->getMagieschulenKostenFaktor($charakter->getCharakterid());

        $magieschulen = $this->mapper->getAllSchools();
        foreach ($magieschulen as $magieschule) {
            if ($this->mapper->checkIfLearned($charakter->getCharakterid(), $magieschule->getId())) {
                $magieschule->setLearned(true);
                $magieschule->setRequirementList(new Shop_Model_Requirementlist());
            } else {
                $magieschule->setRequirementList($this->mapper->getRequirements($magieschule->getId()));
                $magieschule->setLearned(false);
            }
            if ($this->requirementValidator->validate($magieschule->getRequirementList()) === true) {
                $magieschule->setKosten($kostenFaktor * 50);
                if ($magieschule->getId() === 17) {
                    $magieschule->setKosten(0);
                }
                $schulen[] = $magieschule;
            }
        }
        return $schulen;
    }

    /**
     * @param int $charakterId
     * @param Application_Model_Schule $schule
     *
     * @return Application_Model_Magie[]
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
        $kostenFaktor = $this->mapper->getMagieschulenKostenFaktor($charakter->getCharakterid());

        $fpRequirement = new Shop_Model_Requirement();
        $fpRequirement->setArt('FP')->setRequiredValue($kostenFaktor * 50);
        if ($magieschule->getId() === 17) {
            $fpRequirement->setArt('FP')->setRequiredValue(0);
        }
        $requirements->addRequirement($fpRequirement);
        if ($this->requirementValidator->validate($requirements) === true) {
            $this->mapper->unlockMagieschuleForCharakter($charakter, $magieschule);
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
        if ($this->magieMapper->checkIfLearned($charakter->getCharakterid(), $magie->getId()) === true) {
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
        if ($this->requirementValidator->validate($this->magieMapper->getRequirements($magie->getId())) !== true) {
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
     * @return array
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
            $magie->setLearned($this->magieMapper->checkIfLearned($charakter->getCharakterid(), $magie->getId()));
            if ($this->requirementValidator->validate($this->magieMapper->getRequirements($magie->getId()))) {
                $returnMagien[] = $magie;
            }
        }
        return $returnMagien;
    }

    /**
     * @param Application_Model_Charakter $charakter
     * @param int $magieId
     *
     * @return Shop_Model_Magie
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
