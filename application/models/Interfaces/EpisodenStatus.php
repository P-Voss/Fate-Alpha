<?php

/**
 * Description of Application_Model_Interfaces_EpisodenStatus
 *
 * @author Voß
 */
Interface Application_Model_Interfaces_EpisodenStatus {
    
    public function getId();

    public function setId($id);
    
    public function getStatus();

    public function setStatus($status);
    
    public function getColorCode();

    public function setColorCode($colorCode);
    
}
