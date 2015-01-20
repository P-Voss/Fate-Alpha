<?php

/**
 * Description of Factory
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Model_Erstellung_Beschreibung_BeschreibungFactory {
    
    public function getConcrete($name) {
        if(class_exists('Application_Model_Erstellung_Mapper_' . $name . 'Mapper')){
            $class = 'Application_Model_Erstellung_Mapper_' . $name . 'Mapper';
            $concrete = new $class();
            if($concrete instanceof Application_Model_Erstellung_Beschreibung_BeschreibungInterface){
                return $concrete;
            }
        }
        return false;
    }
    
}
