<?php

namespace Shop\Models\Requirements\Validators;

use Shop\Models\Requirements\ValidationInterface;

/**
 * Description of Gruppe
 *
 * @author Voß
 */
class Gruppe implements ValidationInterface {
    
    /**
     * @param \Application_Model_Charakter $charakter
     * @param mixed $value
     * @return boolean
     */
    public function check(\Application_Model_Charakter $charakter, $value) {
        $values = explode('|', $value);
        foreach ($values as $value){
            if($charakter->getKlassengruppe()->getId() == $value){
                return true;
            }
        }
        return false;
    }
    
}
