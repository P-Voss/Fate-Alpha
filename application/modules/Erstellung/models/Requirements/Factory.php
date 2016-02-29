<?php

/**
 * Description of Factory
 *
 * @author Voß
 */
class Erstellung_Model_Requirements_Factory {
    
    
    public function getValidator($validator) {
        $class = 'Erstellung_Model_Requirements_Validators_' . ucfirst($validator);
        if(class_exists($class)){
            $validator = new $class();
            if($validator instanceof Erstellung_Model_Requirements_ValidationInterface){
                return $validator;
            }else{
                throw new Exception('Die Validatorklasse '. $class .' konnte nicht gefunden werden');
            }
        }else{
            throw new Exception('Die Validatorklasse '. $class .' konnte nicht gefunden werden');
        }
    }
    
}
