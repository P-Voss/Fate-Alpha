<?php

/**
 * Description of Magie
 *
 * @author Voß
 */
class Application_Model_Requirements_Validators_Magie implements Application_Model_Requirements_ValidationInterface {
    
    /**
     * @param Application_Model_Charakter $charakter
     * @param mixed $value
     * @return boolean
     */
    public function check(Application_Model_Charakter $charakter, $value) {
        $values = explode(':', $value);
        foreach ($values as $value){
            $result = false;
            foreach ($charakter->getMagien() as $magie){
                if($magie->getId() == $value){
                    $result = true;
                }
            }
            if($result === false){
                return false;
            }
        }
        return true;
    }
    
}
