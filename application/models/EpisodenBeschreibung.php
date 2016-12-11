<?php

/**
 * Description of Application_Model_EpisodenBeschreibung
 *
 * @author Voß
 */
class Application_Model_EpisodenBeschreibung {
    
    protected $beschreibung;
    protected $creationdate;
    
    public function getBeschreibung() {
        return $this->beschreibung;
    }

    public function getCreationdate() {
        return $this->creationdate;
    }

    public function setBeschreibung($beschreibung) {
        $this->beschreibung = $beschreibung;
    }

    public function setCreationdate($creationdate) {
        $this->creationdate = $creationdate;
    }
    
}
