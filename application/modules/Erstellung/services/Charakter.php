<?php

/**
 * Description of Erstellung_Service_Charakter
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Erstellung_Service_Charakter extends Application_Service_Charakter {

    /**
     * @param $userId
     *
     * @return bool|Erstellung_Model_Charakter
     * @throws Exception
     */
    public function getInactiveCharakterByUserId($userId) {
        $mapper = new Erstellung_Model_Mapper_CharakterMapper();
        $charakter = $mapper->getInactiveCharakterByUserId($userId);
        if($charakter !== false){
            $charakter->setVorteile($mapper->getVorteileByCharakterId($charakter->getCharakterid()));
            $charakter->setNachteile($mapper->getNachteileByCharakterId($charakter->getCharakterid()));
            $charakter->setUserid($userId);
        }
        return $charakter;
    }
    
}
