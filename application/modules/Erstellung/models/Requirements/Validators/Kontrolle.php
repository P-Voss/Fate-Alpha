<?php

/**
 * Description of Kontrolle
 *
 * @author Voß
 */
class Shop_Model_Requirements_Validators_Kontrolle implements Shop_Model_Requirements_ValidationInterface {
    
    /**
     * @param Application_Model_Charakter $charakter
     * @param mixed $value
     * @return boolean
     */
    public function check(Application_Model_Charakter $charakter, $value){
        return $charakter->getCharakterwerte()->getKontrolle() >= $value;
    }
    
}
