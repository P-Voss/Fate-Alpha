<?php

/**
 * Description of Story_Model_Plot
 *
 * @author Voß
 */
class Story_Model_Plot extends Application_Model_Plot {
    
    
    /**
     * @var DateTime
     */
    protected $createDate;
    /**
     * @var DateTime
     */
    protected $editDate;
    
    
    public function getCreateDate($format = 'd.m.Y H:i:s') {
        $date = new DateTime($this->createDate);
        return $date->format($format);
    }

    public function getEditDate() {
        return $this->editDate;
    }

    public function setCreateDate($createDate) {
        $this->createDate = $createDate;
    }

    public function setEditDate($editDate) {
        $this->editDate = $editDate;
    }
    
}
