<?php

/**
 * Description of Episode
 *
 * @author Voß
 */
class Story_Model_Episode extends Application_Model_Episode {
    
    protected $creationdate;
    protected $editDate;
    /**
     * @var Story_Model_EpisodenStatus
     */
    protected $status;
    
    /**
     * @return Story_Model_EpisodenStatus
     */
    public function getStatus() {
        return $this->status;
    }
    
    public function setStatus(Application_Model_Interfaces_EpisodenStatus $status) {
        $this->status = $status;
    }

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
    
}
