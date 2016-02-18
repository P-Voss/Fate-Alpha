<?php

/**
 * Description of Schule
 *
 * @author Voß
 */
class Gruppen_Model_Requirements_Validators_Schule implements Gruppen_Model_Requirements_ValidationInterface {
    
    /**
     * @param Application_Model_Charakter $charakter
     * @param mixed $value
     * @return boolean
     */
    public function check(Application_Model_Charakter $charakter, $value) {
        foreach ($charakter->getMagieschulen() as $magieschule) {
            if($magieschule->getId() == $value){
                return true;
            }
        }
        return false;
    }
    
}
