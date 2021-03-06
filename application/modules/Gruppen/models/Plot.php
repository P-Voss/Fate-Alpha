<?php

/**
 * Description of Plot
 *
 * @author Voß
 */
class Gruppen_Model_Plot extends Application_Model_Plot {
    
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
}
