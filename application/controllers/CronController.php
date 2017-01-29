<?php

/**
 * Description of CronController
 *
 * @author Vosser
 */
class CronController extends Zend_Controller_Action{
    
    protected $_trainingService;

    public function init(){
        $this->_trainingService = new Application_Service_Training();
        $auth = Zend_Auth::getInstance()->getIdentity();
        if ($auth === null || $auth->userId !== 1) {
            exit;
        }
    }
    
    public function executeAction() {
        $this->_helper->viewRenderer->setNoRender(true);
        $layout = $this->_helper->layout();
        $layout->disableLayout();
        $this->_trainingService->executeTraining();
        $this->_trainingService->addFp();
    }
    
    public function refreshAction() {
        $this->_helper->viewRenderer->setNoRender(true);
        $layout = $this->_helper->layout();
        $layout->disableLayout();
        $informationService = new Application_Service_Information();
        $informationService->refreshInformation();
    }
    
}
