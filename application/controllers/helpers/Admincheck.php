<?php

/**
 * Description of Auth
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Controller_Helpers_Admincheck extends Zend_Controller_Action_Helper_Abstract {
    
    protected $userService;

    function direct(){
        $this->userService = new Application_Service_User();
        $auth = Zend_Auth::getInstance()->getIdentity();
        if($auth === null){
            return false;
        } else {
            return $this->userService->isAdmin($auth->userId);
        }
    }
    
}
