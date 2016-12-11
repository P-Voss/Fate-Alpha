<?php

/**
 * Description of Logs_IndexController
 *
 * @author Voß
 */
class Logs_IndexController extends Zend_Controller_Action {
    
    /**
     * @var Logs_Service_Plot
     */
    private $plotService;
    
    public function init() {
        if(!$this->_helper->logincheck()){
            $this->redirect('index/index');
        }
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->plotService = new Logs_Service_Plot();
        $logService = new Logs_Service_Log();
        if(!$logService->isLogleser(Zend_Auth::getInstance()->getIdentity()->userId)){
            $this->redirect('index/index');
        }
    }
    
    
    public function indexAction() {
        $this->view->plotsToReview = $this->plotService->getPlotsToReview(Zend_Auth::getInstance()->getIdentity()->userId);
    }
    
}
