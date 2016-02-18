<?php

/**
 * Description of Kontrolle
 *
 * @author Voß
 */
class Gruppen_Model_Requirements_Validators_Kontrolle implements Gruppen_Model_Requirements_ValidationInterface {
    
    /**
     * @param Application_Model_Charakter $charakter
     * @param mixed $value
     * @return boolean
     */
    public function check(Application_Model_Charakter $charakter, $value){
        return $charakter->getCharakterwerte()->getKontrolle() >= $value;
    }
    
}
