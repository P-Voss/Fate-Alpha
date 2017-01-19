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
    
    /**
     * @return \Story_Model_Skill
     */
    public function getRequestedSkills() {
        return $this->requestedSkills;
    }

    
    /**
     * @return \Story_Model_Magie
     */
    public function getRequestedMagien() {
        return $this->requestedMagien;
    }

    public function getRequestedItems() {
        return $this->requestedItems;
    }

    public function getRequestedEigenschaften() {
        return $this->requestedEigenschaften;
    }
    
    /**
     * @return \Application_Model_Charakter
     */
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
        foreach ($requestedSkills as $skill) {
            if ($skill instanceof Application_Model_Skill) {
                $this->requestedSkills[] = $skill;
            }
        }
    }

    public function setRequestedMagien($requestedMagien) {
        foreach ($requestedMagien as $magie) {
            if ($magie instanceof Application_Model_Magie) {
                $this->requestedMagien[] = $magie;
            }
        }
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
