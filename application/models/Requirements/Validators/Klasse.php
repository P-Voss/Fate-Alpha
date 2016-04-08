<?php

/**
 * Description of Klasse
 *
 * @author Voß
 */
class Application_Model_Requirements_Validators_Klasse implements Application_Model_Requirements_ValidationInterface {
    
    /**
     * @param Application_Model_Charakter $charakter
     * @param mixed $value
     * @return boolean
     */
    public function check(Application_Model_Charakter $charakter, $value) {
        $values = explode(':', $value);
        foreach ($values as $value){;
            if($charakter->getKlasse()->getId() == $value){
                return true;
            }
        }
        return false;
    }
    
}
