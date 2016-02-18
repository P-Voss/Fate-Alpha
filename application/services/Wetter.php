<?php


/**
 * Description of Wetter
 *
 * @author Vosser
 */
class Application_Service_Wetter {
    
    public function getForecast() {
        $mapper = new Application_Model_Mapper_WetterMapper();
        return $mapper->getForecast();
    }
    
}
