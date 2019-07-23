<?php

namespace Shop\Models\Requirements\Validators;

use Shop\Models\Requirements\ValidationInterface;

/**
 * Description of FP
 *
 * @author Voß
 */
class FP implements ValidationInterface {
    
    /**
     * @param \Application_Model_Charakter $charakter
     * @param mixed $value
     * @return boolean
     */
    public function check(\Application_Model_Charakter $charakter, $value){
        return $charakter->getCharakterwerte()->getFp() >= $value;
    }
    
}
