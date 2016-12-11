<?php

/**
 * Description of Application_Model_EpisodenErgebnis
 *
 * @author Voß
 */
class Application_Model_EpisodenErgebnis {
    
    protected $result;
    protected $creationdate;
    
    public function getResult() {
        return $this->result;
    }

    public function getCreationdate() {
        return $this->creationdate;
    }

    public function setResult($result) {
        $this->result = $result;
    }

    public function setCreationdate($creationdate) {
        $this->creationdate = $creationdate;
    }
    
}
