<?php

/**
 * Description of Vorteil
 *
 * @author Voß
 */
class Erstellung_Model_Requirements_Validators_Vorteil implements Erstellung_Model_Requirements_ValidationInterface {
    
    /**
     * @param Erstellung_Model_Charakter $charakter
     * @param mixed $value
     * @return boolean
     */
    public function check(Erstellung_Model_Charakter $charakter, $value) {
        $values = explode('OR', $value);
        foreach ($values as $value){
            foreach ($charakter->getVorteile() as $vorteil){
                if($vorteil->getId() == $value){
                    return true;
                }
            }
        }
        return false;
    }
    
}
