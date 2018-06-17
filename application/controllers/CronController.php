<?php

/**
 * Description of CronController
 *
 * @author Vosser
 */
class CronController extends Zend_Controller_Action{

    /**
     * @var Application_Service_Training
     */
    protected $trainingService;

    public function init(){
        $this->_helper->viewRenderer->setNoRender(true);
        $layout = $this->_helper->layout();
        $layout->disableLayout();
        $this->trainingService = new Application_Service_Training();
        $auth = Zend_Auth::getInstance()->getIdentity();
        if ($auth === null || !in_array($auth->userId, [1, 4])) {
            exit;
        }
    }

    /**
     * @throws Exception
     */
    public function executeAction() {
        $this->trainingService->executeTraining();
        $this->trainingService->addFp();
        $this->trainingService->addBirthdayFp();
    }
    
    public function refreshAction() {
        $informationService = new Application_Service_Information();
        $informationService->refreshInformation();
        $this->redirect('information');
    }
    
}
