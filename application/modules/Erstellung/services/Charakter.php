<?php

/**
 * Description of Erstellung_Service_Charakter
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Erstellung_Service_Charakter extends Application_Service_Charakter {
    
    
    public function getInactiveCharakterByUserId($userId) {
        $mapper = new Erstellung_Model_Mapper_CharakterMapper();
        $klassenMapper = new Application_Model_Mapper_KlasseMapper();
        $charakter = $mapper->getInactiveCharakterByUserId($userId);
        if($charakter !== false){
            $charakter->setVorteile($mapper->getVorteileByCharakterId($charakter->getCharakterid()));
            $charakter->setNachteile($mapper->getNachteileByCharakterId($charakter->getCharakterid()));
            $charakter->setUserid($userId);
        }
        return $charakter;
    }
    
}
