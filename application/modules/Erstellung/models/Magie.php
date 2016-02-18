<?php

/**
 * Description of Magie
 *
 * @author Vosser
 */
class Shop_Model_Magie extends Application_Model_Magie {
    
    /**
     * @var boolean
     */
    private $learned;
    /**
     * @var Shop_Model_Requirementlist
     */
    private $requirementList;
    
    public function getLearned() {
        return $this->learned;
    }

    public function setLearned($learned) {
        $this->learned = $learned;
    }
    
    public function getRequirementList() {
        return $this->requirementList;
    }

    public function setRequirementList(Shop_Model_Requirementlist $requirementList) {
        $this->requirementList = $requirementList;
    }
    
    public function jsonSerialize() {
        $return = array();
        foreach (get_object_vars($this) as $key => $property){
            $return[$key] = $property;
        }
        return $return;
    }
    
}
