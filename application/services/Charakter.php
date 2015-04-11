<?php

/**
 * Description of Application_Service_Charakter
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Service_Charakter {
    
    /**
     * 
     * @param int $userId
     * @return boolean|\Application_Model_Charakter
     */
    public function getCharakterByUserid($userId) {
        $mapper = new Application_Model_Mapper_CharakterMapper();
        return $mapper->getCharakterByUserId($userId);
    }
    
    /**
     * 
     * @param int $charakterId
     */
    public function getAssociates($charakterId) {
        $mapper = new Application_Model_Mapper_CharakterMapper();
        return $mapper->getFriendlist($charakterId);
    }
    
    
    public function getProfile($charakterId) {
        $mapper = new Application_Model_Mapper_CharakterMapper();
        return $mapper->getCharakterProfil($charakterId);
    }
    
    public function getVisibleProfile(Zend_Controller_Request_Http $request) {
        $mapper = new Application_Model_Mapper_CharakterMapper();
        return $mapper->getVisibleProfile($request->getParam('id'), $charakterId);
    }
    
}
