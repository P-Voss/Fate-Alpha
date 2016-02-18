<?php

/**
 * Description of Uebung
 *
 * @author Voß
 */
class Gruppen_Model_Requirements_Validators_Uebung implements Gruppen_Model_Requirements_ValidationInterface {
    
    /**
     * @param Application_Model_Charakter $charakter
     * @param mixed $value
     * @return boolean
     */
    public function check(Application_Model_Charakter $charakter, $value){
        return $charakter->getCharakterwerte()->getUebung() >= $value;
    }
    
}
