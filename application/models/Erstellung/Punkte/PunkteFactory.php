<?php

/**
 * Description of Factory
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Model_Erstellung_Punkte_PunkteFactory {
    
    public function getConcrete($name) {
        if(class_exists('Application_Model_Erstellung_Mapper_' . ucfirst($name) . 'Mapper')){
            $class = 'Application_Model_Erstellung_Mapper_' . ucfirst($name) . 'Mapper';
            $concrete = new $class();
            if($concrete instanceof Application_Model_Erstellung_Punkte_PunkteInterface){
                return $concrete;
            }
        }
        return false;
    }
    
}
