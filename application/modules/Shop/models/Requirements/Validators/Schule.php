<?php

/**
 * Description of Schule
 *
 * @author Voß
 */
class Shop_Model_Requirements_Validators_Schule implements Shop_Model_Requirements_ValidationInterface {
    
    /**
     * @param Application_Model_Charakter $charakter
     * @param mixed $value
     * @return boolean
     */
    public function check(Application_Model_Charakter $charakter, $value) {
        return $charakter->getMagischoolId() === (int) $value;
    }
    
}
