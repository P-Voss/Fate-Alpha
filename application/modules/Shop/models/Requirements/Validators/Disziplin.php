<?php

namespace Shop\Models\Requirements\Validators;

use Shop\Models\Requirements\ValidationInterface;

/**
 * Description of Disziplin
 *
 * @author Voß
 */
class Disziplin implements ValidationInterface {
    
    /**
     * @param \Application_Model_Charakter $charakter
     * @param mixed $value
     * @return boolean
     */
    public function check(\Application_Model_Charakter $charakter, $value){
        return $charakter->getCharakterwerte()->getDisziplin() >= $value;
    }
    
}
