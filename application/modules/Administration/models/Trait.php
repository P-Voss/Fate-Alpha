<?php

/**
 * Description of Administration_Model_Trait
 *
 * @author Vosser
 */
class Administration_Model_Trait extends Application_Model_Trait {
    
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
     * @var bool
     */
    private $isIndividual = false;
    
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

    /**
     * @return bool
     */
    public function isIndividual (): bool
    {
        return (bool) $this->isIndividual;
    }

    /**
     * @param bool $isIndividual
     *
     * @return Administration_Model_Trait
     */
    public function setIsIndividual ($isIndividual): Administration_Model_Trait
    {
        $this->isIndividual = (bool) $isIndividual;
        return $this;
    }

}
