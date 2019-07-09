<?php

/**
 * Description of Application_Model_Requirements_Validators_Character
 *
 * @author Voß
 */
class Application_Model_Requirements_Validators_Character implements Application_Model_Requirements_ValidationInterface {
    
    /**
     * @param Application_Model_Charakter $charakter
     * @param string $value
     * @return boolean
     */
    public function check(Application_Model_Charakter $charakter, $value) {
        return in_array($charakter->getCharakterid(), explode('|', $value));
    }
    
}
