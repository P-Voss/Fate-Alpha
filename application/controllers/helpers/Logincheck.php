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
        $this->layoutService = new Application_Service_Layout();
        
        $layout = Zend_Controller_Action_HelperBroker::getExistingHelper('layout');
        $viewRenderer = Zend_Controller_Action_HelperBroker::getExistingHelper('ViewRenderer');
        $auth = Zend_Auth::getInstance()->getIdentity();
        if($auth === null){
            $layout->setLayout('offline');
            return false;
        } else {
            $userMapper = new Application_Model_Mapper_UserMapper();
            $layout->setLayout('online');
            $viewRenderer->view->layoutData = $this->layoutService->getLayoutData($auth);
            $userMapper->updateAccessKey($auth->userId, Uuid::uuid4());
            return true;
        }
    }
    
}
