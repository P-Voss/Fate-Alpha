<?php

namespace Shop\Models\Requirements\Validators;

use Shop\Models\Requirements\ValidationInterface;

/**
 * Description of Kontrolle
 *
 * @author Voß
 */
class Kontrolle implements ValidationInterface {
    
    /**
     * @param \Application_Model_Charakter $charakter
     * @param mixed $value
     * @return boolean
     */
    public function check(\Application_Model_Charakter $charakter, $value){
        return $charakter->getCharakterwerte()->getKontrolle() >= $value;
    }
    
}
