<?php

/**
 * Description of Auth
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Controller_Helpers_Logincheck extends Zend_Controller_Action_Helper_Abstract {
    
    protected $_layoutService;

    function direct(){
        $this->_layoutService = new Application_Service_Layout();
        
        $layout = Zend_Controller_Action_HelperBroker::getExistingHelper('layout');
        $viewRenderer = Zend_Controller_Action_HelperBroker::getExistingHelper('ViewRenderer');
        
        $auth = Zend_Auth::getInstance()->getIdentity();
        if($auth === null){
            $layout->setLayout('offline');
            return false;
        }  else {
            $layout->setLayout('online');
            $viewRenderer->view->layoutData = $this->_layoutService->getLayoutData($auth);
        }
        return true;
    }
    
}
