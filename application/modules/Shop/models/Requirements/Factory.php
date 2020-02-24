<?php

namespace Shop\Models\Requirements;

use Exception;

/**
 * Description of Factory
 *
 * @author Voß
 */
class Factory {

    /**
     * @param $validator
     *
     * @return ValidationInterface
     * @throws Exception
     */
    public function getValidator($validator) {
        $class = 'Shop\\Models\\Requirements\\Validators\\' . $validator;
        if(class_exists($class)){
            $validator = new $class();
            if($validator instanceof ValidationInterface){
                return $validator;
            }else{
                throw new Exception('Die Validatorklasse '. $class .' konnte nicht gefunden werden');
            }
        }else{
            throw new Exception('Die Validatorklasse '. $class .' konnte nicht gefunden werden');
        }
    }
    
}
