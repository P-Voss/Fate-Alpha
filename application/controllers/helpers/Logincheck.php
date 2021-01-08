<?php

use Ramsey\Uuid\Uuid;

/**
 * Description of Auth
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Controller_Helpers_Logincheck extends Zend_Controller_Action_Helper_Abstract {

    /**
     * @var Application_Service_Layout
     */
    protected $layoutService;
    
    function direct(){
        $layout = Zend_Controller_Action_HelperBroker::getExistingHelper('layout');
        try {
            $this->layoutService = new Application_Service_Layout();
            $viewRenderer = Zend_Controller_Action_HelperBroker::getExistingHelper('ViewRenderer');
            $auth = Zend_Auth::getInstance()->getIdentity();
            if($auth === null){
                $layout->setLayout('offline');
                return false;
            } else {
                $layout->setLayout('online');
                $viewRenderer->view->layoutData = $this->layoutService->getLayoutData($auth);
                return true;
            }
        } catch (Exception $exception) {
            $layout->setLayout('offline');
            return false;
        }
    }
    
}
