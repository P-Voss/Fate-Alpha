<?php

namespace Shop\Models\Requirements\Validators;

use Shop\Models\Requirements\ValidationInterface;

/**
 * Description of Faehigkeit
 *
 * @author Voß
 */
class Faehigkeit implements ValidationInterface {
    
    /**
     * @param \Application_Model_Charakter $charakter
     * @param mixed $value
     * @return boolean
     */
    public function check(\Application_Model_Charakter $charakter, $value) {
        foreach ($charakter->getSkills() as $skill){
            if($skill->getId() == $value){
                return true;
            }
        }
        return false;
    }
    
}
