<?php

namespace Shop\Models\Requirements\Validators;

use Shop\Models\Requirements\ValidationInterface;

/**
 * Description of Faehigkeit
 *
 * @author Voß
 */
class FaehigkeitInc implements ValidationInterface {
    
    /**
     * @param \Application_Model_Charakter $charakter
     * @param mixed $value
     * @return boolean
     */
    public function check(\Application_Model_Charakter $charakter, $value) {
        $values = explode('|', $value);
        foreach ($values as $value){
            foreach ($charakter->getSkills() as $skill){
                if($skill->getId() == $value){
                    return false;
                }
            }
        }
        return true;
    }
    
}
