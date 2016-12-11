<?php

/**
 * Description of Application_Model_CharakterResult
 *
 * @author Voß
 */
class Application_Model_CharakterResult implements Application_Model_Interfaces_CharakterResult {
    
    protected $requestedSkills = [];
    protected $requestedMagien = [];
    protected $requestedItems = [];
    protected $requestedEigenschaften = [];
    protected $charaktersKilled = [];
    protected $died;
    protected $killNpcs;
    protected $comment;

    public function getRequestedSkills() {
        return $this->requestedSkills;
    }

    public function getRequestedMagien() {
        return $this->requestedMagien;
    }

    public function getRequestedItems() {
        return $this->requestedItems;
    }

    public function getRequestedEigenschaften() {
        return $this->requestedEigenschaften;
    }

    public function getCharaktersKilled() {
        return $this->charaktersKilled;
    }

    public function getDied() {
        return $this->died;
    }

    public function getKillNpcs() {
        return $this->killNpcs;
    }

    public function setRequestedSkills($requestedSkills) {
        $this->requestedSkills = $requestedSkills;
    }

    public function setRequestedMagien($requestedMagien) {
        $this->requestedMagien = $requestedMagien;
    }

    public function setRequestedItems($requestedItems) {
        $this->requestedItems = $requestedItems;
    }

    public function setRequestedEigenschaften($requestedEigenschaften) {
        $this->requestedEigenschaften = $requestedEigenschaften;
    }

    public function setCharaktersKilled($charaktersKilled) {
        $this->charaktersKilled = $charaktersKilled;
    }

    public function setDied($died) {
        $this->died = $died;
    }

    public function setKillNpcs($killNpcs) {
        $this->killNpcs = $killNpcs;
    }
    
    public function getComment() {
        return $this->comment !== null ? $this->comment : '';
    }

    public function setComment($comment) {
        $this->comment = $comment;
    }
    
}
