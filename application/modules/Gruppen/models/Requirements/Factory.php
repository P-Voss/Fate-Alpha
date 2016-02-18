<?php

/**
 * Description of Factory
 *
 * @author Voß
 */
class Gruppen_Model_Requirements_Factory {
    
    
    public function getValidator($validator) {
        $class = 'Gruppen_Model_Requirements_Validators_' . $validator;
        if(class_exists($class)){
            $validator = new $class();
            if($validator instanceof Gruppen_Model_Requirements_ValidationInterface){
                return $validator;
            }else{
                throw new Exception('Die Validatorklasse '. $class .' konnte nicht gefunden werden');
            }
        }else{
            throw new Exception('Die Validatorklasse '. $class .' konnte nicht gefunden werden');
        }
    }
    
}
