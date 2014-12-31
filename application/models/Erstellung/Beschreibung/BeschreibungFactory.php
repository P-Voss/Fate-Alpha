<?php

/**
 * Description of Factory
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Model_Erstellung_BeschreibungFactory {
    
    public function getConcrete($name) {
        if(class_exists('Application_Model_Erstellung_Beschreibung_'.$name)){
            $class = 'Application_Model_Erstellung_Beschreibung_' . $name;
            $concrete = new $class();
            if($concrete instanceof Application_Model_Erstellung_Beschreibung_BeschreibungInterface){
                return $concrete;
            }
        }
        return false;
    }
    
}
