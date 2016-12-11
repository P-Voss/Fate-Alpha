<?php

/**
 * Description of Logs_Model_Charakter
 *
 * @author Voß
 */
class Logs_Model_Charakter extends Application_Model_Charakter {
    
    protected $result;
    
    
    /**
     * @return Application_Model_Interfaces_CharakterResult
     */
    public function getResult() {
        return $this->result;
    }

    public function setResult(Application_Model_Interfaces_CharakterResult $result) {
        $this->result = $result;
    }
    
}
