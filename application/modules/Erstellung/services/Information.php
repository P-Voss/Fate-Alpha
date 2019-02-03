<?php

/**
 * Description of Information
 *
 * @author Voß
 */
class Erstellung_Service_Information
{

    /**
     * @return array
     * @throws Exception
     */
    public function getKlassen ()
    {
        $mapper = new Erstellung_Model_Mapper_KlassenMapper();
        return $mapper->getKlassengruppen();
    }

    /**
     * @param Erstellung_Model_Character $charakter
     *
     * @return array
     * @throws Exception
     */
    public function getSubclassesByCharacter(Erstellung_Model_Character $charakter)
    {
        $requirementValidator = new Erstellung_Service_Requirement($charakter);
        $mapper = new Application_Model_Mapper_ErstellungMapper();
        $unterklassenToValidate = $mapper->getSubclasses($charakter->getKlassengruppe()->getId());
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
        $mapper = new Erstellung_Model_Mapper_TraitMapper();
        $traits = $mapper->getAllTraits();
        foreach ($traits as $trait) {
            $trait->setIncompatibleTraits($mapper->getIncompatibleTraits($trait->getTraitId()));
        }
        return $traits;
    }

    /**
     * @return array
     */
    public function getDistricts ()
    {
        $mapper = new Application_Model_Mapper_OrteMapper();
        return $mapper->getDistricts();
    }

    /**
     * @return array
     */
    public function getAttractions ()
    {
        $mapper = new Application_Model_Mapper_OrteMapper();
        return $mapper->getAttractions();
    }

}
