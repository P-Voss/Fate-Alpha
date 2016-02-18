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
    }
    
    public function executeAction() {
        $this->_helper->viewRenderer->setNoRender(true);
        $layout = $this->_helper->layout();
        $layout->disableLayout();
        $this->_trainingService->executeTraining();
    }
    
}
