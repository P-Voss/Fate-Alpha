<?php

/**
 * Description of Vorteil
 *
 * @author Voß
 */
class Application_Model_Requirements_Validators_Trait implements Application_Model_Requirements_ValidationInterface {
    
    /**
     * @param Application_Model_Charakter $charakter
     * @param string $value
     * @return boolean
     */
    public function check(Application_Model_Charakter $charakter, $value) {
        $values = explode(':', $value);
        foreach ($values as $value){
            $result = false;
            foreach ($charakter->getTraits() as $trait){
                if($trait->getTraitId() == $value){
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
