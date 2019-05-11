<?php

/**
 * Description of Shop_Model_Requirements_Validators_SchulenAny
 *
 * @author Voß
 */
class Shop_Model_Requirements_Validators_SchulenAny implements Shop_Model_Requirements_ValidationInterface {
    
    /**
     * @param Application_Model_Charakter $charakter
     * @param string $value
     * @return boolean
     */
    public function check(Application_Model_Charakter $charakter, $value) {
        $values = explode('|', $value);
        foreach ($charakter->getMagieschulen() as $magieschule){
            if (in_array($magieschule->getId(), $values)) {
                return true;
            }
        }

        return false;
    }
    
}
