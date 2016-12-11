<?php

/**
 * Description of Story_Model_Charakter
 *
 * @author Voß
 */
class Story_Model_Charakter extends Application_Model_Charakter {
    
    
    protected $datenFreigabe;
    protected $involved;
    protected $result;
    

    public function getDatenFreigabe() {
        return $this->datenFreigabe !== null ? $this->datenFreigabe : false;
    }

    public function setDatenFreigabe($datenFreigabe) {
        $this->datenFreigabe = $datenFreigabe;
    }
    
    public function getInvolved() {
        return $this->involved !== null ? $this->involved : false;
    }

    public function setInvolved($involved) {
        $this->involved = $involved;
    }
    
    /**
     * @return Story_Model_CharakterResult
     */
    public function getResult() {
        return $this->result;
    }

    public function setResult(Story_Model_CharakterResult $result) {
        $this->result = $result;
    }
    
}
