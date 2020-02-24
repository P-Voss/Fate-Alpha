<?php

namespace Shop\Models\Requirements\Validators;

use Shop\Models\Requirements\ValidationInterface;

/**
 * Description of Element
 *
 * @author Voß
 */
class Element implements ValidationInterface {
    
    /**
     * @param \Application_Model_Charakter $charakter
     * @param mixed $value
     * @return boolean
     */
    public function check(\Application_Model_Charakter $charakter, $value){
        $values = explode(':', $value);
        foreach ($values as $value){
            $result = false;
            foreach ($charakter->getElemente() as $element){
                if($element->getId() == $value){
                    $result = true;
                }
            }
            if($result === false){
                return false;
            }
        }
        return true;
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
