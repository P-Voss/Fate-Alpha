<?php

namespace Shop\Models\Requirements\Validators;

use Shop\Models\Requirements\ValidationInterface;

/**
 * Description of Klasse
 *
 * @author Voß
 */
class Klasse implements ValidationInterface {
    
    /**
     * @param \Application_Model_Charakter $charakter
     * @param mixed $value
     * @return boolean
     */
    public function check(\Application_Model_Charakter $charakter, $value) {
        $values = explode('|', $value);
        foreach ($values as $value){
            if($charakter->getKlasse()->getId() == $value){
                return true;
            }
        }
        return false;
    }

    /**
     * @param \Application_Model_Charakter $charakter
     * @param mixed $value
     * @return boolean
     */
    public function successfulWildcard (\Application_Model_Charakter $charakter, $value)
    {
        return false;
    }
    
}
