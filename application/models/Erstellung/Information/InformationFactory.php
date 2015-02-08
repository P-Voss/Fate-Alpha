<?php

/**
 * Description of Factory
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Model_Erstellung_Information_InformationFactory {
    
    public function getConcrete($name) {
        if(class_exists('Application_Model_Mapper_' . ucfirst($name) . 'Mapper')){
            $class = 'Application_Model_Mapper_' . ucfirst($name) . 'Mapper';
            $concrete = new $class();
            if($concrete instanceof Application_Model_Erstellung_Information_InformationInterface){
                return $concrete;
            }
        }
        return false;
    }
    
}
