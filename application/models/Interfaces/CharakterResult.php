<?php

/**
 *
 * @author Voß
 */
interface Application_Model_Interfaces_CharakterResult {
    
    
    public function getRequestedSkills();

    public function getRequestedMagien();

    public function getRequestedItems();

    public function getRequestedEigenschaften();

    public function getCharaktersKilled();

    public function getDied();

    public function getKillNpcs();

    public function setRequestedSkills($requestedSkills);

    public function setRequestedMagien($requestedMagien);

    public function setRequestedItems($requestedItems);

    public function setRequestedEigenschaften($requestedEigenschaften);

    public function setCharaktersKilled($charaktersKilled);

    public function setDied($died);

    public function setKillNpcs($killNpcs);
    
    public function getComment();

    public function setComment($comment);
    
}
