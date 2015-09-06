<?php

/**
 * Description of Factory
 *
 * @author Voß
 */
class Shop_Model_Requirements_Factory {
    
    
    public function getValidator($validator) {
        if(class_exists('Shop_Model_Requirements_Validators_' . $validator)){
            $class = 'Shop_Model_Requirements_Validators_' . $validator;
            $validator = new $class();
            if($validator instanceof Shop_Model_Requirements_ValidationInterface){
                return $validator;
            }else{
                throw new Exception('Die Validatorklasse konnte nicht gefunden werden');
            }
        }
    }
    
}
