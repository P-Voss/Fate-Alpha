<?php

/**
 * Description of Skillart
 *
 * @author Voß
 */
class Shop_Model_Skillart {
    
    private $id;
    private $name;
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

    public function getName() {
        return $this->name;
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

    public function setName($name) {
        $this->name = $name;
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
