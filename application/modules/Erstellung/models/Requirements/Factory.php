<?php

/**
 * Description of Factory
 *
 * @author Voß
 */
class Shop_Model_Requirements_Factory {
    
    
    public function getValidator($validator) {
        $class = 'Shop_Model_Requirements_Validators_' . $validator;
        if(class_exists($class)){
            $validator = new $class();
            if($validator instanceof Shop_Model_Requirements_ValidationInterface){
                return $validator;
            }else{
                throw new Exception('Die Validatorklasse '. $class .' konnte nicht gefunden werden');
            }
        }else{
            throw new Exception('Die Validatorklasse '. $class .' konnte nicht gefunden werden');
        }
    }
    
}
