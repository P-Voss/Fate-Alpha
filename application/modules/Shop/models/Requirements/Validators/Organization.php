<?php

/**
 * Description of Shop_Model_Requirements_Validators_Organization
 *
 * @author Voß
 */
class Shop_Model_Requirements_Validators_Organization implements Shop_Model_Requirements_ValidationInterface {
    
    /**
     * @param Application_Model_Charakter $charakter
     * @param mixed $value
     * @return boolean
     */
    public function check(Application_Model_Charakter $charakter, $value){
        return $charakter->getMagiOrganization() === $value;
    }
    
}
