<?php

/**
 * Description of Nachteil
 *
 * @author Voß
 */
class Erstellung_Model_Requirements_Validators_Nachteil implements Erstellung_Model_Requirements_ValidationInterface {
    
    /**
     * @param Erstellung_Model_Charakter $charakter
     * @param mixed $value
     * @return boolean
     */
    public function check(Erstellung_Model_Charakter $charakter, $value) {
        $values = explode('OR', $value);
        foreach ($values as $value){
            $result = false;
            foreach ($charakter->getNachteile() as $nachteil){
                if($nachteil->getId() == $value){
                    $result = true;
                }
            }
            if($result === false){
                return false;
            }
        }
        return true;
    }
    
}
