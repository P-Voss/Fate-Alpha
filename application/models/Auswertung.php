<?php

/**
 * Description of Application_Model_Auswertung
 *
 * @author Voß
 */
class Application_Model_Auswertung implements Application_Model_Interfaces_Auswertung {
    
    protected $userId;
    protected $profilname;
    protected $description;
    protected $isAccepted;
    
    
    public function getUserId() {
        return $this->userId;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getIsAccepted() {
        return $this->isAccepted === true;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setIsAccepted($isAccepted) {
        $this->isAccepted = $isAccepted;
    }
    
    public function getProfilname() {
        return $this->profilname;
    }

    public function setProfilname($profilname) {
        $this->profilname = $profilname;
    }
    
}
