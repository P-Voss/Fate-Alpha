<?php

/**
 * Description of Requirementlist
 *
 * @author Voß
 */
class Gruppen_Model_Requirementlist implements Iterator {
    
    /**
     * @var array
     */
    private $requirements = array();
    
    /**
     * @return Gruppen_Model_Requirement
     */
    public function getRequirements() {
        return $this->requirements;
    }

    public function setRequirements(array $requirements) {
        foreach ($requirements as $requirement){
            if($requirement instanceof Gruppen_Model_Requirement){
                $this->requirements[] = $requirement;
            }
        }
    }
    
    
    public function addRequirement(Gruppen_Model_Requirement $requirement) {
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
