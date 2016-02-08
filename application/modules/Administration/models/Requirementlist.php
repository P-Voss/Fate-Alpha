<?php

/**
 * Description of Requirementlist
 *
 * @author Voß
 */
class Administration_Model_Requirementlist implements Iterator {
    
    /**
     * @var array
     */
    private $requirements = array();
    
    /**
     * @return Administration_Model_Requirement
     */
    public function getRequirements() {
        return $this->requirements;
    }

    public function setRequirements(array $requirements) {
        foreach ($requirements as $requirement){
            if($requirement instanceof Administration_Model_Requirement){
                $this->requirements[] = $requirement;
            }
        }
    }
    
    
    public function getRequirementByKey($key) {
        foreach ($this->requirements as $requirement) {
            if($requirement->getArt() === $key){
                return $requirement;
            }
        }
        return new Administration_Model_Requirement();
    }
    
    
    public function getRequirementArrayByKey($key) {
        $returnArray = array();
        foreach ($this->requirements as $requirement) {
            if($requirement->getArt() === $key){
                $returnArray[] = $requirement;
            }
        }
        return $returnArray;
    }
    
    
    public function addRequirement(Administration_Model_Requirement $requirement) {
        $this->requirements[] = $requirement;
    }
    
    public function current() {
        
    }
    
    public function next() {
        
    }
    
    public function key() {
        
    }
    
    public function rewind() {
        
    }
    
    public function valid() {
        
    }
    
}
