<?php

/**
 * Description of Erstellung_Service_Charakter
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Erstellung_Service_Charakter extends Application_Service_Charakter {
    
    
    public function getInactiveCharakterByUserId($userId) {
        $mapper = new Erstellung_Model_Mapper_CharakterMapper();
        $charakter = $mapper->getInactiveCharakterByUserId($userId);
        return $charakter;
    }
    
}
