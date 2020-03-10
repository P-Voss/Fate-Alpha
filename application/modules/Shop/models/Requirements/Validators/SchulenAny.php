<?php

namespace Shop\Models\Requirements\Validators;

use Shop\Models\Requirements\ValidationInterface;

/**
 * Description of SchulenAny
 *
 * @author Voß
 */
class SchulenAny implements ValidationInterface {
    
    /**
     * @param \Application_Model_Charakter $charakter
     * @param string $value
     * @return boolean
     */
    public function check(\Application_Model_Charakter $charakter, $value) {
        return true;
    }

    public function successfulWildcard (\Application_Model_Charakter $charakter, $value)
    {
        $values = explode('|', $value);
        return in_array($charakter->getMagischoolId(), $values);
    }

    /**
     * @param \Application_Model_Charakter $charakter
     * @param $value
     *
     * @return bool
     */
    public function isIncompatible (\Application_Model_Charakter $charakter, $value)
    {
        return false;
    }

}
