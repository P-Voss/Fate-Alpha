<?php

/**
 * Description of Vorteil
 *
 * @author Voß
 */
class Shop_Model_Requirements_Validators_Vorteil implements Shop_Model_Requirements_ValidationInterface {
    
    /**
     * @param Application_Model_Charakter $charakter
     * @param mixed $value
     * @return boolean
     */
    public function check(Application_Model_Charakter $charakter, $value) {
        foreach ($charakter->getVorteile() as $vorteil){
            if($vorteil->getId() == $value){
                return true;
            }
        }
        return false;
    }
    
}
