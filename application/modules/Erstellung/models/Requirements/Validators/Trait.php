<?php

/**
 * Description of Erstellung_Model_Requirements_Validators_Trait
 *
 * @author Voß
 */
class Erstellung_Model_Requirements_Validators_Trait implements Erstellung_Model_Requirements_ValidationInterface {
    
    /**
     * @param Erstellung_Model_Character $charakter
     * @param mixed $value
     * @return boolean
     */
    public function check(Erstellung_Model_Character $charakter, $value) {
        $values = explode('OR', $value);
        foreach ($values as $value){
            foreach ($charakter->getTraits() as $trait){
                if($trait->getTraitId() == $value){
                    return true;
                }
            }
        }
        return false;
    }
    
}
