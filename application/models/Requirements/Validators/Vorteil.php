<?php

/**
 * Description of Vorteil
 *
 * @author Voß
 */
class Application_Model_Requirements_Validators_Vorteil implements Application_Model_Requirements_ValidationInterface {
    
    /**
     * @param Application_Model_Charakter $charakter
     * @param mixed $value
     * @return boolean
     */
    public function check(Application_Model_Charakter $charakter, $value) {
        $values = explode(':', $value);
        foreach ($values as $value){
            $result = false;
            foreach ($charakter->getVorteile() as $vorteil){
                if($vorteil->getId() == $value){
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
