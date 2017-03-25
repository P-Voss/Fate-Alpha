<?php

/**
 * Description of Application_Model_Requirements_Validators_MagieAny
 *
 * @author Voß
 */
class Application_Model_Requirements_Validators_MagieAny implements Application_Model_Requirements_ValidationInterface {
    
    /**
     * @param Application_Model_Charakter $charakter
     * @param mixed $value
     * @return boolean
     */
    public function check(Application_Model_Charakter $charakter, $value) {
        $values = explode(':', $value);
        foreach ($values as $value){
            foreach ($charakter->getMagien() as $magie){
                if($magie->getId() == $value){
                    return true;
                }
            }
        }
        return false;
    }
    
}
