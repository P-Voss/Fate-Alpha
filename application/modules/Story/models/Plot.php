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
    protected $creationdate;
    /**
     * @var DateTime
     */
    protected $editDate;
    protected $status;
    
    
    public function getCreateDate($format = 'd.m.Y H:i:s') {
        $date = new DateTime($this->creationdate);
        return $date->format($format);
    }

    public function getEditDate() {
        return $this->editDate;
    }

    public function setCreateDate($creationdate) {
        $this->creationdate = $creationdate;
    }

    public function setEditDate($editDate) {
        $this->editDate = $editDate;
    }
    
    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }
    
}
