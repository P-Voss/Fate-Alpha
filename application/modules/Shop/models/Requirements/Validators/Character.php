<?php

/**
 * Description of Shop_Model_Requirements_Validators_Character
 *
 * @author Voß
 */
class Shop_Model_Requirements_Validators_Character implements Shop_Model_Requirements_ValidationInterface {
    
    /**
     * @param Application_Model_Charakter $charakter
     * @param string $value
     * @return boolean
     */
    public function check(Application_Model_Charakter $charakter, $value) {
        return in_array($charakter->getCharakterid(), explode('|', $value));
    }
    
}
