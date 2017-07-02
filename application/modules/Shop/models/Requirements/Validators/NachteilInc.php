<?php

/**
 * Description of Shop_Model_Requirements_Validators_NachteilInc
 *
 * @author Voß
 */
class Shop_Model_Requirements_Validators_NachteilInc implements Shop_Model_Requirements_ValidationInterface {
    
    /**
     * @param Application_Model_Charakter $charakter
     * @param mixed $value
     * @return boolean
     */
    public function check(Application_Model_Charakter $charakter, $value) {
        $values = explode('|', $value);
        foreach ($values as $value){
            foreach ($charakter->getNachteile() as $nachteil){
                if($nachteil->getId() == $value){
                    return false;
                }
            }
        }
        return true;
    }
    
}
