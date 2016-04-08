<?php

/**
 * Description of Factory
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Model_Validation_Factory {
    
    /**
     * @param type $name
     * @return \Application_Model_Validation_ValidationInterface|boolean
     */
    public function getValidator($name) {
        if(class_exists('Application_Model_Validation_'.$name)){
            $class = 'Application_Model_Validation_' . $name;
            $validator = new $class();
            if($validator instanceof Application_Model_Validation_ValidationInterface){
                return $validator;
            }
        }
        return false;
    }
    
}
