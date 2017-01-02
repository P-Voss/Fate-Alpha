<?php

/**
 *
 * @author Voß
 */
interface Application_Model_Interfaces_Auswertung {
    
    
    public function getUserId();
    
    public function getProfilname();

    public function getDescription();

    public function getIsAccepted();

    public function setUserId($userId);

    public function setDescription($description);

    public function setIsAccepted($isAccepted);
    
}
