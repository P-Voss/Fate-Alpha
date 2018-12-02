<?php

/**
 * Description of Information
 *
 * @author Voß
 */
class Erstellung_Service_Information
{

    public function getKlassen ()
    {
        $mapper = new Erstellung_Model_Mapper_KlassenMapper();
        return $mapper->getKlassengruppen();
    }


    public function getFamiliennamen ()
    {
        $mapper = new Erstellung_Model_Mapper_KlassenMapper();
        return $mapper->getFamiliennamen();
    }


    public function getKlasse ($id)
    {
        $mapper = new Erstellung_Model_Mapper_KlassenMapper();
        $klasse = $mapper->getKlassengruppeById($id);
        if ($klasse !== false) {
            $returnArray = [
                'success' => true,
                'klasse' => $klasse->getBezeichnung(),
                'beschreibung' => $klasse->getBeschreibung(),
            ];
        } else {
            $returnArray = ['success' => false];
        }
        return $returnArray;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getUnterklassen ()
    {
        $mapper = new Application_Model_Mapper_ErstellungMapper();
        return $unterklassen = $mapper->getAllClasses();
    }

    /**
     * @param Erstellung_Model_Charakter $charakter
     *
     * @return Erstellung_Model_Unterklasse[]
     * @throws Exception
     */
    public function getUnterklassenByCharakter (Erstellung_Model_Charakter $charakter): array
    {
        $requirementValidator = new Erstellung_Service_Requirement($charakter);
        $mapper = new Application_Model_Mapper_ErstellungMapper();
        $unterklassenToValidate = $mapper->getUnterklassenForCharakter($charakter);
        $unterklassen = [];
        foreach ($unterklassenToValidate as $unterklasse) {
            $unterklasse->setRequirementList($mapper->getUnterklassenRequirements($unterklasse->getId()));
            if ($requirementValidator->validate($unterklasse->getRequirementList())) {
                $unterklassen[] = $unterklasse;
            }
        }
        return $unterklassen;
    }

    /**
     * @param $id
     *
     * @return array
     * @throws Exception
     */
    public function getUnterklasse ($id)
    {
        $mapper = new Erstellung_Model_Mapper_KlassenMapper();
        $klasse = $mapper->getKlasseById($id);
        if ($klasse !== false) {
            $returnArray = [
                'success' => true,
                'klasse' => $klasse->getBezeichnung(),
                'beschreibung' => $klasse->getBeschreibung(),
                'points' => $klasse->getKosten(),
            ];
        } else {
            $returnArray = ['success' => false];
        }
        return $returnArray;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getCreationParams ()
    {
        $mapper = new Erstellung_Model_Mapper_AttributeMapper();
        $creationParamContainer = [];
        $creationParamContainer['odo'] = $mapper->getAllOdo();
        $creationParamContainer['circuits'] = $mapper->getAllCircuits();
        $creationParamContainer['elements'] = $mapper->getAllElements();
        $creationParamContainer['luck'] = $mapper->getAllLuckvalues();
        return $creationParamContainer;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getTraits (): array
    {
        $mapper = new Application_Model_Mapper_TraitMapper();
        $traits = $mapper->getAllTraits();
        foreach ($traits as $trait) {
            $trait->setIncompatibleTraits($mapper->getIncompatibleTraits($trait->getTraitId()));
        }
        return $mapper->getAllTraits();
    }

    /**
     * @param $traitId
     *
     * @return array
     * @throws Exception
     */
    public function getTraitDetails (int $traitId): array
    {
        $mapper = new Application_Model_Mapper_TraitMapper();
        $trait = $mapper->getTraitById($traitId);
        return [
            'points' => $trait->getKosten(),
            'beschreibung' => $trait->getBeschreibung(),
        ];
    }

    /**
     * @param Erstellung_Model_Charakter $charakter
     *
     * @return bool
     */
    public function hasCircuit (Erstellung_Model_Charakter $charakter)
    {
        $mapper = new Erstellung_Model_Mapper_CharakterMapper();
        $klassenId = $mapper->getKlasse($charakter);
        return $klassenId === 1;
    }


    public function getOdo ($id)
    {
        $mapper = new Application_Model_Mapper_OdoMapper();
        return [
            'points' => $mapper->getPunkte($id),
            'beschreibung' => $mapper->getBeschreibung($id),
        ];
    }


    public function getCircuit ($id)
    {
        $mapper = new Application_Model_Mapper_CircuitMapper();
        return [
            'points' => $mapper->getPunkte($id),
            'beschreibung' => $mapper->getBeschreibung($id),
        ];
    }


    public function getLuck ($id)
    {
        $mapper = new Application_Model_Mapper_LuckMapper();
        return [
            'points' => $mapper->getPunkte($id),
            'beschreibung' => $mapper->getBeschreibung($id),
        ];
    }

}
