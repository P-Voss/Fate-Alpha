<?php

/**
 * Description of Skillart
 *
 * @author Voß
 */
class Shop_Model_Skillart {
    
    private $id;
    private $bezeichnung;
    private $beschreibung;
    private $skills = array();
    private $requirementList;
    private $learned;
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getBezeichnung() {
        return $this->bezeichnung;
    }

    public function getBeschreibung() {
        return $this->beschreibung;
    }

    public function getSkills() {
        return $this->skills;
    }
    
    /**
     * @return Shop_Model_Requirementlist
     */
    public function getRequirementList() {
        return $this->requirementList;
    }

    public function getLearned() {
        return $this->learned;
    }

    public function setBezeichnung($bezeichnung) {
        $this->bezeichnung = $bezeichnung;
    }

    public function setBeschreibung($beschreibung) {
        $this->beschreibung = $beschreibung;
    }

    public function setSkills($skills) {
        $this->skills = $skills;
    }

    /**
     * @param Shop_Model_Requirementlist $requirementList
     */
    public function setRequirementList(Shop_Model_Requirementlist $requirementList) {
        $this->requirementList = $requirementList;
    }

    public function setLearned($learned) {
        $this->learned = $learned;
    }


    
}
