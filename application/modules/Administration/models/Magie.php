<?php

/**
 * Description of Magie
 *
 * @author Vosser
 */
class Administration_Model_Magie extends Application_Model_Magie implements Administration_Model_CrudObject {

    /**
     * @var
     */
    private $creator;
    /**
     * @var
     */
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
    /**
     * @var int
     */
    private $magieschuleId;

    /**
     * @return mixed
     */
    public function getCreator() {
        return $this->creator;
    }

    /**
     * @return mixed
     */
    public function getEditor() {
        return $this->editor;
    }

    /**
     * @param string $format
     *
     * @return string
     * @throws Exception
     */
    public function getCreateDate($format = 'd.m.Y H:i') {
        $date = new DateTime($this->createDate);
        return $date->format($format);
    }

    /**
     * @param string $format
     *
     * @return string
     * @throws Exception
     */
    public function getEditDate($format = 'd.m.Y H:i') {
        $date = new DateTime($this->editDate);
        return $date->format($format);
    }

    /**
     * @param $creator
     */
    public function setCreator($creator) {
        $this->creator = $creator;
    }

    /**
     * @param $editor
     */
    public function setEditor($editor) {
        $this->editor = $editor;
    }

    /**
     * @param $createDate
     */
    public function setCreateDate($createDate) {
        $this->createDate = $createDate;
    }

    /**
     * @param $editDate
     */
    public function setEditDate($editDate) {
        $this->editDate = $editDate;
    }

    /**
     * @return mixed
     */
    public function getLearned() {
        return $this->learned;
    }

    /**
     * @param $learned
     */
    public function setLearned($learned) {
        $this->learned = $learned;
    }

    /**
     * @return Administration_Model_Requirementlist
     */
    public function getRequirementList() {
        return $this->requirementList;
    }

    /**
     * @param Administration_Model_Requirementlist $requirementList
     */
    public function setRequirementList(Administration_Model_Requirementlist $requirementList) {
        $this->requirementList = $requirementList;
    }

    /**
     * @return int
     */
    public function getMagieschuleId (): int
    {
        return $this->magieschuleId;
    }

    /**
     * @param int $magieschuleId
     *
     * @return Administration_Model_Magie
     */
    public function setMagieschuleId (int $magieschuleId): Administration_Model_Magie
    {
        $this->magieschuleId = $magieschuleId;
        return $this;
    }
    
}
