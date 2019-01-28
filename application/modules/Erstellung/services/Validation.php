<?php

/**
 * Description of Validation
 *
 * @author Voß
 */
class Erstellung_Service_Validation {

    /**
     * @var Erstellung_Model_Mapper_TraitMapper
     */
    private $traitMapper;
    /**
     * @var Erstellung_Model_Mapper_KlassenMapper
     */
    private $classMapper;
    /**
     * @var Erstellung_Model_Mapper_AttributeMapper
     */
    private $attributeMapper;


    public function __construct ()
    {
        $this->traitMapper = new Erstellung_Model_Mapper_TraitMapper();
        $this->attributeMapper = new Erstellung_Model_Mapper_AttributeMapper();
        $this->classMapper = new Erstellung_Model_Mapper_KlassenMapper();
    }

    /**
     * @param Erstellung_Model_Character $character
     *
     * @return bool
     * @throws Exception
     */
    public function validateCharacter (Erstellung_Model_Character $character)
    {
        if (!$this->isBetween(strlen($character->getVorname()), 2, 30)) {
            throw new Exception('Vorname muss zwischen 2 und 30 Zeichen lang sein');
        }
        if (!$this->isBetween(strlen($character->getNachname()), 2, 30)) {
            throw new Exception('Nachname muss zwischen 2 und 30 Zeichen lang sein');
        }
        if (!$this->isBetween(date_diff(new DateTime(), new DateTime($character->getGeburtsdatum()))->y, 12, 90))
        {
            throw new Exception('Charakter muss zwischen 12 und 90 Jahre alt sein.');
        }
        if (!$this->isBetween($character->getSize(), 130, 210)) {
            throw new Exception('Charakter muss zwischen 12 und 90 Jahre alt sein.');
        }
        if (!in_array($character->getGeschlecht(), ['m', 'w'])) {
            throw new Exception('Mann oder Frau?');
        }
        if (!in_array($character->getSexualitaet(), ['Heterosexuell', 'Bisexuell', 'Homosexuell'])) {
            throw new Exception('Die sexuelle Orientierung fehlt.');
        }
        if (!in_array($character->getWohnort(), ['City', 'Kizaka', 'Kurokizaka', 'Miyama-Nord', 'Miyama-Sued', 'Miyamachou'])) {
            throw new Exception('Wo wohnt der Charakter?');
        }
        if (!$this->validateAttributes($character)) {
            throw new Exception('Fehler bei den Eigenschaften.');
        }
        if (!$this->validateSubclass($character)) {
            throw new Exception('Fehler bei der Klassenwahl.');
        }
        if (!$this->validateTraits($character)) {
            throw new Exception('Fehler bei der Auswahl der Traits.');
        }
        if (!$this->validatePoints($character)) {
            throw new Exception('Zu viele Punkte ausgegeben.');
        }
        return true;
    }

    /**
     * @param Erstellung_Model_Character $character
     *
     * @return bool
     */
    private function validatePoints(Erstellung_Model_Character $character) {
        $costs = [];
        $traitIds = array_map(function (Erstellung_Model_Trait $trait) {
            return $trait->getTraitId();
        }, $character->getTraits());
        try {
            foreach ($traitIds as $traitId) {
                $costs[] = $this->traitMapper->getTraitById($traitId)->getKosten();
            }
            $costs[] = $this->classMapper->getKlasseById($character->getKlasse()->getId())->getKosten();
            if ($character->getMagiccircuit()->getId() > 0) {
                $costs[] = $this->attributeMapper->getCircuit($character->getMagiccircuit()->getId())->getKosten();
            }
            $costs[] = $this->attributeMapper->getLuck($character->getLuck()->getId())->getKosten();
            $costs[] = $this->attributeMapper->getOdo($character->getOdo()->getId())->getKosten();

            return array_sum($costs) <= 30;
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * @param Erstellung_Model_Character $character
     *
     * @return bool
     */
    private function validateSubclass(Erstellung_Model_Character $character) {
        $requirementValidator = new Erstellung_Service_Requirement($character);
        $mapper = new Application_Model_Mapper_ErstellungMapper();
        try {
            return $requirementValidator->validate($mapper->getUnterklassenRequirements($character->getKlasse()->getId()));
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param Erstellung_Model_Character $character
     *
     * @return bool
     */
    private function validateTraits(Erstellung_Model_Character $character) {
        $traitIds = array_map(function (Erstellung_Model_Trait $trait) {
            return $trait->getTraitId();
        }, $character->getTraits());
        try {
            foreach ($traitIds as $traitId) {
                foreach ($this->traitMapper->getIncompatibleTraits($traitId) as $incompatibleTrait) {
                    if (in_array($incompatibleTrait->getTraitId(), $traitIds)) {
                        return false;
                    }
                }
            }
            return true;
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * @param Erstellung_Model_Character $character
     *
     * @return bool
     */
    private function validateAttributes(Erstellung_Model_Character $character) {
        if (!(
            $this->isBetween($character->getLuck()->getId(), 3, 6)
            && count($character->getTraits()) === 5
            && $this->isBetween($character->getOdo()->getId(), 3, 6)
            && $this->isBetween($character->getMagiccircuit()->getId(), 0, 5)
            && $this->isBetween($character->getKlassengruppe()->getId(), 1, 5)
            && $this->isBetween($character->getKlasse()->getId(), 1, 52)
            && in_array($character->getNaturElement()->getId(), [4, 5, 6, 9])
        )) {
            return false;
        }
        if ($character->getKlassengruppe()->getId() === 1 && !$this->isBetween($character->getMagiccircuit()->getId(), 1, 5)) {
            return false;
        }
        if ($character->getKlassengruppe()->getId() > 1 && $this->isBetween($character->getMagiccircuit()->getId(), 1, 5)) {
            return false;
        }
        return true;
    }

    /**
     * @param $value
     * @param $min
     * @param $max
     *
     * @return bool
     */
    private function isBetween($value, $min, $max) {
        return $value >= $min && $value <= $max;
    }
}
