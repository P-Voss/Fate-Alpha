<?php

/**
 * Description of Magie
 *
 * @author Vosser
 */
class Administration_Model_Magie extends Application_Model_Magie implements Administration_Model_CrudObject {
    
    private $creator;
    private $editor;
    /**
     * @var DateTime
     */
    private $createDate;
    /**
     * @var DateTime
     */
    private $editDate;
    /**
     * @var Administration_Model_Requirementlist
     */
    private $requirementList;
    
    public function getCreator() {
        return $this->creator;
    }

    public function getEditor() {
        return $this->editor;
    }

    public function getCreateDate($format = 'd.m.Y H:i') {
        $date = new DateTime($this->createDate);
        return $date->format($format);
    }

    public function getEditDate($format = 'd.m.Y H:i') {
        $date = new DateTime($this->editDate);
        return $date->format($format);
    }

    public function setCreator($creator) {
        $this->creator = $creator;
    }

    public function setEditor($editor) {
        $this->editor = $editor;
    }

    public function setCreateDate($createDate) {
        $this->createDate = $createDate;
    }

    public function setEditDate($editDate) {
        $this->editDate = $editDate;
    }
    
    public function getLearned() {
        return $this->learned;
    }

    public function setLearned($learned) {
        $this->learned = $learned;
    }
    
    public function getRequirementList() {
        return $this->requirementList;
    }

    public function setRequirementList(Administration_Model_Requirementlist $requirementList) {
        $this->requirementList = $requirementList;
    }
    
}
