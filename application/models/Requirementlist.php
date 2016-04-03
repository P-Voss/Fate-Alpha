<?php

/**
 * Description of Requirementlist
 *
 * @author Voß
 */
class Application_Model_Requirementlist implements Iterator {
    
    /**
     * @var array
     */
    private $requirements = array();
    
    /**
     * @return Application_Model_Requirement
     */
    public function getRequirements() {
        return $this->requirements;
    }

    public function setRequirements(array $requirements) {
        foreach ($requirements as $requirement){
            if($requirement instanceof Application_Model_Requirement){
                $this->requirements[] = $requirement;
            }
        }
    }
    
    
    public function addRequirement(Application_Model_Requirement $requirement) {
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
