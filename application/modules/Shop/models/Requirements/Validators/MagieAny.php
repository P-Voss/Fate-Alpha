<?php

namespace Shop\Models\Requirements\Validators;

use Shop\Models\Requirements\ValidationInterface;

/**
 * Description of MagieAny
 *
 * @author Voß
 */
class MagieAny implements ValidationInterface {
    
    /**
     * @param \Application_Model_Charakter $charakter
     * @param mixed $value
     * @return boolean
     */
    public function check(\Application_Model_Charakter $charakter, $value) {
        return null;
    }

    /**
     * @param \Application_Model_Charakter $charakter
     * @param $value
     *
     * @return bool
     */
    public function successfulWildcard (\Application_Model_Charakter $charakter, $value)
    {
        $values = explode('|', $value);
        foreach ($values as $value){
            foreach ($charakter->getMagien() as $magie){
                if($magie->getId() == $value){
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @return bool
     */
    public function isWildcard ()
    {
        return true;
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
