<?php

/**
 * Description of Application_Service_Charakter
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Service_Charakter {
    
    public function getCharakterByUserid($userId) {
        $mapper = new Application_Model_Mapper_CharakterMapper();
        return $mapper->getCharakterById($userId);
    }
    
}
