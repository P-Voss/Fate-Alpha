<?php

/**
 * Description of Application_Model_Requirements_Validators_Disziplin
 *
 * @author Voß
 */
class Application_Model_Requirements_Validators_Disziplin implements Application_Model_Requirements_ValidationInterface {
    
    /**
     * @param Application_Model_Charakter $charakter
     * @param mixed $value
     * @return boolean
     */
    public function check(Application_Model_Charakter $charakter, $value) {
        return $charakter->getCharakterwerte()->getDisziplin() >= $value;
    }
    
}
