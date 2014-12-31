<?php

/**
 * Description of Factory
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Model_Erstellung_PunkteFactory {
    
    public function getConcrete($name) {
        if(class_exists('Application_Model_Erstellung_Punkte_'.$name)){
            $class = 'Application_Model_Erstellung_Punkte_' . $name;
            $concrete = new $class();
            if($concrete instanceof Application_Model_Erstellung_Punkte_PunkteInterface){
                return $concrete;
            }
        }
        return false;
    }
    
}
