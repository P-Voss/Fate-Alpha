<?php

namespace Shop\Models\Requirements\Validators;

use Shop\Models\Requirements\ValidationInterface;

/**
 * Description of Character
 *
 * @author Voß
 */
class Character implements ValidationInterface {
    
    /**
     * @param \Application_Model_Charakter $charakter
     * @param string $value
     * @return boolean
     */
    public function check(\Application_Model_Charakter $charakter, $value) {
        return in_array($charakter->getCharakterid(), explode('|', $value));
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
