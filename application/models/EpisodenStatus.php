<?php

/**
 * Description of Application_Model_EpisodenStatus
 *
 * @author Voß
 */
class Application_Model_EpisodenStatus implements Application_Model_Interfaces_EpisodenStatus {
    
    protected $id;
    protected $status;
    protected $colorCode;
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }
    
    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }
    
    public function getColorCode() {
        return $this->colorCode;
    }

    public function setColorCode($colorCode) {
        $this->colorCode = $colorCode;
    }
    
}
