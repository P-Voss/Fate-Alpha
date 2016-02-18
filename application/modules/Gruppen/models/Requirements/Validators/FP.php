<?php

/**
 * Description of FP
 *
 * @author Voß
 */
class Gruppen_Model_Requirements_Validators_FP implements Gruppen_Model_Requirements_ValidationInterface {
    
    /**
     * @param Application_Model_Charakter $charakter
     * @param mixed $value
     * @return boolean
     */
    public function check(Application_Model_Charakter $charakter, $value){
        return $charakter->getCharakterwerte()->getFp() >= $value;
    }
    
}
