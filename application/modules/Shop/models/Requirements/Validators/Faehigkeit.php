<?php

/**
 * Description of Faehigkeit
 *
 * @author Voß
 */
class Shop_Model_Requirements_Validators_Faehigkeit implements Shop_Model_Requirements_ValidationInterface {
    
    /**
     * @param Application_Model_Charakter $charakter
     * @param mixed $value
     * @return boolean
     */
    public function check(Application_Model_Charakter $charakter, $value) {
        $values = explode(':', $value);
        foreach ($values as $value){
            $result = false;
            foreach ($charakter->getSkills() as $skill){
                if($skill->getId() == $value){
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
